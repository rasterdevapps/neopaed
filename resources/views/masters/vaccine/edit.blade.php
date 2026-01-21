@extends('app')
@section('content')
				<!-- Breadcrumbs line -->
				<div class="crumbs bread-crumbs-shadow">
					<ul id="breadcrumbs" class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="{{ url('/') }}">Dashboard</a>
						</li>
						<li>
							<a href="{{ action('Masters\VaccineController@index') }}">Vaccines</a>
						</li>       
						<li class="current">
							<a>Edit</a>
						</li>                                              
					</ul>
<!--				<ul class="crumb-buttons">
						<li><a href="" title=""><i class="icon-signal"></i><span>Statistics</span></a></li>
					</ul>-->
				</div>
				<!-- /Breadcrumbs line -->

				<!-- Page Header -->
				<!-- <div class="page-header"> -->
<!--					<div class="page-title">
						<h3>Dashboard</h3>
					</div>-->
				<!-- </div> -->
				<!-- /Page Header -->

				<!--=== Page Content ===-->
				<div class="row row-spacing select-container-main">
					<div class="master-btn-layout">
					   {!! Form::model($results,['method'=> 'PATCH','url' => action('Masters\VaccineController@update',$results->Id),'id'=>'EditForm']) !!}
                       		    @include('masters.vaccine.form',['SubmitButtonText'=>'Update'])
                       {!! Form::close() !!}
                      @include('errors.list')
					</div> <!-- /.col-md-12 -->
                    <div class="sidebar-right panel panel-default hidden">
                        <div class="">
                            <h3>Search</h3>
                            <div class="form-group">
                             {!! Form::text('SearchField',null,['class'=>'form-control','id'=>'SearchField']) !!}
                             </div>
                             <div class="form-group">
                             <a href="javascript:void(0);" class="btn btn-primary form-control search-list">Search</a>
                             </div>
                             <ul class="search-results list-group">
                             </ul>
                        </div>
                    </div>                    
				</div> <!-- /.row -->
				<!-- /Page Content -->
<div class="modal fade bs-example-modal-lg" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
	   		<div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    			<h4 id="myModalLabel" class="modal-title">Details</h4>
			</div>
            <div class="modal-body">
				<div class="container-fluid">
				<div class="row">
               	  <div class="col-md-6">
                    	<p>Name: <span class="col-name"></span></p>
                    </div>
                	<div class="col-md-6">
                    	<p>Partner Name: <span class="col-partnername"></span></p>
                    </div>
                </div>
				<div class="row">

               	  <div class="col-md-6">
                    	<p>Contact: <span class="col-mobile"></span></p>                    
                    </div>
               	  <div class="col-md-6">
                    	<p>Partner Contact: <span class="col-partnercontact"></span></p>
                    </div>                    
                </div>
				<div class="row">
                	<div class="col-md-6">
                    	<p>DOB: <span class="col-dob"></span></p>
                    </div>
                	<div class="col-md-6">
                    	<p>Partner DOB: <span class="col-partnerdob"></span></p>
                    </div>
                </div>    
				<div class="row">
                	<div class="col-md-6">
                    	<p>Occupation: <span class="col-state"></span></p>
                    </div>
                	<div class="col-md-6">
                    	<p>Partner Occupation: <span class="col-country"></span></p>
                    </div>
                </div>                            
				<div class="row">
                	<div class="col-md-6">
                    	<p>Address 1: <span class="col-address1"></span></p>
                    </div>                
                	<div class="col-md-6">
                    	<p>City: <span class="col-city"></span></p>
                    </div>
                </div>
				<div class="row">
                	<div class="col-md-6">
                    	<p>Address2: <span class="col-address2"></span></p>
                    </div>
                	<div class="col-md-6">
                    	<p>State: <span class="col-state"></span></p>
                    </div>
                </div>
				<div class="row">
                	<div class="col-md-6">
                    	<p>Address3: <span class="col-address3"></span></p>
                    </div>
                	<div class="col-md-6">
                    	<p>Country: <span class="col-country"></span></p>
                    </div>
                </div>
				<div class="row">
                	<div class="col-md-6">
                    	<p>Address4: <span class="col-address4"></span></p>
                    </div>
                	<div class="col-md-6">
                    	<p>Email: <span class="col-email"></span></p>
                    </div>
                </div>
				<div class="row">
                	<div class="col-md-6">
                    	<p>Landline: <span class="col-landline"></span></p>
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
$(".search-list").click(function(){
		var data = $("#SearchField").val();
			$.ajax({
				type    :"GET",
				url     :"/search-data",
				data    :{ data1:data },
				success :function(response){
					Datas = JSON.parse(response);
					content = '';
					for(i=0; i < Datas.length; i++){
						content += '<li MotherId="'+Datas[i]['MotherId']+'" class="list-group-item"><p><span>'+Datas[i]['MotherTitle']+''+Datas[i]['MotherName']+'<br />'+Datas[i]['MMrNo']+'</span><a href="javascript:void(0);" class="pull-right" onclick="EditData('+Datas[i]['MotherId']+')"><i class="fa fa-pencil"></i></a><a href="javascript:void(0);" class="pull-right" onclick="ShowModal('+Datas[i]['MotherId']+')"><i class="fa fa-eye"></i></a></p></li>';
					}
					$(".search-results").html(content);
				}
			});
});
function ShowModal(id){
	  $.ajax({
			  type    :"GET",
			  url     :"/get-data/",
			  data    :{ id:id },
			  success :function(response){
				  Datas = JSON.parse(response);
				  EditLink = '<a href="javascript:void(0);" class="" onclick="EditData('+Datas['MotherId']+')"><i class="fa fa-pencil"></i></a>';
				  $(".modal-title").html(Datas['MotherName']+' '+EditLink);
				  $(".col-name").html(Datas['MotherName']);				  				  				  
				  $(".col-partnername").html(Datas['PartnerName']);
				  $(".col-email").html(Datas['Email']);
				  $(".col-mobile").html(Datas['Mobile']);
				  $(".col-partnercontact").html(Datas['PartnerContact']);				  
				  $(".col-city").html(Datas['City']);
				  $(".col-country").html(Datas['Country']);
				  $(".col-address1").html(Datas['Address1']);				  		
				  $(".col-address2").html(Datas['Address2']);				  		
				  $(".col-address3").html(Datas['Address3']);				  		
				  $(".col-address4").html(Datas['Address4']);				  						  				  														
				  $(".col-partneroccupation").html(Datas['PartnerOccupation']);  
				  $(".col-partnerdob").html(Datas['PartnerDOB']);  
				  $(".col-dob").html(Datas['MotherDOB']);  
				  $(".col-country").html(Datas['Country']);  				  				  				  
				  $(".col-landline").html(Datas['LandLine']);  				  				  				  				  
				  $(".col-occupation").html(Datas['Occupation']);
				  $(".col-state").html(Datas['State']);						  		  				  				  				  				 			  },
			  complete: function(){
			  	$('#basicModal').modal('show');
			  }
		});
}
$( "form" ).sisyphus({  customKeySuffix: "mother", locationBased: true });
$(document).ready(function() {
        $('#EditForm').validate({
	        rules: {
	            Name: {
	                required: true
	            }
	        }
	    });
   });
</script>
@endsection
