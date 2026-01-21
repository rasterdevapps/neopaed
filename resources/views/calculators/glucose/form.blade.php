@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current"><a href="{{ action('Calculators\GlucoseController@index') }}">Glucose Rate Calculator</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12 col-sm-12">
        {!! Form::open(['url' => '', 'id'=>'glucose-rate-calculator-form']) !!}                               
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BWeight','Body Weight(gms):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('BWeight',0,['class'=>'form-control input-vals']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('FluidRate','Fluid Rate(ml/hr):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('FluidRate',0,['class'=>'form-control input-vals']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control mt-0">
                            {!! Form::label('GlucoseRate','Glucose Rate (mg/kg/min):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('GlucoseRate',0,['class'=>'form-control input-vals']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Dextrose1','Dextrose 1 (%):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Dextrose1',[0=>0,5=>5,10=>10,25=>25,50=>50],0,['class'=>'form-control input-vals']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Dextrose2','Dextrose 2 (%):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Dextrose2',[0=>0,5=>5,10=>10,25=>25,50=>50],0,['class'=>'form-control input-vals']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control mt-0">
                            {!! Form::label('TotalDextroseMl','Total Dextrose (ml/day):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('TotalDextroseMl',0,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control mt-0">
                            {!! Form::label('TotalDextroseGms','Total Dextrose (gms/day):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('TotalDextroseGms',0,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="mt-10 widget box row mx-0">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="col-md-5">
                        <h4>Per Day</h4>
                        <div class="form-group">
                            {!! Form::label('Dextrose1Res','Dextrose 1 (ml):') !!}
                            {!! Form::text('Dextrose1Res',0,['class'=>'form-control','readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Dextrose2Res','Dextrose 2 (ml):') !!}
                            {!! Form::text('Dextrose2Res',0,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <h4>
                            <select name="Perml" id="Perml" class="form-control input-vals">
                                <option value="20" selected="selected">Per 20 ml</option>
                                <option value="50">Per 50 ml</option>
                                <option value="100">Per 100 ml</option>
                                <option value="150">Per 150 ml</option>
                                <option value="200">Per 200 ml</option>
                            </select>
                        </h4>
                        <div class="form-group">
                            {!! Form::label('Dextrose1Res20','Dextrose 1 (ml):') !!}
                            {!! Form::text('Dextrose1Res20',0,['class'=>'form-control','readonly']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Dextrose2Res20','Dextrose 2 (ml):') !!}
                            {!! Form::text('Dextrose2Res20',0,['class'=>'form-control','readonly']) !!}
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            {!! Form::label('GlucoseConcent','Glucose Concentration (%):') !!}<br />
                            <input type="text" class="GlucoseConcent form-control" value="0" readonly="readonly" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-sm-12 clear">
            <a href="javascript:void(0);" class="btn btn-default btn-basic-shadow form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Clear</span></a>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.col-md-12 -->                    
</div>
<!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
    $(".input-vals").bind('focusout',function() {
        FluidRate = $("#FluidRate").val();
        BWeight = $("#BWeight").val();
        GlucoseRate = $("#GlucoseRate").val();
        Dextrose1 = $("#Dextrose1").val();
        Dextrose2 = $("#Dextrose2").val();
        
        PerMl = $("#Perml").val();
        
        TotalDextroseMl = FluidRate * 24;
        TotalDextroseGms = GlucoseRate * BWeight / 1000 * 60 * 24 / 1000 ;
        Dextrose1Res = (TotalDextroseMl * Dextrose2 - TotalDextroseGms * 100)/(Dextrose2-Dextrose1);
        Dextrose2Res = (TotalDextroseMl * Dextrose1 - TotalDextroseGms * 100)/(Dextrose1-Dextrose2);
        Dextrose1Res20 = Dextrose1Res / (Dextrose1Res+Dextrose2Res) * PerMl;
        Dextrose2Res20 = Dextrose2Res / (Dextrose1Res+Dextrose2Res) * PerMl;
        Total = TotalDextroseGms / TotalDextroseMl * 100;    

        TotalDextroseMl = isNaN(TotalDextroseMl) ? 0 : TotalDextroseMl;
        TotalDextroseGms = isNaN(TotalDextroseGms) ? 0 : TotalDextroseGms;
        Dextrose1Res = isNaN(Dextrose1Res) ? 0 : Dextrose1Res;
        Dextrose2Res = isNaN(Dextrose2Res) ? 0 : Dextrose2Res;
        Dextrose2Res20 = isNaN(Dextrose2Res20) ? 0 : Dextrose2Res20;
        Dextrose1Res20 = isNaN(Dextrose1Res20) ? 0 : Dextrose1Res20;
        Total = isNaN(Total) ? 0 : Total;

        $("#TotalDextroseMl").val(TotalDextroseMl.toFixed(2));
        $("#TotalDextroseGms").val(TotalDextroseGms.toFixed(2));
        $("#Dextrose1Res").val(Dextrose1Res.toFixed(2));
        $("#Dextrose2Res").val(Dextrose2Res.toFixed(2));
        $("#Dextrose2Res20").val(Dextrose2Res20.toFixed(2));
        $("#Dextrose1Res20").val(Dextrose1Res20.toFixed(2));
        
        $(".GlucoseConcent").val(Total.toFixed(2));
    });
    $(".input-vals").bind('change',function() {
        FluidRate = $("#FluidRate").val();
        BWeight = $("#BWeight").val();
        GlucoseRate = $("#GlucoseRate").val();
        Dextrose1 = $("#Dextrose1").val();
        Dextrose2 = $("#Dextrose2").val();
        
        PerMl = $("#Perml").val();
        
        TotalDextroseMl = FluidRate * 24;
        TotalDextroseGms = GlucoseRate * BWeight / 1000 * 60 * 24 / 1000 ;
        Dextrose1Res = (TotalDextroseMl * Dextrose2 - TotalDextroseGms * 100)/(Dextrose2-Dextrose1);
        Dextrose2Res = (TotalDextroseMl * Dextrose1 - TotalDextroseGms * 100)/(Dextrose1-Dextrose2);
        
        Dextrose1Res20 = Dextrose1Res / (Dextrose1Res+Dextrose2Res) * PerMl;
        Dextrose2Res20 = Dextrose2Res / (Dextrose1Res+Dextrose2Res) * PerMl;
        
        Total = TotalDextroseGms / TotalDextroseMl * 100;

        TotalDextroseMl = isNaN(TotalDextroseMl) ? 0 : TotalDextroseMl;
        TotalDextroseGms = isNaN(TotalDextroseGms) ? 0 : TotalDextroseGms;
        Dextrose1Res = isNaN(Dextrose1Res) ? 0 : Dextrose1Res;
        Dextrose2Res = isNaN(Dextrose2Res) ? 0 : Dextrose2Res;
        Dextrose2Res20 = isNaN(Dextrose2Res20) ? 0 : Dextrose2Res20;
        Dextrose1Res20 = isNaN(Dextrose1Res20) ? 0 : Dextrose1Res20;
        Total = isNaN(Total) ? 0 : Total;

        $("#TotalDextroseMl").val(TotalDextroseMl.toFixed(2));
        $("#TotalDextroseGms").val(TotalDextroseGms.toFixed(2));
        $("#Dextrose1Res").val(Dextrose1Res.toFixed(2));
        $("#Dextrose2Res").val(Dextrose2Res.toFixed(2));
        $("#Dextrose2Res20").val(Dextrose2Res20.toFixed(2));
        $("#Dextrose1Res20").val(Dextrose1Res20.toFixed(2));
        
        $(".GlucoseConcent").val(Total.toFixed(2));
    });
    
</script>
@endsection
