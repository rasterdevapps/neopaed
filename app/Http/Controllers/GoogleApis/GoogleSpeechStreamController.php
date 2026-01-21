<?php

namespace App\Http\Controllers\GoogleApis;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GoogleSpeechStreamController extends Controller
{
   /**
    * This for audio file path
    *  
    * @var $audioFile
    */
    public $audioFile;

   /**
    * audio content RecognitionAudio
    *
    * @var $audio  
    */
    public $audio;

   /**
    * audio RecognitionConfig  
    *
    * @var $config  
    */
    public $config;

   /**
    * Instantiates a client
    * 
    * @var $client  
    **/
    public $client;

   /**
    * Detects speech in the audio file
    *
    * @var $response  
    **/
    public $response;

    /**
    * converted text 
    *
    * @var $converted_text  
    **/
    public $converted_text;

    /**
     * set rate 
     *
     * @var $rate
     */
    public $rate;



   /**
	* GoogleSpeechApiController constructor
	*
	*/
    public function __construct() 
    {
    	# The name of the audio file to transcribe
    	# $audioFile = __DIR__ . '/test/data/audio32KHz.raw';
       // $this->audioFile = public_path('audio').'/1482210045.wav';

		# Instantiates a client
		$this->client = new SpeechClient();

		

    }

    /**
     * initiate process
     * 
     * 
     * @return audio string content
     */
    public function index($audioFile, $rate)
    {

        // change these variables
			    $encoding = AudioEncoding::LINEAR16;
			    $sampleRateHertz = $rate;
			    $languageCode = 'en-US';

			    if (!extension_loaded('grpc')) {
			        throw new \Exception('Install the grpc extension ' .
			            '(pecl install grpc)');
			    }

			    $speechClient = new SpeechClient();
			    try {
			        $config = (new RecognitionConfig())
			            ->setEncoding($encoding)
			            ->setSampleRateHertz($sampleRateHertz)
			            ->setLanguageCode($languageCode);

			        $strmConfig = new StreamingRecognitionConfig();
			        $strmConfig->setConfig($config);

			        $strmReq = new StreamingRecognizeRequest();
			        $strmReq->setStreamingConfig($strmConfig);

			        $strm = $speechClient->streamingRecognize();
			        $strm->write($strmReq);

			        $strmReq = new StreamingRecognizeRequest();
			        $content = file_get_contents($audioFile);
			        $strmReq->setAudioContent($content);
			        $strm->write($strmReq);

			        foreach ($strm->closeWriteAndReadAll() as $response) {
			            foreach ($response->getResults() as $result) {
			                foreach ($result->getAlternatives() as $alt) {
			                    printf("Transcription: %s\n", $alt->getTranscript());
			                }
			            }
			        }
			    } finally {
			        $speechClient->close();
			    }



    }

    /**
     * set the rate 
     * @param $rate type integer 
     */
    public function setSamplerate($rate)
    {
        return $this->rate = $rate; 

    }

    /**
     * set file name 
     *
     * @param $path file path string
     */
    public function setFilepath($path)
    {

       return $this->audioFile = $path;

    }

     /**
     * The audio file's encoding, sample rate and language
     * 
     * 
     * @return config array settings
     */
    public function setaudioconfig()
    {
		$this->config = new RecognitionConfig([
		    'encoding' => AudioEncoding::LINEAR16,
		    'sample_rate_hertz' => $this->rate,
		    'language_code' => 'en-US'
		]);

		return $this->config;
    }

    /**
     * get contents of a file into a string
     * 
     * 
     * @return audio string content
     */
    public function getaudiocontents()
    {

	   $content = file_get_contents($this->audioFile);
	   return $this->audio = (new RecognitionAudio())->setContent($content);
    }

   

    /**
     * Detects speech in the audio file
     * 
     * 
     * @return audio string content
     */
    public function getrecognize() 
    {
	   $this->response = $this->client->recognize($this->config, $this->audio);
    }

    /**
     * Print most likely transcription
     * 
     * 
     * @return audio string content
     */
    public function getresponse() 
    {


		foreach ($this->response->getResults() as $result) {

		      $alternatives         = $result->getAlternatives();
		      $mostLikely           = $alternatives[0];
              //$mostLikely->serializeToJsonString()
		      $this->converted_text = $mostLikely->getTranscript();
      
             

		}


        return $this->converted_text;

    }

    /**
     * close client
     * 
     * 
     * @return audio string content
     */
    public function closeconnection() 
    {
    	$this->client->close();
    }
}
