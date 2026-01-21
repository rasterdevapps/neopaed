@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{url('/')}}">Dashboard</a></li>
        <li class="current"><a href="{{ action('Reports\NutritionChartController@index') }}">Nutrition Chart</a></li>       
    </ul>
</div>
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Nutrition Chart</h4>
            </div>
            <div class="widget-content">
                <div class="col-md-12 mt-15 mb-20 p-10 multi-search display-grid" style="border: 1px solid #dddddd; border-radius: 5px; float: unset;">
                    {!! Form::model(null, ['url' => action('Reports\NutritionChartController@getNutritionData'), 'method' => 'get', 'id' => 'nutrition-chart']) !!}
                    <div class="col-md-3">
                        {{ Lang::get('home.mrn') }}:<span class="required-label"></span> {{ Form::text('mrn',@$mrn,['class'=>'form-control']) }}
                    </div>
                    <div class="col-md-3" style="display: flex;flex-direction: row;justify-content: center;align-items: center;height: 70px;">
                        <button type="submit" class="btn btn-primary save-button-shadow mr-10"> Search </button>
                        <button type="button" class="btn btn-default save-button-shadow mr-10" id="reset">Reset</button>
                        @if (isset($mrn) && strlen($mrn) > 0)
                        <a href="{{ action('Reports\NutritionChartController@export') }}?mrn={{@$mrn}}" class="btn btn-success" id="nutrition-chart-export-btn" title="Export"><i class="fa fa-download" aria-hidden="true"></i> Export</a>
                        @endif
                    </div>
                    {!! Form::close() !!} 
                </div>
                @if (isset($mrn) && strlen($mrn) > 0)
                @if (count($sheet_date_list) > 0) 
                <div role="tabpanel" class="tabbable tabbable-custom">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($sheet_date_list as $key => $sheet_date)
                        @php 
                        $str_sheet_date = strtotime($sheet_date);
                        $display_sheet_date = date('d-m-Y', strtotime($sheet_date));
                        @endphp
                        <li role="presentation" class="{!! $key == 0 ? 'active' : '' !!}">
                            <a href="#{!! $str_sheet_date !!}" aria-controls="{!! $str_sheet_date !!}" role="tab" data-toggle="tab">{!! $display_sheet_date !!}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content tab-view-shadow">
                        @foreach ($sheet_date_list as $key => $sheet_date)
                        @php 
                        $str_sheet_date = strtotime($sheet_date);
                        @endphp
                        <div role="tabpanel" class="tab-pane {!! $key == 0 ? 'active' : '' !!}" id="{!! $str_sheet_date !!}">
                            <table class="table table-striped table-bordered table-responsive"  id="data-list">
                                <thead>
                                    <tr>
                                        <th>10% dextrose</th>
                                        <th>10% dextrose instruction</th>
                                        <th>Isolyte P</th>
                                        <th>Isolyte P instruction</th>
                                        <th>Aminoven</th>
                                        <th>Lipids</th>
                                        <th>Milk</th>
                                        <th>Type of milk</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                    $drug_dtl = $dextrose10 = $isolytep = $aminoven = $lipids = $data_set = [];
                                    @endphp

                                    @if (isset($drug_infused[$sheet_date]))
                                    @php 
                                    $drug_dtl = $drug_infused[$sheet_date];
                                    $dextrose10 = isset($drug_dtl[7]) ? $drug_dtl[7] : [];
                                    $isolytep = isset($drug_dtl[8]) ? $drug_dtl[8] : [];
                                    $aminoven = isset($drug_dtl[14]) ? $drug_dtl[14] : [];
                                    $lipids = isset($drug_dtl[15]) ? $drug_dtl[15] : [];
                                    @endphp
                                    @endif

                                    @if (is_array($dextrose10) && count($dextrose10) > 0)
                                    @php $i = 0; @endphp
                                    @foreach($dextrose10 as $item)
                                    @php $data_set[$i][0] = $item['day_infused']; @endphp
                                    @php $data_set[$i][1] = $item['instruction']; @endphp
                                    @php $i++; @endphp
                                    @endforeach
                                    @endif

                                    @if (is_array($isolytep) && count($isolytep) > 0)
                                    @php $k = 0; @endphp
                                    @foreach($isolytep as $item)
                                    @php $data_set[$k][2] = $item['day_infused']; @endphp
                                    @php $data_set[$k][3] = $item['instruction']; @endphp
                                    @php $k++; @endphp
                                    @endforeach
                                    @endif

                                    @if (is_array($aminoven) && count($aminoven) > 0)
                                    @php $m = 0; @endphp
                                    @foreach($aminoven as $item)
                                    @php $data_set[$m][4] = $item['day_infused']; @endphp
                                    @php $m++; @endphp
                                    @endforeach
                                    @endif

                                    @if (is_array($lipids) && count($lipids) > 0)
                                    @php $n = 0; @endphp
                                    @foreach($lipids as $item)
                                    @php $data_set[$n][5] = $item['day_infused']; @endphp
                                    @php $n++; @endphp
                                    @endforeach
                                    @endif

                                    @if (isset($day_wise_milk_volume[$sheet_date]))
                                    @php $o = 0; @endphp
                                    @foreach($day_wise_milk_volume[$sheet_date] as $type => $vol)
                                    @php $data_set[$o][6] = $vol; @endphp
                                    @php $data_set[$o][7] = $type; @endphp
                                    @php $o++; @endphp
                                    @endforeach
                                    @endif

                                    @for ($i = 0; $i < count($data_set); $i++)
                                    <tr>
                                    @for ($j = 0; $j < 8; $j++)
                                    @if (isset($data_set[$i][$j]) && !empty($data_set[$i][$j]))
                                    <td>{!! $data_set[$i][$j] !!}</td>
                                    @else
                                    <td>-</td>
                                    @endif
                                    @endfor
                                    </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#reset').on('click', function() {
            window.location = 'nutrition-chart-report';
        });
    });
</script>
@endsection