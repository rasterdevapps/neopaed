@extends('app')
@section('content')
@php 
$write_permission = session('write_permission'); 
Session::put('slug-nav','discharge-list'); 
$hide='false'; 
@endphp
<style type="text/css">
    .btn.active {
        background-color: #D9EDF7;
        color: black;
        font-weight: bold;
    }
    .toggle-on, .toggle-on:hover {
        background: #DFF0D8;
        color: black;
        font-weight: bold;
    }
/*.pdropbtn {
    background-color: transparent;
    color: white;
    font-size: 16px !important;
    border: none;
}

.pdropdown {
    position: relative;
    display: inline-block;
}

.pdropdown-content {
    display: none;
    position: absolute;
    background-color: var(--theme-color);
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
    top: 28px;
    left: -66px;
}

.pdropdown-content span {
    color: white;
    padding: 2px 10px;
    text-decoration: none;
    display: block;
}

.pdropdown-content span:hover, .pdropdown-content span.active {
    background-color: #2c374e;
}

.pdropdown:hover .pdropdown-content {
    display: block;
}

.pdropdown:hover .pdropbtn {
    color: #2c374e;
    }*/

    select.patient-filter:not(.ui-datepicker-month):not(.ui-datepicker-year) {
        background-position-y: 0px !important;
    }

</style>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }} ">{{ Lang::get('home.nicu_discharge_dashboard') }}</a></li>
        <li class="current"><a href="{{ action('Admission\NicuController@dischargeList') }}/{{$status}}">{{ Lang::get('home.nicu_discharge_details') }}</a></li>
    </ul>
    <ul class="pull-right dischargeList discharge-color-code list-none mr-15">
        <li><span class="info-tick info"></span> <b class="mb-2">{{ Lang::get('home.nicu_discharge_inpatient') }}</b></li>
        <li><span class="tick success"></span>  <b class="mb-2">{{ Lang::get('home.nicu_discharge_deceased')}} </b></li>
    </ul>
    <ul class="pull-right nicu-list discharge-color-code1 list-none hidden-xs hidden-sm">
        <li>
            <a class='btn btn-info btn-basic-shadow search-btn' href="{{ action('Search\NicuController@create').'?module=discharge' }}">
                <i class="fa fa-search"></i>  
                <span>{{ Lang::get('home.nicu_admission_advanced_search')}}</span>
            </a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>{{ Lang::get('home.nicu_discharge_details') }}</h4>
                @include('admission_filter')
                @if(in_array('NICU_FORM',$write_permission))
                <a href="{{ action('Admission\NicuController@chooseBaby') }}" title="" class="btn btn-info pull-right hide create-btn-spacing"><i class="fa fa-plus "></i> <span>{{ Lang::get('home.nicu_discharge_create') }}</span></a>       
                @endif                         
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-md-6 col-sm-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        {!! Form::open(['url' => action('Admission\NicuController@dischargeList'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                        <select name="limit"  size="1" aria-controls="data-list">
                                            <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                            <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                            <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                            <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                            <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                        </select><span class="hidden-xs">{{ Lang::get('home.nicu_discharge_records') }}</span>
                                        {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                        {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                        {!! Form::close() !!}
                                    </label>
                                </div>
                            </div>
                            {!! Form::open(['url' => action('Admission\NicuController@dischargeList'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                            <div class="col-xs-8 col-md-4 col-sm-6 pull-right">
                                <div class="input-group">
                                    <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{!! $search['search_txt'] !!}" placeholder="{{ Lang::get('home.nicu_discharge_search') }}">
                                    <a href="{{ action('Admission\NicuController@dischargeList') }}" class="input-group-addon" id="search-reset"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th>S.No.</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">{{ Lang::get('home.nicu_discharge_baby_name') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}" data-hide="phone,tablet">{{ Lang::get('home.mrn') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'baby.DOB') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('baby.DOB') }}" data-hide="phone,tablet">{{ Lang::get('home.nicu_discharge_dob') }}</th>
                            @if($hide=='true')  
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'AdmissionDate') sorting_{{$order['sortorder']}}_icon @endif hidden-xs" data-field="{{ SiteHelpers::encrypt_id('AdmissionDate') }}">{{ Lang::get('home.nicu_discharge_date') }}</th>
                            @if(in_array('NICU_FORM',$write_permission))
                            <th>Edit</th>
                            <th class="hidden-xs">{{ Lang::get('home.nicu_discharge_delete') }}</th>
                            @endif
                            <th class="hidden-xs">{{ Lang::get('home.nicu_discharge_preview') }}</th>
                            <th data-hide="phone">{{ Lang::get('home.nicu_discharge_print') }}</th>
                            @endif 
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($results) > 0  )
                        @for ($i = 0; $i <  @count($results); $i++)
                        <tr class="{{ $results[$i]->rowcolor }}">
                            <td>{{ $i+1 }}</td>
                            <td>
                                @if (isset($results[$i]->NeonatalId))
                                <a href="{{ action('Admission\NicuController@dischargeSublist',\SiteHelpers::encrypt_id($results[$i]->BabyId)) }}" class="check-neonatal" data-neonatal-id="{{$results[$i]->NeonatalId}}" data-baby-id="{{SiteHelpers::encrypt_id($results[$i]->BabyId)}}">
                                    {{  $results[$i]->BabyName }}
                                </a>
                                @else
                                <a class="check-neonatal" data-neonatal-id="{{$results[$i]->NeonatalId}}" data-baby-id="{{SiteHelpers::encrypt_id($results[$i]->BabyId)}}">
                                    {{  $results[$i]->BabyName }}
                                </a>
                                @endif
                            </td>
                            <td>{{  $results[$i]->BMrNo }}</td>
                            <td class="hidden-xs">
                                @if(date('Y',strtotime($results[$i]->DOB)) > 1970)
                                {{  date('d-m-Y',strtotime($results[$i]->DOB)) }}
                                @endif
                            </td>
                            @if($hide=='true')  
                            <td>{{  date('d-m-Y',strtotime($results[$i]->AdmissionDate)) }}</td>
                            @if(in_array('NICU_FORM',$write_permission))
                            <td class="center-align-phone">
                                <a class="icon edit-discharge"  href="{{ action('Admission\NicuController@edit',$results[$i]->NicuId) }}">
                                    <i class="fa fa-pencil"></i> 
                                    <span class="hidden-phone">{{ Lang::get('home.nicu_discharge_edit') }}</span>
                                </a>
                            </td>
                            <td class="center-align-phone hidden-xs">
                                <a class="icon" href="javascript:void(0);" onclick="DeleteData({{$results[$i]->NicuId}})">
                                    <i class="fa fa-remove"></i> 
                                    <span class="hidden-phone">{{ Lang::get('home.nicu_discharge_delete') }}</span>
                                </a>
                            </td>
                            @endif
                            <td  class="center-align-phone hidden-xs">
                                <a class="icon view-button" href="javascript:void(0);" onclick="ShowModal({!!  $results[$i]->NicuId !!},'{{ action('Admission\NicuController@getData',$results[$i]->NicuId) }}')" >
                                    <i class="fa fa-eye"></i> 
                                    <span class="hidden-phone">{{ Lang::get('home.nicu_discharge_view') }}</span>
                                </a>
                            </td>
                            <td  class="center-align-phone">
                                <a class="icon" href="{{ action('Admission\NicuController@printData',$results[$i]->NicuId) }}">
                                    <i class="fa fa-print"></i> 
                                    <span class="hidden-phone">{{ Lang::get('home.nicu_discharge_print') }}</span>
                                </a>
                            </td>
                            @endif  
                        </tr>
                        @endfor
                        @else
                        <tr>
                            <td colspan="4" class="text-center"> <span> {{ Lang::get('home.nicu_discharge_no_record') }}</span></td>
                        </tr>
                        @endif
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    {{ Lang::get('home.nicu_discharge_showing') }} {{$pagination['limit'][0]}} {{ Lang::get('home.nicu_discharge_to') }} {{$pagination['limit'][1]}} {{ Lang::get('home.nicu_discharge_of') }} {{$pagination['total']}} {{ Lang::get('home.nicu_discharge_entries') }} {{ $search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('nicu-admission/discharge-list?page='.$pagination['previous']) }}@endif">&#8592; {{ Lang::get('home.nicu_discharge_previous') }}</a>
                                        </li>
                                        @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                                        <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                            <a class='sort_with_page' href="{{ url('nicu-admission/discharge-list?page='.$i) }}">{{$i}}</a>
                                        </li>
                                        @endfor
                                        <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                            <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('nicu-admission/discharge-list?page='.$pagination['next']) }}@endif">{{ Lang::get('home.nicu_discharge_next') }} &#8594; </a>  
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
    function DeleteData(id) {
        bootbox.confirm("Are you sure?", function(confirmed) {
            if (confirmed) {
                $("#DeleteForm").attr('action', "{{ action('Admission\NicuController@dischargeList') }}/" + id);
                $("#DeleteForm").submit();
            }
        });
    }
    // $('#search').click(function(e) {
    //     e.preventDefault();
    //     pagination();
    // });
    // $('#search-form').submit(function(e) {
    //     e.preventDefault();
    //     pagination(); 
    // })
    // $('.sorting_by').on('click', function(e) {
    //     e.preventDefault();
    //     var sortby = $(this).data('field');
    //     pagination(sortby);
    // });
    // $('.sort_with_page').click(function(e) {
    //     e.preventDefault();
    //     var sorting_param = $('#limit-form').serialize();
    //     var link = $(this).attr('href');
    //     var status = $('.patient-filter').val();
    //     link = link.replace('discharge-list?', 'discharge-list/' + status + '?', link);
    //     var searchText = $('input[name="search_txt"]').val();
    //     window.location = link + '&search_txt=' + searchText + '&' + sorting_param;
    // });
    // $('select[name="limit"]').on('change', function(e) {
    //     e.preventDefault();
    //     pagination();
    // });
    // function pagination(sortby) {
    //     var pagination_url = $('#limit-form').attr('action');
    //     var status = $('.patient-filter').val();
    //     pagination_url = pagination_url + '/' + status;
    //     var limit = $('select[name="limit"] option:selected').val();
    //     var searchText = $('input[name="search_txt"]').val();
    //     var sorting_param = $('#limit-form').serialize();
    //     var sorting_param1 = sorting_param.split('&sortorder=')[0];
    //     var sorting_param2 = sorting_param.split('&sortorder=')[1];
    //     if (sortby) {
    //         $('#sortby').val(sortby);
    //         if (sorting_param2 == 'desc') {
    //             var sortorder = 'asc';
    //             $('#sortorder').val(sortorder);
    //         } else {
    //             var sortorder = 'desc';
    //             $('#sortorder').val(sortorder);
    //         }
    //         window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
    //     } else {
    //         window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
    //     }
    // }
    // $('.patient-filter').on('change', function() {
    //     var link = window.location.href;
    //     var status = $(this).val();
    //     if (link.indexOf('/All') > 0) {
    //         link = link.replace('/All', '/' + status, link);
    //     } else if (link.indexOf('/inpatient') > 0) {
    //         link = link.replace('/inpatient', '/' + status, link);
    //     } else if (link.indexOf('/discharged') > 0) {
    //         link = link.replace('/discharged', '/' + status, link);
    //     } else {
    //         link = link.replace('discharge-list', 'discharge-list/'+status, link);
    //     }
    //     window.location = link;
    // });
    $(document).on('click', '.check-neonatal', function(e) {
        var neonatal_id = $(this).attr('data-neonatal-id');
        var baby_id = $(this).attr('data-baby-id');
        if (neonatal_id == '') {
            e.preventDefault();
            // bootbox.confirm("Please, complete the 'Neonatal Performa'.", function(confirmed) {
            //     if (confirmed) {
            //         window.location = "{{ action('Registration\NeonatalController@create')}}/" + baby_id;
            //     }
            // });
            bootbox.dialog({
              message: "Please, complete the 'Neonatal Performa'.",
              buttons: {
                ok: {
                  label: "Later",
                  className: "btn-danger"
                },
                confirm: {
                  label: "Go To Neonatal Performa",
                  className: "btn-success",
                  callback: function() {
                    window.location = "{{ action('Registration\NeonatalController@create')}}/"+baby_id;
                  }
                }
              }
            });
        }
    });
    // $('#search-reset').click(function(e) {
    //     e.preventDefault();
    //     var link = $(this).attr('href');
    //     var status = $('.patient-filter').val();
    //     window.location = link + '/' + status;
    // });
</script>
@endsection
