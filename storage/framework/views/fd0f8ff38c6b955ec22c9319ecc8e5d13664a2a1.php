<?php $__env->startSection('content'); ?>
<?php $write_permission = session('write_permission'); ?>
<?php $hide='false'; ?>
<?php echo e(Session::put('daycare-create-slug','2'), false); ?>

<?php echo e(Session::put('daycare-baby-id',$babyId), false); ?>

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="<?php echo e(url('/'), false); ?>"><?php echo e(Lang::get('home.daycare_sub_dashboard'), false); ?></a></li>
		<li><a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>"><?php echo e(Lang::get('home.daycare_sub_daycare'), false); ?></a></li>  
    <li class="current"><a href="javascript:void(0);"><?php if(!empty($babyName)): ?> <?php echo e(Lang::get('home.daycare_sub_history'), false); ?> <?php echo e($babyName, false); ?>  <?php echo e(isset($bmrno) ? $bmrno : '', false); ?> <?php else: ?> <?php echo e(Lang::get('home.daycare_sub_baby'), false); ?> <?php endif; ?> </a></li>                                               
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4><?php echo e(Lang::get('home.daycare_sub_history1'), false); ?></h4>
        <?php if(in_array('NICU_DAY',$write_permission)): ?>
					<a href="<?php echo e(action('Admission\DaycareController@create'), false); ?>" title="Create New" class="btn create-btn-spacing btn-basic-shadow btn-info pull-right"><i class="fa fa-plus "></i> <span>Create New</span></a>  
        <?php endif; ?>                              
			</div>
			<div class="widget-content inherittable">  
        <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div class="row"></div>
        </div>
	      <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
        <thead>
            <tr>
                <th>  <?php echo e(Lang::get('home.daycare_sub_sno'), false); ?></th>
                <th>  <?php echo e(Lang::get('home.daycare_sub_admission'), false); ?></th>
                <th>  <?php echo e(Lang::get('home.ip'), false); ?></th>
                <th class="hidden-xs">  <?php echo e(Lang::get('home.daycare_sub_doa'), false); ?></th>
                <th class="hidden-xs">  <?php echo e(Lang::get('home.daycare_sub_dod'), false); ?></th>
              <?php if($hide=='true'): ?>
                <?php if(in_array('NICU_DAY',$write_permission)): ?>
                <th ><?php echo e(Lang::get('home.daycare_sub_edit'), false); ?></th>  
                <th class="hidden-xs"><?php echo e(Lang::get('home.daycare_sub_delete'), false); ?></th>                            
                <?php endif; ?>   
                <th class="hidden-xs"><?php echo e(Lang::get('home.daycare_sub_preview'), false); ?></th>
                <th><?php echo e(Lang::get('home.daycare_sub_print'), false); ?></th>   
              <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php for($i = 0; $i <  @count($results); $i++): ?>
        <tr>
          <td><?php echo e($i+1, false); ?></td>
          <td>
            <a href="<?php echo e(url('daycare-admission/daycare-admission-daylist/'.\SiteHelpers::encrypt_id($results[$i]->AdmissionId)), false); ?>">
                  <?php echo e($results[$i]->episodes, false); ?>

            </a>
          </td>
          <td class="hidden-xs"><?php echo e($results[$i]->ip_number, false); ?></td>
          <td class="hidden-xs">
            <?php if(date('Y',strtotime($results[$i]->AdmissionDate)) > 1970): ?> 
              <?php echo e(date('d-m-Y', strtotime($results[$i]->AdmissionDate)), false); ?>

            <?php endif; ?>  
          </td>
          <td>
            <?php if(date('Y',strtotime($results[$i]->DischargeDate)) > 1970): ?> 
              <?php echo e(date('d-m-Y', strtotime($results[$i]->DischargeDate)), false); ?>

            <?php endif; ?>  
          </td>
          <?php if($hide=='true'): ?>
          <?php if(in_array('NICU_DAY',$write_permission)): ?>
          <td  class="center-align-phone">
            <a class="icon" href="<?php echo e(action('Admission\DaycareController@edit', $results[$i]->DayId), false); ?>">
              <i class="fa fa-pencil"></i> 
              <span class="hidden-phone">Edit</span>
            </a>
          </td>
          <td  class="center-align-phone hidden-xs">
            <a class="icon" href="javascript:void(0);" onclick="DeleteData(<?php echo e($results[$i]->DayId, false); ?>)">
              <i class="fa fa-remove"></i> 
              <span class="hidden-phone">Delete</span>
            </a>
          </td>
          <?php endif; ?>
          <td  class="center-align-phone hidden-xs">
            <a class="icon" onclick="ShowModal(<?php echo $results[$i]->DayId; ?>,'<?php echo e(action('Admission\DaycareController@getData',$results[$i]->DayId), false); ?>')" href="javascript:void(0);">
              <i class="fa fa-eye"></i> 
              <span class="hidden-phone">View</span>
            </a>
          </td>          
          <td  class="center-align-phone">
            <a class="icon" href="<?php echo e(action('Admission\DaycareController@printData',$results[$i]->DayId), false); ?>">
              <i class="fa fa-print"></i> 
              <span class="hidden-phone">Print</span>
            </a>
          </td>   
          <?php endif; ?>
          </tr>
          <?php endfor; ?>
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
<?php echo Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']); ?>

<?php echo Form::close(); ?>        
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
function ShowModal(id,url1){
	  $.ajax({
			  type    :"GET",
			  url     : url1,
			  data    :{ id:id },
			  success :function(response){
				  Datas = JSON.parse(response);
				  EditLink = '';
				  <?php if(in_array('NICU_DAY',$write_permission)): ?>
				  EditLink = '<a href="/daycare-admission/'+Datas['DayId']+'/edit" class=""><i class="fa fa-pencil"></i></a>';
				  <?php endif; ?>
				 PrintLink = '<a href="/daycare-admission/'+Datas['DayId']+'/printdata" class=""><i class="fa fa-print"></i></a>';
				  $(".modal-title").html(Datas['BabyName']+' '+EditLink + ' '+PrintLink);						  			  
				 
				  $(".col-name").html(Datas['BabyName']);
				  $(".col-bmrno").html(Datas['BMrNo']);
				  $(".col-sex").html(Datas['Sex']);
				  $(".col-cga").html(Datas['CGA']);				  				  				  				
				  $(".col-birthweight").html(Datas['BirthWeight']);				  				  				  				
				  $(".col-dob").html(Datas['DOB']);			
				  $(".col-dayoflife").html(Datas['DayOfLife']);								  
				  $(".col-date").html(Datas['DayDate']);				  				  				  				
				  $(".col-time").html(Datas['DayTime']);	
				  $(".col-admissionage").html(Datas['AgeOnAdmission']);	
				  $(".col-currentprobs").html(Datas['CurrentProblems']);				  				  				  								  				   								  
				  $(".col-previousprobs").html(Datas['PreviousProblems']);
				  $(".col-background").html(Datas['Background']);				  				  				  				
				  
				  },
			  complete: function(){
			  	$('#basicModal').modal('show');
			  }
		});
}
function DeleteData(id){
	  bootbox.confirm("Are you sure?",function(confirmed){
		  if(confirmed){
			  $("#DeleteForm").attr('action',"<?php echo e(action('Admission\DaycareController@index'), false); ?>/"+id);
			  $("#DeleteForm").submit();
		  }
	  });
}

$('.sorting_by').click(function(e){
    e.preventDefault();
    $('#sortby').val($(this).data('field'));
       if($('#sortorder').val()=='desc'){
          $('#sortorder').val('asc');
       }else{
          $('#sortorder').val('desc');
       }
   $('#limit-form').submit();

});

$('.sort_with_page').click(function(e){
  e.preventDefault();
  var sorting_param=$('#limit-form').serialize();
  var link =$(this).attr('href');
  window.location=link+'&'+sorting_param;


});
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>