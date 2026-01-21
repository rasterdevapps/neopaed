@extends('app')
@section('content')
<style type="text/css">
    #postnatal-search-form .custom-fields-search-sidebar .search-container {
        padding: 0 !important;
        border: 1px solid #ddd;
        font-size: 12px;
        box-shadow: 0px 2px 6px 0px rgb(0 0 0 / 40%);
    }
    .fields-search-list a {
        color: #0000FF;
    }
    .fields-search-list a:hover {
        color: #A020F0;
    }
    .fields-search-list a.search-list-active {
        color: #FF0000;
        background-color: unset !important;
    }
</style>
<!-- Breadcrumbs line -->
@php $active = 'dischargeform'; @endphp
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="fa fa-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li class="">
            @if ($module == 'admission')
            <a title="" href="{{ action('Admission\PostnatalController@index') }}">
                Postnatal Admission
            </a>
            @else
            <a title="" href="{{ action('Admission\PostnatalDischargeController@index') }}">
                Discharge Details
            </a>
            @endif
        </li>
        <li class="current">
            <a title="">Search</a>
        </li>
    </ul>
    <?php 
    if (isset($postntallist)) {
        $getTotal = count($postntallist);
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
    ?>
    <div class="pull-right">
        @if(isset($post_last) && is_array($post_last))
        <table class="table">
            <tr>
                @if (@$results->posdisid != $very_first)
                <td><a class="forward-boot-class" href="{{ action('Search\PostnatalController@index', \SiteHelpers::encrypt_id($very_first) . '&post_count=' . $count.'&page=1&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last. '&module=' . $module) }}"><i class="fa fa-fast-backward fa-2x" title="Previous Page" aria-hidden="true"></i></a></td>
                @endif
                <td> @if(isset($post_last[0]) && !empty($post_last[0]) && @$results->posdisid != $very_first)<a class="forward-boot-class"  href="{{ $post_last[0]. '&module=' . $module }}"><i class="fa fa-backward fa-2x" title="Previous Page"  aria-hidden="true"></i></a>@endif</td>
                <td> @if(isset($post_last[1]) &&  !empty($post_last[1]) && @$results->posdisid != $very_last)<a class="forward-boot-class" href="{{ $post_last[1]. '&module=' . $module }}"><i class="fa fa-forward fa-2x" title="Next Page" aria-hidden="true"></i></a>@endif </td>
                @if (@$results->posdisid != $very_last)
                <td><a class="forward-boot-class"  href="{{ action('Search\PostnatalController@index', \SiteHelpers::encrypt_id($very_last) . '&post_count=' . $count.'&page='.$last_page.'&query_log_id='.$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last. '&module=' . $module . '&last=true') }}"><i class="fa fa-fast-forward fa-2x" title="Next Page"  aria-hidden="true"></i></a></td>
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
                <td> <a class="btn btn-info btn-basic-shadow reset-btn" href="{{ action('Search\PostnatalController@create'). '?module=' . $module }}"> Reset </a></td>
                <td><a class="btn btn-info btn-basic-shadow export margin-btn" href="{{ action('Search\PostnatalController@download') }}"> Export </a></td>
                @endif
            </tr>
        </table>
    </div>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing" id ="postnatal-search-form">
    <div class="col-md-9 col-sm-9 col-xs-9">
        {!! Form::model($results,['url' => action('Search\PostnatalController@index', 0), 'method' => 'GET','id' => 'search-form', 'class'=>'post-discharge-form']) !!}
        @include('errors.list')
        {!! Form::hidden('query_log_id', @$query_log_id) !!}
        {!! Form::hidden('module', @$module) !!}
        <!-- Nav tabs -->
        <div role="tabpanel" class="tabbable tabbable-custom">
            @if ($module == 'admission')
                @include('search.postnatal.admission')
            @else
                @include('search.postnatal.discharge')
            @endif
        </div>
        {!! Form::close() !!}
    </div>
    <div class="col-md-3 col-sm-3 col-xs-3 custom-fields-search-sidebar @if(isset($postntallist) && count($postntallist) > 0) sidebar-scroll-enable @endif">
        <div class="search-container">
            <table class="table table-striped table-bordered  table-responsive"  id="data-list">
                <thead>
                    <tr class="hide">
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($postntallist) && count($postntallist) > 0)
                    @php rsort($postntallist); @endphp
                    @foreach($postntallist as $key => $value)
                    @php $value = collect($value)->toArray(); @endphp
                    <tr>
                        <td>
                            <div class="fields-search-list baby-name-list">
                                <a href="{{ action('Search\PostnatalController@searchview',SiteHelpers::encrypt_id($value['posdisid']).'?post_ids='.json_encode(@$post_ids).'&post_count='.@$count.'&query_log_id='.@$query_log_id . '&very_first=' . $very_first . '&very_last=' . $very_last. '&module=' . $module.'&page='.$current_page) }}" class="@if(Request::get('last') && ($value['posdisid'] == $very_last || $value['posdisid'] == $last_id)) search-list-active @elseif (!Request::get('last') && SiteHelpers::decrypt_id(Request::segment(2)) == $value['posdisid']) search-list-active search-list-active @endif">
                                    {{ $value['BabyName'] }} - {{ $value['BMrNo'] }}
                                    ({!! $value['episodes'] !!})
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
                                <a class="@if($page != @$pagination['start'] &&  $page != '') sort_with_page @endif" href="@if($page == @$pagination['start'] || $page == '') javascript:void(0); @else {{url('postnatal-search?page='.@$pagination['previous'].'&query_log_id='.@$query_log_id.'&post_count='.@$count . '&very_first=' . $very_first . '&very_last=' . $very_last. '&module=' . $module)}}@endif">&#8592; Previous</a>
                            </li>
                            @if (@$getTotal > 0)
                            @for ($i = @$pagination['start']; $i <= @$pagination['end']; $i++) 
                            <li class="@if($i == $page) active @elseif($page == '' && $i == @$pagination['start']) active @endif">
                                <a class='sort_with_page' href="{{url('postnatal-search?page='.$i.'&query_log_id='.@$query_log_id.'&post_count='.@$count . '&very_first=' . $very_first . '&very_last=' . $very_last. '&module=' . $module)}}">{{$i}}</a>
                            </li>
                            @endfor
                            @endif
                            <li class="next @if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) disabled @endif">
                                <a class="@if($page != @$pagination['end'] && @$pagination['start'] != @$pagination['end']) sort_with_page @endif" href="@if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) javascript:void(0); @else {{url('postnatal-search?page='.@$pagination['next'].'&query_log_id='.@$query_log_id.'&post_count='.@$count . '&very_first=' . $very_first . '&very_last=' . $very_last. '&module=' . $module)}}@endif">Next → </a>  
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php $post = Config('exportfields.post'); @endphp
<div class="modal fade" id="exportModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <h3 class="text-center text-white">Choose Fields To Be Export</h3>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="close-font">&times;</span>
                </button>
            </div>
            <div class="modal-body row">
                {{ Form::open(['url'=>action('Search\PostnatalController@download'),'method'=>'post','id'=>'export-sheet']) }}
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            {{ Form::label('file_name','Save As Name') }}
                            {{ Form::text('file_name','post-search-list',['class'=>'form-control']) }}
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
                {{ Form::hidden('post_id', json_encode(@$post_ids)) }}
                {{ Form::hidden('post_export_list') }}
                <div class="col-md-12 plr-30">
                    <select multiple="multiple" size="10" id="post-options" name="post-options">
                        @foreach($post as $listkey => $listvalue)
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
    new DualListbox("#post-options", {
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

    $('input[name="post_export_list"]').val(JSON.stringify(value_list));

    if ($('input[name="file_name"]').val() == '') {
        validate = true;
        $('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
    }
    if (value_list.length == 0) {
        validate = true;
        $('select[name="post-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
    }

    if (!validate) {
        $('#export-sheet').submit();
        $('#exportModal').modal('hide');
    }
});

  $('.container').addClass('advance-search');
  $('#container').addClass('advance-search');

</script>
@endsection
