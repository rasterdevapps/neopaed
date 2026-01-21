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
        <h3 class="text-center" @if(isset($is_print)) style="margin: 0px;" @endif>
            <strong>IAP Immunization Timetable</strong> 
            @if(!isset($is_print) && isset($baby_detail->BabyId))
            <a href="{{ url('out-patient/vaccine-chart-print/') }}/{{ \SiteHelpers::encrypt_id($baby_detail->BabyId) }}" class="btn btn-warning pull-right vaccine-chart-print-btn"> PRINT CHART</a>
            @endif
        </h3>
        <div class="@if(!isset($is_print)) table-responsive @endif">
            @if(count($mas_vaccine_age) > 0)
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th width="8%">Age</th>
                        <th width="14%">Vaccine</th>
                        <th width="7%">Date Due</th>
                        <th width="7%">Date Given</th>
                        <th width="20%">Brand Name 
                            @if(!isset($is_print)) 
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Vaccine" data-destination_elements="temp_vaccines,Vaccine[],vaccine_chart_input[vaccine_brand_name][]" data-option_value="id" data-option_text="Name" data-mas_table="mas_vaccine">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Vaccine"></i>
                            </a>
                            @endif
                        </th>
                        <th width="15%">Bar Code</th>
                        <th width="7%">Signature</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                @if(isset($baby_vaccine_chart) && count($baby_vaccine_chart) != 0)
                    @foreach($mas_vaccine_age as $age_key => $age_val)
                        @php $rowspan = 1; @endphp
                        @if(isset($baby_vaccine_chart[$age_key]) && count($baby_vaccine_chart[$age_key]) > 0)
                            @php $rowspan = count($baby_vaccine_chart[$age_key]) + 1; @endphp
                        @endif
                        <tr> 
                            <td rowspan="{{ $rowspan }}" style="vertical-align : middle;text-align:center; border-bottom: 1px solid #444 !important; border-top: 1px solid #444 !important;">
                                <h4><strong>{{ $age_val }}</strong></h4>
                            </td>
                        </tr>
                        @if(isset($baby_vaccine_chart[$age_key]) && count($baby_vaccine_chart[$age_key]) > 0)
                            @php $start = 0 ; @endphp
                            @php $last_index = count($baby_vaccine_chart[$age_key]) -1; @endphp
                            @foreach($baby_vaccine_chart[$age_key] as $chart_key => $chart_val)
                                @php $chart_val->id = $chart_val->vaccine_generic_id; @endphp
                                <tr>
                                    <td @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        <label for="is_given_radio{{ $chart_val->id }}" style="white-space: nowrap;word-wrap: unset;">{{ $chart_val->name }}</label>

                                        <input type="radio" name="vaccine_chart_input[is_given][{{ $chart_val->id }}]" class="vaccine-given-radio @if(isset($chart_val->is_given) && $chart_val->is_given == 1) checked-radio @endif @if(isset($is_print)) hide @endif @if(isset($chart_val->is_given) && $chart_val->is_given == 1 && \Auth::user()->RoleId != env('SUPER_ADMIN_ROLE'))not-changable @endif" id="is_given_radio{{ $chart_val->id }}" value="1" @if(isset($chart_val->is_given) && $chart_val->is_given == 1) checked @endif data-vaccine_id = "{{ $chart_val->id }}" />
                                        <input type="hidden" name="vaccine_chart_input[age_id][{{ $chart_val->id }}]" value="{{ $age_key }}" />
                                        <input type="hidden" name="vaccine_chart_input[age_sort_order][{{ $chart_val->id }}]" value="{{ $chart_val->age_sort_order }}" />
                                        <input type="hidden" name="vaccine_chart_input[vaccine_sort_order][{{ $chart_val->id }}]" value="{{ $chart_val->vaccine_sort_order }}" />
                                        <input type="hidden" id="vaccine_user_given_input_{{ $chart_val->id }}" name="vaccine_chart_input[user_given][{{ $chart_val->id }}]" value="@if(isset($chart_val->user_given) && !empty($chart_val->user_given) && $chart_val->user_given != 0){{ $chart_val->user_given }}@endif" class="user-given-input" data-vaccine_id="{{ $chart_val->id }}" />
                                    </td>
                                    <td align="center" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(!isset($is_print)) 
                                        <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_due][{{ $chart_val->id }}]" readonly id="vaccine_due_date_{{ $chart_val->id }}" @if(isset($chart_val->date_due) && $chart_val->date_due != null && $chart_val->date_due != '') value="{{ date('d-m-Y', strtotime($chart_val->date_due)) }}" @endif />
                                        @else
                                            @if($chart_val->date_due != '' && $chart_val->date_due != null)
                                                {{ date('d-m-Y', strtotime($chart_val->date_due)) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td align="center" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(!isset($is_print)) 
                                            <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_given][{{ $chart_val->id }}]" readonly id="vaccine_given_date_{{ $chart_val->id }}" @if(isset($chart_val->date_given) && $chart_val->date_given != null && $chart_val->date_given != '') value="{{ date('d-m-Y', strtotime($chart_val->date_given)) }}" @endif />
                                        @else
                                            @if($chart_val->date_given != '' && $chart_val->date_given != null)
                                                {{ date('d-m-Y', strtotime($chart_val->date_given)) }}
                                            @endif
                                        @endif
                                    </td>
                                    <td align="center" id="vaccine-select-td_{{ $chart_val->id }}" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(isset($chart_val->vaccine_details) && $chart_val->vaccine_details != null && $chart_val->vaccine_details != '')
                                            @php 
                                                $vaccine_details = json_decode($chart_val->vaccine_details); 
                                                $vaccine_start = 0;
                                            @endphp
                                            @if (isset($vaccine_details->vaccine))
                                            @foreach($vaccine_details->vaccine as $vac_key => $vac_val)
                                                @if(!isset($is_print))
                                                    <div class="mt-10">
                                                        {!! Form::select('vaccine_chart_input[vaccine_brand_name]['.$chart_val->id.'][]', $vaccine, $vac_val, ['class' => "select2 vaccine-brand-name"]) !!}
                                                        @if($vaccine_start == 0)
                                                            <a href="javascript:void(0);" class="add-vaccine-into-chart btn btn-success btn-view" data-vaccine_id="{{ $chart_val->id }}"><i class="fa fa-plus"></i></a>
                                                        @else
                                                            <a href="javascript:void(0);" class="remove-vaccine-into-chart btn btn-danger btn-view" data-vaccine_id="{{ $chart_val->id }}"><i class="fa fa-trash"></i></a>
                                                        @endif
                                                        <div class="clearfix"></div>
                                                    </div>  
                                                    
                                                @else
                                                    @if($vac_val != 0 && isset($vaccine[$vac_val]))
                                                        {{ $vaccine_start + 1 }}. {{ $vaccine[$vac_val] }}
                                                        <br>
                                                    @endif
                                                @endif
                                                @php 
                                                    $vaccine_start++;
                                                @endphp
                                            @endforeach
                                            @endif
                                        @else
                                            <div>
                                                {!! Form::select('vaccine_chart_input[vaccine_brand_name]['.$chart_val->id.'][]', $vaccine, null, ['class' => "select2 vaccine-brand-name"]) !!}
                                                <a href="javascript:void(0);" class="add-vaccine-into-chart btn btn-success btn-view" data-vaccine_id="{{ $chart_val->id }}"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="clearfix"></div>
                                        @endif
                                    </td>
                                    <td align="center" id="vaccine-barcode-td_{{ $chart_val->id }}" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(isset($chart_val->vaccine_details) && $chart_val->vaccine_details != null && $chart_val->vaccine_details != '')
                                            @php $vaccine_details = json_decode($chart_val->vaccine_details); @endphp
                                            @if (isset($vaccine_details->bar_code))
                                            @foreach($vaccine_details->bar_code as $vac_key => $vac_val)  
                                                <div class="mt-10">
                                                    <input type="text" name="vaccine_chart_input[vaccine_barcode][{{ $chart_val->id }}][]" class="form-control input-width-medium barcode-input @if(isset($is_print)) hide @endif" data-vaccine_id="{{ $chart_val->id }}" value="{{ $vac_val }}" />
                                                    <svg class="hide" id="barcode-img_{{ $chart_val->id }}"></svg>
                                                    @if(!isset($is_print))
                                                    <a href="javascript:void(0);" class="remove-barcode-svg hide"><i class="fa fa-times"></i></a>
                                                    @endif
                                                    <div class="clearfix"></div>
                                                </div>
                                            @endforeach
                                            @endif
                                        @else
                                        <div>
                                            @if(!isset($is_print))
                                            <input type="text" name="vaccine_chart_input[vaccine_barcode][{{ $chart_val->id }}][]" class="form-control input-width-medium barcode-input" data-vaccine_id="{{ $chart_val->id }}" style="float:left" />
                                            <svg class="hide" id="barcode-img_{{ $chart_val->id }}"></svg>
                                            <a href="javascript:void(0);" class="remove-barcode-svg hide"><i class="fa fa-times"></i></a>
                                            <div class="clearfix"></div>
                                            @endif
                                        </div>
                                         @endif
                                    </td>
                                    <td @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;" id="user_given_sign_{{ $chart_val->id }}">

                                    </td>
                                    @if($start == 0)
                                        <td rowspan="{{ $rowspan-1 }}" style="vertical-align : middle;text-align:center; border-top: 1px solid #444;"> 
                                            @if(!isset($is_print))
                                            <textarea class="form-control" rows="5" name="vaccine_chart_input[comments][{{ $age_key }}]">{{ $chart_val->comments }}</textarea>
                                            @else
                                                {{ $chart_val->comments }}
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                @php $start++; @endphp
                            @endforeach
                        @endif
                    @endforeach
                @else
                    @foreach($mas_vaccine_age as $age_key => $age_val)
                        @php $rowspan = 1; @endphp
                        @if(isset($mas_vaccine_chart[$age_key]) && count($mas_vaccine_chart[$age_key]) > 0)
                            @php $rowspan = count($mas_vaccine_chart[$age_key]) + 1; @endphp
                        @endif
                        <tr> 
                            <td rowspan="{{ $rowspan }}" style="vertical-align : middle;text-align:center; border-bottom: 1px solid #444 !important; border-top: 1px solid #444 !important;">
                                <h4><strong>{{ $age_val }}</strong></h4>
                            </td>
                        </tr>
                        @if(isset($mas_vaccine_chart[$age_key]) && count($mas_vaccine_chart[$age_key]) > 0)
                            @php $start = 0 ; @endphp
                            @php $last_index = count($mas_vaccine_chart[$age_key]) -1; @endphp
                            @foreach($mas_vaccine_chart[$age_key] as $chart_key => $chart_val)
                                <tr>
                                    <td @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        <label for="is_given_radio{{ $chart_val->id }}">{{ $chart_val->name }}</label>
                                        <input type="radio" name="vaccine_chart_input[is_given][{{ $chart_val->id }}]" class="vaccine-given-radio @if(isset($is_print)) hide @endif" id="is_given_radio{{ $chart_val->id }}" value="1" data-vaccine_id="{{ $chart_val->id }}"/>
                                        <input type="hidden" name="vaccine_chart_input[age_id][{{ $chart_val->id }}]" value="{{ $age_key }}" />
                                        <input type="hidden" name="vaccine_chart_input[age_sort_order][{{ $chart_val->id }}]" value="{{ $chart_val->age_sort_order }}" />
                                        <input type="hidden" name="vaccine_chart_input[vaccine_sort_order][{{ $chart_val->id }}]" value="{{ $chart_val->sort_order }}" />
                                        <input type="hidden" id="vaccine_user_given_input_{{ $chart_val->id }}" name="vaccine_chart_input[user_given][{{ $chart_val->id }}]" class="user-given-input" data-vaccine_id="{{ $chart_val->id }}" />
                                    </td>
                                    <td align="center" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(!isset($is_print)) 
                                        <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_due][{{ $chart_val->id }}]" readonly id="vaccine_due_date_{{ $chart_val->id }}" />
                                        @endif
                                    </td>
                                    <td align="center" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(!isset($is_print)) 
                                        <input type="text" class="form-control datepicker" name="vaccine_chart_input[date_given][{{ $chart_val->id }}]" readonly id="vaccine_given_date_{{ $chart_val->id }}" />
                                        @endif
                                    </td>
                                    <td align="center" id="vaccine-select-td_{{ $chart_val->id }}" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(!isset($is_print))
                                        <div>
                                            {!! Form::select('vaccine_chart_input[vaccine_brand_name]['.$chart_val->id.'][]', $vaccine, null, ['class' => "select2 vaccine-brand-name"]) !!}
                                            <a href="javascript:void(0);" class="add-vaccine-into-chart btn btn-success btn-view" data-vaccine_id="{{ $chart_val->id }}"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="clearfix"></div>
                                        @endif
                                    </td>
                                    <td align="center" id="vaccine-barcode-td_{{ $chart_val->id }}" @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;">
                                        @if(!isset($is_print))
                                        <div>
                                            <input type="text" name="vaccine_chart_input[vaccine_barcode][{{ $chart_val->id }}][]" class="form-control input-width-medium barcode-input" data-vaccine_id="{{ $chart_val->id }}" />
                                            <svg class="hide" id="barcode-img_{{ $chart_val->id }}"></svg>
                                            <a href="javascript:void(0);" class="remove-barcode-svg hide"><i class="fa fa-times"></i></a>
                                            <div class="clearfix"></div>
                                        </div>
                                        @endif
                                    </td>
                                    <td @if($start == 0) class="border-enable-top" @elseif($last_index == $start) class="border-enable" @endif style="vertical-align : middle;text-align:center;" id="user_given_sign_{{ $chart_val->id }}">

                                    </td>
                                    @if($start == 0)
                                        <td rowspan="{{ $rowspan-1 }}" style="vertical-align : middle;text-align:center; border-top: 1px solid #444;"> 
                                            @if(!isset($is_print))
                                                <textarea class="form-control" rows="5" name="vaccine_chart_input[comments][{{ $age_key }}]"></textarea>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                                @php $start++; @endphp
                            @endforeach
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
            @endif
        </div>
    </div>
</div>
<script type="text/javascript" src="{{ url('/') }}/public/js/barcode.js"></script>
<script type="text/javascript">
    var current_user_id = '{{ \Auth::user()->id }}';
    var user_sign = JSON.parse('<?php echo $user_sign ?>');
    $('.user-given-input').each(function()
    {
        var vaccine_id = $(this).data('vaccine_id');
        if ($('#is_given_radio'+vaccine_id+'').prop('checked') === true) {
            var user_given_val = $('#vaccine_user_given_input_'+vaccine_id).val();
            if (user_sign[user_given_val] !== undefined && user_sign[user_given_val] != null && user_sign[user_given_val] != '') {
                var user_image = '<img src="{{ url('/') }}/public/img/users/'+user_sign[user_given_val]+'" alt="Doctor sign" />'
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
            url:'{{ url("out-patient/save-vaccine-chart-patient-data") }}',
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
                    var user_image = '<img src="{{ url('/') }}/public/img/users/'+user_sign[current_user_id]+'" alt="Doctor sign" />'
                    $('#user_given_sign_'+vaccine_id).html(user_image);
                }
            }
        }
    });
</script>
