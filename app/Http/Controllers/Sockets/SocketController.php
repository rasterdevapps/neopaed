<?php

namespace App\Http\Controllers\Sockets;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests;
use App\Models\MirthQuery;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Sockets\Hl7MessageController;
use App\Http\Controllers\Sockets\Hl7BaseController;

class SocketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $_MESSAGE_PREFIX  = '';
    public $_MESSAGE_SUFFIX = '';
    public $_Return_message='';

    public function __construct()
    {

        $this->_MESSAGE_PREFIX = "\013";
        $this->_MESSAGE_SUFFIX = "\034\015";

    }
  
    public function create_socket()
    {

       if (!($sockreceive= socket_create(AF_INET, SOCK_STREAM, SOL_TCP))) {
           return "Couldn't create socket: ".$this->error_message();
       }
 
       return $sockreceive;
        
    }

    public function check_port()
    {
         $output=system('netstat -an | grep '.env('MIRTH_LISTENER_PORT'));
         $output_list=explode(" ", $output);
         $result=array();
         foreach ($output_list as $key => $line) {
            if (!empty($line)) {  
                array_push($result, $line);
             }
         }
         return $result;

    }

    public function close_port()
    {

        $output = system(' lsof -i tcp:'.env('MIRTH_LISTENER_PORT'));
        if (!empty($output)) {   
            $list =explode(" ", $output);
            system('kill -9 '.$list[3]);
            $this->close_port();
        }
         return true;
    }

    //create bind 
    public function bind_socket($sockreceive = '')
    {
      
        if (!socket_bind($sockreceive, env('MIRTH_LISTENER_IP'), env('MIRTH_LISTENER_PORT'))) {
              
               return "Could not bind socket :".$this->error_message();

        }

        return $sockreceive;
    }




    public function listen_socket($sockreceive = '')
    {
        if (!socket_listen($sockreceive, 1)) {              
          return "Could not listen on socket :".$this->error_message();
        }
             
        return $sockreceive;
 
    }
    public function error_message()
    {

        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
        return "[$errorcode] $errormsg \n";  
    }

    public function accept_connections($sockreceive = '', $message = '', $mr_no = '')
    {
        //Accept incoming connection - This is a blocking call
        $client = socket_accept($sockreceive);


        //display information about the client who is connected
        if (socket_getpeername($client, $address, $port)) {
            //Fetch  the output from client
            $input =socket_read($client, 1024000);
            $response = $message;
            // Display output  back to client
            socket_write($client, $response);
            socket_close($client); 
            socket_close($sockreceive);
            
            //Update the result to record 
            $results = MirthQuery::where('mr_no', $mr_no);
            if (count($results)>0 && !empty($input)) {

              $requset_data=array('answer_values'=>$input);
              $results->update($requset_data);
             return json_encode(['status'=>true, 'message'=>'Data Received']);

            } else {
              return json_encode(['status'=>false, 'message'=>'Internal Problem']);
            } 
           
        } else {

            socket_close($client); 
            socket_close($sockreceive);
            return json_encode(['status'=>false, 'message'=>'Internal Problem :'.$this->error_message()]);

        }

    }

   

    public function socket_connection($socket = '')
    {
       
        if (!socket_connect($socket, env('MIRTH_SERVER_IP'), env('MIRTH_PORT'))) {
               return "Could not connect on server :".$this->error_message();
        }
       

        return $socket;
    }

    public function send_message($req, $socket, $responseCharEncoding = 'UTF-8')
    {
       

        $hl7Msg = (string)$req;


        socket_write($socket, $this->_MESSAGE_PREFIX . $hl7Msg . $this->_MESSAGE_SUFFIX);

        $data = "";

        while (($buf = socket_read($socket, 1)) !== false) {
            $data .= $buf;

            if (preg_match("/" . $this->_MESSAGE_SUFFIX . "$/", $data))
                break;
        }

        // Remove message prefix and suffix
        $data = preg_replace("/^" . $this->_MESSAGE_PREFIX . "/", "", $data);
        $data = preg_replace("/" . $this->_MESSAGE_SUFFIX . "$/", "", $data);

        // set character encoding
        $data = mb_convert_encoding($data, $responseCharEncoding);

       return $data;
       
       
    }

    public function Request_patient_details(Request $request)
    {
           $input = $request->all();
           $input['mr_no'] = trim($input['mr_no']);
             $response['status']=false;
             $response['message']='Please Enter Mr No';
           try {
               if (!empty($input['mr_no'])) {
                    $input = $request->all();
                    $socket=$this->create_socket();
                    $socket=$this->bind_socket($socket);
                    $socket=$this->listen_socket($socket);
                    return $this->accept_connections($socket, '$ok succuess$', $input['mr_no']);
               } 
          } catch (\Exception $e) {
             $response['status']=false;
             $response['message']='Requesting host is down';
         }

            
           return json_encode($response);
    }

    public function Retrieve_patient_details(Request $request)
    {

            $input = $request->all();
            //here we generate the query for mirth 
            $input['mr_no'] = trim($input['mr_no']);
          if (!empty($input['mr_no'])) {
            $base    = new Hl7QueryController();
            $base->set_pid_felds('3.1', $input['mr_no']);   
            $message = implode('|', $base->create_patient());
          try {
                // create socket 
                $socket=$this->create_socket();
                //establish connection 
                $socket=$this->socket_connection($socket);
          } catch (\Exception $e) {

                return json_encode(['status'=>false,'message'=>'Requesting host is down']);
          }
            
            $len = strlen($message);
            if (socket_getpeername($socket, $address, $port)) {
                // create query record 
                 $requset_data['mr_no']        = $input['mr_no'];
                 $requset_data['query_values'] = $message;
                 $requset_data['request_date'] = Carbon::now();
                 $Mirth_query_id = MirthQuery::create($requset_data)->id;

                 // send query to mirth 
                 $this->send_message($message, $socket);

                  // Get Record  
                 $fetch_param['mr_no']=$input['mr_no'];
                 $fetch_param['id']=$Mirth_query_id;
                 $result = MirthQuery::where($fetch_param)->orderBy('id', 'DESC')->first();

                 //formate received message 
                 if (!empty($result->answer_values)) { 
                    $get_pid=explode("\r", $result->answer_values);
                    $information_patient=array();
                        if (count($get_pid) > 4 && isset($get_pid[4])) {

                           $hl7_message = new Hl7MessageController($get_pid[4]);
                           $information_patient=$hl7_message->Get_details();
                          if (!empty($information_patient['Mr_Number'])) {
                             return json_encode(['status' =>true,
                                           'message'=>'Data eeceived successfully',
                                           'result' =>$information_patient]);
                           } else {
                              return json_encode(['status' =>false,
                                           'message'=>'No data found']);
                           }  

                        }
                     
                 } else {
                      return json_encode(['status'=>false, 'message'=>'No Data Received']);
                }  
            }

            return json_encode(['status'=>false, 'message'=>'Connection Failed']);
       } else {
           return json_encode(['status'=>false, 'message'=>'Please enter MRN']);
       }
      
         
    }

  
}
