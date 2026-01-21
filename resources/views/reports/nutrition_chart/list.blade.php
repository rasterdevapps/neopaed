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
                    <div class="col-md-6">
                        {!! Form::select('baby', ['N/A' => '-- Select Baby --']+$babies, @$baby_id, ['class'=>'full-width', 'required']) !!}
                        <p class="error-message hide" id="baby-error">Baby name is required !</p>
                    </div>
                    <div class="col-md-3" style="display: flex;flex-direction: row;justify-content: center;align-items: center;height: 70px;">
                        <button type="submit" class="btn btn-primary save-button-shadow mr-10"> Search </button>
                        <button type="button" class="btn btn-default save-button-shadow mr-10" id="reset">Reset</button>
                        @if (isset($baby_id) && strlen($baby_id) > 0)
                        <a href="{{ action('Reports\NutritionChartController@export') }}?baby_id={{@$baby_id}}" class="btn btn-success" id="nutrition-chart-export-btn" title="Export"><i class="fa fa-download" aria-hidden="true"></i> Export</a>
                        @endif
                    </div>
                    {!! Form::close() !!} 
                </div>
                @if (isset($baby_id) && strlen($baby_id) > 0)
                @if (count($sheet_date_list) > 0) 
                <div role="tabpanel" class="tabbable tabbable-custom">
                    <ul class="nav nav-tabs" role="tablist">
                        @foreach ($sheet_date_list as $key => $sheet_date)
                        @php 
                        $str_sheet_date = strtotime($sheet_date);
                        $display_sheet_date = date('d-m-Y', strtotime($sheet_date));
                        @endphp
                        <li role="presentation" class="{!! $key == 0 ? 'active' : '' !!}">
                            <a href="#{!! $str_sheet_date !!}" aria-controls="{!! $str_sheet_date !!}" data-date="{{ $sheet_date }}" data-baby_id="{{ $baby_id }}" data-loaded="{{ $key == 0 ? 'true' : 'false' }}" role="tab" data-toggle="tab">{!! $display_sheet_date !!}</a>
                        </li>
                        @endforeach
                    </ul>
                    <div class="tab-content tab-view-shadow">
                        @foreach ($sheet_date_list as $key => $sheet_date)
                        @php 
                        $str_sheet_date = strtotime($sheet_date);
                        @endphp
                        <div role="tabpanel" class="tab-pane {!! $key == 0 ? 'active' : '' !!}" id="{!! $str_sheet_date !!}">
                            @if($key == 0)
                                @include('reports.nutrition_chart._table', ['sheet_date' => $sheet_date, 'drug_infused' => $drug_infused, 'day_wise_milk_volume' => $day_wise_milk_volume])
                            @else
                                <div class="nutrition-data-body">
                                    <tr><td colspan="8" class="text-center">Loading...</td></tr>
                                </div>
                            @endif
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
        $('select[name="baby"]').select2();
        $('#reset').on('click', function() {
            window.location = 'nutrition-chart-report';
        });
        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        var $target = $(e.target);
        var isLoaded = $target.data('loaded');
        var date = $target.data('date');
        var baby_id = $target.data('baby_id');
        var tabId = $target.attr('href');

        if (!isLoaded) {
            $.ajax({
                url: '{{ action('Reports\NutritionChartController@getNutritionDataByDateWise') }}',
                type: 'GET',
                data: {
                    date: date,
                    baby_id: baby_id
                },
                beforeSend: function() {
                    $(tabId).find('.nutrition-data-body').html('<tr><td colspan="8" class="text-center">Fetching data...</td></tr>');
                },
                success: function(response) {
                    $(tabId).find('.nutrition-data-body').html(response.html);
                    $target.data('loaded', true);
                    $target.attr('data-loaded', 'true');
                },
                error: function() {
                    $(tabId).find('.nutrition-data-body').html('<tr><td colspan="8" class="text-center text-danger">Error loading data.</td></tr>');
                }
            });
        }
    });
    });
</script>
@endsection