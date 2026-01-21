<!-- Resources -->
<script type="text/javascript" src="{{$site_url}}/js/amcharts5/index.js"></script>
<script type="text/javascript" src="{{$site_url}}/js/amcharts5/xy.js"></script>
<script type="text/javascript" src="{{$site_url}}/js/amcharts5/plugins/exporting.js"></script>
<style type="text/css">    
  .status-btn.label-success {
    background-color: #5cb85c;
    color: white;
  }
  .status-btn.label-info {
    background-color: #2f96b4;
    color: white;
  }
  .status-btn.label-warning {
    background-color: #f0ad4e;
    color: white;
  }
</style>
<div class="row">
    <div class="col-xs-12 text-right back-to-screeening">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>   
</div>
<div class="col-md-12">
    <div class="temp-chart-container temp-layer"></div>
    <div class="row" id="chart-container">
        <button type="button" class="btn btn-primary" onclick="printbtn();"><i class="fa fa-print"></i> Print</button>
        <div id="chartdiv"></div>
        {!! Form::hidden('ddst_age') !!}
        @php $ddst_result = isset($ddst_result) ? $ddst_result : []; @endphp
        {!! Form::hidden('ddst_settings', json_encode(@$ddst_settings)) !!}
        {!! Form::hidden('ddst_interpretation_status') !!}
        {!! Form::hidden('ddst_gross_motor_interpretation_status') !!}
        {!! Form::hidden('ddst_language_interpretation_status') !!}
        {!! Form::hidden('ddst_fine_motor_interpretation_status') !!}
        {!! Form::hidden('ddst_personal_interpretation_status') !!}
        @php $settings = collect($ddst_settings)->where('task', '<>', '')->toArray(); @endphp
        @foreach ($settings as $value)
            @php 
                $task_id = $value['taskid'];
                $start_value = $value['value'];
                $end_value = $value['endValue'];
            @endphp
            {!! Form::hidden('ddst['.$task_id.']', @$ddst_result[$task_id], ['data-x-start-value'=>$start_value, 'data-x-end-value'=>$end_value]) !!}
        @endforeach
        <div class="col-md-12 text-center mt-15">
            <span class="status-btn display-block label-success {{(isset($results->ddst_interpretation_status) && $results->ddst_interpretation_status != null && $results->ddst_interpretation_status == 0) ? '' : 'hide'}} p-5"><b>{!! $ddst_interpretation_result[0] !!}</b></span>
            <span class="status-btn display-block label-warning {{(isset($results->ddst_interpretation_status) && $results->ddst_interpretation_status != null && $results->ddst_interpretation_status == 1) ? '' : 'hide'}} p-5"><b>{!! $ddst_interpretation_result[1] !!}</b></span>
            <span class="status-btn display-block label-info {{(isset($results->ddst_interpretation_status) && $results->ddst_interpretation_status != null && $results->ddst_interpretation_status == 2) ? '' : 'hide'}} p-5"><b>{!! $ddst_interpretation_result[2] !!}</b></span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group">
            {!! Form::label('ddst_interpretation','Interpretation:') !!}
            {!! Form::hidden('ddst_interpretation_options', json_encode($ddst_interpretation_options)) !!}
            {!! Form::textarea('ddst_interpretation',null,['class'=>'form-control', 'rows'=>5]) !!}
        </div>
        <div class="form-group">
            {!! Form::label('ddst_interpretation_others','Note:') !!}
            {!! Form::textarea('ddst_interpretation_others', null,['class'=>'form-control', 'rows'=>2]) !!}
        </div>
    </div>
    <div class="col-xs-12 text-right">
        <button type="button" class="btn btn-success back_to_screening"><i class="fa fa-chevron-circle-left"></i> BACK TO SCREENING</button>
    </div>   
</div>
