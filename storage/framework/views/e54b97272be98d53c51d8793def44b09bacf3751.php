<?php 
      $results = (isset($baby)) ? (array) $baby : (array) $results;
?>
<?php 
      $togglesDetails = ['VentilationRequired', 'delivery_cpap', 'Ventilation', 'UAC', 'UVC', 'ParentsSpokenTo', 'NextAppointmentStatus'];
    $toggleValues = $results;
?>
<?php 
      $tagsids = ['DescriptionOfResuscitation', 'MajorComplaints', 'Plan', 'MattersDiscussed', 'FinalDiagnosis', 'Advice'];
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#Investigations').tagsinput({
            allowDuplicates: false
        });
        if ($('#Investigations').val() && $('#Investigations').val() != '' && $('#Investigations').val() != null) {
            var investigation_values = $('#Investigations').val().split(',');
            if (investigation_values.length > 0) {
                $.each(investigation_values, function (index, value) {
                    $('#Investigations').tagsinput('add', value);
                });
            }
        }
    });

    <?php $__currentLoopData = $togglesDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $values): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(isset($toggleValues[$values]) && is_null($toggleValues[$values]) || empty($toggleValues[$values]) || $toggleValues[$values] == 'No'): ?>
            $('#' + "<?php echo e($values, false); ?>").bootstrapToggle('off');
        <?php elseif(isset($toggleValues[$values]) && !is_null($toggleValues[$values]) && $toggleValues[$values] == 'Yes'): ?>
            $('#' + "<?php echo e($values, false); ?>").bootstrapToggle('on');
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    $('#echocardiography_status').on('change', function () {
        echoCardiographyReport();
    });
    $('#discharge_cuss').on('change', function () {
        cranialUltrasoundReport();
    });
    $(document).ready(function () {
        $('#RopScreening').on('change', function () {
            nicuropDependancy();
        });
        $('#ROPTreatment').on('change', function () {
            nicuropTreatementDependancy();
        });
        $('#HearingScreening').on('change', function () {
            nicuhearingDependancy();
        });
        nicuropDependancy();
        nicuropTreatementDependancy();
        nicuhearingDependancy();
        echoCardiographyReport();
        cranialUltrasoundReport();
        $('select[name="investigations_test"]').on('change', function (e) {
            if (typeof e.added != 'undefined') {
                var package_id = e.added.id;
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        package_id: package_id
                    },
                    url: "<?php echo e(action('Masters\InvestigationsController@getTestList'), false); ?>",
                    success: function (response) {
                        var result = response.results;
                        var package_id = '';
                        var test_name = '';
                        $.each(result, function (key, value) {
                            $.each(value, function (test_key, test_value) {
                                $('#Investigations').tagsinput('add', test_value.test_name);
                            });
                        });
                    }
                });
            }
        });
    });

    $('select[name="investigations_test"]').on("removed", function (e) {
        var removed_value = e.val;
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            data: {
                package_id: removed_value
            },
            url: "<?php echo e(action('Masters\InvestigationsController@getTestList'), false); ?>",
            success: function (response) {
                var result = response.results;
                $.each(result, function (key, value) {
                    $.each(value, function (test_key, test_value) {
                        $('#Investigations').tagsinput('remove', test_value.test_name);
                    });
                });
            }
        });
    });
</script>