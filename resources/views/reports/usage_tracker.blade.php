@extends('app')
@section('content')
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="current">
            <a href="{{ action('Reports\UsageTrackController@list') }}">{{ Lang::get('menu.side_menu_usage_tracker') }}</a>
        </li>                                         
    </ul>
</div>
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>{{ Lang::get('menu.side_menu_usage_tracker') }}</h4> 
            </div>
            <div class="widget-content">
                <div class="col-md-12 mt-15 mb-20 plr-0 pt-15 multi-search display-grid filter-block">
                    {!! Form::model(null, ['url' => action('Reports\UsageTrackController@list'), 'method' => 'get', 'id' => 'filter']) !!}
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('from_date','From Date:') !!}
                                {!! Form::text('from_date', $from_date, ['class'=>'form-control', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {!! Form::label('to_date','To Date:') !!}
                                {!! Form::text('to_date', $to_date, ['class'=>'form-control', 'readonly']) !!}
                            </div>
                        </div>
                        <div class="col-md-2 filter-btn">
                            <button class="btn btn-primary save-button-shadow data-filter mr-10">Search</button>
                            <button class="btn btn-default save-button-shadow reset ml-10">Reset</button>
                        </div>
                    {!! Form::close() !!}
                </div>
                <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
                    <thead>
                        <tr>
                            <th>S.No.</th>                                                                
                            <th>Nurse's Name</th>                                                                
                            <th>Nurse's Sheet Entered By Count</th>                                                                
                            <th>Care Event Entered By Count</th>                                                                
                        </tr>
                    </thead>
                    <tbody>
                         @if(count($nurse_list) > 0)   
                            @php $i = 1; @endphp
                            @foreach ($nurse_list as $key => $value)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $value }}</td>
                                    @if (isset($entry_results[$key]))
                                        @php 
                                            $count = $entry_results[$key];
                                        @endphp
                                    @else
                                        @php $count = 0; @endphp
                                    @endif
                                    <td>{{ $count }}</td>
                                    @if (isset($event_results[$key]))
                                        @php 
                                            $event_count = $event_results[$key];
                                        @endphp
                                    @else
                                        @php $event_count = 0; @endphp
                                    @endif
                                    <td>{{ $event_count }}</td>
                                </tr>
                                @php $i++; @endphp
                            @endforeach
                        @else
                            <tr>
                                <td></td>
                                <td><span>No Records Found</span></td>
                                <td></td>
                            </tr>
                        @endif   
                    </tbody>
                </table> 
            </div> 
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('input[name="from_date"], input[name="to_date"]').datepicker({
            dateFormat: 'dd-mm-yy'
        });
        $('.reset').click(function() {
            var form = $('#filter').get(0);
            $.removeData(form,'validator');
            $('input').val('');
        });     
        $('tr > th:last-child').trigger('click').trigger('click');
    });
</script>
@endsection