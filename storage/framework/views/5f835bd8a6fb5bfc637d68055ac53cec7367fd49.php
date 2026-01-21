<script type="text/javascript">
var currentStatus = [];
var development = [];
var examination = [];
var diagnosis = [];
var advice =[];

<?php if(isset($ac_current_status) && !empty($ac_current_status)): ?>
 <?php $__currentLoopData = $ac_current_status; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

     currentStatus.push('<?php echo e($status, false); ?>');

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>


<?php if(isset($ac_current_status) && !empty($ac_current_status)): ?>
  <?php $__currentLoopData = $ac_development; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

     development.push('<?php echo e($status, false); ?>');

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if(isset($ac_current_status) && !empty($ac_current_status)): ?>
 <?php $__currentLoopData = $ac_examination; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

     examination.push('<?php echo e($status, false); ?>');

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(isset($ac_current_status) && !empty($ac_current_status)): ?>
 <?php $__currentLoopData = $ac_diagnosis; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

     diagnosis.push('<?php echo e($status, false); ?>');

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(isset($ac_current_status) && !empty($ac_current_status)): ?>
  <?php $__currentLoopData = $ac_advice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

     advice.push('<?php echo e($status, false); ?>');

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>



 $('#Complaints').autoCompleteRaster({
    statements:currentStatus,
 }); 

 $('#Development').autoCompleteRaster({
    statements:development,
 }); 

 $('#Examination').autoCompleteRaster({
    statements:examination,
 });

 $('#Diagnosis').autoCompleteRaster({
    statements:diagnosis,
 });
  
 $('#Advice').autoCompleteRaster({
    statements:advice,
 }); 

<?php if(@$results->neurosonogram == 2): ?>

   $('#neurosonogram').bootstrapToggle('on');

<?php endif; ?>

<?php if(@$results->echocardiogram == 2): ?>

   $('#echocardiogram').bootstrapToggle('on');

<?php endif; ?>

<?php if(@$results->fee_status == 1): ?>
   
   $('#fee_status').bootstrapToggle('on');
   
<?php endif; ?>

<?php if(@$results->need_neuro == 1): ?>
   
   $('#need_neuro').bootstrapToggle('on');
   
<?php endif; ?>
</script>
