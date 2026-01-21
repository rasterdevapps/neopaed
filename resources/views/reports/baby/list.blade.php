@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">{{ Lang::get('home.baby_tag_dashbord')}}</a>
        </li>
        <li class="current">
            <a href="{{ action('Reports\BabyReportController@index') }}">{{ Lang::get('home.baby_tag_print')}}</a>
        </li>                                                
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12 col-sm-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>{{ Lang::get('home.baby_tag_print')}}</h4>
                @if (count(\ValuelistHelpers::getHospitals()) > 1)
                {!! Form::select('hospital_name', [''=>'- - Select Hospital - -']+\ValuelistHelpers::getHospitals(), @$_GET['hospital_name'], ['class'=>'form-control input-width-medium display-inline-block mt-5', 'id'=>'hospital-filter']) !!}
                @endif
                <button type="button" @if(count($results) == 0) disabled="true" @endif class="btn create-btn-spacing btn-basic-shadow btn-info pull-right print-tag"><i class="fa fa-forward "></i> <span>{{ Lang::get('home.baby_tag_print_page') }}</span></button> 
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                    {!! Form::open(['url' => action('Reports\BabyReportController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                                    <select name="limit" @if(count($results) == 0) disabled="true" @endif size="1" aria-controls="data-list">
                                        <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                                        <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                                        <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                                        <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                                        <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                                    </select>
                                    <span class="hidden-xs">{{ Lang::get('home.baby_tag_records') }}</span>
                                    {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                                    {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                                    {!! Form::close() !!}
                                    </label>
                                </div>
                            </div>
                                {!! Form::open(['url' => action('Reports\BabyReportController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
                                <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                    <div class="input-group">
                                     <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                      <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ @$search['search_txt'] }}" placeholder="Search">
                                     <a href="{{ action('Reports\BabyReportController@index') }}" class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
                                  </div>
                                </div>
                                {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                {!! Form::open(['method'=> 'POST','url' => action('Reports\BabyReportController@filter'),'id'=>'SelectForm','class'=>'m-0']) !!}

                <table class="table table-striped table-bordered table-hover  table-checkable"  id="data-list">
                    <thead>
                        <tr>
                            <th><input type="checkbox" name="baby_select" id="baby_select" class="select_baby" /></th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BabyName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('BabyName') }}">{{ Lang::get('home.baby_tag_baby_name')}}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BMrNo') sorting_{{$order['sortorder']}}_icon @endif hidden-phone" data-field="{{ SiteHelpers::encrypt_id('BMrNo') }}" data-hide="phone">{{ Lang::get('home.mrn') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'Sex') sorting_{{$order['sortorder']}}_icon @endif hidden-phone" data-field="{{ SiteHelpers::encrypt_id('Sex') }}" data-hide="phone">{{ Lang::get('home.baby_tag_sex') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'DOB') sorting_{{$order['sortorder']}}_icon @endif hidden-phone" data-field="{{ SiteHelpers::encrypt_id('DOB') }}" data-hide="phone,tablet">{{ Lang::get('home.baby_tag_dob') }}</th>
                            <th class="sorting_by sorting_icon @if($order['sortby'] == 'BirthCity') sorting_{{$order['sortorder']}}_icon @endif hidden-phone" data-field="{{ SiteHelpers::encrypt_id('BirthCity') }}" data-hide="phone,tablet">{{ Lang::get('home.baby_tag_birth_city') }}</th>
                            <th class="center-align-phone">{{ Lang::get('home.baby_tag_preview') }}</th>                                                                
                        </tr>
                    </thead>
                    <tbody>
                         @if(count($results) > 0)   
                            @for ($i = 0; $i <  @count($results); $i++)
                                <tr>
                                    <td><input type="checkbox" name="baby_list[]" class="read" value="{{ $results[$i]->BabyId }}" /></td>
                                    <td class="text-captialize">{{  $results[$i]->BabyName }}</td>
                                    <td class="hidden-phone">{{  $results[$i]->BMrNo }}</td>
                                    <td class="hidden-phone">{{  $results[$i]->Sex }}</td>
                                    <td class="hidden-phone">{{ (!is_null($results[$i]->DOB)) ? date('d-m-Y',strtotime($results[$i]->DOB)) : '' }}</td>
                                    <td class="hidden-phone">{{  $results[$i]->BirthCity }}</td>
                                    <td class="center-align-phone">
                                    <a class="btn btn-info btn-view view-button" href="javascript:void(0);" onclick="ShowModal({!!  $results[$i]->BabyId !!});" ><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endfor
                        @else
                            <tr><td colspan="7" class="text-center"> <span>No Records Found</span></td> </tr>
                        @endif    
                    </tbody>
                </table> 
               {!! Form::close() !!}
        <div class="row">
          <div class="col-md-12">
            <div class="dataTables_footer clearfix">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                {{ Lang::get('home.baby_tag_showing') }} {{$pagination['limit'][0]}} {{ Lang::get('home.baby_tag_to')}} {{$pagination['limit'][1]}} {{ Lang::get('home.baby_tag_of')}} {{$pagination['total']}} {{ Lang::get('home.baby_tag_entries') }} {{ @$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                </div>
              </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="dataTables_paginate paging_bootstrap pagination_footer">
                    <ul class="pagination">    
                      <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                        <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('baby-print?page='.$pagination['previous']) }}@endif">&#8592; {{ Lang::get('home.baby_tag_previous') }}</a>
                      </li>
                    @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                      <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                        <a class='sort_with_page' href="{{ url('baby-print?page='.$i) }}">{{$i}}</a>
                      </li>  
                    @endfor
                      <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                        <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('baby-print?page='.$pagination['next']) }}@endif">{{ Lang::get('home.baby_tag_next') }} &#8594; </a>  
                      </li>
                    </ul>
                  </div>
                </div>
            </div>
          </div>
        </div><!-- /.row -->
            </div>
        </div>
    </div> <!-- /.col-md-12 -->
</div> 

<!-- /Page Content -->
<div class="modal fade bs-example-modal-lg modal-default" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white">
                    <i class="fa fa-times"></i>
                </button>
                <h4 id="myModalLabel" class="modal-title color-white">Baby Details</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_name') }} <span class="col-name"></span></p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_birth_status') }} <span class="col-birthstatus"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.mrn') }} <span class="col-bmrno"></span></p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_mother_name')}} <span class="col-mothername"></span></p>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_city') }} <span class="col-city"></span></p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_sex') }} <span class="col-sex"></span></p>
                    </div>
                </div>
                <div class="row">
                  <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_birth_weight') }} <span class="col-birthweight"></span></p>                    
                    </div>
                  <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_birth_order') }} <span class="col-birthorder"></span></p>

                    </div>                    
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_dob') }} <span class="col-dob"></span></p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_tob') }} <span class="col-tob"></span></p>
                    </div>
                </div>    
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_father') }} <span class="col-fspoken"></span></p>
                    </div>                
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_mother_name')}} <span class="col-mspoken"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_background') }} <span class="col-background"></span></p>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_confidential') }} <span class="col-confident"></span></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <p>{{ Lang::get('home.baby_tag_view_baby_blood')}} <span class="col-bloodgroup"></span></p>
                    </div>
                </div>                            

                </div>
            </div>
        </div>
    </div>
</div>                
@endsection
@section('scripts')
<script type="text/javascript">
$('.print-tag').prop('disabled', true);
$(".select_baby").on('click',function(){
    val = $(this).is(":checked");
    if(val){
        $('.print-tag').prop('disabled', false);        
        $(".read").prop('checked', true);
    }
    else{
        $('.print-tag').prop('disabled', true);
        $(".read").prop('checked', false);
    }
});

$("input[name='baby_list[]']").on('click',function(){
    if ($("input[name='baby_list[]']").is(":checked")) {    
        $('.print-tag').prop('disabled', false);        
    } else {
        $('.print-tag').prop('disabled', true);       
    }
});
$('.print-tag').click(function(){
    $('#SelectForm').submit();
});


function ShowModal(id){
      $.ajax({
              type    :"GET",
              url     :"{{ url('baby-registration') }}"+'/'+id,
              data    :{ id:id },
              success :function(response){
                  Datas = JSON.parse(response);
                  $(".modal-title").html(Datas['BabyName']);
                  $(".col-name").html(Datas['BabyName']);
                  $(".col-bmrno").html(Datas['BMrNo']);
                  $(".col-birthstatus").html(Datas['BirthStatus']);
                  $(".col-sex").html(Datas['Sex']);
                  $(".col-city").html(Datas['BirthCity']);
                  $(".col-bloodgroup").html(Datas['BabyBloodGroup']);                                                               
                  $(".col-birthorder").html(Datas['BirthOrder']);                                                               
                  $(".col-birthweight").html(Datas['BirthWeight']);                                                             
                  $(".col-fspoken").html(Datas['FatherSpokenLanguages']);                                                               
                  $(".col-mspoken").html(Datas['MotherSpokenLanguages']);                                                               
                  $(".col-dob").html(Datas['DOB']);                                                                                             
                  $(".col-tob").html(Datas['TOB']);                                                              
                  $(".col-background").html(Datas['BackgroundDetails']);
                  $(".col-confident").html(Datas['ConfidentialBackgroundDetails']);
                  $(".col-mothername").html(Datas['MotherName']);                                 
              },
              complete: function(){
                $('#basicModal').modal('show');
              }
        });
}
function DeleteData(id){
    bootbox.confirm("Are you sure?",function(confirmed){
        if(confirmed){
            $("#DeleteForm").attr('action',"{{ action('Registration\BabyController@index') }}/"+id);
            $("#DeleteForm").submit();
        }
    });
}

// $('#search').click(function() {
//     $('#search-form').submit();
// });

// $('.sorting_by').on('click', function(e) {
//     e.preventDefault();
//     var sortby       = $(this).data('field');
//     pagination(sortby);
// });

// $('.sort_with_page').click(function(e){
//     e.preventDefault();
//     var sorting_param = $('#limit-form').serialize();
//     var link      = $(this).attr('href');
//     var searchText    = $('input[name="search_txt"]').val();
//     window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
// });

// $('select[name="limit"]').on('change',function(e) {
//     e.preventDefault();
//     pagination();
// });

// function pagination(sortby) {
//   var pagination_url = $('#limit-form').attr('action');
//   var limit          = $('select[name="limit"] option:selected').val();
//   var searchText     = $('input[name="search_txt"]').val();    
//   var sorting_param  = $('#limit-form').serialize();
//   var sorting_param1 = sorting_param.split('&sortorder=')[0];
//   var sorting_param2 = sorting_param.split('&sortorder=')[1];

//   if (sortby) {
//     $('#sortby').val(sortby);
//     if (sorting_param2 == 'desc') {
//       var sortorder = 'asc';
//       // $("[data-field='"+ sortby +"']").removeClass('sorting_icon');
//       // $("[data-field='"+ sortby +"']").addClass('sorting_asc_icon');
//       $('#sortorder').val(sortorder);
//     } else {
//       var sortorder = 'desc';
//       // $("[data-field='"+ sortby +"']").removeClass('sorting_icon');
//       // $("[data-field='"+ sortby +"']").addClass('sorting_desc_icon');
//       $('#sortorder').val(sortorder);
//     }
//     window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
//   } else {
//     window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
//   }

// }
    $('#search').click(function(e) {
            e.preventDefault();
            pagination();
        });
        $('#search-form').submit(function(e) {
            e.preventDefault();
            pagination(); 
        })
        $('.sorting_by').on('click', function(e) {
            e.preventDefault();
            var sortby = $(this).data('field');
            pagination(sortby);
        });
        $('select[name="limit"]').on('change', function(e) {
            e.preventDefault();
            pagination();
        });
        $('.sort_with_page').click(function(e) {
            e.preventDefault();
            var sorting_param = $('#limit-form').serialize();
            var link = $(this).attr('href');
            var hospital_name = '?hospital_name='+$('#hospital-filter').val();
            var searchText = $('input[name="search_txt"]').val();
            window.location = link + hospital_name + '&search_txt=' + searchText + '&' + sorting_param;
        });
        function pagination(sortby) {
            var pagination_url = $('#limit-form').attr('action');
            var hospital_name = '?hospital_name='+$('#hospital-filter').val();
            pagination_url = pagination_url + hospital_name;
            var limit = $('select[name="limit"] option:selected').val();
            var searchText = $('input[name="search_txt"]').val();
            var sorting_param = $('#limit-form').serialize();
            var sorting_param1 = sorting_param.split('&sortorder=')[0];
            var sorting_param2 = sorting_param.split('&sortorder=')[1];
            if (sortby) {
                $('#sortby').val(sortby);
                if (sorting_param2 == 'desc') {
                    var sortorder = 'asc';
                    $('#sortorder').val(sortorder);
                } else {
                    var sortorder = 'desc';
                    $('#sortorder').val(sortorder);
                }
                window.location = pagination_url + '&page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
            } else {
                window.location = pagination_url + '&page=1&search_txt=' + searchText + '&' + sorting_param;
            }
        }
        $('#search-reset').click(function(e) {
            e.preventDefault();
            var link = $(this).attr('href');
            var hospital_name = '?hospital_name='+$('#hospital-filter').val();
            window.location = link + hospital_name;
        });

        var base_url = $("input[name='site_base_url']").val();
        $('#hospital-filter').on('change', function() {
            var link = window.location.href.replace(window.location.search, '');
            var hospital_name = '?hospital_name='+$(this).val();
            var search_context = window.location.search.split('&');
                search_context[0] = hospital_name;
                search_context[1] = 'page=';
            var search = search_context.join("&");
            window.location = link + search;
        });

        $('.dataTables_paginate.pagination_footer li a').on('click', function(e) {
            e.preventDefault();
            var page_url = $(this).attr('href');
            var current_location = page_url.split('?page=')[0];
            var page = 'page='+page_url.split('?page=')[1];
            var hospital_name = '?hospital_name='+$('#hospital-filter').val();
            var search_context = window.location.search.split('&');
                search_context[0] = hospital_name;
                search_context[1] = page;
            var search = search_context.join("&");
            window.location = current_location + search;
        });
</script>
@endsection
