@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Masters\ComplicationController@index') }}">Complications</a></li>       
		<li class="current"><a>Create</a></li>                                                 
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing select-container-main">
	<div class="master-layout">
		{!! Form::open(['url' => action('Masters\ComplicationController@store'),'id'=> 'checkform']) !!}
		<div class="col-md-12 overflow-auto">
			<table class="masters table table-add-more full-width-fix">
				<thead>
					<tr>
						<th>Name</th>
						<th>Status</th>                       
						<th>
							<span>
								<a class="btn btn-success master_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
							</span>                
						</th>                                            
					</tr>
				</thead>
				<tbody>
					<tr data-len="0">
						<td><input type="text" name="Name[]" value="" class="form-control input-fields-shadow input-width-medium name" /></td>
						<td>
							<select name="Status[]" class="form-control input-fields-shadow input-width-medium">
								<option selected="selected" value="Active">Active</option>
								<option value="Inactive">Inactive</option>                                             
							</select>
						</td>
						<td><span class="fa fa-trash btn btn-danger btn-view remove"></span></td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="4">
							<div class="master-btn-layout">
								<button type="submit" class="btn btn-primary btn-basic-shadow form-control input-width-medium"><i class="fa fa-floppy-o"></i> Save</button>
								<a href="{{ action('Masters\ComplicationController@index') }}" class="btn btn-default btn-basic-shadow form-control input-width-medium" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> Cancel</a>
							</div>
						</td>
					</tr>
				</tfoot>
			</table>  
		</div>
		{!! Form::close() !!}
		@include('errors.list')
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">

	$(document).ready(function() {

		$('#checkform .btn.btn-primary').on('click', function(event) {

			$('#checkform input.name').each(function() {
				$(this).rules("add", {
					required: true
				});
			});

			if($('#checkform').validate().form()) {
				$(this).prop('disabled', true);

            	$(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
            	$('#checkform').submit();
				return true;
			} else {
				return false;
			}
		});

		$('#checkform').validate();

	});


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
	function EditData(id){
		$.ajax({
			type    :"GET",
			url     :"/get-data",
			data    :{ id:id },
			success :function(response){
				Datas = JSON.parse(response);
				$(".panel-heading").html("Mother Details - "+Datas['MotherName']);
				$("#MMrNo").val(Datas['MMrNo']);
				$("#MotherName").val(Datas['MotherName']);
				$("#MotherInitial").val(Datas['MotherInitial']);
				$("#PartnerInitial").val(Datas['PartnerInitial']);
				$("#MotherTitle").val(Datas['MotherTitle']);
				$("#MotherId").val(Datas['MotherId']);				  				  				  
				$("#Email").val(Datas['Email']);
				$("#Address1").val(Datas['Address1']);
				$("#Address2").val(Datas['Address2']);
				$("#Address3").val(Datas['Address3']);
				$("#Address4").val(Datas['Address4']);
				$("#Mobile").val(Datas['Mobile']);
				$("#MotherDOB").val(Datas['MotherDOB']);
				$("#City").val(Datas['City']);
				$("#State").val(Datas['State']);
				$("#Country").val(Datas['Country']);
				$("#PartnerName").val(Datas['PartnerName']);
				$("#PartnerContact").val(Datas['PartnerContact']);
				$("#PartnerDOB").val(Datas['PartnerDOB']);
				$("#PartnerOccupation").val(Datas['PartnerOccupation']);
				$("#LandLine").val(Datas['LandLine']);
				$("#Occupation").val(Datas['Occupation']);
				$('#basicModal').modal('hide');				  
			}
		});	
	}
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
</script>
@endsection
