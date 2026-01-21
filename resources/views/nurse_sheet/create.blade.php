@extends('app')
@section('content')
<style type="text/css">
    .label-control {
        margin-top: 0px;
    }
</style>
<?php $write_permission = session('write_permission'); ?>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Nurse\NurseSheetController@index') }}">Nurse Sheets</a>
        </li>
        <li class="current">
            <a href="javascript:void(0);">
                <b class="font-babyname">{{ $baby_details->BabyName.' - '. $baby_details->BMrNo }}</b>
            </a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
{!! Form::model(null,['method' => 'POST','url' => action('Nurse\NurseSheetController@store'),'id'=> 'nurse-form']) !!}
{{ Form::hidden('baby_id', $baby_details->BabyId) }}
{{ Form::hidden('admission_id', $admission_id) }}
{{ Form::hidden('indication', json_encode($indication)) }}
{{ Form::hidden('monitor', json_encode($monitor)) }}
{{ Form::hidden('ventilator', json_encode($ventilator)) }}
<div class="row row-spacing">
    @include('nurse_sheet.baby_basic')
</div>
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div>
                <table class="table nurse-sheet-date-time">
                    <tbody>
                        <tr>
                            <td>{!! Form::label('dcp','DCT:') !!}</td>
                            <td>{!! Form::select('dcp',["N/A"=>"N/A","Positive"=>"Positive","Negative"=>"Negative"],null,['class'=>'form-control not_saved permanant_saved input-width-medium', 'id'=>'dcp']) !!} </td>
                            <td>{!! Form::label('hemolysis','Hemolysis:') !!}</td>
                            <td colspan="3">{!! Form::select('hemolysis',["N/A"=>"N/A","Yes"=>"Yes","No"=>"No"],null,['class'=>'form-control not_saved permanant_saved input-width-medium', 'id'=>'hemolysis']) !!} </td>
                        </tr>
                        <tr>
                            <td>{!! Form::label('sheet_date','Date:', ['class'=>'required-label avoid-wrap']) !!}</td>
                            <td>{!! Form::text('sheet_date',@$sheet_date,['class'=>'form-control daycare-date input-fields-shadow not_saved permanant_saved input-width-medium', 'readonly']) !!}</td>
                            <td>{!! Form::label('sheet_date','Time:') !!}</td>
                            <td>{!! Form::select('time_hour',$time_master['time'],$currrent_time['hour'],['class'=>'form-control input-width-mini not_saved permanant_saved', 'id'=>'time_hour']) !!} </td>
                            <td>{!! Form::select('time_min',$time_master['mins'],$currrent_time['mins'],['class'=>'form-control input-width-mini not_saved permanant_saved', 'id'=>'time_min']) !!}  </td>
                            <td>{!! Form::select('time_session',$time_master['session'],$currrent_time['session'],['class'=>'form-control input-width-mini not_saved permanant_saved', 'id'=>'time_session']) !!}  </td>
                            <tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-6" style="margin-top: 8px">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('added_nurse', 'Entered By:') !!}
                            <a href="javascript:void(0)" class="add_master_data" data-modal_header="Nurse" data-destination_elements="added_nurse" data-option_value="id" data-option_text="name" data-mas_table="mas_nures">
                                <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Nurse"></i>
                            </a>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('added_nurse',[''=>'N/A']+$nurse_master,$nurse_id,['class'=>'input-width-xxlarge full-width-must not_saved permanant_saved']) !!}
                        </div>
                    </div>
                    <div class="pull-right">
                        <a href="javascript:void(0);" class="btn btn-primary reset-from save-button-shadow"> Reset Time Sheet</a>
                    </div>
                </div>
            </div>
        </div>
        <!--=== Page Content ===-->
        <div class="row row-spacing">
            <div class="col-md-12">
                <div role="tabpanel" class="tabbable tabbable-custom">
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active">
                            <a href="#sheet1" role="tab" data-toggle="tab">Basic</a>
                        </li>
                        <li role="presentation">
                            <a href="#sheet2" role="tab" data-toggle="tab">Input/Output</a>
                        </li>
                        <li role="presentation">
                            <a href="#sheet3" role="tab" data-toggle="tab">Calculation</a>
                        </li>
                        <li role="presentation">
                            <a href="#blood-values" role="tab" data-toggle="tab">Bed Side Investigation</a>
                        </li>
                        <li role="presentation" class="hide">
                            <a href="#gluco-meter" role="tab" data-toggle="tab">Lab Investigation</a>
                        </li>
                        <li role="presentation">
                            <a href="#ward-rounds" role="tab" data-toggle="tab">Ward Rounds Instruction</a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tab-view-shadow nurse-sheet-hour-wise-sheet">
                        <!-- General Form -->
                        <div role="tabpanel" class="tab-pane active" id="sheet1">  
                            @include('nurse_sheet.basic')
                        </div>
                        <div role="tabpanel" class="tab-pane" id="sheet2">
                            @include('nurse_sheet.input_output')
                        </div>
                        <div role="tabpanel" class="tab-pane" id="sheet3"> 
                            @include('nurse_sheet.calculation')
                        </div>
                        <div role="tabpanel" class="tab-pane" id="blood-values"> 
                            @include('nurse_sheet.blood_values')    
                        </div>
                        <div role="tabpanel" class="tab-pane hide" id="gluco-meter">
                            @include('nurse_sheet.gluco_meter')  
                        </div>
                        <div role="tabpanel" class="tab-pane" id="ward-rounds"> 
                            <div class="col-md-12">
                                <div class="form-group">                                    
                                    {!! Form::label('ward_rounds_instruction', 'Ward Rounds Instruction:') !!}
                                    {!! Form::textarea('ward_rounds_instruction',null,['class'=>'form-control not_saved permanant_saved','rows'=>20,'cols'=>2, 'id'=>'wri']) !!}
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="print_flag" value="0" id="print_flag"/>
                        <div class="row col-md-11">
                            <div class="col-md-3 col-sm-4 col-xs-12">
                                <button type="button" class="btn btn-block btn-primary save-button-shadow save-nurse-sheet form-control">
                                    <i class="fa fa-floppy-o"></i>
                                    <span>Save </span></button>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <button type="button" class="btn btn-block save-button-shadow btn-info form-control save-nurse-sheet" data-flag="2">
                                        <i class="fa fa-floppy-o"></i>
                                        <span>Save & Close</span>
                                    </button>
                                </div>
                                <div class="col-md-3 col-sm-4 col-xs-12">
                                    <a href="{{ action('Nurse\NurseSheetController@index') }}" class="btn btn-block save-button-shadow btn-default form-control" onclick="$('form')[0].reset();">
                                        <i class="fa fa-exclamation-circle"></i> 
                                        <span>Cancel</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- /Page Content -->
            <div class="modal fade iv-fluides-master-modal" id="iv-fluides-master-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title">
                                <h3>NICU IV FLUIDS & IV MEDICINES</h3>
                            </h5>
                        </div>
                        <div class="modal-body row m-20">
                            <table class="master_ivfluids multi-row col-md-12">
                                <thead>
                                    <tr>
                                        <th>Pharmacological Name</th>
                                        <th>Brand Name</th>
                                        <th>Status</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <form id="ivfluids-post">
                                    <tbody class="iv-fuids-body">
                                        <tr>
                                            <td><input name="pharmacological_name[]" type="text" class="form-control input-fields-shadow"></td>
                                            <td><input name="name[]" type="text" class="form-control input-fields-shadow"/></td>
                                            <td>
                                                <select name="status[]" class="form-control input-fields-shadow">
                                                    <option selected="selected" value="Active">Active</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </td>
                                            <td class="hide"><a href="javascript:void(0);" class="btn btn-default save-button-shadow master_ivfluids_add"><i class="fa fa-plus"></i></a></td>
                                            <td class="hide"><a href="javascript:void(0);" class="btn btn-default save-button-shadow remove"> <i class="fa fa-remove"></i></a></td>
                                        </tr>
                                    </tbody>
                                </form>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id="save-fluids-btn" class="btn btn-default btn-primary save-button-shadow">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
@include('nurse_sheet.nurse_sheet_create_script')
        @endsection
