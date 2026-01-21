@extends('app')
@section('content')
<meta name="_token" content="{!! $encrypted_csrf_token !!}"/>
<style type="text/css">
    .hc{
    display:none;
    }
    .hc + label {
    margin: 0px 5px;
    display: inline-block;
    width: 40px;
    height: 40px;
    text-algin: center;
    //background-color: #e74c3c;
    border: 1px solid #aaa;
    border-radius: 50%;
    vertical-align: middle;
    padding: 10px 8px;
    box-shadow: 0px 0px 3px #444;
    }
    .hc:checked + label {
    display: inline-block;
    background-color: #434468;
    color: #fff;
    }
</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current"><a title="Site Setting" href="{{ action('Settings\SiteController@edit') }}">Site Setting</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!-- Page Header -->
<!-- <div class="page-header"> -->
<!-- </div> -->
<!-- /Page Header -->
<div class="row row-spacing">
    <div class="col-md-12">
        @include('errors.list')
        {!! Form::model($results,['url' => action('Settings\SiteController@update'),'method'=>'POST','files'=>'true','id'=>'mrform-edit']) !!}                    
        @php $user_role = Auth::user()->RoleId; @endphp
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                @if(isset($user_role) && $user_role == env('SUPER_ADMIN_ROLE'))
                <li role="presentation" class="hide">
                    <a href="#generalform" role="tab" data-toggle="tab">General Information</a>
                </li>
                <li role="presentation" class="active">
                    <a href="#Generalsetting" role="tab" data-toggle="tab">General Setting</a>
                </li>
                <li role="presentation" class="">
                    <a href="#specialpermission" role="tab" data-toggle="tab">Special Permission</a>
                </li>
                <li role="presentation" class="">
                    <a href="#reportsetting" role="tab" data-toggle="tab"> Discharge Report Settings</a>
                </li>
                <li role="presentation" class="">
                    <a href="#sidemenu" role="tab" data-toggle="tab"> Menu Name Changes</a>
                </li>
                <li role="presentation" class="">
                    <a href="#notificationanimation" role="tab" data-toggle="tab">Notification</a>
                </li>
                <li role="presentation" class="">
                    <a href="#highlightertab" role="tab" data-toggle="tab">Highlighter</a>
                </li>
                @endif
                <li role="presentation" class="">
                    <a href="#opprint" role="tab" data-toggle="tab">Op Print Page Configuration</a>
                </li>
            </ul>
            <div class="tab-content tab-view-shadow">
                <!-- general settings -->
                <div role="tabpanel" class="tab-pane active" id="Generalsetting">
                    <div class="col-md-12 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i></h4>
                        </div>
                        <div class="widget-content">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-group">
                                                {!! Form::label('report_logo','Report Logo:') !!}
                                            </div>
                                            <div class="form-group upload-logo">
                                                @if(!empty($results->PrintLogo))
                                                <img src="{{ url('public/img/'.$results->PrintLogo) }}" class="PrintLogo" >
                                                <i class="fa fa-times fa-2x croppimage" aria-hidden="true"></i>
                                                @endif   
                                            </div>
                                            <div class="form-group logo-box @if(!empty($results->PrintLogo)) hide @endif">
                                                <input type="hidden" name="image-upload">
                                                <input type="hidden" name="image-upload-width">
                                                <input type="hidden" name="image-upload-height">
                                                <input type="hidden" name="image-upload-x">
                                                <input type="hidden" name="image-upload-y">
                                                <div class="hospital-logo-upload">
                                                    <div class="actions">
                                                        <a class="btn file-btn">
                                                        <span>Upload</span>
                                                        <input type="file" id="upload" value="Choose a file" accept="image/*" />
                                                        </a>
                                                    </div>
                                                    <div class="hospital-logo-preview">
                                                        <div id="hospital-logo-upload"></div>
                                                    </div>
                                                    <div>
                                                        <button  type="button" class="btn btn-primary upload-result">Crop</button>
                                                        <button  type="button" class="btn btn-info upload-cancel">Cancel</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--hos-->
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <!-- <div class="form-group">
                                            <table class="page_limit">
                                              <thead>
                                                <tr>
                                                  <th>{!! Form::label('limit_option','Limit Option:') !!}</th>
                                                  <th></th>
                                                  <th>{!! Form::label('default_limit','Default Limit:') !!}</th>
                                                </tr>
                                              </thead>
                                              <tbody class="limit-option-body">
                                                @php $pagination_option = isset(\SiteHelpers::paginationLimit()->limit_option) ? \SiteHelpers::paginationLimit()->limit_option : ''; @endphp
                                                @if (!empty($pagination_option))
                                                @foreach ($pagination_option as $key => $value)
                                                <tr data-test="option-{{$key}}" id="option-{{$key}}" class="mb-5">
                                                  <td class="form-group">{!! Form::text('limit_option[]',$value,['class'=>'form-control input-width-large']) !!}</td>
                                                  <td class="form-group">
                                                    <a href="javascript:void(0);" class="btn btn-default remove"><i class="fa fa-remove"></i></a>
                                                  </td>
                                                  <td class="form-group pl-10 ptb-10">
                                                    @if ($value == json_decode($results->pagenation_limit_options)->default_limit)
                                                    <input type="radio" name="default_limit" value={{$value}} checked="true"> Yes  
                                                    @else
                                                    <input type="radio" name="default_limit" value={{$value}}> Yes  
                                                    @endif
                                                  </td>
                                                </tr>
                                                @endforeach
                                                @else
                                                <tr data-test="option-0" id="option-0" class="mb-5">
                                                  <td class="form-group">{!! Form::text('limit_option[]', null,['class'=>'form-control input-width-large']) !!}</td>
                                                  <td class="form-group">
                                                    <a href="javascript:void(0);" class="btn btn-default remove"><i class="fa fa-remove"></i></a>
                                                  </td>
                                                  <td class="form-group pl-10 ptb-10">
                                                    <input type="radio" name="default_limit" value=""> Yes  
                                                  </td>
                                                </tr>
                                                @endif
                                              </tbody>
                                            </table>
                                            <a class="btn option_add" href="javascript:void(0);" data-limit="option-{{count($pagination_option)}}"><i class="fa fa-plus"></i><span>Add More</span></a>
                                            </div> -->
                                        <div class="form-group hide">
                                            {!! Form::label('nurse_entry_start','Start Time For Nurse Entry Chart:') !!}
                                            {!! Form::text('nurse_entry_start',null,['class'=>'form-control input-width-large']) !!}
                                        </div>
                                        <div class="form-group">
                                            {!! Form::label('period','24 hrs period:') !!}
                                            <table>
                                                <tr>
                                                    <td> 
                                                        {!! Form::select('period_hours',[''=>'N/A']+ValuelistHelpers::timeEngine()['time'],null,['class'=>'form-control input-width-small']) !!}
                                                    </td>
                                                    <td class="form-group-spacing"> 
                                                        {!! Form::select('period_mins',[''=>'N/A']+ValuelistHelpers::timeEngine()['mins'],null,['class'=>'form-control input-width-small']) !!}
                                                    </td>
                                                    <td> 
                                                        {!! Form::select('period_session',[''=>'N/A']+ValuelistHelpers::timeEngine()['period'],null,['class'=>'form-control input-width-small']) !!}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!--   <div class="form-group">
                                            {!! Form::label('mirthIntegration','Mirth Integration:') !!}
                                            <input id="mirthIntegration" name="mirthIntegration" data-on="Yes" data-off="No" @if(isset($results->mirthIntegration) && $results->mirthIntegration == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </div> -->
                                        <div class="form-group">
                                            {!! Form::label('header_required','Header Required:') !!}
                                            <input id="header_required" name="header_required" data-on="Yes" data-off="No" @if(isset($results->header_required) && $results->header_required == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                        </div>
                                    </div>
                                    @php
                                    $selected_days = \SiteHelpers::getDaysForChart();
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="col-md-12 form-group plr-0">
                                            <div class="col-md-12 plr-0">
                                                {!! Form::label('daycare_dates_for_chart','Days to be taken for Growth chart:') !!}
                                            </div>
                                            <div class="col-md-12 custom-input">
                                                <input type="checkbox" name="daycare_dates_for_chart[]" class="hc" id="checkbox-button-opt-s" value="Sun" @if(in_array('Sun', $selected_days)) checked @endif>
                                                <label for="checkbox-button-opt-s">Sun</label>
                                                <input type="checkbox" name="daycare_dates_for_chart[]" class="hc" id="checkbox-button-opt-m" value="Mon" @if(in_array('Mon', $selected_days)) checked @endif>
                                                <label for="checkbox-button-opt-m">Mon</label>
                                                <input type="checkbox" name="daycare_dates_for_chart[]" class="hc" id="checkbox-button-opt-t" value="Tue" @if(in_array('Tue', $selected_days)) checked @endif>
                                                <label for="checkbox-button-opt-t">Tue</label>
                                                <input type="checkbox" name="daycare_dates_for_chart[]" class="hc" id="checkbox-button-opt-w" value="Wed" @if(in_array('Wed', $selected_days)) checked @endif>
                                                <label for="checkbox-button-opt-w">Wed</label>
                                                <input type="checkbox" name="daycare_dates_for_chart[]" class="hc" id="checkbox-button-opt-th" value="Thu" @if(in_array('Thu', $selected_days)) checked @endif>
                                                <label for="checkbox-button-opt-th">Thu</label>
                                                <input type="checkbox" name="daycare_dates_for_chart[]" class="hc" id="checkbox-button-opt-f" value="Fri" @if(in_array('Fri', $selected_days)) checked @endif>
                                                <label for="checkbox-button-opt-f">Fri</label>
                                                <input type="checkbox" name="daycare_dates_for_chart[]" class="hc" id="checkbox-button-opt-sa" value="Sat" @if(in_array('Sat', $selected_days)) checked @endif>
                                                <label for="checkbox-button-opt-sa">Sat</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- general settings -->
                <!-- special permission  -->    
                <div role="tabpanel" class="tab-pane" id="specialpermission">
                    <div class="col-md-12 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i></h4>
                        </div>
                        <div class="widget-content">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('user_id','User:') !!}
                                    {!! Form::Select('user_id',['0'=>'Select User']+$User,$speical_user_id,['class'=>'select2-select-00 full-width-fix']) !!}
                                </div>
                            </div>
                            <div class="col-md-10 permission-module-main-div mtb-10" id="permission-render-div">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- special permission  -->   
                <!-- Report Settings -->
                <div role="tabpanel" class="tab-pane" id="reportsetting">
                    <div class="col-md-12 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i></h4>
                        </div>
                        <div class="widget-content">
                            <div class="col-md-12 plr-0">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('hospital_name','Hospital Name:') !!}
                                        {!! Form::text('hospital_name',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('hospital_contact','Hospital Phone:') !!}<i class="fa fa-info-circle bs-tooltip color-black-must" data-placement="right" data-original-title="if you have multiple numbers use / as separator"></i>
                                        {!! Form::text('hospital_contact',null,['class'=>'form-control','placeholder'=>'More than one contact format 0000-0000000 / 0000-0000000 / etc','row'=>'10','cols'=>'10']) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('discharge_report_left','Discharge Report Left:') !!}
                                    {!! Form::textarea('discharge_report_left',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('discharge_report_right','Discharge Report Right:') !!}
                                    {!! Form::textarea('discharge_report_right',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('discharge_instraction','Discharge Instructions:') !!}
                                    {!! Form::textarea('discharge_instraction',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('discharge_summary_footer','Discharge Summary Footer:') !!}
                                    {!! Form::textarea('discharge_summary_footer',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('pediatric_discharge_summary','Pediatric Discharge Summary:') !!}
                                    {!! Form::textarea('pediatric_discharge_summary',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('condition_at_discharge','Condition At Discharge:') !!}
                                    {!! Form::textarea('condition_at_discharge',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                             <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('review_details','Pediatric Discharge Review Details:') !!}
                                    {!! Form::textarea('review_details',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    {!! Form::label('neonatal_op_print_right','Neonatal OP  Print Header:') !!}
                                    {!! Form::textarea('neonatal_op_print_right',null,['class'=>'form-control','row'=>'10','cols'=>'10']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Report Settings -->
                <!-- side menu name changes -->
                <div role="tabpanel" class="tab-pane" id="sidemenu">
                    @php $const_name = \SiteHelpers::menuname(); @endphp
                    @php $count = 1; @endphp 
                    <div class="col-md-12 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i></h4>
                        </div>
                        <div class="widget-content">
                            @foreach($menu_names as $menu_key =>$menu)
                            @if(($count % 2) != 0)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <b style="color: #3968c6;">{{$const_name[$menu_key]}}</b>{!! Form::text($menu_key,$menu,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            @else
                            <div class="col-md-6">
                                <div class="form-group">
                                    <b style="color: #3968c6;">{{$const_name[$menu_key]}}</b>{!! Form::text($menu_key,$menu,['class'=>'form-control']) !!}
                                </div>
                            </div>
                            @endif
                            @php $count++; @endphp 
                            @endforeach 
                        </div>
                    </div>
                </div>
                <!-- side menu name changes -->
                <!-- General Form -->
                <div role="tabpanel" class="tab-pane hide" id="generalform">
                    <div class="col-md-12 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i></h4>
                        </div>
                        <div class="widget-content">
                            <div class="col-md-6">
                                <h1>Baby MR Settings</h1>
                                <h4>Format: <span>Option1</span>-<span>Option2</span>-<span>Option3</span>-B-<span>Option4</span></h4>
                                <h4>Example: <span class="Bopt1">Option1</span><span class="Bopt2">Option2</span><span class="Bopt3">Option3</span>B<span class="Bopt4">Option4</span></h4>
                                <div class="form-group col-md-8">
                                    {!! Form::label('BOption1','Option1 (Serial no):') !!}
                                    @if ($results->OverwriteBabyMR === 1)
                                    {!! Form::text('BOption1',null,['class'=>'form-control options','id'=>'Bopt1' ,'readonly'  ]) !!}
                                    @else
                                    {!! Form::text('BOption1',null,['class'=>'form-control options','id'=>'Bopt1'  ]) !!}
                                    @endif
                                </div>
                                <div class="form-group col-md-8">
                                    {!! Form::label('BOption2','Option 2:') !!}
                                    @if ($results->OverwriteBabyMR === 1)
                                    {!! Form::select('BOption2',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Bopt2' ,'readonly']) !!}
                                    @else
                                    {!! Form::select('BOption2',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Bopt2']) !!}
                                    @endif
                                </div>
                                <div class="form-group col-md-8">
                                    {!! Form::label('BOption3','Option 3:') !!}
                                    @if ($results->OverwriteBabyMR === 1)
                                    {!! Form::select('BOption3',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Bopt3' ,'readonly']) !!}
                                    @else
                                    {!! Form::select('BOption3',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Bopt3']) !!}
                                    @endif
                                </div>
                                <div class="form-group col-md-8">
                                    {!! Form::label('BOption4','Random Code Digits:') !!}
                                    @if ($results->OverwriteBabyMR === 1)
                                    {!! Form::select('BOption4',[4=>4,6=>6,8=>8,10=>10],null,['class'=>'form-control options','id'=>'Bopt4' ,'readonly']) !!}
                                    @else
                                    {!! Form::select('BOption4',[4=>4,6=>6,8=>8,10=>10],null,['class'=>'form-control options','id'=>'Bopt4']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <h1>Mother MR Settings</h1>
                                <h4>Format: <span class="motheropt1">Option1</span>-<span class="motheropt2">Option2</span>-<span class="motheropt3">Option3</span>-M-<span class="motheropt4">Option4</span></h4>
                                <h4>Example: <span class="Mopt1">Option1</span><span class="Mopt2">Option2</span><span class="Mopt3">Option3</span>M<span class="Mopt4">Option4</span></h4>
                                <div class="form-group col-md-8">
                                    {!! Form::label('MOption1','Option1 (Serial no):') !!}
                                    @if ($results->OverwriteMotherMR === 1)
                                    {!! Form::text('MOption1',null,['class'=>'form-control options','id'=>'Mopt1' ,'readonly']) !!}
                                    @else
                                    {!! Form::text('MOption1',null,['class'=>'form-control options','id'=>'Mopt1']) !!}
                                    @endif
                                </div>
                                <div class="form-group col-md-8">
                                    {!! Form::label('MOption2','Option 2:') !!}
                                    @if ($results->OverwriteMotherMR === 1)
                                    {!! Form::select('MOption2',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Mopt2','readonly']) !!}
                                    @else
                                    {!! Form::select('MOption2',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Mopt2']) !!}
                                    @endif
                                </div>
                                <div class="form-group col-md-8">
                                    {!! Form::label('MOption3','Option 3:') !!}
                                    @if ($results->OverwriteMotherMR === 1)
                                    {!! Form::select('MOption3',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Mopt3' ,'readonly']) !!}
                                    @else
                                    {!! Form::select('MOption3',[''=>'None','YY'=>'YY','MM'=>'MM','DD'=>'DD'],null,['class'=>'form-control options','id'=>'Mopt3']) !!}
                                    @endif
                                </div>
                                <div class="form-group col-md-8 col-offset-0">
                                    {!! Form::label('MOption4','Random Code Digits:') !!}
                                    @if ($results->OverwriteMotherMR === 1)
                                    {!! Form::select('MOption4',[4=>4,6=>6,8=>8,10=>10],null,['class'=>'form-control options','id'=>'Mopt4' ,'readonly']) !!}
                                    @else
                                    {!! Form::select('MOption4',[4=>4,6=>6,8=>8,10=>10],null,['class'=>'form-control options','id'=>'Mopt4']) !!}
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::checkbox('OverwriteBabyMR', 1, null, ['class' => 'uniform', 'id' => 'OverwriteBabyMR']) !!}
                                            {!! Form::label('OverwriteBabyMR','Overwrite Baby MR') !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::checkbox('OverwriteMotherMR', 1, null, ['class' => 'uniform', 'id' => 'OverwriteMotherMR']) !!}
                                            {!! Form::label('OverwriteMotherMR','Overwrite Mother MR') !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- General Form -->
                <!-- Notification animation -->
                <div role="tabpanel" class="tab-pane" id="notificationanimation">
                    <div class="col-md-12 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i></h4>
                        </div>
                        <div class="widget-content">
                            <div class="col-md-12 col-sm-12 col-xs-12">
                                <button type="button" class="btn btn-primary save-button-shadow pull-right" id="showtoast">Preview</button>
                            </div>
                            <div class="col-md-12 col-sm-12 col-xs-12 plr-0">
                                <div class="form-group col-md-2 col-sm-4 col-xs-6"> 
                                    {{ Form::label('closeButton', 'Close Button') }}
                                    {{ Form::checkbox('closeButton', 1, $toastrOption->closeButton) }} 
                                </div>
                                <div class="form-group col-md-2 col-sm-4 col-xs-6">   
                                    {{ Form::label('debugInfo', 'Debug') }}
                                    {{ Form::checkbox('debugInfo', 1, $toastrOption->debug) }} 
                                </div>
                                <div class="form-group col-md-2 col-sm-4 col-xs-6"> 
                                    {{ Form::label('progressBar', 'Progress Bar:') }}
                                    {{ Form::checkbox('progressBar', 1, $toastrOption->progressBar) }} 
                                </div>
                                <div class="form-group col-md-3 col-sm-4 col-xs-6">   
                                    {{ Form::label('preventDuplicates', 'Prevent Duplicates:') }}
                                    {{ Form::checkbox('preventDuplicates', 1, $toastrOption->preventDuplicates) }} 
                                </div>
                                <div class="form-group col-md-3 col-sm-4 col-xs-6">
                                    {{ Form::label('newestOnTop', 'Newest On Top:') }}
                                    {{ Form::checkbox('newestOnTop', 1, $toastrOption->newestOnTop) }} 
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0 display-inline-block toastr-full-width">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('toastTypeGroup', 'Type:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('toastTypeGroup',['success'=>'Success','info'=>'Info','warning'=>'Warning','error'=>'Error'],$toastrOption->toastTypeGroup,["class"=>"form-control"]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('positionGroup', 'Position:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('positionGroup',['toast-top-right'=>'Top Right','toast-bottom-right'=>'Bottom Right','toast-bottom-left'=>'Bottom Left','toast-top-left'=>'Top Left','toast-top-full-width'=>'Top Full Width','toast-bottom-full-width'=>'Bottom Full Width','toast-top-center'=>'Top Center','toast-bottom-center'=>'Bottom Center'],$toastrOption->positionClass,["class"=>"form-control"]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('showDuration', 'Show Duration:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::input('number','showDuration',$toastrOption->showDuration,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('hideDuration', 'Hide Duration:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::input('number','hideDuration',$toastrOption->hideDuration,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('timeOut', 'Time out:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::input('number','timeOut',$toastrOption->timeOut,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('extendedTimeOut', 'Extended time out:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::input('number','extendedTimeOut',$toastrOption->extendedTimeOut,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('showEasing', 'Show Easing:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('showEasing', ['swing'=>'swing','linear'=>'linear'], $toastrOption->showEasing,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('hideEasing', 'Hide Easing:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('hideEasing', ['swing'=>'swing','linear'=>'linear'], $toastrOption->hideEasing, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('showMethod', 'Show Method:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('showMethod', ['fadeIn'=>'fadeIn', 'slideDown'=>'slideDown'], $toastrOption->showMethod,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-6 plr-0">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {{ Form::label('hideMethod', 'Hide Method:') }}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {{ Form::select('hideMethod', ['fadeOut'=>'fadeOut', 'slideUp'=>'slideUp'], $toastrOption->hideMethod,['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Notification animation -->
                <!-- Highlighter -->
                <div role="tabpanel" class="tab-pane" id="highlightertab">
                    <div class="col-md-12 widget box" id="highlighter">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i></h4>
                        </div>
                        <div class="widget-content">
                            <h2 class="text-center"><b>Module Based Highlighter</b></h2>
                            <div class="col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr class="@if(isset($results->neonatal_highlight) && $results->neonatal_highlight == 2) print-highlighter @endif">
                                            <td>
                                                {!! Form::label('neonatal_highlight','Neonatal:') !!}                          
                                            </td>
                                            <td>
                                                <input id="neonatal_highlight" name="neonatal_highlight" data-on="Yes" data-off="No" @if(isset($results->neonatal_highlight) && $results->neonatal_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr class="@if(isset($results->nicu_highlight) && $results->nicu_highlight == 2) nicu-print-highlighter @endif">
                                            <td>
                                                {!! Form::label('nicu_highlight','NICU:') !!}
                                            </td>
                                            <td>
                                                <input id="nicu_highlight" name="nicu_highlight" data-on="Yes" data-off="No" @if(isset($results->nicu_highlight) && $results->nicu_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr class="@if(isset($results->nicu_daycare_highlight) && $results->nicu_daycare_highlight == 2) nicudaycare-print-highlighter @endif">
                                            <td>
                                                {!! Form::label('nicu_daycare_highlight','NICU Daycare:') !!}
                                            </td>
                                            <td>
                                                <input id="nicu_daycare_highlight" name="nicu_daycare_highlight" data-on="Yes" data-off="No" @if(isset($results->nicu_daycare_highlight) && $results->nicu_daycare_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr class="@if(isset($results->daycare_summary_highlight) && $results->daycare_summary_highlight == 2) nicu-dsummary-highlighter @endif">
                                            <td>
                                                {!! Form::label('daycare_summary_highlight','NICU Daycare Summary:') !!}
                                            </td>
                                            <td>
                                                <input id="daycare_summary_highlight" name="daycare_summary_highlight" data-on="Yes" data-off="No" @if(isset($results->daycare_summary_highlight) && $results->daycare_summary_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr class="@if(isset($results->prblm_summary_highlight) && $results->prblm_summary_highlight == 2) nicu-pblmsummary-highlighter @endif">
                                            <td>
                                                {!! Form::label('prblm_summary_highlight','NICU Problem Base Summary:') !!}
                                            </td>
                                            <td>
                                                <input id="prblm_summary_highlight" name="prblm_summary_highlight" data-on="Yes" data-off="No" @if(isset($results->prblm_summary_highlight) && $results->prblm_summary_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table">
                                    <tbody>
                                        <tr class="@if(isset($results->post_adm_highlight) && $results->post_adm_highlight == 2) post-adm-highlighter @endif">
                                            <td>
                                                {!! Form::label('post_adm_highlight','Postnatal Admission:') !!}
                                            </td>
                                            <td>
                                                <input id="post_adm_highlight" name="post_adm_highlight" data-on="Yes" data-off="No" @if(isset($results->post_adm_highlight) && $results->post_adm_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr class="@if(isset($results->post_daycare_adm_highlight) && $results->post_daycare_adm_highlight == 2) post-daycare-adm-highlighter @endif">
                                            <td>
                                                {!! Form::label('post_daycare_adm_highlight','Postnatal Daycare:') !!}
                                            </td>
                                            <td>
                                                <input id="post_daycare_adm_highlight" name="post_daycare_adm_highlight" data-on="Yes" data-off="No" @if(isset($results->post_daycare_adm_highlight) && $results->post_daycare_adm_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr class="@if(isset($results->post_summary_highlight) && $results->post_summary_highlight == 2) post-summary-highlighter @endif">
                                            <td>
                                                {!! Form::label('post_summary_highlight','Postnatal Summary:') !!}
                                            </td>
                                            <td>
                                                <input id="post_summary_highlight" name="post_summary_highlight" data-on="Yes" data-off="No" @if(isset($results->post_summary_highlight) && $results->post_summary_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                        <tr class="@if(isset($results->op_highlight) && $results->op_highlight == 2) op-highlighter @endif">
                                            <td>
                                                {!! Form::label('op_highlight','OP:') !!}
                                            </td>
                                            <td>
                                                <input id="op_highlight" name="op_highlight" data-on="Yes" data-off="No" @if(isset($results->op_highlight) && $results->op_highlight == 2) checked @endif data-toggle="toggle" data-width="100" data-size="small" class="form-control" type="checkbox">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- OP Print Page Configuration -->
                <div role="tabpanel" class="tab-pane" id="opprint">
                    <div class="col-lg-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i>User Based Configuration</h4>
                            </div>
                            <div class="widget-content overflow-auto">
                                <table class="table" id="op_print_user_config_table">
                                    <thead>
                                        <tr>
                                            <th>User</th>
                                            <th>Top Spacing</th>
                                            <th>Right Spacing</th>
                                            <th>Bottom Spacing</th>
                                            <th>Left Spacing</th>
                                            <th>Status</th>
                                            <th>
                                                <span>
                                                <a class="btn btn-success btn-view btn_add" id="op_print_user_config" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                </span>                
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <div class="hidden">
                                            {!! Form::select('temp_user',[''=>'N/A']+ValuelistHelpers::getUserBasedDetails(),null) !!}
                                        </div>
                                        @php 
                                            $temp_user_list_count = 0;
                                        @endphp
                                        @if (count($op_print_page_user) > 0)
                                        @php 
                                        $user = collect($op_print_page_user)->pluck('id')->toArray();
                                        $user_list = json_encode($user);
                                        $current_user = Auth::user()->id;
                                        @endphp
                                        {!! Form::hidden('op_print_user_ids_list', $user_list) !!}
                                        @foreach($op_print_page_user as $key=>$value)
                                        @if((isset($user_role) && $user_role == env('SUPER_ADMIN_ROLE')) || ($value->user_id == $current_user))
                                            @php $temp_user_list_count++; @endphp
                                            <tr data-len="{{$key}}" class="">
                                                <td>
                                                    {!! Form::hidden('op_print_user_ids[]', $value->id) !!}
                                                    {!! Form::select('op_print_user_id[]', [''=>'N/A']+ValuelistHelpers::getUserBasedDetails(), $value->user_id, ['class'=>'form-control input-fields-shadow input-width-medium']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('op_print_user_top_spacing[]', $value->top_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('op_print_user_right_spacing[]', $value->right_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('op_print_user_bottom_spacing[]', $value->bottom_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('op_print_user_left_spacing[]', $value->left_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('op_print_user_status[]', [1=>'Active', 0=>'Inactive'], $value->status, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                                </td>
                                                <td><span class="fa fa-trash btn btn-danger btn-view remove ml-5"></span></td>
                                            </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                        @if (count($op_print_page_user) == 0 || $temp_user_list_count == 0)
                                        <tr data-len="0">
                                            <td>
                                                {!! Form::select('op_print_user_id[]', [''=>'N/A']+ValuelistHelpers::getUserBasedDetails(), null, ['class'=>'form-control input-fields-shadow input-width-medium']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_user_top_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_user_right_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_user_bottom_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_user_left_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('op_print_user_status[]', [1=>'Active', 0=>'Inactive'], null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td><span class="fa fa-trash btn btn-danger btn-view remove ml-5"></span></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i>Ip Based Configuration</h4>
                            </div>
                            <div class="widget-content overflow-auto">
                                <table class="table" id="op_print_ip_config_table">
                                    <thead>
                                        <tr>
                                            <th>IP Address</th>
                                            <th>Top Spacing</th>
                                            <th>Right Spacing</th>
                                            <th>Bottom Spacing</th>
                                            <th>Left Spacing</th>
                                            <th>Status</th>
                                            <th>
                                                <span>
                                                <a class="btn btn-success btn-view btn_add" id="op_print_ip_config" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
                                                </span>                
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            $temp_ip_list_count = 0;
                                        @endphp
                                        @if (count($op_print_page_ip) > 0)
                                        @php 
                                        $user = collect($op_print_page_ip)->pluck('id')->toArray();
                                        $user_list = json_encode($user);
                                        $current_ip = \Request::ip();
                                        @endphp
                                        {!! Form::hidden('op_print_ip_ids_list', $user_list) !!}
                                        @foreach($op_print_page_ip as $key=>$value)
                                        @if((isset($user_role) && $user_role == env('SUPER_ADMIN_ROLE')) || ($value->ip_address == $current_ip))
                                        @php $temp_ip_list_count++; @endphp
                                        <tr data-len="{{$key}}">
                                            <td>
                                                {!! Form::hidden('op_print_ip_ids[]', $value->id) !!}
                                                {!! Form::text('op_print_ip_address[]', $value->ip_address, ['class'=>'form-control input-fields-shadow input-width-medium']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_top_spacing[]', $value->top_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_right_spacing[]', $value->right_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_bottom_spacing[]', $value->bottom_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_left_spacing[]', $value->left_spacing, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('op_print_ip_status[]', [1=>'Active', 0=>'Inactive'], $value->status, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td><span class="fa fa-trash btn btn-danger btn-view remove ml-5"></span></td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endif
                                        @if (count($op_print_page_ip) == 0 || $temp_ip_list_count == 0)
                                        <tr data-len="0">
                                            <td>
                                                {!! Form::text('op_print_ip_address[]', null, ['class'=>'form-control input-fields-shadow input-width-medium']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_top_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_right_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_bottom_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::text('op_print_ip_left_spacing[]', null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td>
                                                {!! Form::select('op_print_ip_status[]', [1=>'Active', 0=>'Inactive'], null, ['class'=>'form-control input-fields-shadow input-width-small']) !!}
                                            </td>
                                            <td><span class="fa fa-trash btn btn-danger btn-view remove ml-5"></span></td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <button type="submit" class="btn btn-primary save-button-shadow form-control btn-block"><i class="fa fa-floppy-o"></i> <span>Update</span></button>
                        </div>
                        <div class="col-md-3 col-sm-4 col-xs-12">
                            <a href="{{ action('HomeController@index') }}" class="btn btn-default save-button-shadow form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
        {!! Form::model($results,['url' => action('Settings\SiteController@mroverwrite'),'method'=>'POST']) !!}
        {!! Form::close() !!}
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function(){
    
     CKEDITOR.replace('discharge_report_left',{
      on :
      {
        instanceReady : function( ev )
        {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
            });
    
     CKEDITOR.replace('discharge_report_right',{
      on :
      {
        instanceReady : function( ev )
        {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
            });
    
     CKEDITOR.replace('discharge_instraction',{
      on :
      {
        instanceReady : function( ev )
        {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
            });
    
     CKEDITOR.replace('discharge_summary_footer',{
      on :
      {
        instanceReady : function( ev )
        {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
            });
    CKEDITOR.replace('pediatric_discharge_summary',{
      on :
      {
        instanceReady : function( ev )
        {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
            });
     CKEDITOR.replace('condition_at_discharge',{
      on :
      {
        instanceReady : function( ev )
        {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
            });
     CKEDITOR.replace('review_details',{
      on :
      {
        instanceReady : function( ev )
        {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
            });
        CKEDITOR.replace('neonatal_op_print_right',{
          on :
          {
            instanceReady : function( ev )
            {
                        // Output paragraphs as <p>Text</p>.
                        this.dataProcessor.writer.setRules( 'p',
                        {
                          indent : false,
                          breakBeforeOpen : false,
                          breakAfterOpen : false,
                          breakBeforeClose : false,
                          breakAfterClose :false
                      });
                    }
                }
          });
    });
    
    $('#user_id').change(function(){
    
      getUserpermission();
      
    }); 
    getUserpermission();
    
    
    $.ajaxSetup({
    
     headers: {
       'X-XSRF-TOKEN': $('meta[name="_token"]').attr('content')
    }
    
    });
    
    
    
    function getUserpermission(){
    
     var  userId = $('#user_id').val();
     var  permissions = $("input[name='permissions[]']").val();
    
     $.ajax({
      type:'GET',
      url:"{!! url($speicalurl) !!}",
      data:{userId:userId,permissions:permissions},
      beforeSend:function(){
        $('#permission-render-div').html('<div class="text-center height-750"><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span>Please Wait...</span></div>');
    },
    success:function(data){
        $('#permission-render-div').html(data);
    },
    });
    
    }
    
    
    function UpdateValue(id,value){
     if(id=='Bopt1' || id== 'Mopt1')
      $("."+id).html(value);
    if(id=='Bopt2' || id== 'Mopt2' || id== 'Mopt3' || id== 'Bopt3'){
      d = new Date();
      var month = d.getMonth();
      var day = d.getDate();
      var year = d.getFullYear();
    
      year = year.toString().substr(2,2);
    
      month = month + 1;
      month = month + "";
    
      if (month.length == 1){
       month = "0" + month;
    }
    
    day = day + "";
    if (day.length == 1){
       day = "0" + day;
    }    
    if(value=='YY'){
       $("."+id).html(year);
    }
    if(value=='MM'){
       $("."+id).html(month);
    }
    if(value=='DD'){
       $("."+id).html(day);
    
    }
    }
    if(id=='Bopt4' || id== 'Mopt4')
    $("."+id).html((Math.pow(10,value)-1));
    
    }
    $("#OverwriteBabyMR").on("click", function(){ 
    check = $("#OverwriteBabyMR").is(":checked");
    if(check){
        $('#Bopt1').attr('readonly', true);
        $('#Bopt2').attr('readonly', true);
        $('#Bopt3').attr('readonly', true);
        $('#Bopt4').attr('readonly', true);
    } else {
        $('#Bopt1').removeAttr('readonly');
        $('#Bopt2').removeAttr('readonly');
        $('#Bopt3').removeAttr('readonly');
        $('#Bopt4').removeAttr('readonly');
    }
    });
    $("#OverwriteMotherMR").on("click", function(){ 
    check = $("#OverwriteMotherMR").is(":checked");
    if(check){
        $('#Mopt1').attr('readonly', true);
        $('#Mopt2').attr('readonly', true);
        $('#Mopt3').attr('readonly', true);
        $('#Mopt4').attr('readonly', true);
    } else {
        $('#Mopt1').removeAttr('readonly');
        $('#Mopt2').removeAttr('readonly');
        $('#Mopt3').removeAttr('readonly');
        $('#Mopt4').removeAttr('readonly');
    }
    });
    
    
    
    // $('.croppimage').click(function(){
    //     $('.print-logo-style').hide();
    //     $('#report-logo').removeClass('hide');
    //     printLogo();
    // });
    
    // @if(empty($results->PrintLogo))
    // $('.croppimage').trigger('click');
    // @endif 
    
    
    
    $("#report_logo").change(function() {
      readURL(this);
    }); 
    
    function readURL(input) {
      var imageUrl = window.URL || window.webkitURL;
      
      var errorFlag    = false;
      var errorMessage = '';
      
      if (input.files && input.files[0]) {
        $('.error-message').empty();
        
        var reader = new FileReader();
        var image  = new Image();
        
        image.onload = function () {
    
          if((this.width > 700 || this.width < 230 ) && (this.height > 130   || this.height < 300)){
           $('#report_logo_image').attr('src','');
    
           $('.error-message').text('Please Upload Image less than or equal width 350 px & height 200 px');
    
           $('.report_logo_browse').empty().html('<input type="file" name="report_logo" id="report_logo"/>');
    
       }else{
          reader.onload = function(e) {
    
            $('#report_logo_image').attr('src', e.target.result);
            
        }
        reader.readAsDataURL(input.files[0]);
        printLogo();
    }
    };
    image.src = imageUrl.createObjectURL(input.files[0]);
    
    
    
    }
    }
    
    
    
    $('.tabbable li a').click(function(){
    
    $.cookie('siteSetting', $(this).attr('href'),{ path: '/' });
    
    });
    
    var activeId =  $.cookie('siteSetting');
    
    if(activeId!='' && activeId!=null){
    
    $('.tabbable a').each(function(){
    
      $(this).parent().removeClass('active');
      
    });
    
    $('.tabbable a[href="'+activeId+'"]').parent().addClass('active');
    
    $('.tab-content .tab-pane').each(function(){
    
     $(this).removeClass('active');
    
    });
    
    $(activeId).addClass('active');
    
    }
    
    //  function printLogo() {
    
    //         $('#report_logo_image').selectAreas({
    //                 minSize: [10, 10],
    //                 onChanged: debugQtyAreas,
    //                 width: 500,
    //                 areas: [
    //                     {
    //                         x: 10,
    //                         y: 20,
    //                         width: 60,
    //                         height: 100,
    //                     }
    //                 ]
    //          });   
    // }
    
    // function debugQtyAreas (event, id, areas) {
    //     console.log(areas.length + " areas", arguments);
    // };
    
    //[77,469,280,739]
    
    function hospitalLogoupload() {
      var $uploadCrop;
      function readFile(input) {
       var imageUrl = window.URL || window.webkitURL;
    
       if (input.files && input.files[0]) {
        var reader = new FileReader();
        var image  = new Image();
        image.onload = function () {
          var width  = this.width;
          var height = this.height; 
          reader.onload = function (e) {
            $('.hospital-logo-upload').addClass('ready');
            $uploadCrop.croppie('bind', {
              url: e.target.result,
              points: [0,0,width,height]
          }).then(function(){
              $('.actions').hide();
              console.log('jQuery bind complete');
          });
    
      }
    
      reader.readAsDataURL(input.files[0]);
    };
    image.src = imageUrl.createObjectURL(input.files[0]);
    
    }
    else {
    swal("Sorry - you're browser doesn't support the FileReader API");
    }
    }
    
    function inizalizeCroppie() {
    return  $('#hospital-logo-upload').croppie({
                    // viewport: { width: 300, height: 150, type: 'square' },
                    // boundary: { width: 325, height: 175 },
                    viewport: { width: 250, height: 100, type: 'square' },
                    boundary: { width: 270, height: 125 },
                    showZoomer: true,
                    enableResize: false,
                    enableZoom: true,
                    enforceBoundary:false,
                    enableOrientation: true,
                    mouseWheelZoom: true,
                });
    }
    
    $uploadCrop = inizalizeCroppie(); 
    
    function imageResults(result, resultParam, $uploadCrop) {
    var html;
    $('input[name="image-upload"]').val(result);
    $('input[name="image-upload-width"]').val(resultParam.clientWidth);
    $('input[name="image-upload-height"]').val(resultParam.clientHeight);
    $('input[name="image-upload-x"]').val(resultParam.offsetLeft);
    $('input[name="image-upload-y"]').val(resultParam.offsetTop);
    
    if (result) {
    html  = '<img src="' + result+ '" width="'+resultParam.clientWidth+'" height="'+resultParam.clientHeight+'" />';
    html +='<i class="fa fa-times fa-2x croppimage" aria-hidden="true"></i>';
    }
    $('.hospital-logo-upload').removeClass('ready');
    $uploadCrop.croppie('destroy', {
    });
    $('.upload-logo').html(html).removeClass('hide');
    }
    
    
    
    $('#upload').on('change', function () { readFile(this); });
    $('.upload-result').on('click', function (ev) {
    $uploadCrop.croppie('result', {
    type: 'base64',
    size: 'viewport',
    format:'png'
    }).then(function (resp) {
    var resultParam = $uploadCrop.get()[0].children[0].lastElementChild;
    
    imageResults(resp, resultParam, $uploadCrop);
    });
    });
    
    $('.upload-cancel').on('click',function() {
    
    $('.hospital-logo-upload').removeClass('ready');
    $('.actions').show();
    $uploadCrop.croppie('destroy', {
    
    });
    
    $uploadCrop = inizalizeCroppie(); 
    });
    
    $('.croppimage').on('click', function() {
    $('.upload-logo').addClass('hide');
    $('.logo-box').removeClass('hide');
    
    });
    }
    hospitalLogoupload(); 
    
    $(document).ready(function() {
    $('#nurse_entry_start').timeDropper({
      format:'hh:mm A',
      setCurrentTime:false
    });
    @if(isset($results->nurse_entry_start) && $results->nurse_entry_start != '')
    $('#nurse_entry_start').val('{{ $results->nurse_entry_start }}');
    @endif
    
    }); 
    $(function () {
    var $toastlast;
    msg = "Welcome";
    title = "Neonatal";
    
    $('#showtoast').click(function () {
      var shortCutFunction = $("#toastTypeGroup").val();
      var $showDuration = $('#showDuration');
      var $hideDuration = $('#hideDuration');
      var $timeOut = $('#timeOut');
      var $extendedTimeOut = $('#extendedTimeOut');
      var $showEasing = $('#showEasing');
      var $hideEasing = $('#hideEasing');
      var $showMethod = $('#showMethod');
      var $hideMethod = $('#hideMethod');
      
      toastr.options = {
        closeButton: $('#closeButton').prop('checked'),
        debug: $('#debugInfo').prop('checked'),
        newestOnTop: $('#newestOnTop').prop('checked'),
        progressBar: $('#progressBar').prop('checked'),
        positionClass: $('#positionGroup').val() || 'toast-top-right',
        preventDuplicates: $('#preventDuplicates').prop('checked'),
        onclick: null
    };
    
    if ($showDuration.val().length) {
        toastr.options.showDuration = $showDuration.val();
    }
    
    if ($hideDuration.val().length) {
        toastr.options.hideDuration = $hideDuration.val();
    }
    
    if ($timeOut.val().length) {
        toastr.options.timeOut = $timeOut.val();
    }
    
    if ($extendedTimeOut.val().length) {
        toastr.options.extendedTimeOut = $extendedTimeOut.val();
    }
    
    if ($showEasing.val().length) {
        toastr.options.showEasing = $showEasing.val();
    }
    
    if ($hideEasing.val().length) {
        toastr.options.hideEasing = $hideEasing.val();
    }
    
    if ($showMethod.val().length) {
        toastr.options.showMethod = $showMethod.val();
    }
    
    if ($hideMethod.val().length) {
        toastr.options.hideMethod = $hideMethod.val();
    }
    
    var $toast = toastr[shortCutFunction](msg, title);
    $toastlast = $toast;
    });
    });
    
    $(document).on("keyup","input[name='limit_option[]']", function() {
    var rowId = $(this).parent('td').parent('tr').attr('id');
    var changeRadioBtnVal = "#"+rowId +" input:radio[name=default_limit]";
    $(changeRadioBtnVal).val($(this).val());            
    });
    
        // $('.option_add').click(function() {
        //     console.log('dfgdfg');
        //     var limitId = $(this).data('limit');
        //     var addMoreCount = parseInt(limitId.split('-')[1], 10)+1;
        //     $(this).data('limit','option-'+addMoreCount);
        //     addMoreCount+=1;
        // });
        
    
</script>
@endsection
