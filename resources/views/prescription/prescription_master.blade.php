<div class="modal fade prescription-modal-up" id="drug-master-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3>NON IV MEDICINES</h3>
                </h5>
            </div>
            <div class="modal-body row m-20">
                <table class="master_drugs multi-row col-md-12">
                    <thead>
                        <tr>
                            <th>Pharmacological Name</th>
                            <th>Brand Name</th>
                            <th>Formulations/Strength</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <form id="drug-post">
                        <tbody>
                            <tr>
                                <td><input type="text" name="generic_name" value="" class=" form-control input-fields-shadow width-sm-70"></td>
                                <td><input type="text" name="Name" data-nameLen="1" value="" class="form-control input-fields-shadow width-sm-70" /></td>
                                <td><input type="text" name="Value[]" value="" class="form-control input-fields-shadow width-sm-70" /></td>
                                <td>
                                    <select name="Status[]" class="form-control input-fields-shadow width-sm-76">
                                        <option selected="selected" value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </td>
                                <td class="hide"><span data-len="1" class="fa fa-plus btn btn-default btn-basic-shadow add-values"></span></td>
                                <td class="hide"><span class="fa fa-remove btn btn-basic-shadow  btn-default remove"></span></td>
                            </tr>
                        </tbody>
                    </form>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-btn" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="iv-fluids-master-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Drug & IV Fluids</h3>
                </h5>
            </div>
            <div class="modal-body row m-20">
                <table class="master_drug_ivfluid multi-row col-md-12">
                    <thead>
                        <tr>
                            <th>Brand Name</th>
                            <th>Generic / Pharmacological Name</th>
                            <th>Value</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <form id="fluiddrug-post">
                        <tbody>
                            <tr data-len="0">
                                <td><input type="text" name="brand_name" value="" class="form-control input-fields-shadow full-width valid"/></td>
                                <td><input type="text" name="generic_pharmacological_name" value="" class="form-control input-fields-shadow full-width valid" /></td>
                                <td><input type="text" name="value" value="" class="form-control input-fields-shadow input-width-medium" /></td>
                                <td>
                                    <select name="type" class="form-control input-fields-shadow input-width-medium valid">
                                        <!-- <option>N/A</option> -->
                                        @if (isset($prescription_type))
                                        @foreach($prescription_type as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <input type="hidden" name="usage_type" value="IC">
                                </td>
                                <td>
                                    <select name="status" class="form-control input-fields-shadow input-width-medium">
                                        <option selected="selected" value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </form>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-fluiddrug-btn" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="frequency-master-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">FREQUENCY</h3>
                </h5>
            </div>
            <div class="modal-body row m-20">
                <table class="master_frequency multi-row col-md-12">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Frequency</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <form id="frequency-post">
                        <tbody class="iv-fuids-body">
                            <tr>
                                <td><input name="name" type="text" class="form-control input-fields-shadow"></td>
                                <td><input name="value" type="text" class="form-control input-fields-shadow"/></td>
                                <td>
                                    <select name="status" class="form-control input-fields-shadow width-sm-76">
                                        <option selected="selected" value="0">Active</option>
                                        <option value="1">Inactive</option>
                                    </select>
                                    <input type="hidden" name="usage_type" value="IC">
                                </td>
                            </tr>
                        </tbody>
                    </form>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-frequency-btn" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="create-drug-modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Drug Preparation</h3>
                </h5>
            </div>
            <div class="modal-body row mtb-10 mlr-20">
                <form id="prescription-post">
                    {{ Form::hidden('baby_id',@$baby_id) }}
                    {{ Form::hidden('admission_id',@$admission_id) }}
                    {{ Form::hidden('mother_id',@$baby_details->MotherId) }}          
                    <table class="multi-row col-md-12 plr-0 full-width" id="drug_prepartion">
                        <thead>
                            <tr>
                                <th><b>Brand / Pharmacological Name</b></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="display-flex">
                                    <select name="brandname" class="full-width-must" id="drug_names">
                                        <option value="--Select option--">--Select option--</option>
                                        @if (isset($drug_iv_fluid_name))
                                        @foreach($drug_iv_fluid_name as $key => $value)
                                        @php $group_name = explode(':', $key);  @endphp
                                        <optgroup label="{{$group_name[0]}}" id="{{$group_name[1]}}">
                                            @foreach($value as $key1 => $value1)
                                            @php 
                                              $attr = isset($drug_iv_fluid_attributes[$key1]) ? $drug_iv_fluid_attributes[$key1] : ['is_gir'=>'false', 'is_gc'=>'false'];
                                            @endphp
                                            <option value="{{$group_name[1]}}:{{$key1}}" data-is-gir="{{$attr['is_gir']}}" data-is-gc="{{$attr['is_gc']}}">{{$value1}} / {{$drug_iv_fluid_phar_gen[$key][$key1]}}</option>
                                            @endforeach
                                        </optgroup>
                                        @endforeach
                                        @endif
                                    </select>
                                    <button type="button" id="pres-set-default" class="btn btn-default pull-right mlr-15 display-none">Set Default</button>
                                    <button type="button" id="pres-clear" class="btn btn-default pull-right display-none">Reset</button>
                                </td>          
                            </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="working_weight" value="{{@$working_weight}}">
                    <input type="hidden" name="allegries" value="{{@$allegries}}">
                </form>
            </div>
            <div class="modal-footer">
                <button type="submit" id="prescription-save-btn" class="btn btn-primary save-button-shadow">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up" id="status-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 id="drugName" class="m-0"></h3>
                </h5>
                <button type="button" id="export-excel" data-export-id=""  data-bmr-no=""  data-ip-number="" class="btn btn-primary">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                </button>
                <button type="button" class="close btn" data-dismiss="modal" aria-label="close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body m-20">
                <table>
                    <thead>
                        <tr>
                            <!-- <th class="text-center">S.NO.</th> -->
                            <th class="text-center">Date & Time</th>
                            <th class="text-center">
                                Infused 
                                <span class="font-small">ml</span>
                            </th>
                            <th class="text-center">Remaining</th>
                            <th class="text-center">
                                Rate 
                                <span class="font-small">ml/h</span>
                            </th>
                            <th class="text-center">Pressure</th>
                            <!-- <th class="text-center width-120">Status</th> -->
                        </tr>
                    </thead>
                    <tbody class="status_log">
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <table class="infused-table col-md-6">
                    <tbody>
                        <tr>
                            <td rowspan="2" class="text-center">Total Infused</td>
                            <td><span class="pull-left">From Machine:&nbsp</span><span class="machine-val pull-right"></span></td>
                        </tr>
                        <tr>
                            <td><span class="pull-left">Manual:&nbsp</span><span class="manual-val pull-right"></span></td>
                        </tr>
                    </tbody>
                </table>
                <div class="col-md-6 plr-0 align-btn">
                    <button type="button" id="close" class="btn btn-default save-button-shadow" data-dismiss="modal">Close</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Confirm Order</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <div id="pres-cross-verify-content"><i class="fas fa-exclamation-triangle fa-2x"></i>Please verify all data. If not valid please inform to prescriber and click the cancel button.</div>
                <div id="pres-cross-verify"></div>
                <form id="confirm-post">
                    {{ Form::hidden('baby_id', @$baby_id) }}
                    {{ Form::hidden('drug_list', @$drug_list) }}
                    {{ Form::hidden('hdr_id') }}
                    {{ Form::hidden('status_type', @$status_type) }}
                    {{ Form::hidden('working_weight', @$working_weight) }}
                    <div class="col-md-12 mt-20 plr-0">
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Date</div>
                            <div class="col-md-9 plr-0 display-flex">
                                {{ Form::text('confirm_datetime', null, ['class'=>'form-control input-fields-shadow', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Time</div>
                            <div class="col-md-9 plr-0 display-flex time-selection">
                                <div class="input-width-small mr-5">
                                    {{ Form::select('confirm_time',SiteHelpers::prepare_time()['time'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small mr-5">
                                    {{ Form::select('confirm_mins',SiteHelpers::prepare_time()['mins'],null,['class' => 'form-control mr-10', 'required']) }}
                                </div>
                                <div class="input-width-small">
                                    {{ Form::select('confirm_session',SiteHelpers::prepare_time()['session'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                            </div>
                        </div>
                        @if(env('PUMP_INTERFACE'))
                            <div id="pump-type-selection" class="hide">
                                @if(isset($pump_type) && $pump_type == 'e-n-series')
                                    <input type="hidden" name="order_pump_type" value="e-n-series">
                                    <div class="col-md-12 form-group plr-0">
                                        <div class="col-md-3 plr-0">Select pump number</div>
                                        <div class="col-md-9 plr-0 display-flex" style="flex-direction: column;">
                                            <select id="pump_device_ids" name="order_pump_device_id" class="form-control">
                                                <option value="0">-- Select pump --</option>
                                            </select>
                                            <span></span>
                                        </div>
                                    </div>
                                @elseif(isset($pump_type) && $pump_type == 'cs5')
                                    <input type="hidden" name="order_pump_type" value="cs5" />
                                    <input type="hidden" name="order_pump_device_id" value="" />
                                @else
                                    <input type="hidden" name="order_pump_type" value="" />
                                    <input type="hidden" name="order_pump_device_id" value="" />
                                @endif
                            </div>
                        @endif
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="close-btn" class="btn btn-default save-button-shadow"><b>Cancel</b></button>
                <button type="button" id="confirm-btn" class="btn btn-primary save-button-shadow"><b>OK</b></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="resend-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Resend Order</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <form id="resend-post">
                    {{ Form::hidden('baby_id', @$baby_id) }}
                    {{ Form::hidden('resend_id') }}
                    {{ Form::hidden('hdr_id') }}
                    <div class="col-md-12 mt-20 plr-0">
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Date</div>
                            <div class="col-md-9 plr-0 display-flex">
                                {{ Form::text('resend_datetime', null, ['class'=>'form-control input-fields-shadow', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Time</div>
                            <div class="col-md-9 plr-0 display-flex time-selection">
                                <div class="input-width-small mr-5">
                                    {{ Form::select('resend_time',SiteHelpers::prepare_time()['time'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small mr-5">
                                    {{ Form::select('resend_mins',SiteHelpers::prepare_time()['mins'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small">
                                    {{ Form::select('resend_session',SiteHelpers::prepare_time()['session'],null,['class' => 'form-control mr-10', 'required']) }}
                                </div>
                            </div>
                        </div>
                        <div id="pump-type-selection" class="hide">
                            @if(isset($pump_type) && $pump_type == 'e-n-series')
                                <input type="hidden" name="order_pump_type" value="e-n-series">
                                <div class="col-md-12 form-group plr-0">
                                    <div class="col-md-3 plr-0">Select pump number</div>
                                    <div class="col-md-9 plr-0 display-flex" style="flex-direction: column;">
                                        <select id="pump_device_ids" name="order_pump_device_id" class="form-control">
                                            <option value="0">-- Select pump --</option>
                                        </select>
                                        <span></span>
                                    </div>
                                </div>
                            @elseif(isset($pump_type) && $pump_type == 'cs5')
                                <input type="hidden" name="order_pump_type" value="cs5" />
                                <input type="hidden" name="order_pump_device_id" value="" />
                            @else
                                <input type="hidden" name="order_pump_type" value="" />
                                <input type="hidden" name="order_pump_device_id" value="" />
                            @endif
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="resend-close-btn" class="btn btn-default save-button-shadow"><b>Cancel</b></button>
                <button type="button" id="resend-order-btn" class="btn btn-primary save-button-shadow"><b>OK</b></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="cancel-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Cancel / Omit Order</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <form id="cancel-post">
                    {{ Form::hidden('baby_id', @$baby_id) }}
                    {{ Form::hidden('drug_list', @$drug_list) }}
                    {{ Form::hidden('hdr_id') }}
                    {{ Form::hidden('status_type', @$status_type) }}
                    {{ Form::hidden('working_weight', @$working_weight) }}
                    <div class="col-md-12 mt-20 plr-0">
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Date</div>
                            <div class="col-md-9 plr-0 display-flex">
                                {{ Form::text('cancel_datetime', null, ['class'=>'form-control input-fields-shadow', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Time</div>
                            <div class="col-md-9 plr-0 display-flex time-selection">
                                <div class="input-width-small mr-5">
                                    {{ Form::select('cancel_time',SiteHelpers::prepare_time()['time'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small mr-5">
                                    {{ Form::select('cancel_mins',SiteHelpers::prepare_time()['mins'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small">
                                    {{ Form::select('cancel_session',SiteHelpers::prepare_time()['session'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Reason For Cancelling / Omitting</div>
                            <div class="col-md-9 plr-0 display-flex">
                                {{ Form::textarea('cancel_reason', null, ['class'=>'form-control input-fields-shadow', 'rows'=>'5']) }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancel-btn" class="btn btn-default btn-primary save-button-shadow"><b>OK</b></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="stop-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Stop Order</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <form id="stop-post">
                    {{ Form::hidden('baby_id', @$baby_id) }}
                    {{ Form::hidden('drug_list', @$drug_list) }}
                    {{ Form::hidden('hdr_id') }}
                    {{ Form::hidden('status_type', @$status_type) }}
                    {{ Form::hidden('working_weight', @$working_weight) }}
                    <div class="col-md-12 mt-20 plr-0">
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Date</div>
                            <div class="col-md-9 plr-0 display-flex">
                                {{ Form::text('stop_datetime', null, ['class'=>'form-control input-fields-shadow', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Time</div>
                            <div class="col-md-9 plr-0 display-flex time-selection">
                                <div class="input-width-small mr-5">
                                    {{ Form::select('stop_time',SiteHelpers::prepare_time()['time'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small mr-5">
                                    {{ Form::select('stop_mins',SiteHelpers::prepare_time()['mins'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small">
                                    {{ Form::select('stop_session',SiteHelpers::prepare_time()['session'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Reason For Stopping</div>
                            <div class="col-md-9 plr-0 display-flex">
                                {{ Form::textarea('stop_reason', null, ['class'=>'form-control input-fields-shadow', 'rows'=>'5']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Total Infused</div>
                            <div class="col-md-9 plr-0 display-flex">
                                <div class="full-width">
                                    {{ Form::text('total_ml', null, ['class'=>'form-control input-fields-shadow full-width']) }}
                                </div>
                                <div class="input-width-small">
                                    {{ Form::select('total_type', [''=>'N/A']+ValuelistHelpers::oraldoesunitgrams(), null, ['class'=>'form-control input-fields-shadow']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="stop-btn" class="btn btn-default btn-primary save-button-shadow"><b>OK</b></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="terminate-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Terminate Prescripion</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <form id="terminate-post">
                    {{ Form::hidden('drug_id') }}
                    <div class="col-md-12 mt-20 plr-0">
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-4 plr-0">Date</div>
                            <div class="col-md-8 plr-0 display-flex">
                                {{ Form::text('terminate_datetime', null, ['class'=>'form-control input-fields-shadow', 'readonly']) }}
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-4 plr-0">Time</div>
                            <div class="col-md-8 plr-0 display-flex">
                                <div class="input-width-small mr-5">
                                    {{ Form::select('terminate_time',SiteHelpers::prepare_time()['time'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small mr-5">
                                    {{ Form::select('terminate_mins',SiteHelpers::prepare_time()['mins'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                                <div class="input-width-small">
                                    {{ Form::select('terminate_session',SiteHelpers::prepare_time()['session'],null,['class' => 'form-control mr-10','required']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-4 plr-0">Reason For terminate</div>
                            <div class="col-md-8 plr-0 display-flex">
                                {{ Form::textarea('terminate_reason', null, ['class'=>'form-control input-fields-shadow', 'rows'=>'5']) }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="terminate-btn" class="btn btn-default btn-primary save-button-shadow"><b>OK</b></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="review-update-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Update Review Date</h3>
                </h5>
            </div>
            <div class="modal-body row m-10">
                <form id="review-post">
                    {{ Form::hidden('prescription_hdr_id', @$prescription_hdr_id) }}
                    {{ Form::hidden('old_review_date', @$old_review_date) }}
                    {{ Form::hidden('sno', @$sno) }}
                    <div class="col-md-12 mt-20 plr-0">
                        <div class="col-md-12 form-group plr-0">
                            <div class="col-md-3 plr-0">Review Date</div>
                            <div class="col-md-9 plr-0 display-flex">
                                {{ Form::text('review_date', null, ['class'=>'form-control input-fields-shadow', 'readonly']) }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="review-update-btn" class="btn btn-default btn-primary save-button-shadow"><b>Update</b></button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="baby-info" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Baby Details</h3>
                </h5>
            </div>
            <div class="modal-body row m-20">
                <table class="table basic-details">
                    <tbody>
                        <tr>
                            <td class="text-wrap-none">
                                <b>Baby's Name:</b> <span>{!! isset($baby_details->BabyName) ? $baby_details->BabyName :''  !!}</span>
                            </td>
                            <td>
                                <b>{{ Lang::get('home.mrn') }}:</b> <span>{!! isset($baby_details->BMrNo) ? $baby_details->BMrNo : '' !!} </span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>{{ Lang::get('home.ip') }}:</b> <span>{!! isset($ip_details->ip_number) ? $ip_details->ip_number : '' !!} </span>
                            </td>
                            <td>
                                <b>DOB:</b> <span>{!! isset($baby_details->DOB) ?  date('d-m-Y',strtotime($baby_details->DOB)) : '' !!}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Sex:<b> <span>{!! isset($baby_details->Sex) ? $baby_details->Sex : '' !!}</span>
                            </td>
                            <td>
                                <b>Gestation:<b> <span>{!! isset($baby_details->Gestation) ?  SiteHelpers::decode_gestation($baby_details->Gestation) : '' !!}</span>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <b>Corrected Gestational Age:<b> <span>{!! isset($corrected_gestation) ? $corrected_gestation : '' !!}</span>
                            </td>
                            <td>
                                <b>Birth Weight:<b> <span>{!! isset($baby_details->BirthWeight) ? $baby_details->BirthWeight : '' !!}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="pump-info" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body row m-20">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                <table class="table">
                    <tbody>
                        <tr>
                            <td class="text-wrap-none">
                                <ul class="list-none">
                                    <li><span class="syringe-pump-status-1 display-inline-block"></span> 
                                        <b>Waiting For Confirmation</b>
                                    </li>
                                    <li><span class="syringe-pump-status-2 display-inline-block"></span> 
                                        <b>Confirmed</b>
                                    </li>
                                    <li><span class="syringe-pump-status-3 display-inline-block"></span> 
                                        <b>In Pump Queue / Resend</b>
                                    </li>
                                    <li><span class="syringe-pump-status-5 display-inline-block"></span> 
                                        <b>Executing / Running</b>
                                    </li>
                                    <li><span class="syringe-pump-status-4 display-inline-block"></span> 
                                        <b>Pump in pause</b>
                                    </li>
                                    <li><span class="syringe-pump-status-20 display-inline-block"></span> 
                                        <b>Stop / Cancel</b>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade prescription-modal-up flow-control-modal" id="already-done" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body row m-20 text-center">
                <i class="fa fa-check fa-5x text-success" aria-hidden="true"></i>
                <h2>Status has been changed !</h2>
                <button type="button" class="btn btn-default mt-30" data-dismiss="modal">Ok</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal Fullscreen -->
<div class="modal modal-fullscreen prescription-modal-up" id="create-prescription" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body row">
                    <form class="col-md-12 drug-gen" id="new-prescription-post">
                    {{ Form::hidden('baby_id',@$baby_id) }}
                    {{ Form::hidden('admission_id',@$admission_id) }}
                    {{ Form::hidden('mother_id',@$baby_details->MotherId) }}
                        <div class="col-md-6 col-sm-6 pr-0 prescription-search">
                            <span><b>Brand / Pharmacological Name</b></span>
                            <div class="input-icons">
                                <input type="text" id="brandname" class="form-control mtb-15" placeholder="Search" />
                                <i class="fa fa-times icon reset"></i>
                                <input type="hidden" name="brandname"/>
                            </div>
                            @if (isset($drug_iv_fluid_name))
                            <div class="drug-list-main">
                                @php $i = 1; @endphp
                                @foreach($drug_iv_fluid_name as $key => $value)
                                <div class="drug-list" id="main-div-{{$i}}">
                                    @php $group_name = explode(':', $key);  @endphp
                                    <div class="drug-title"><b>{{$group_name[0]}}</b></div>
                                    @foreach($value as $key1 => $value1)
                                    <span data-drug="{{$group_name[1]}}:{{$key1}}" data-drugname="{{$value1}} / {{$drug_iv_fluid_phar_gen[$key][$key1]}}">{{$value1}} / {{$drug_iv_fluid_phar_gen[$key][$key1]}}</span>
                                    @endforeach
                                </div>
                                @php $i++; @endphp
                                @endforeach
                            </div>
                            <div class="drug-list-hidden"></div>
                            @endif
                            <div class="col-md-12 recently-prescribe card-layout">
                                <div class="prescribed-title"><b class="mtb-10">Recently Prescribed</b><i class="fa fa-expand pull-right"></i></div>
                                <div class="prescribed"></div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 prescription-entry"> </div>
                        
                    <input type="hidden" name="working_weight" value="{{@$working_weight}}">
                    <input type="hidden" name="allegries" value="{{@$allegries}}">
                    </form>
                <div class="col-md-12 row modal-foot">
                    <button type="button" id="new-prescription-save-btn" class="btn btn-primary pull-right mr-15">Save</button>
                    <button type="button" class="btn btn-default pull-right mr-15" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
