@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="current">
            <a href="{{ action('Calculators\TpnCalculatorController@index') }}">TPN Calculator</a>
        </li>                                         
    </ul>
</div>
<div class="row row-spacing" id="tpn-block">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>TPN Calculator</h4> 
            </div>
            <div class="widget-content">
                <div class="row display-grid">
                    <div class="col-md-12 multi-search display-grid">
                        {!! Form::hidden('select_field_data', $babies) !!}
                        @include('select',  [
                            'label_name' => 'Select Baby:',
                            'placeholder' => '-- Select from List --'
                        ])
                    </div>
                    <div class="col-md-12" id="tpn-container">
                        <div class="col-md-12 mb-20 p-0" id="logo-container">
                            <img src="{{ SiteHelpers::getNicuLogo() }}">
                        </div>
                        <div class="col-md-12 p-0">
                            @php
                                $plan_1 = 'Total Fluid Intake (ml/kg/day)';
                                $plan_2 = 'Planned feeds (ml/kg/day)';
                                $plan_3 = 'Drugs/infusions (ml)';
                                $plan_4 = 'Amino acids (g/kg/day)';
                                $plan_5 = 'Lipids (g/kg/day)';
                                $plan_6 = 'Dextrose (mg/kg/min)';
                                $plan_7 = 'Sodium (meq/kg/day)';
                                $plan_8 = 'Potassium (meq/kg/day)';
                                $plan_9 = 'Calcium (ml/kg/day)';
                                $plan_10 = 'Wastage factor';

                                $recipe_1 = 'Amino acids (ml)';
                                $recipe_2 = '3% saline (ml)';
                                $recipe_3 = 'Potassium chloride (ml)';
                                $recipe_4 = 'MVI (ml): add to Intralipid';
                                $recipe_5 = 'Calcium gluconate (ml)';
                                $recipe_6 = 'Magnesium sulphate (ml)';
                                $recipe_7 = '10% Dextrose (ml)';
                                $recipe_8 = '25% Dextrose (ml)';
                                $recipe_9 = 'Intralipid: + 5 ml wastage';
                                $recipe_10 = 'Amino acid%';
                                $recipe_11 = 'Lipids%';
                                $recipe_12 = 'Calories/kg/day (TPN only)';

                                $wt = 'Working weight (kg)';
                            @endphp
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="4" class="main-title"><span>NICU TPN CALCULATOR</span> <span class="pull-right" id="tpn-print"><i class="fa fa-print"></i></span></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="2" class="width-50-percentage"><span class="text-center"><b id="baby-tag"></b></span></td>
                                        <td colspan="2" class="width-50-percentage"><span>{!! date('d-M-Y') !!}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="text-center">G-</span></td>
                                        <td><span>{!! $wt !!}:</span></td>
                                        <td>{!! Form::text('wt', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                    </tr>
                                </tbody>
                                <thead>
                                    <tr>
                                        <th colspan="2" class="sub-title">PLAN</th>
                                        <th colspan="2" class="sub-title">RECIPE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="37%"><span>{!! $plan_1 !!}</span></td>
                                        <td width="13%">{!! Form::text('plan_1', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td width="37%"><span>{!! $recipe_1 !!}</span></td>
                                        <td width="13%">{!! Form::text('recipe_1', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_2 !!}</span></td>
                                        <td>{!! Form::text('plan_2', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_2 !!}</span></td>
                                        <td>{!! Form::text('recipe_2', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_3 !!}</span></td>
                                        <td>{!! Form::text('plan_3', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_3 !!}</span></td>
                                        <td>{!! Form::text('recipe_3', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_4 !!}</span></td>
                                        <td>{!! Form::text('plan_4', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_4 !!}</span></td>
                                        <td>{!! Form::text('recipe_4', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_5 !!}</span></td>
                                        <td>{!! Form::text('plan_5', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_5 !!}</span></td>
                                        <td>{!! Form::text('recipe_5', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_6 !!}</span></td>
                                        <td>{!! Form::text('plan_6', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_6 !!}</span></td>
                                        <td>{!! Form::text('recipe_6', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_7 !!}</span></td>
                                        <td>{!! Form::text('plan_7', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_7 !!}</span></td>
                                        <td>{!! Form::text('recipe_7', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_8 !!}</span></td>
                                        <td>{!! Form::text('plan_8', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_8 !!}</span></td>
                                        <td>{!! Form::text('recipe_8', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_9 !!}</span></td>
                                        <td>{!! Form::text('plan_9', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_9 !!}</span></td>
                                        <td>{!! Form::text('recipe_9', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>{!! $plan_10 !!}</span></td>
                                        <td>{!! Form::text('plan_10', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                        <td><span>{!! $recipe_10 !!}</span></td>
                                        <td>{!! Form::text('recipe_10', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="font-size-12"><span class="pull-left align-left">Wastage is to account for loss in tubing or increase in TFI during the day. <br/>Default is 1.3 (i.e. 130%); consider 1.5 if volume is small.</span></td>
                                        <td><span>{!! $recipe_11 !!}</span></td>
                                        <td>{!! Form::text('recipe_11', null, ['class'=>'form-control', 'onkeypress'=>'return isNumber(event, this);']) !!}</td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td><span>Final dextrose concentration:</span></td>
                                        <td>{!! Form::text('plan_12', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                        <td><span>{!! $recipe_12 !!}:</span></td>
                                        <td>{!! Form::text('recipe_12', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                    <tr>
                                        <td><span>Calories from lipids%:</span></td>
                                        <td>{!! Form::text('plan_13', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                        <td><span>Calories/gram of protein:</span></td>
                                        <td>{!! Form::text('recipe_13', null, ['class'=>'form-control', 'readonly'=>true, 'tabindex'=>-1]) !!}</td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr>
                                        <td colspan="4" class="align-center">
                                            <div class="align-center">
                                                <span><b>TPN:</b> infuse at the rate of&nbsp</span>
                                                <span id="plan_14">0.00</span>
                                                <span>&nbspml/hr X 24 hours; (rounded from&nbsp</span>
                                                <span id="recipe_14">0.00)</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <div class="align-center">
                                                <span><b>Intralipid:</b> infuse at the rate of&nbsp</span>
                                                <span id="plan_15">0.00</span>
                                                <span>&nbspml/hr X 24 hours; (rounded from&nbsp</span>
                                                <span id="recipe_15">0.00)</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
