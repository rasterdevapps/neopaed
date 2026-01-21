@php $times=ValuelistHelpers::timeEngine(); @endphp
<a class="btn btn-success reassessment-add remove-episode pull-right mb-15 btn_add" href="javascript:void(0);"><i class="fa fa-plus-circle"></i> Add Assessment</a>
<div class="col-md-12" id="reassessmentsheet">
    @if(count($daycare_reassessment) > 0)
    @php $assesment_number = 1 ; @endphp
    @foreach($daycare_reassessment as $assessment_values)
    {!! Form::hidden('reassessment_id[]',$assessment_values['id']) !!}
    <div class="reassment-sheet-group">
        <div class="mt-10 widget box row mx-0">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-reorder"></i> Assessment {{ $assesment_number }} 
                </h4>
                <button type="button" class="btn btn-danger btn-view pull-right remove-sheet-group cardio-padding">
                <i class="fa fa-trash"></i>
                </button>
            </div>
            <div class="widget-content">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                @php $assesment_date = date('Y',strtotime($assessment_values['reassessment_date'])) > 1970 ? date('d-m-Y',strtotime($assessment_values['reassessment_date'])) : '' ; @endphp 
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_date","Date:") !!} 
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_date[]",$assesment_date,["class"=>"form-control datepicker"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_ventilater","Ventilator Support:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassessment_ventilater[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],$assessment_values['reassessment_ventilater'],["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_nc","NC:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassessment_nc[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],$assessment_values['reassessment_nc'],["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_systalic_bp","Systolic BP:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_systalic_bp[]",$assessment_values['reassessment_systalic_bp'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_bp","Mean BP:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_bp[]",$assessment_values['reassessment_bp'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_hr","HR:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_hr[]",$assessment_values['reassessment_hr'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_rr","RR:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_rr[]",$assessment_values['reassessment_rr'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_cns","CNS:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_cns[]",$assessment_values['reassemant_cns'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-10 widget box">
                        <div class="widget-header">
                            <h4><i class="fa fa-reorder"></i> </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                    {!! Form::label("reassessment_time","Time:") !!}
                                </div>
                                <div class="col-md-9 custom-input clear-xs">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <small>(Hour)</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <small>(Minute)</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <small>(Session)</small>
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::select("reassessment_time[]",$times["time"],null,["class"=>"form-control "]) !!}
                                        </div>
                                        <div class="col-xs-4">                                        
                                            {!! Form::select("reassessment_min[]",$times["mins"],null,["class"=>"form-control "]) !!}
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::select("reassessment_am[]",$times["period"],null,["class"=>"form-control "]) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_cpap","CPAP / HHHFNC:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassessment_cpap[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],$assessment_values['reassessment_cpap'],["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassesment_room_air","Room air:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassesment_room_air[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],$assessment_values['reassesment_room_air'],["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_diastolic_bp","Diastolic BP:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_diastolic_bp[]",$assessment_values['reassessment_diastolic_bp'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_spo2","SPO2:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_spo2[]",$assessment_values['reassessment_spo2'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_rs","RS:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_rs[]",$assessment_values['reassemant_rs'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_gi","GI:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_gi[]",$assessment_values['reassemant_gi'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_cvs","CVS:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_cvs[]",$assessment_values['reassemant_cvs'],["class"=>"form-control"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $assesment_number++; @endphp
    @endforeach
    @else
    <div class="reassment-sheet-group">
        <div class="mt-10 widget box row mx-0">
            <div class="widget-header">
                <h4>
                    <i class="fa fa-reorder"></i> Assessment 1
                </h4>
                <button type="button" class="btn btn-danger btn-view pull-right remove-sheet-group cardio-padding">
                <i class="fa fa-trash"></i>
                </button>
            </div>
            <div class="widget-content">
                <div class="col-md-6 col-sm-6">
                    <div class="mt-10 widget box row mx-0">
                        <div class="widget-header">
                            <h4>
                                <i class="fa fa-reorder"></i>
                            </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_date","Date:") !!} 
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_date[]",null,["class"=>"form-control datepicker"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_ventilater","Ventilator Support:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassessment_ventilater[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_nc","NC:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassessment_nc[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_systalic_bp","Systolic BP:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_systalic_bp[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_bp","Mean BP:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_bp[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_hr","HR:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_hr[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_rr","RR:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_rr[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_cns","CNS:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_cns[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                    <div class="mt-10 widget box row mx-0">
                        <div class="widget-header">
                            <h4>
                                <i class="fa fa-reorder"></i>
                            </h4>
                        </div>
                        <div class="widget-content">
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                    {!! Form::label("reassessment_time","Time:") !!}
                                </div>
                                <div class="col-md-9 custom-input clear-xs">
                                    <div class="row">
                                        <div class="col-xs-4 text-center">
                                            <small>(Hour)</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <small>(Minute)</small>
                                        </div>
                                        <div class="col-xs-4 text-center">
                                            <small>(Session)</small>
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::select("reassessment_time[]",$times["time"],null,["class"=>"form-control "]) !!}
                                        </div>
                                        <div class="col-xs-4">                                        
                                            {!! Form::select("reassessment_min[]",$times["mins"],null,["class"=>"form-control "]) !!}
                                        </div>
                                        <div class="col-xs-4">
                                            {!! Form::select("reassessment_am[]",$times["period"],null,["class"=>"form-control "]) !!}<
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_cpap","CPAP / HHHFNC:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassessment_cpap[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassesment_room_air","Room air:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::select("reassesment_room_air[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"])!!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_diastolic_bp","Diastolic BP:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_diastolic_bp[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassessment_spo2","SPO2:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassessment_spo2[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_rs","RS:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_rs[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_gi","GI:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_gi[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3 text-right label-control">
                                    {!! Form::label("reassemant_cvs","CVS:") !!}
                                </div>
                                <div class="col-md-9 custom-input">
                                    {!! Form::text("reassemant_cvs[]",null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif  
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var pageHeight=$('.container').height() + $('.crumbs').height() + $('.page-header').height() + $('.nav-tabs').height();
        $('#reassessment').css('min-height',$(window).height()-(pageHeight+85));
        
        $('.reassessment-add').click(function(){
            var reassessmentCount = ($('#reassessmentsheet .col-md-6').length/2)+1;
    
            var reassessmentFields  = '<div class="reassment-sheet-group mt-20"><div class="mt-10 widget box row mx-0"><div class="widget-header"><h4><i class="fa fa-reorder"></i> Assessment '+reassessmentCount+' </h4><button type="button" class="btn btn-danger btn-view pull-right remove-sheet-group cardio-padding"><i class="fa fa-trash"></i></button></div><div class="widget-content"><div class="col-md-6 col-sm-6"><div class="mt-10 widget box"><div class="widget-header"><h4><i class="fa fa-reorder"></i> </h4></div><div class="widget-content">';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_date","Date:") !!} </div><div class="col-md-9 custom-input">{!! Form::text("reassessment_date[]",null,["class"=>"form-control datepicker"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_ventilater","Ventilator Support:") !!}</div><div class="col-md-9 custom-input">{!! Form::select("reassessment_ventilater[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_nc","NC:") !!} </div><div class="col-md-9 custom-input">{!! Form::select("reassessment_nc[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"])!!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_systalic_bp","Systolic BP:") !!} </div><div class="col-md-9 custom-input">{!! Form::text("reassessment_systalic_bp[]",null,["class"=>"form-control"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_bp","Mean BP:") !!}</div><div class="col-md-9 custom-input">{!! Form::text("reassessment_bp[]",null,["class"=>"form-control"]) !!} </div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_hr","HR:") !!}</div><div class="col-md-9 custom-input">{!! Form::text("reassessment_hr[]",null,["class"=>"form-control"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_rr","RR:") !!}</div><div class="col-md-9 custom-input">{!! Form::text("reassessment_rr[]",null,["class"=>"form-control"]) !!} </div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassemant_cns","CNS:") !!}</div><div class="col-md-9 custom-input">{!! Form::text("reassemant_cns[]",null,["class"=>"form-control"]) !!} </div></div>';
            reassessmentFields += '</div></div></div>';
            reassessmentFields += '<div class="col-md-6 col-sm-6"><div class="mt-10 widget box"><div class="widget-header"><h4><i class="fa fa-reorder"></i> </h4></div><div class="widget-content"><div class="form-group row"><div class="col-md-3 text-right label-control" style="margin-top: 25px;">{!! Form::label("reassessment_time","Time:") !!}</div><div class="col-md-9 custom-input clear-xs"><div class="row"><div class="col-xs-4 text-center"><small>(Hour)</small></div><div class="col-xs-4 text-center"><small>(Minute)</small></div><div class="col-xs-4 text-center"><small>(Session)</small></div><div class="col-xs-4">{!! Form::select("reassessment_time[]",$times["time"],null,["class"=>"form-control "]) !!}</div><div class="col-xs-4">{!! Form::select("reassessment_min[]",$times["mins"],null,["class"=>"form-control "]) !!}</div><div class="col-xs-4">{!! Form::select("reassessment_am[]",$times["period"],null,["class"=>"form-control "]) !!}</div></div></div></div>';
    
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_cpap","CPAP / HHHFNC:") !!}</div><div class="col-md-9 custom-input">{!! Form::select("reassessment_cpap[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"])!!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassesment_room_air","Room air:") !!}</div><div class="col-md-9 custom-input">{!! Form::select("reassesment_room_air[]",[" "=>"--N/A--","No"=>"No","Yes"=>"Yes"],null,["class"=>"form-control"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_diastolic_bp","Diastolic BP:") !!} </div><div class="col-md-9 custom-input">{!! Form::text("reassessment_diastolic_bp[]",null,["class"=>"form-control"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassessment_spo2","SPO2:") !!}</div><div class="col-md-9 custom-input">{!! Form::text("reassessment_spo2[]",null,["class"=>"form-control"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassemant_rs","RS:") !!} </div><div class="col-md-9 custom-input">{!! Form::text("reassemant_rs[]",null,["class"=>"form-control"]) !!} </div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassemant_gi","GI:") !!}</div><div class="col-md-9 custom-input">{!! Form::text("reassemant_gi[]",null,["class"=>"form-control"]) !!}</div></div>';
            reassessmentFields += '<div class="form-group row"><div class="col-md-3 text-right label-control">{!! Form::label("reassemant_cvs","CVS:") !!}</div><div class="col-md-9 custom-input">{!! Form::text("reassemant_cvs[]",null,["class"=>"form-control"]) !!} </div></div></div></div></div></div></div>';
    
            $('#reassessmentsheet').append(reassessmentFields);
            $('.datepicker').datepicker();
        });
    
    });
    
    $(document).on('click','.remove-sheet-group',function(){
    
    $(this).parent().parent().remove();
    
    }); 
</script>