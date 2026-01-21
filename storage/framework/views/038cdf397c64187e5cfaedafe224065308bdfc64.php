
<?php $__env->startSection('content'); ?>
    <style type="text/css">
        #score-data-container #score-block {
            display: inline-block;
            background: black;
            font-size: 24px;
            color: white;
            padding: 5px 15px;
            margin: 5px;
            border-radius: 4px;
        }

        th.active,
        td.active {
            /* background-color: #ffb3b3 !important; */
            /* Removed active highlighting for readability in 3-col layout, or keep it differently */
        }

        .score-value {
            font-weight: bold;
        }

        .score-points {
            color: #888;
            font-size: 0.9em;
        }
    </style>
    <!-- Breadcrumbs line -->
    <div class="crumbs bread-crumbs-shadow">
        <ul id="breadcrumbs" class="breadcrumb">
            <li><i class="icon-home"></i><a href="<?php echo e(url('/'), false); ?>">Dashboard</a></li>
            <li class="current"><a href="<?php echo e(action('Reports\MSNSController@index'), false); ?>">MSNS Report</a></li>
        </ul>
    </div>
    <!-- /Breadcrumbs line -->
    <!--=== Page Content ===-->
    <div class="row row-spacing" id="msns-block">
        <div class="col-md-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4>MSNS Report</h4>
                </div>
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="row mb-15">
                                <?php echo Form::model(null, ['method' => 'GET', 'id' => 'msns-filter']); ?>

                                <div class="col-md-4">
                                    <label>Select Baby:</label>
                                    <?php echo Form::select('baby', ['N/A' => '-- Select --'] + $babies, $baby_id, ['class' => 'full-width', 'id' => 'ssearch', 'required']); ?>

                                    <p class="error-message hide" id="baby-error">Baby name is required !</p>
                                </div>
                                <div class="col-md-3" id="admission-container" style="display: none;">
                                    <label>Select Admission:</label>
                                    <?php echo Form::select('Admission_id', ['0' => '-- Select Admission --'], null, ['class' => 'full-width', 'id' => 'Admission_id']); ?>

                                    <p class="error-message hide" id="admission-error">Please Select Admission !</p>
                                </div>

                                <div class="col-md-2" style="margin-top: 25px;">
                                    <button type="button" class="btn btn-primary" id="generate-score">Generate
                                        Report</button>
                                </div>
                                <div class="col-md-5 text-right" id="patient-info" style="margin-top: 25px; display: none;">
                                    <strong>DOB:</strong> <span id="display-dob"></span> |
                                    <strong>LoS:</strong> <span id="display-los"></span>
                                </div>
                                <?php echo Form::close(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget box" id="report-container" style="display: none;">
                <div class="widget-content">
                    <div class="row">
                        <div class="col-md-12" id="msns-container">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="25%">Parameter</th>
                                        <th width="25%" id="th-admission">On Admission</th>
                                        <th width="25%" id="th-24h">24 Hours</th>
                                        <th width="25%" id="th-72h">72 Hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Rows will be simpler now, just showing value (score) -->
                                    <?php
                                        $params = [
                                            'rr' => 'Respiratory rate (cycles/minute)',
                                            'hr' => 'Heart rate (beats/minute)',
                                            'temp' => 'Temperature (C)',
                                            'cft' => 'Capillary refill time (seconds)',
                                            'rbs' => 'Random blood sugar (mg/dL)',
                                            'os' => 'Oxygen saturation (%)',
                                            'ga' => 'Gestational age (weeks)',
                                            'bw' => 'Birth weight (kg)'
                                        ];
                                    ?>
                                    <?php $__currentLoopData = $params; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($label, false); ?></td>
                                            <td id="td-<?php echo e($key, false); ?>-admission"></td>
                                            <td id="td-<?php echo e($key, false); ?>-24h"></td>
                                            <td id="td-<?php echo e($key, false); ?>-72h"></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><strong>Total MSNS Score</strong></th>
                                        <th>
                                            <div id="score-admission" class="text-center"
                                                style="font-size: 1.5em; font-weight: bold;">-</div>
                                        </th>
                                        <th>
                                            <div id="score-24h" class="text-center"
                                                style="font-size: 1.5em; font-weight: bold;">-</div>
                                        </th>
                                        <th>
                                            <div id="score-72h" class="text-center"
                                                style="font-size: 1.5em; font-weight: bold;">-</div>
                                        </th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            $('select[name="baby"]').select2();
            $('#Admission_id').select2();

            // If baby_id is present (from redirect/controller), trigger load
            if ($('#ssearch').val() != 'N/A') {
                get_admission();
            }

            $('#ssearch').change(function () {
                get_admission();
            });

            $('#Admission_id').change(function () {
                var admissionId = $(this).val();
                if (admissionId != 0) {
                    get_report();
                }
            });

            $('#generate-score').on('click', function () {
                get_report();
            });

            function get_admission() {
                var babyID = $('#ssearch').val();
                var site_url = $('input[name="site_base_url"]').val();
                if (babyID != 'N/A') {
                    $.ajax({
                        type: 'GET',
                        url: site_url + "/msns-get-admission/" + babyID,
                        beforeSend: function () {
                            $('#admission-container').hide();
                            $('#generate-score').attr('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Loading...');
                        },
                        success: function (responseText) {
                            var admissionOption = '';
                            var count = 0;
                            var lastId = 0;
                            $.each(responseText.data, function (index, value) {
                                admissionOption += '<option value=' + value.id + '>' + value.episodes + '</option>';
                                lastId = value.id;
                                count++;
                            });

                            $('#Admission_id').html('<option value="0">-- Select Admission --</option>' + admissionOption);

                            if (count == 1) {
                                // Single admission, auto-generate
                                $('#Admission_id').val(lastId).trigger('change');
                                $('#admission-container').hide();
                            } else if (count > 1) {
                                // Multiple admissions, show dropdown
                                $('#admission-container').show();
                            } else {
                                alert('No admissions found for this baby.');
                            }
                        },
                        complete: function () {
                            $('#generate-score').removeAttr('disabled').html('Generate Report');
                        }
                    });
                } else {
                    $('#admission-container').hide();
                    $('#generate-score').attr('disabled', true);
                }
            }

            function get_report() {
                var babyId = $('#ssearch').val();
                var admissionId = $('#Admission_id').val();

                if (babyId == 'N/A') {
                    $('#baby-error').removeClass('hide');
                    return;
                } else {
                    $('#baby-error').addClass('hide');
                }

                if (admissionId == 0) {
                    $('#admission-error').removeClass('hide');
                    return;
                } else {
                    $('#admission-error').addClass('hide');
                }

                var button_content = $('#generate-score').html();
                var site_url = $('input[name="site_base_url"]').val();

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'GET',
                    data: {
                        baby_id: babyId,
                        id: admissionId // id maps to admission_id in controller
                    },
                    url: site_url + '/msns-report-view',
                    beforeSend: function () {
                        $('#generate-score').html('<i class="fa fa-spinner fa-spin"></i> ' + button_content);
                        $('#generate-score').attr('disabled', true);
                        $('#report-container').hide();
                        $('#patient-info').hide();
                    },
                    success: function (response) {
                        // Update Patient Info
                        $('#display-dob').text(response.dob);
                        $('#display-los').text(response.los);
                        $('#patient-info').show();

                        // Update Headers with Labels and Timestamps
                        $('#th-admission').html('On Admission <br><small class="text-muted">' + response.formatted_times.admission + '</small>');
                        $('#th-24h').html('24 Hours <br><small class="text-muted">' + response.formatted_times['24h'] + '</small>');
                        $('#th-72h').html('72 Hours <br><small class="text-muted">' + response.formatted_times['72h'] + '</small>');

                        // Render Columns
                        renderColumn('admission', response.scores.admission);
                        renderColumn('24h', response.scores['24h']);
                        renderColumn('72h', response.scores['72h']);

                        $('#report-container').show();
                    },
                    error: function () {
                        alert('Error generating report. Please check if the baby has a valid admission.');
                    },
                    complete: function () {
                        $('#generate-score').html(button_content);
                        $('#generate-score').removeAttr('disabled');
                    }
                });
            }

        function renderColumn(suffix, data) {
            var keys = ['rr', 'hr', 'temp', 'cft', 'rbs', 'os', 'ga', 'bw'];

            if (data == null) {
                // Future time or no data
                keys.forEach(function (key) {
                    $('#td-' + key + '-' + suffix).html('<span class="text-muted">-</span>');
                });
                $('#score-' + suffix).text('-');
            } else {
                keys.forEach(function (key) {
                    var item = data.breakdown[key];
                    var html = '';
                    if (item && item.value != null && item.value != 'N/A') {
                        html = '<span class="score-value">' + item.value + '</span> <br> <span class="score-points">(' + item.score + ')</span>';
                    } else {
                        html = '<span class="text-muted">N/A</span>';
                    }
                    $('#td-' + key + '-' + suffix).html(html);
                });
                $('#score-' + suffix).text(data.total_score);
            }
        }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>