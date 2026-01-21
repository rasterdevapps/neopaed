<style type="text/css">
    .vaccine-brand-name
    {
        width: 90%;
        float: left;
    }
    .add-vaccine-into-chart, .remove-vaccine-into-chart
    {
        width: 10%;
        float: right;
        margin-left: 10px;
    }
    .vaccine-container svg
    {
        width: 300px;
        height: 50px;
        float: right;
    }
    @media(max-width: 1080px)
    {
        .vaccine-brand-name
        {
            width: 80%;
            float: left;
        }
        .add-vaccine-into-chart, .remove-vaccine-into-chart
        {
            width: 18% !important;
            float: right;
            margin-left: 3px;
        }
        .vaccine-container svg
        {
            width: 200px;
            height: 50px;
            float: right;
        }
    }
    @media(max-width: 810px)
    {
        .vaccine-brand-name
        {
            width: 80%;
            float: left;
        }
        .add-vaccine-into-chart, .remove-vaccine-into-chart
        {
            width: 18% !important;
            float: right;
            margin-left: 0px;
        }
        .vaccine-container svg
        {
            width: 150px;
            height: 50px;
            float: right;
        }
    }
    @media(max-width: 768px)
    {
        .vaccine-brand-name
        {
            width: 80%;
            float: left;
        }
        .add-vaccine-into-chart, .remove-vaccine-into-chart
        {
            width: 18% !important;
            float: right;
            margin-left: 0px;
        }
        .vaccine-container svg
        {
            width: 150px;
            height: 50px;
            float: right;
        }
    }
    .border-enable
    {
        border-bottom: 1px solid #444 !important;
    }
    .border-enable-top
    {
        border-top: 1px solid #444 !important;
    }
    .remove-barcode-svg
    {
        position: absolute;
        top: 17%;
        left: 99%;
        background-color: red;
        color: #fff;
        font-size: 17px;
        opacity: 0.5;
        border-radius: 50%;
        padding: 2px 5px;
    }
    .remove-barcode-svg:hover
    {
        opacity: 1;
        background-color: #fb4f4f;
        color: #fff;
    }
    [id^=vaccine-barcode-td_] div, [id^=vaccine-barcode-td_] div input[type="text"]
    {
        position: relative;
    }
    
</style>
<div class="row vaccine-container">
    <div class="col-md-12">
        <h3 class="text-center" <?php if(isset($is_print)): ?> style="margin: 0px;" <?php endif; ?>>
            <strong>IAP Immunization Timetable</strong> 
            <?php if(!isset($is_print) && isset($baby_detail->BabyId)): ?>
            <a href="<?php echo e(url('out-patient/vaccine-chart-print/'), false); ?>/<?php echo e(\SiteHelpers::encrypt_id($baby_detail->BabyId), false); ?>" class="btn btn-warning pull-right vaccine-chart-print-btn"> PRINT CHART</a>
            <?php endif; ?>
        </h3>
        <div class="<?php if(!isset($is_print)): ?> table-responsive <?php endif; ?>">
            <?php if(count($mas_vaccine_age) > 0): ?>
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="8%">Age</th>
                        <th width="14%">Vaccine</th>
                        <th width="7%">Date Due</th>
                        <th width="7%">Date Given</th>
                        <th width="20%">Brand Name 
                            <?php if(!isset($is_print)): ?> 
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Vaccine" data-destination_elements="temp_vaccines,Vaccine[],vaccine_chart_input[vaccine_brand_name][]" data-option_value="id" data-option_text="Name" data-mas_table="mas_vaccine">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Vaccine"></i>
                            </a>
                            <?php endif; ?>
                        </th>
                        <th width="15%">Bar Code</th>
                        <th width="7%">Signature</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(isset($baby_vaccine_chart) && count($baby_vaccine_chart) != 0): ?>
                    <?php $__currentLoopData = $mas_vaccine_age; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age_key => $age_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $rowspan = 1; ?>
                        <?php if(isset($baby_vaccine_chart[$age_key]) && count($baby_vaccine_chart[$age_key]) > 0): ?>
                            <?php $rowspan = count($baby_vaccine_chart[$age_key]) + 1; ?>
                        <?php endif; ?>
                        <tr> 
                            <td rowspan="<?php echo e($rowspan, false); ?>" style="vertical-align : middle;text-align:center; border-bottom: 1px solid #444 !important; border-top: 1px solid #444 !important;">
                                <h4><strong><?php echo e($age_val, false); ?></strong></h4>
                            </td>
                        </tr>
                        <?php if(isset($baby_vaccine_chart[$age_key]) && count($baby_vaccine_chart[$age_key]) > 0): ?>
                            <?php $start = 0 ; ?>
                            <?php $last_index = count($baby_vaccine_chart[$age_key]) -1; ?>
                            <?php $__currentLoopData = $baby_vaccine_chart[$age_key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart_key => $chart_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $chart_val->id = $chart_val->vaccine_generic_id; ?>
                                <tr>
                                    <td <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <label for="is_given_radio<?php echo e($chart_val->id, false); ?>" style="white-space: nowrap;word-wrap: unset;"><?php echo e($chart_val->name, false); ?></label>

                                        <input type="radio" name="vaccine_chart_input[is_given][<?php echo e($chart_val->id, false); ?>]" class="vaccine-given-radio <?php if(isset($chart_val->is_given) && $chart_val->is_given == 1): ?> checked-radio <?php endif; ?> <?php if(isset($is_print)): ?> hide <?php endif; ?> <?php if(isset($chart_val->is_given) && $chart_val->is_given == 1 && \Auth::user()->RoleId != env('SUPER_ADMIN_ROLE')): ?>not-changable <?php endif; ?>" id="is_given_radio<?php echo e($chart_val->id, false); ?>" value="1" <?php if(isset($chart_val->is_given) && $chart_val->is_given == 1): ?> checked <?php endif; ?> data-vaccine_id = "<?php echo e($chart_val->id, false); ?>" />
                                        <input type="hidden" name="vaccine_chart_input[age_id][<?php echo e($chart_val->id, false); ?>]" value="<?php echo e($age_key, false); ?>" />
                                        <input type="hidden" name="vaccine_chart_input[age_sort_order][<?php echo e($chart_val->id, false); ?>]" value="<?php echo e($chart_val->age_sort_order, false); ?>" />
                                        <input type="hidden" name="vaccine_chart_input[vaccine_sort_order][<?php echo e($chart_val->id, false); ?>]" value="<?php echo e($chart_val->vaccine_sort_order, false); ?>" />
                                        <input type="hidden" id="vaccine_user_given_input_<?php echo e($chart_val->id, false); ?>" name="vaccine_chart_input[user_given][<?php echo e($chart_val->id, false); ?>]" value="<?php if(isset($chart_val->user_given) && !empty($chart_val->user_given) && $chart_val->user_given != 0): ?><?php echo e($chart_val->user_given, false); ?><?php endif; ?>" class="user-given-input" data-vaccine_id="<?php echo e($chart_val->id, false); ?>" />
                                    </td>
                                    <td align="center" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(!isset($is_print)): ?> 
                                        <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_due][<?php echo e($chart_val->id, false); ?>]" readonly id="vaccine_due_date_<?php echo e($chart_val->id, false); ?>" <?php if(isset($chart_val->date_due) && $chart_val->date_due != null && $chart_val->date_due != ''): ?> value="<?php echo e(date('d-m-Y', strtotime($chart_val->date_due)), false); ?>" <?php endif; ?> />
                                        <?php else: ?>
                                            <?php if($chart_val->date_due != '' && $chart_val->date_due != null): ?>
                                                <?php echo e(date('d-m-Y', strtotime($chart_val->date_due)), false); ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td align="center" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(!isset($is_print)): ?> 
                                            <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_given][<?php echo e($chart_val->id, false); ?>]" readonly id="vaccine_given_date_<?php echo e($chart_val->id, false); ?>" <?php if(isset($chart_val->date_given) && $chart_val->date_given != null && $chart_val->date_given != ''): ?> value="<?php echo e(date('d-m-Y', strtotime($chart_val->date_given)), false); ?>" <?php endif; ?> />
                                        <?php else: ?>
                                            <?php if($chart_val->date_given != '' && $chart_val->date_given != null): ?>
                                                <?php echo e(date('d-m-Y', strtotime($chart_val->date_given)), false); ?>

                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td align="center" id="vaccine-select-td_<?php echo e($chart_val->id, false); ?>" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(isset($chart_val->vaccine_details) && $chart_val->vaccine_details != null && $chart_val->vaccine_details != ''): ?>
                                            <?php 
                                                $vaccine_details = json_decode($chart_val->vaccine_details); 
                                                $vaccine_start = 0;
                                            ?>
                                            <?php if(isset($vaccine_details->vaccine)): ?>
                                            <?php $__currentLoopData = $vaccine_details->vaccine; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vac_key => $vac_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if(!isset($is_print)): ?>
                                                    <div class="mt-10">
                                                        <?php echo Form::select('vaccine_chart_input[vaccine_brand_name]['.$chart_val->id.'][]', $vaccine, $vac_val, ['class' => "select2 vaccine-brand-name"]); ?>

                                                        <?php if($vaccine_start == 0): ?>
                                                            <a href="javascript:void(0);" class="add-vaccine-into-chart btn btn-success btn-view" data-vaccine_id="<?php echo e($chart_val->id, false); ?>"><i class="fa fa-plus"></i></a>
                                                        <?php else: ?>
                                                            <a href="javascript:void(0);" class="remove-vaccine-into-chart btn btn-danger btn-view" data-vaccine_id="<?php echo e($chart_val->id, false); ?>"><i class="fa fa-trash"></i></a>
                                                        <?php endif; ?>
                                                        <div class="clearfix"></div>
                                                    </div>  
                                                    
                                                <?php else: ?>
                                                    <?php if($vac_val != 0 && isset($vaccine[$vac_val])): ?>
                                                        <?php echo e($vaccine_start + 1, false); ?>. <?php echo e($vaccine[$vac_val], false); ?>

                                                        <br>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                <?php 
                                                    $vaccine_start++;
                                                ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <div>
                                                <?php echo Form::select('vaccine_chart_input[vaccine_brand_name]['.$chart_val->id.'][]', $vaccine, null, ['class' => "select2 vaccine-brand-name"]); ?>

                                                <a href="javascript:void(0);" class="add-vaccine-into-chart btn btn-success btn-view" data-vaccine_id="<?php echo e($chart_val->id, false); ?>"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="clearfix"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td align="center" id="vaccine-barcode-td_<?php echo e($chart_val->id, false); ?>" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(isset($chart_val->vaccine_details) && $chart_val->vaccine_details != null && $chart_val->vaccine_details != ''): ?>
                                            <?php $vaccine_details = json_decode($chart_val->vaccine_details); ?>
                                            <?php if(isset($vaccine_details->bar_code)): ?>
                                            <?php $__currentLoopData = $vaccine_details->bar_code; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vac_key => $vac_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                                <div class="mt-10">
                                                    <input type="text" name="vaccine_chart_input[vaccine_barcode][<?php echo e($chart_val->id, false); ?>][]" class="form-control input-width-medium barcode-input <?php if(isset($is_print)): ?> hide <?php endif; ?>" data-vaccine_id="<?php echo e($chart_val->id, false); ?>" value="<?php echo e($vac_val, false); ?>" />
                                                    <svg class="hide" id="barcode-img_<?php echo e($chart_val->id, false); ?>"></svg>
                                                    <?php if(!isset($is_print)): ?>
                                                    <a href="javascript:void(0);" class="remove-barcode-svg hide"><i class="fa fa-times"></i></a>
                                                    <?php endif; ?>
                                                    <div class="clearfix"></div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        <?php else: ?>
                                        <div>
                                            <?php if(!isset($is_print)): ?>
                                            <input type="text" name="vaccine_chart_input[vaccine_barcode][<?php echo e($chart_val->id, false); ?>][]" class="form-control input-width-medium barcode-input" data-vaccine_id="<?php echo e($chart_val->id, false); ?>" style="float:left" />
                                            <svg class="hide" id="barcode-img_<?php echo e($chart_val->id, false); ?>"></svg>
                                            <a href="javascript:void(0);" class="remove-barcode-svg hide"><i class="fa fa-times"></i></a>
                                            <div class="clearfix"></div>
                                            <?php endif; ?>
                                        </div>
                                         <?php endif; ?>
                                    </td>
                                    <td <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;" id="user_given_sign_<?php echo e($chart_val->id, false); ?>">

                                    </td>
                                    <?php if($start == 0): ?>
                                        <td rowspan="<?php echo e($rowspan-1, false); ?>" style="vertical-align : middle;text-align:center; border-top: 1px solid #444;"> 
                                            <?php if(!isset($is_print)): ?>
                                            <textarea class="form-control" rows="5" name="vaccine_chart_input[comments][<?php echo e($age_key, false); ?>]"><?php echo e($chart_val->comments, false); ?></textarea>
                                            <?php else: ?>
                                                <?php echo e($chart_val->comments, false); ?>

                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php $start++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <?php $__currentLoopData = $mas_vaccine_age; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $age_key => $age_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $rowspan = 1; ?>
                        <?php if(isset($mas_vaccine_chart[$age_key]) && count($mas_vaccine_chart[$age_key]) > 0): ?>
                            <?php $rowspan = count($mas_vaccine_chart[$age_key]) + 1; ?>
                        <?php endif; ?>
                        <tr> 
                            <td rowspan="<?php echo e($rowspan, false); ?>" style="vertical-align : middle;text-align:center; border-bottom: 1px solid #444 !important; border-top: 1px solid #444 !important;">
                                <h4><strong><?php echo e($age_val, false); ?></strong></h4>
                            </td>
                        </tr>
                        <?php if(isset($mas_vaccine_chart[$age_key]) && count($mas_vaccine_chart[$age_key]) > 0): ?>
                            <?php $start = 0 ; ?>
                            <?php $last_index = count($mas_vaccine_chart[$age_key]) -1; ?>
                            <?php $__currentLoopData = $mas_vaccine_chart[$age_key]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chart_key => $chart_val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <label for="is_given_radio<?php echo e($chart_val->id, false); ?>"><?php echo e($chart_val->name, false); ?></label>
                                        <input type="radio" name="vaccine_chart_input[is_given][<?php echo e($chart_val->id, false); ?>]" class="vaccine-given-radio <?php if(isset($is_print)): ?> hide <?php endif; ?>" id="is_given_radio<?php echo e($chart_val->id, false); ?>" value="1" data-vaccine_id="<?php echo e($chart_val->id, false); ?>"/>
                                        <input type="hidden" name="vaccine_chart_input[age_id][<?php echo e($chart_val->id, false); ?>]" value="<?php echo e($age_key, false); ?>" />
                                        <input type="hidden" name="vaccine_chart_input[age_sort_order][<?php echo e($chart_val->id, false); ?>]" value="<?php echo e($chart_val->age_sort_order, false); ?>" />
                                        <input type="hidden" name="vaccine_chart_input[vaccine_sort_order][<?php echo e($chart_val->id, false); ?>]" value="<?php echo e($chart_val->sort_order, false); ?>" />
                                        <input type="hidden" id="vaccine_user_given_input_<?php echo e($chart_val->id, false); ?>" name="vaccine_chart_input[user_given][<?php echo e($chart_val->id, false); ?>]" class="user-given-input" data-vaccine_id="<?php echo e($chart_val->id, false); ?>" />
                                    </td>
                                    <td align="center" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(!isset($is_print)): ?> 
                                        <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_due][<?php echo e($chart_val->id, false); ?>]" readonly id="vaccine_due_date_<?php echo e($chart_val->id, false); ?>" />
                                        <?php endif; ?>
                                    </td>
                                    <td align="center" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(!isset($is_print)): ?> 
                                        <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_given][<?php echo e($chart_val->id, false); ?>]" readonly id="vaccine_given_date_<?php echo e($chart_val->id, false); ?>" />
                                        <?php endif; ?>
                                    </td>
                                    <td align="center" id="vaccine-select-td_<?php echo e($chart_val->id, false); ?>" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(!isset($is_print)): ?>
                                        <div>
                                            <?php echo Form::select('vaccine_chart_input[vaccine_brand_name]['.$chart_val->id.'][]', $vaccine, null, ['class' => "select2 vaccine-brand-name"]); ?>

                                            <a href="javascript:void(0);" class="add-vaccine-into-chart btn btn-success btn-view" data-vaccine_id="<?php echo e($chart_val->id, false); ?>"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        <?php endif; ?>
                                    </td>
                                    <td align="center" id="vaccine-barcode-td_<?php echo e($chart_val->id, false); ?>" <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;">
                                        <?php if(!isset($is_print)): ?>
                                        <div>
                                            <input type="text" name="vaccine_chart_input[vaccine_barcode][<?php echo e($chart_val->id, false); ?>][]" class="form-control input-width-medium barcode-input" data-vaccine_id="<?php echo e($chart_val->id, false); ?>" />
                                            <svg class="hide" id="barcode-img_<?php echo e($chart_val->id, false); ?>"></svg>
                                            <a href="javascript:void(0);" class="remove-barcode-svg hide"><i class="fa fa-times"></i></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                    <td <?php if($start == 0): ?> class="border-enable-top" <?php elseif($last_index == $start): ?> class="border-enable" <?php endif; ?> style="vertical-align : middle;text-align:center;" id="user_given_sign_<?php echo e($chart_val->id, false); ?>">

                                    </td>
                                    <?php if($start == 0): ?>
                                        <td rowspan="<?php echo e($rowspan-1, false); ?>" style="vertical-align : middle;text-align:center; border-top: 1px solid #444;"> 
                                            <?php if(!isset($is_print)): ?>
                                                <textarea class="form-control" rows="5" name="vaccine_chart_input[comments][<?php echo e($age_key, false); ?>]"></textarea>
                                            <?php endif; ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <?php $start++; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                </tbody>
            </table>
            <?php endif; ?>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo e(url('/'), false); ?>/public/js/barcode.js"></script>
<script type="text/javascript">
    var current_user_id = '<?php echo e(\Auth::user()->id, false); ?>';
    var user_sign = JSON.parse('<?php echo $user_sign ?>');
    $('.user-given-input').each(function()
    {
        var vaccine_id = $(this).data('vaccine_id');
        if ($('#is_given_radio'+vaccine_id+'').prop('checked') === true) {
            var user_given_val = $('#vaccine_user_given_input_'+vaccine_id).val();
            if (user_sign[user_given_val] !== undefined && user_sign[user_given_val] != null && user_sign[user_given_val] != '') {
                var user_image = '<img src="<?php echo e(url('/'), false); ?>/public/img/users/'+user_sign[user_given_val]+'" alt="Doctor sign" />'
                $('#user_given_sign_'+vaccine_id).html(user_image);
            }
        }
    });
    $(document).ready(function()
    {
        $('.barcode-input').each(function()
        {
            if ($(this).val()) {
                var svgElement = this.parentNode.getElementsByTagName( 'svg' )[ 0 ];
                svgElement.className.baseVal = "";
                JsBarcode(this.parentNode.getElementsByTagName( 'svg' )[ 0 ], $(this).val(), 
                {
                    format: 'CODE128',
                    width:4,
                    height: 60,
                    displayValue: false
                });
                $(this).parent().find('.remove-barcode-svg').removeClass('hide');
                $(this).addClass('hide');
            }
        });
    });
    $(document).on('click', '.remove-barcode-svg', function(){
        var svgElement = this.parentNode.getElementsByTagName( 'svg' )[ 0 ];
        svgElement.className.baseVal = "hide";
        svgElement.innerHtml =  '';
        $(this).addClass('hide');
        $(this).siblings('input[type="text"]').val('').removeClass('hide');
    });
    $(document).on('blur', '.barcode-input', function(){
        if ($(this).val()) {
            var svgElement = this.parentNode.getElementsByTagName( 'svg' )[ 0 ];
            svgElement.className.baseVal = "";
            JsBarcode(this.parentNode.getElementsByTagName( 'svg' )[ 0 ], $(this).val(), 
            {
                format: 'CODE128',
                width:4,
                height: 60,
                displayValue: false
            });
            $(this).addClass('hide');
            $(this).parent().find('.remove-barcode-svg').removeClass('hide');

        }
    });

    $('.add-vaccine-into-chart').click(function(e)
    {  
        var vaccine_id = $(this).data('vaccine_id');
        var options = $('select[name="temp_vaccines"]').html();
        var new_element = '<div class="mt-10"><select name="vaccine_chart_input[vaccine_brand_name]['+vaccine_id+'][]">'+options+'</select><a href="javascript:void(0);" class="remove-vaccine-into-chart btn btn-danger btn-view" data-vaccine_id="'+vaccine_id+'"><i class="fa fa-trash"></i></a></div>';
        $(this).parents('td').append(new_element);
        $('#vaccine-select-td_'+vaccine_id+' div').last().children('select[name^="vaccine_chart_input[vaccine_brand_name]"]').select2();
        
        var bar_code_new_element = '<div class="barcode-image-div_'+vaccine_id+' mt-10"><input type="text" name="vaccine_chart_input[vaccine_barcode]['+vaccine_id+'][]" class="form-control input-width-medium barcode-input" /><svg class="hide" id="barcode-img_'+vaccine_id+'"></svg><a href="javascript:void(0);" class="remove-barcode-svg hide"><i class="fa fa-times"></i></a><div class="clearfix"></div></div>';
        
        $('#vaccine-barcode-td_'+vaccine_id).append(bar_code_new_element);
    });

    $(document).on('click', '.vaccine-chart-print-btn', function(e)
    {
        e.preventDefault();
        var url = $(this).attr('href');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type:'POST',
            url:'<?php echo e(url("out-patient/save-vaccine-chart-patient-data"), false); ?>',
            data: $('.vaccine-container input[name^="vaccine_chart_input"], .vaccine-container select[name^="vaccine_chart_input"], .vaccine-container textarea[name^="vaccine_chart_input"], input[name="BabyId"], input[name="module"]').serialize(),
            beforeSend:function() {

            },
            success:function(response) {
                window.location = url;
            },
            complete:function(response) {
            },

            error:function(response) {
                Showalert('error', 'Something went wrong, Please try again later...!');
            }
        });
    });
    $(document).on('click', '.remove-vaccine-into-chart', function(e)
    {
        var vaccine_id = $(this).data('vaccine_id');
        var index = $(this).parent().index();
        $(this).parent().remove();
        console.log(index-1);
        $('#vaccine-barcode-td_'+vaccine_id).children().eq(index - 1).remove();
    });
    $('.vaccine-given-radio').click(function(e)
    {
        var vaccine_id = $(this).data('vaccine_id');
        if (!$(this).hasClass('not-changable')) {
            if ($(this).hasClass('checked-radio')) {
                $(this).removeClass('checked-radio').prop('checked', false);
                $('#vaccine_user_given_input_'+vaccine_id).val('0');
                $('#user_given_sign_'+vaccine_id).html('');
            }
            else
            {
                $(this).addClass('checked-radio').prop('checked', true);
                $('#vaccine_user_given_input_'+vaccine_id).val(current_user_id);
                if (user_sign[current_user_id] !== undefined && user_sign[current_user_id] != null && user_sign[current_user_id] != '') {
                    var user_image = '<img src="<?php echo e(url('/'), false); ?>/public/img/users/'+user_sign[current_user_id]+'" alt="Doctor sign" />'
                    $('#user_given_sign_'+vaccine_id).html(user_image);
                }
            }
        }
    });
</script>
