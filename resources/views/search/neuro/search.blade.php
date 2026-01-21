@extends('app')
@section('content')
<style type="text/css">
    .add_master_data, .btn_add, .add-discharge-medications-neuro, .remove-discharge-medications-neuro {
        display: none;
    }
    .mt-50 {
        margin-top: 0px !important;
    }
    .tab-pane {
        padding: 15px 0px 15px 0px !important;
    }
    .pt-15 {
        padding-top: 15px;
    }
    .pb-15 {
        padding-bottom: 15px;
    }
    #neuro-discharge-search-form {
        margin-left: 0px;
    }
    .custom-input > div.tinymce-body {
        border: 1px solid #CCCCCC !important;
        min-height: 100px;
        border-radius: 0px !important;
        padding: 5px;
        background-color: white;
    }
    .custom-input > div.tinymce-body:focus {
        border-color: #4d7496 !important;
    }
    #assessment .table>tbody>tr>td {
        border-top: 0px;
        vertical-align: middle;
    }

    #assessment .row {
        display: flex;
        justify-content: center;
    }
    #assessment .table {
        width: fit-content;
    }
    #assessment .table>tbody>tr>td {
        border: 0px;
        vertical-align: middle;
    }
    #assessment .label-danger, #assessment .label-success {
        padding: 5px;
        color: white;
    }
    #assessment .m_chat_name {
        font-size: 14;
        font-weight: bold;
    }
    .box-selection {
        cursor: not-allowed;
        pointer-events: none;
    }
    .reset {
        display: none;
    }
    .hine-container .table td {
        pointer-events: none;
        cursor: not-allowed;
    }
</style>

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="">
            <a title="" href="{{ action('Registration\NeuroController@index') }}">
                Neuro Development
            </a>
        </li>
        <li class="current">
            <a title="">Search</a>
        </li>
    </ul>
    <?php 
    if (isset($neuroList)) {
        $getTotal = count($neuroList);
        $total = @$count;
        $page = @$current_page;
        $limit = 10;
        $pagecount = ceil($total / $limit);
        $pagination['total'] = $total;
        $pagination['start'] = (($page - 2) < 1) ? 1 : ($page - 2);
        $pagination['end'] = ($pagecount < ($page + 3)) ? $pagecount : ($page + 3);
        $pagestart = $total != 0 ? ($page <= 1) ? $page : ($page - 1) * $limit + 1 : 0;
        $pagerecords = ($page == $pagination['end'] || $pagination['total'] == 0) ? $pagination['total'] : $page * $limit;
        $pagination['limit'] = array(
            $pagestart,
            $pagerecords
        );
        $pagination['limits'] = $limit;
        $pagination['previous'] = (($page - 1) < 1) ? 1 : ($page - 1);
        $pagination['next'] = ($pagecount < ($page + 1)) ? $pagecount : ($page + 1);

        $last_page = ceil($total/10);
    }
    $page = isset($page) ? $page : 1;
    ?>
    <div class="pull-right">
        @if(isset($neuro_last) && is_array($neuro_last))
        <table class="table">
            <tr>
                @if (@$results->neuro_id != $very_first)
                <td><a class="forward-boot-class" href="{{ action('Search\NeuroController@index', \SiteHelpers::encrypt_id($very_first) . '&neuro_count=' . $count.'&page=1&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last) }}"><i class="fa fa-fast-backward fa-2x" title="Previous Page" aria-hidden="true"></i></a></td>
                @endif
                <td> @if(isset($neuro_last[0]) &&  !empty($neuro_last[0]) && @$results->neuro_id != $very_first)<a class="forward-boot-class"  href="{{ $neuro_last[0] }}"><i class="fa fa-backward fa-2x" title="Previous Page"  aria-hidden="true"></i></a>@endif</td>
                <td> @if(isset($neuro_last[1]) &&  !empty($neuro_last[1]) && @$results->neuro_id != $very_last)<a class="forward-boot-class" href="{{ $neuro_last[1] }}"><i class="fa fa-forward fa-2x" title="Next Page" aria-hidden="true"></i></a>@endif </td>
                @if (@$results->neuro_id != $very_last)
                <td><a class="forward-boot-class"  href="{{ action('Search\NeuroController@index', \SiteHelpers::encrypt_id($very_last) . '&neuro_count=' . $count.'&page='.$last_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last . '&last=true') }}"><i class="fa fa-fast-forward fa-2x" title="Next Page"  aria-hidden="true"></i></a></td>
                @endif
            </tr>
        </table>
        @endif    
    </div>
    <div class="pull-right reset-search">
        <table>
            <tr>
                @if(isset($count))
                <td class="p-10">No.Record : {{ $count }}</td>
                <td> <a class="btn btn-info btn-basic-shadow reset-btn" href="{{ action('Search\NeuroController@create') }}"> Reset </a></td>
                <td><a class="btn btn-info btn-basic-shadow export margin-btn" href="{{ action('Search\NeuroController@download') }}"> Export </a></td>
                @endif
            </tr>
        </table>
    </div>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing" id ="neuro-discharge-search-form">
    <div class="col-md-9 col-sm-9 col-xs-9 pr-0 neuro-edit">
        {!! Form::model($results,['url' => action('Search\NeuroController@index', 0), 'method' => 'GET']) !!}
        @include('errors.list')
        {!! Form::hidden('query_log_id', @$query_log_id) !!}

        @include('search.neuro.form')
        {!! Form::close() !!}
    </div>
    <div class="col-md-3 col-sm-3 col-xs-3 custom-fields-search-sidebar @if(isset($neuroList) && count($neuroList) > 0) sidebar-scroll-enable @endif">
        <div class="search-container">
            <table class="table table-striped table-bordered  table-responsive"  id="data-list">
                <thead>
                    <tr class="hide">
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($neuroList) && count($neuroList) > 0)
                    @php rsort($neuroList); @endphp
                    @foreach($neuroList as $key => $value)
                    @php $value = collect($value)->toArray(); @endphp
                    <tr>
                        <td>
                            <div class="fields-search-list baby-name-list">
                                <a href="{{ action('Search\NeuroController@searchview',SiteHelpers::encrypt_id($value['neuro_id']).'?neuro_ids='.json_encode(@$neuro_ids).'&neuro_count='.@$count.'&query_log_id='.@$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last.'&page='.$current_page) }}" class="@if(Request::get('last') && ($value['neuro_id'] == $very_last || $value['neuro_id'] == $last_id)) search-list-active @elseif (!Request::get('last') && SiteHelpers::decrypt_id(Request::segment(2)) == $value['neuro_id']) search-list-active @endif">
                                    {{ $value['BabyName'] }} - {{ $value['BMrNo'] }} - <span style="color: black;">({{ date('d-m-Y', strtotime($value['visit_date'])) }})</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr>
                        <td>
                            <div class="fields-search-list">
                                <div class="text-center"> No Records Found </div>
                            </div>
                        </td>
                    </tr>
                    @endif  
                </tbody>
            </table>
            <div class="dataTables_footer clearfix">
                <div class="col-md-12 col-sm-12 col-xs-12 pagination-xs">
                    <div class="dataTables_paginate paging_bootstrap pagination_footer">
                        <ul class="pagination">
                            <li class="prev @if($page == '' || $page == @$pagination['start']) disabled @endif">
                                <a class="@if($page != @$pagination['start'] &&  $page != '') sort_with_page @endif" href="@if($page == @$pagination['start'] || $page == '') javascript:void(0); @else {{url('neuro-search?page='.@$pagination['previous'].'&query_log_id='.@$query_log_id.'&neuro_count='.@$count . '&very_first=' . @$very_first . '&very_last=' . @$very_last)}}@endif">&#8592; Previous</a>
                            </li>
                            @if (@$getTotal > 0)
                            @for ($i = @$pagination['start']; $i <= @$pagination['end']; $i++) 
                            <li class="@if($i == $page) active @elseif($page == '' && $i == @$pagination['start']) active @endif">
                                <a class='sort_with_page' href="{{url('neuro-search?page='.$i.'&query_log_id='.@$query_log_id.'&neuro_count='.@$count . '&very_first=' . @$very_first . '&very_last=' . @$very_last)}}">{{$i}}</a>
                            </li>
                            @endfor
                            @endif
                            <li class="next @if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) disabled @endif">
                                <a class="@if($page != @$pagination['end'] && @$pagination['start'] != @$pagination['end']) sort_with_page @endif" href="@if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) javascript:void(0); @else {{url('neuro-search?page='.@$pagination['next'].'&query_log_id='.@$query_log_id.'&neuro_count='.@$count . '&very_first=' . @$very_first . '&very_last=' . @$very_last)}}@endif">Next → </a>  
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php $neuro = Config('exportfields.neuro'); @endphp
    <div class="modal fade" id="exportModal" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <h3 class="text-center">Choose Fields To Be Export</h3>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" class="close-font">&times;</span>
                    </button>
                </div>
                <div class="modal-body row">
                    {{ Form::open(['url'=>action('Search\NeuroController@download'),'method'=>'post','id'=>'export-sheet']) }}
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('file_name','Save As Name') }}
                                {{ Form::text('file_name','neuro-search-list',['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                {{ Form::label('file_format','Save As Format') }}
                                {{ Form::select('file_format',['xlsx'=>'xlsx','xlsm'=>'xlsm','csv'=>'csv'],null,['class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                    {{ Form::hidden('query_log_id', @$query_log_id) }}
                    {{ Form::hidden('neuro_id', json_encode(@$neuro_ids)) }}
                    {{ Form::hidden('neuro_export_list') }}
                    <div class="col-md-12 plr-30">
                        <select multiple="multiple" size="10" id="neuro-options" name="neuro-options">
                            @foreach($neuro as $listkey => $listvalue)
                            <option value="{{ $listkey }}">{{ $listvalue }}</option>
                            @endforeach                   
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info btn-basic-shadow pull-right export-fields">Export</button>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    @endsection
    @section('scripts')
    <script type="text/javascript">
        $('.search-sidebar').click(function(){

            $(this).parent().next('div').slideToggle('fast');

            if($(this).children('i').hasClass('fa-chevron-down')) {

               $(this).children('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');

           }else{

               $(this).children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
           }
       });   

        $('.search-list-active').parent().prev('div').children('a').click();
        $('.search-list-active').parent().parent().prev('div').children('a').click();   

        $('.export').click(function(e){
            e.preventDefault();           
            $('#exportModal').modal('show');
        });

        $(document).ready(function(){
            new DualListbox("#neuro-options", {
                availableTitle: "Available numbers",
                selectedTitle: "Selected numbers",
                addButtonText: ">",
                removeButtonText: "<",
                addAllButtonText: ">>",
                removeAllButtonText: "<<",
                searchPlaceholder: "search numbers",
                enableDoubleClick: true,
            });
        });

        $('.export-fields').click(function(e) {
            e.preventDefault();
            var value_list = [];
            $('.dual-listbox__selected li').each(function(){
                value_list.push($(this).attr('data-id'));
            });

            var validate   =  false;

            $('.error-export').remove();

            $('input[name="neuro_export_list"]').val(JSON.stringify(value_list));

            if ($('input[name="file_name"]').val() == '') {
                validate = true;
                $('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
            }
            if (value_list.length == 0) {
                validate = true;
                $('select[name="neuro-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
            }

            if (!validate) {
                $('#export-sheet').submit();
                $('#exportModal').modal('hide');
            }
        });
        
        tinymce.init({
            selector: '.tinymce-body',
            menubar: false,
            inline: true,
            plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
            toolbar: ['undo redo | bold italic underline strikethrough | fontfamily fontsize blocks', 'alignleft aligncenter alignright alignjustify |  numlist bullist | forecolor backcolor casechange | preview | table']
        });
    </script>
    @endsection
