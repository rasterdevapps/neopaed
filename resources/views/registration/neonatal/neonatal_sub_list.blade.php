@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ action('Registration\NeonatalController@index') }}">Neonatal Proforma</a>
		</li>                                                
	</ul>					
</div>
				<!-- /Breadcrumbs line -->
				<!-- Page Header -->
<div class="page-header">
<!-- <div class="page-title">
	<h3>Dashboard</h3>
      </div>-->
</div>
<!-- /Page Header -->
<!--=== Page Content ===-->
<div class="row">
	<div class="col-md-12">
	    <div class="widget box">
			<div class="widget-header">
				<h4>Neonatal Proforma</h4>
                @if(in_array('NEONATAL',$write_permission))
				<a href="{{ action('Registration\NeonatalController@chooseBaby') }}" title="" class="btn btn-info pull-right create-btn-spacing">
                    <i class="fa fa-plus "></i> 
                    <span>Create New</span>
                </a>           
                @endif                     
			</div>
            <div class="widget-content no-padding">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                       
          </div>
          </div>
	    <table class="table table-striped table-bordered table-responsive"  id="data-list">
			<thead>
                <tr>
                  <th >Baby Name</th>
                  <th data-hide="phone,tablet" >{{ Lang::get('home.mrn') }}</th>
                  <th data-hide="phone,tablet hidden-xs">Test Date</th>
                  <th data-hide="phone,tablet">Status</th>
                  @if(in_array('NEONATAL',$write_permission))
                  <th>Edit</th>                                
                  <th class="hidden-xs">Delete</th>                                                                
                  @endif
                  <th class="hidden-xs">Preview</th>                                                                
                  <th data-hide="phone,tablet">Print</th>                                
                </tr>
            </thead>                    
            <tbody>
           @for ($i = 0; $i <  @count($results); $i++)
            <tr>
              <td>{{  $results[$i]->BabyName }}</td>
              <td>{{  $results[$i]->BMrNo }}</td>
              <td class="hidden-xs">{{  date('d-m-Y',strtotime($results[$i]->TestDate)) }}</td>
              <td>{{  $results[$i]->Status }}</td>
              @if(in_array('NEONATAL',$write_permission))
              <td class="center-align-phone">
                <a class="icon" href="{{ action('Registration\NeonatalController@edit', $results[$i]->NeonatalId) }}">
                   <i class="fa fa-pencil"></i> 
                    <span class="hidden-phone">Edit</span>
                </a>
              </td>
              <td class="center-align-phone hidden-xs">
                <a class="icon" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->NeonatalId }})">
                   <i class="fa fa-remove"></i> 
                   <span class="hidden-phone">Delete</span>
                </a>
              </td>
              @endif
               <td class="center-align-phone hidden-xs">
                  <a class="icon view-button" href="javascript:void(0);" onclick="ShowModal({!!  $results[$i]->NeonatalId !!});" >
                    <i class="fa fa-eye"></i>
                    <span class="hidden-phone">View</span>
                   </a>
               </td>
		      <td class="center-align-phone">
                   <a class="icon" href="{{ action('Registration\NeonatalController@show', $results[$i]->NeonatalId) }}">
                      <i class="fa fa-print"></i> 
                      <span class="hidden-phone">Print</span>
                    </a>               		
                </td>
             </tr>
            @endfor
            </tbody>                                  
		</table>   
      </div>
    </div>
   </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->
				<!--
                	DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
                -->                
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
<div class="row">
    <div class="col-md-12">
        <div class="dataTables_footer clearfix">
           <div class="col-md-6">
              <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                Showing {{ $total }} entries
               </div>
            </div>
       
         </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	   		<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    			<h4 id="myModalLabel" class="modal-title">Baby Details</h4>
			</div>
            <div class="modal-body">
				<div class="container-fluid">
				<div class="row">
               	  <div class="col-md-6">
                    	<label class="col-md-6">{{ Lang::get('home.mrn') }}:</label>
                         <span class="col-bmrno col-md-6"></span>
                    </div>
                </div>

				<div class="row">
               	  <div class="col-md-6">
                    	<label class="col-md-6">Date:</label>
                         <span class="col-date col-md-6"></span>
                    </div>
                	<div class="col-md-6">
                    	<label class="col-md-6">Time:</label>
                         <span class="col-time col-md-6"></span>
                    </div>
                </div>

				<div class="row">
               	  <div class="col-md-6">
                    	<label class="col-md-6">Name:</label>
                         <span class="col-name col-md-6"></span>
                    </div>
                	<div class="col-md-6">
                    	<label class="col-md-6">Blood Group:</label>
                         <span class="col-bloodgroup col-md-6"></span>
                    </div>
                </div>
				<div class="row">
                	<div class="col-md-6">
                    	<label class="col-md-6">DOB:</label>
                         <span class="col-dob col-md-6"></span>
                    </div>
                	<div class="col-md-6">
                    	<label class="col-md-6">TOB:</label>
                         <span class="col-tob col-md-6"></span>
                    </div>
                </div>    
				<div class="row">
                	<div class="col-md-6">
                    	<label class="col-md-6">Birth City:</label>
                         <span class="col-city col-md-6"></span>
                    </div>
                	<div class="col-md-6">
                    	<label class="col-md-6">Sex:</label>
                         <span class="col-sex col-md-6"></span>
                    </div>
                </div>
				<div class="row">
               	  <div class="col-md-6">
                    	<label class="col-md-6">Birth Weight(Gms):</label>
                         <span class="col-birthweight col-md-6"></span>                    
                    </div>
               	  <div class="col-md-6">
                    	<label class="col-md-6">Birth Status:</label>
                         <span class="col-birthstatus col-md-6"></span>

                    </div>                    
                </div>

				<div class="row">
                	<div class="col-md-6">
                    	<label class="col-md-6">Gestation :</label>
                         <span class="col-gestation col-md-6"></span>
                    </div>                
                	<div class="col-md-6">
                    	<label class="col-md-6">Birth Order:</label>
                         <span class="col-birthorder col-md-6"></span>
                    </div>

                </div>				
                <div class="row">
                	<div class="col-md-6">
                    	<label class="col-md-6">Length(cm):</label>
                         <span class="col-length col-md-6"></span>
                    </div>
                	<div class="col-md-6">
                    	<label class="col-md-6">OFC(cm):</label>
                         <span class="col-ofc col-md-6"></span>
                    </div>
                </div>
                <div class="row">
                <div class="modal-footer">
                </div>
                </div>
				</div>
            </div>
	    </div>
    </div>
</div>                
@endsection
@section('scripts')
<script type="text/javascript">
function ShowModal(id){
	  $.ajax({
			  type    :"GET",
			  url     :"{{ url('/') }}"+"/neonatal/"+id+"/getdata",
			  data    :{ id:id },
			  success :function(response){
				  Datas = JSON.parse(response);
				  EditLink='';
				  @if(in_array('NEONATAL',$write_permission))
				  EditLink = '<a href="/neonatal/'+id+'/edit/" class=""><i class="fa fa-pencil"></i></a>';	
				  @endif			
				  PrintLink = '<a href="/neonatal/'+id+'" class=""><i class="fa fa-print"></i></a>';
				  $(".modal-title").html(Datas['BabyName']+' '+EditLink+' '+PrintLink);				  

				  $(".col-name").html(Datas['BabyName']);
				  $(".col-bmrno").html(Datas['BMrNo']);
				  $(".col-birthstatus").html(Datas['BirthStatus']);
				  $(".col-sex").html(Datas['Sex']);
				  $(".col-city").html(Datas['BirthCity']);
				  $(".col-bloodgroup").html(Datas['BabyBloodGroup']);				  				  				  				
				  $(".col-birthorder").html(Datas['BirthOrder']);				  				  				  				
				  $(".col-birthweight").html(Datas['BirthWeight']);				  				  				  				
				  $(".col-dob").html(Datas['DOB']);				  				  				  								 				
				  $(".col-tob").html(Datas['TOB']);				  				  				  				 

				  $(".col-gestation").html(Datas['Gestation']);				  				  				  				
				  $(".col-date").html(Datas['TestDate']);				  				  				  				
				  $(".col-time").html(Datas['TestTime']);				  				  				  				 				
				  $(".col-length").html(Datas['Length']);	
				  $(".col-ofc").html(Datas['OFC']);			  				  
				  
				  },
			  complete: function(){
			  	$('#basicModal').modal('show');
			  }
		});
}
function DeleteData(id){
	bootbox.confirm("Are you sure?",function(confirmed){
		if(confirmed){
			$("#DeleteForm").attr('action',"{{ action('Registration\NeonatalController@index') }}/"+id);
			$("#DeleteForm").submit();
		}
	});
}
$(document).ready(function(){

    var dataTableresponseive = ['.dataTables_header .col-md-6','.dataTables_footer .col-md-6'];

    $.each(dataTableresponseive,function(dataTableclassindex,dataTableclassvalue){

      $(dataTableclassvalue).each(function(dataTablechildindex,dataTablechildvalue){
          if(dataTablechildindex == 0){
            $(this).addClass('col-xs-4');
          }
          if(dataTablechildindex == 1){
            $(this).addClass('col-xs-8');
          }

       });

    });
  
});


</script>
@endsection
