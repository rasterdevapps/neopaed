@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current"><a href="#">Automated Glucose Intake Calculator</a></li>
    </ul>
</div>

<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box">
            <div class="widget-header">
                <h4><i class="fa fa-calculator"></i> Glucose Intake Calculator (Automated)</h4>
            </div>
            <div class="widget-content">
                <form method="GET" action="{{ url('glucose-intake-calculator') }}" class="form-horizontal row-border">
                    <div class="form-group">
                        <label class="col-md-2 control-label">Baby ID (MRNo/ID):</label>
                        <div class="col-md-3">
                            <input type="text" name="baby_id" value="{{ $baby_id }}" class="form-control" placeholder="Enter Baby ID">
                        </div>
                        <label class="col-md-2 control-label">Date:</label>
                        <div class="col-md-3">
                            <input type="date" name="date" value="{{ $date }}" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Calculate</button>
                        </div>
                    </div>
                </form>

                @if(isset($data['baby']))
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <h4>Baby Details</h4>
                        <table class="table table-bordered">
                            <tr>
                                <th>Name</th>
                                <td>{{ $data['baby']->BabyName }}</td>
                            </tr>
                            <tr>
                                <th>MR No</th>
                                <td>{{ $data['baby']->BMrNo }}</td>
                            </tr>
                            <tr>
                                <th>Birth Weight</th>
                                <td>{{ $data['baby']->BirthWeight }} g ({{ number_format($data['baby']->BirthWeight/1000, 3) }} kg)</td>
                            </tr>
                            <tr>
                                <th>Weight Used for Calc</th>
                                <td>
                                    <strong>{{ number_format($data['weight_kg'], 3) }} kg</strong>
                                    <span class="badge badge-info">{{ $data['weight_source'] }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h4>Calculation Results ({{ $date }})</h4>
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th>Total Volume Infused (Glucose)</th>
                                <td>{{ number_format($data['total_volume_ml'], 2) }} ml</td>
                            </tr>
                            <tr>
                                <th>Total Glucose (Grams)</th>
                                <td>{{ number_format($data['total_glucose_grams'], 2) }} g</td>
                            </tr>
                            <tr>
                                <th>Total Energy (Glucose x 4)</th>
                                <td>{{ number_format($data['total_kcal'], 2) }} Kcal</td>
                            </tr>
                            <tr class="success">
                                <th>Energy Intake (Kcal/kg/day)</th>
                                <td style="font-size: 1.2em; font-weight: bold;">
                                    {{ number_format($data['kcal_per_kg'], 2) }} Kcal/kg/day
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                @elseif($baby_id)
                <div class="alert alert-warning mt-10">
                    Baby not found.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
