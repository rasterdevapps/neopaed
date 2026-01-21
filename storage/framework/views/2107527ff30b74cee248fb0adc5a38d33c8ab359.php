<?php $__env->startSection('content'); ?>
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<?php $hide='true'; ?>
<?php echo e(Session::put('daycare-create-slug','3'), false); ?>

<?php echo e(Session::put('daycare-baby-id',$babyId), false); ?>

<?php echo e(Session::put('daycare-baby-admissionid',$admission_id), false); ?>

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="<?php echo e(url('/'), false); ?>"><?php echo e(Lang::get('home.daycare_list_dashboard'), false); ?></a></li>
        <li><a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>"><?php echo e(Lang::get('home.daycare_list_daycare'), false); ?></a></li>
        <li><a href="<?php echo e(action('Admission\DaycareController@daycareBabysubList',SiteHelpers::encrypt_id($babyId)), false); ?>">
            <?php if(!empty($babyName)): ?> 
            <?php echo e(Lang::get('home.daycare_list_history'), false); ?> <?php echo e($babyName, false); ?>  <?php echo e(isset($bmrno) ? $bmrno : '', false); ?>

            <?php else: ?> 
            <?php echo e(Lang::get('home.daycare_list_baby_history'), false); ?> 
            <?php endif; ?>
        </a>
    </li>
    <li><a href="javascript:void(0);"><?php echo e($episodes, false); ?></a></li>
</ul>
</ul>
<div class="pull-right">
    <?php
    echo \SiteHelpers::menuList($bmrno, $admission_id, 'daycare_list');
    ?>
</div>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4><?php echo e(Lang::get('home.daycare_list_daycare'), false); ?></h4>
                <?php if(in_array('NICU_DAY',$write_permission)): ?>
                <?php if(isset($flow_wise_register) && $flow_wise_register == 'from-dashboard'): ?>
                <a href="<?php echo e(url('daycare-admission/'.SiteHelpers::encrypt_id($admission_id.'-'.$babyId)), false); ?>?flow=from-dashboard" title="Create New" class="btn btn-info create-btn-spacing btn-basic-shadow pull-right"><i class="fa fa-plus "></i> <span><?php echo e(Lang::get('home.daycare_list_create'), false); ?></span></a>  
                <?php else: ?>
                <a href="<?php echo e(url('daycare-admission/'.SiteHelpers::encrypt_id($admission_id.'-'.$babyId)), false); ?>" title="Create New" class="btn btn-info create-btn-spacing btn-basic-shadow pull-right"><i class="fa fa-plus "></i> <span><?php echo e(Lang::get('home.daycare_list_create'), false); ?></span></a>  
                <?php endif; ?>                              
                <?php endif; ?>                              
            </div>
            <div class="widget-content inherittable">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row"></div>
                    <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
                        <thead>
                            <tr>
                                <th><?php echo e(Lang::get('home.daycare_list_sno'), false); ?></th>
                                <th><?php echo e(Lang::get('home.daycare_list_days'), false); ?></th>
                                <th><?php echo e(Lang::get('home.daycare_list_date'), false); ?></th>
                                <?php if($hide=='true'): ?>
                                <th  class="hidden-xs">
                                    Print 
                                </th>
                                <th  class="hidden-xs">
                                    Reassessment Print 
                                </th>
                                <th  class="hidden-xs hide">
                                    Edited Print
                                </th>
                                <?php if(in_array('NICU_DAY',$delete_permission)): ?>
                                <th class="center-align-phone hidden-xs">
                                    <?php echo e(Lang::get('home.daycare_list_delete'), false); ?>

                                </th>
                                <?php endif; ?>
                                <?php endif; ?>
                                <th  class="hidden-xs">
                                    Status
                                </th>
                            <!-- <th>
                                Reassessment Sheet
                            </th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = count($results); ?>
                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res_key => $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($res_key + 1, false); ?></td>
                            <td>
                                <?php if(isset($flow_wise_register) && $flow_wise_register == 'from-dashboard'): ?>
                                <a class="pull-left input-width-small icon <?php if(!in_array('NICU_DAY',$write_permission)): ?> permission-denied <?php endif; ?>" href=" <?php if(in_array('NICU_DAY',$write_permission)): ?> <?php echo e(action('Admission\DaycareController@edit', SiteHelpers::encrypt_id($result->DayId)).'?flow=from-dashboard', false); ?> <?php else: ?> javascript:void(0); <?php endif; ?>">
                                    <?php else: ?>
                                    <a class="pull-left input-width-small icon <?php if(!in_array('NICU_DAY',$write_permission)): ?> permission-denied <?php endif; ?>" href=" <?php if(in_array('NICU_DAY',$write_permission)): ?> <?php echo e(action('Admission\DaycareController@edit', SiteHelpers::encrypt_id($result->DayId)), false); ?> <?php else: ?> javascript:void(0); <?php endif; ?>">
                                        <?php endif; ?>
                                        Day <?php echo e($i, false); ?>

                                    </a>
                                    <span class="pull-left">
                                        <?php if(isset($file_list[$result->DayId])): ?>
                                            <?php $__currentLoopData = $file_list[$result->DayId]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo $__env->make('registration.media_list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </span> 
                                </td>
                                <td><?php echo e(date('d-m-Y', strtotime($result->DayDate)), false); ?></td>
                                <?php if($hide=='true'): ?>                      
                                <td  class="center-align-phone hidden-xs">
                                    <a class="btn btn-warning btn-view bs-tooltip" href="<?php echo e(action('Admission\DaycareController@printData',SiteHelpers::encrypt_id($result->DayId)), false); ?>" title="Generated Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td>                 
                                <td  class="center-align-phone hidden-xs">
                                    <a class="btn btn-warning btn-view bs-tooltip" href="<?php echo e(action('Admission\DaycareController@reassessmentPrintData',SiteHelpers::encrypt_id($result->DayId)), false); ?>" title="Generated Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td>
                                <?php if(in_array('NICU_DAY',$delete_permission)): ?>
                                <td  class="center-align-phone hidden-xs">
                                    <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData(<?php echo e($result->DayId, false); ?>)">
                                        <i class="fa fa-trash"></i> 
                                    </a>
                                </td>
                                <?php endif; ?> 
                                <td  class="center-align-phone hidden-xs hide">
                                    <?php if($result->edited): ?>
                                    <a class="btn btn-default btn-view bs-tooltip open-doc-editor" href="<?php echo e(action('Admission\DaycareController@getAbbreviatedsummaryShow',$result->DayId), false); ?>" title="Final Print">
                                        <i class="fa fa-file-word-o"></i> 
                                    </a>         
                                    <?php else: ?>
                                    -
                                    <?php endif; ?>
                                </td>
                                <?php endif; ?>     
                                <?php
                                $daycare_started = '';
                                $daycare_partial = '';
                                $daycare_completed = '';
                                ?> 
                                <?php if($result->form_status == 0): ?>
                                <?php $daycare_started = 'active'; ?>
                                <?php elseif($result->form_status == 1): ?>
                                <?php $daycare_partial = 'active'; ?>
                                <?php else: ?>
                                <?php $daycare_completed = 'active'; ?>
                                <?php endif; ?> 
                                <td  class="center-align-phone hidden-xs">
                                    <span class="status-container">
                                        <strong class="not-started <?php echo e($daycare_started, false); ?>"></strong>
                                        <strong class="partial <?php echo e($daycare_partial, false); ?>"></strong>
                                        <strong class="completed <?php echo e($daycare_completed, false); ?>"></strong>
                                    </span>
                                </td> 
                            <!-- <td>
                                <a class="btn btn-info btn-view bs-tooltip" href="<?php echo e(action('Admission\DaycareController@reassessmentCreate',['day_id'=>SiteHelpers::encrypt_id($result->DayId)]), false); ?>" title="Create Reassessment">
                                      <i class="fa fa-plus"></i> 
                                    </a>
                                <a class="btn btn-primary btn-view bs-tooltip" href="<?php echo e(action('Admission\DaycareController@printData',$result->DayId), false); ?>" title="Edit Reassessment">
                                      <i class="fa fa-edit"></i> 
                                    </a>
                                <a class="btn btn-warning btn-view bs-tooltip" href="<?php echo e(action('Admission\DaycareController@printData',$result->DayId), false); ?>" title="Print">
                                      <i class="fa fa-print"></i> 
                                    </a>
                                </td> -->
                            </tr>
                            <?php $i--; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.col-md-12 -->
    </div>
    <!-- /.row -->
    <!-- /Page Content -->
<!--
    DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
-->   
<?php echo Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']); ?>

<?php echo Form::close(); ?>        
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
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