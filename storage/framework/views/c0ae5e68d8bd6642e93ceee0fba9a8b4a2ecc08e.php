<?php $__env->startSection('content'); ?>
<?php
$write_permission = session('write_permission');
$delete_permission = session('delete_permission');
?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="<?php echo e(url('/'), false); ?>">Dashboard</a></li>
        <li><a href="<?php echo e(action('Registration\OpController@index'), false); ?>">OP Registration</a></li>
        <li class="current"><a href="javascript:void(0);">History of <span class="text-captialize"><?php echo e($baby_name, false); ?></span></a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>OP Registration</h4>
                <?php if(in_array('OP_REG',$write_permission)): ?>
                    <a href="<?php echo e(action('Registration\OpController@chooseBaby'), false); ?>" title="" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right"><i class="fa fa-plus "></i> <span>Create New</span></a>
                <?php endif; ?>
                <?php if(in_array('LABREQUEST',$write_permission)): ?>
                    <a href="<?php echo e(action('Nurse\NurseSheetController@overallLabValuePrint', $baby_mrn).'?closewinlink=neonatal-op-visit-list', false); ?>" class="btn btn-primary create-btn-spacing mr-15 pull-right">
                        <i class="fa fa-print"></i>
                        <span>Lab Report</span>
                    </a>
                <?php endif; ?>
                <?php
                    $pacs_link = \SiteHelpers::pacsViewerLink();
                    $pacs_link = str_replace('MRN', $baby_mrn, $pacs_link);
                ?>
                <a href="<?php echo e($pacs_link, false); ?>" target="_blank" class="btn btn-default create-btn-spacing btn-basic-shadow pull-right btn-custom-pacs">
                    <i class="fas fa-x-ray"></i>
                    <span>PACS</span>
                </a>
            </div>
            <div class="widget-content inherittable">
                <table class="table table-striped table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th class="hidden">No.</th>
                            <th>Visits</th>
                            <th data-hide="phone,tablet"><?php echo e(Lang::get('home.ip'), false); ?></th>
                            <th data-hide="phone,tablet">Op Date</th>
                            <th class="center-align-phone">Neonatal OP Print</th>
                            <?php if(in_array('OP_REG',$delete_permission)): ?>
                                <th class="center-align-phone">Delete</th>
                            <?php endif; ?>
                            <th class="center-align-phone">Neuro OP Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            $total_count = $visite_list['count'];
                        ?>
                        <?php $__currentLoopData = $visite_list['lists']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $neonatal_list = isset($value['neonatal']) ? $value['neonatal'] : [];
                                $neuro_list = isset($value['neuro']) ? $value['neuro'] : [];

                                $neonatal_count = count($neonatal_list);
                                $neuro_count = count($neuro_list);
                                $count = $neuro_count > $neonatal_count ? $neuro_count : $neonatal_count;
                            ?>
                            <?php for($k = 0; $k < $count; $k++): ?>
                                <tr>
                                    <?php
                                        unset($neonatal_op_visit);
                                        unset($neuro_op_visit);
                                    ?>
                                    <?php if(isset($neonatal_list[$k])): ?>
                                        <?php
                                            $neonatal_op_visit = (object)$neonatal_list[$k];
                                        ?>
                                    <?php endif; ?>
                                    <?php if(isset($neuro_list[$k])): ?>
                                        <?php
                                            $neuro_op_visit = (object)$neuro_list[$k];
                                        ?>
                                    <?php endif; ?>
                                    <?php if(isset($neonatal_op_visit)): ?>
                                        <td class="text-left">
                                            <a class="pull-left input-width-small icon  <?php if(!in_array('OP_REG',$write_permission)): ?> permission-denied <?php endif; ?>" href="<?php if(in_array('OP_REG',$write_permission)): ?> <?php echo e(action('Registration\OpController@edit', SiteHelpers::encrypt_id($neonatal_op_visit->OpId)), false); ?> <?php else: ?> javascript:void(0); <?php endif; ?>">
                                                <?php
                                                $visit_count = $total_count - $i;
                                                ?>
                                                <?php if(strlen($visit_count) == 1): ?>
                                                Visit-00<?php echo e($visit_count, false); ?>

                                                <?php elseif(strlen($visit_count) == 2): ?>
                                                Visit-0<?php echo e($visit_count, false); ?>

                                                <?php endif; ?>
                                            </a>
                                            <span class="pull-left">
                                                <?php if(isset($file_list[$neonatal_op_visit->OpId])): ?>
                                                <?php $__currentLoopData = $file_list[$neonatal_op_visit->OpId]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo $__env->make('registration.media_list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td><?php echo e($neonatal_op_visit->visit_number, false); ?></td>
                                        <td><?php echo e(date('d-m-Y',strtotime($neonatal_op_visit->visit_date)), false); ?></td>
                                        <td class="center-align-phone">
                                            <a class="btn btn-warning btn-view" href="<?php echo e(action('Registration\OpController@show', SiteHelpers::encrypt_id($neonatal_op_visit->OpId)), false); ?>" title="Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                        <?php if(in_array('OP_REG',$delete_permission)): ?>
                                            <td  class="center-align-phone">
                                                <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData(<?php echo e($neonatal_op_visit->OpId, false); ?>)">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                        <?php if(isset($neuro_op_visit)): ?>
                                        <td  class="center-align-phone <?php echo e(!isset($neonatal_op_visit) ? 'neuro-op-color' : '', false); ?>">
                                            <a class="btn btn-warning btn-view" href="<?php echo e(action('Registration\NeuroController@show', SiteHelpers::encrypt_id($neuro_op_visit->id)).'?closewinlink=neonatal-op-list-view', false); ?>" title="Final Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                        <?php else: ?>
                                        <td>-</td>
                                        <?php endif; ?>
                                    <?php elseif(isset($neuro_op_visit)): ?>
                                        <td class="text-left neuro-op-color">
                                            <span class="pull-left input-width-small icon">
                                                <?php
                                                $visit_count = $total_count - $i;
                                                ?>
                                                <?php if(strlen($visit_count) == 1): ?>
                                                Visit-00<?php echo e($visit_count, false); ?>

                                                <?php elseif(strlen($visit_count) == 2): ?>
                                                Visit-0<?php echo e($visit_count, false); ?>

                                                <?php endif; ?>
                                            </span>
                                        </td>
                                        <td class="neuro-op-color"><?php echo e($neuro_op_visit->visit_number, false); ?></td>
                                        <td class="neuro-op-color"><?php echo e(date('d-m-Y',strtotime($neuro_op_visit->visit_date)), false); ?></td>
                                        <td class="neuro-op-color">-</td>
                                        <td class="neuro-op-color">-</td>
                                        <td  class="center-align-phone <?php echo e(!isset($neonatal_op_visit) ? 'neuro-op-color' : '', false); ?>">
                                            <a class="btn btn-warning btn-view" href="<?php echo e(action('Registration\NeuroController@show', SiteHelpers::encrypt_id($neuro_op_visit->id)).'?closewinlink=neonatal-op-list-view', false); ?>" title="Final Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php  $i++; ?>
                            <?php endfor; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- /.col-md-12 -->
<!-- DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK -->
<?php echo Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']); ?>

<?php echo Form::close(); ?>

</div>

<!-- /.row -->
<!-- /Page Content -->

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">

    function DeleteData(id){
       bootbox.confirm("Are you sure?",function(confirmed){
          if(confirmed){
             $("#DeleteForm").attr('action',"<?php echo e(action('Registration\OpController@index'), false); ?>/"+id);
             $("#DeleteForm").submit();
         }
     });
   }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>