@extends('app')
@section('content')
<style></style>
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li class="current"><a href="{{ url('/mother-registration') }}">Registered Patients</a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class=" col-sm-12 col-md-12">
        <div class="widget box table-view-shadow">
          <div class="widget-header">
            <h4>{{ Lang::get('home.mother_registered_patients') }}</h4>
            @if(in_array('MOTHER_REG',$write_permission))
            <a href="{{ action('Registration\MotherController@create') }}" title="create new" class="btn btn-info create-btn-spacing btn-basic-shadow pull-right" >
              <i class="fa fa-plus "></i> 
              <span>{{ Lang::get('home.mother_create_new')}}</span>
          </a>      
          @endif
      </div> 
      <div class="widget-content">
        <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
          <div class="row">
            <div class="dataTables_header clearfix" >
              <div class="col-xs-4 col-sm-6 col-md-6">
                <div id="data-list_length" class="dataTables_length">
                  <label class="data_limit">
                    {!! Form::open(['url' => action('Registration\MotherController@index'), 'method' => 'get', 'id' => 'limit-form']) !!}
                    <select name="limit"  size="1" aria-controls="data-list">
                      <option value="10" @if($pagination['limits'] == 10) selected="selected" @endif  >10</option>
                      <option value="25" @if($pagination['limits'] == 25) selected="selected" @endif>25</option>
                      <option value="50" @if($pagination['limits'] == 50) selected="selected" @endif>50</option>
                      <option value="100" @if($pagination['limits'] == 100) selected="selected" @endif>100</option>
                      <option value="1000" @if($pagination['limits'] == 1000) selected="selected" @endif>All</option>
                  </select><span class="hidden-xs">{{ Lang::get('home.mother_records') }}</span>
                  {!! Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']) !!}
                  {!! Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']) !!}
                  {!! Form::close() !!}
              </label>
          </div>
      </div>
      {!! Form::open(['url' => action('Registration\MotherController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']) !!} 
      <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
        <div class="input-group">
          <span id="search" class="input-group-addon">
             <i class="glyphicon glyphicon-search"></i>
         </span>
         <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="{{ @$search['search_txt'] }}" placeholder="{{ Lang::get('home.mother_search') }}">
         <a href="{{ action('Registration\MotherController@index') }}" class="input-group-addon">
          <i class="glyphicon glyphicon-remove"></i>
      </a>
  </div>                
</div>              
{!! Form::close() !!}
</div>
</div>
</div>
<table class="table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th class="sorting_by sorting_icon @if($order['sortby'] == 'MotherName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('MotherName') }}">Name</th>
            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'PartnerName') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('PartnerName') }}" data-hide="phone,tablet">Partner Name</th>
            <th class="sorting_by sorting_icon @if($order['sortby'] == 'MMrNo') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('MMrNo') }}" data-hide="phone,tablet">{{ Lang::get('home.mrn') }}</th>
            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'DateAdded') sorting_{{$order['sortorder']}}_icon @endif hide" data-field="{{ SiteHelpers::encrypt_id('DateAdded') }}" data-hide="phone,tablet"> Added Date</th>
            <th class="visible-xs">More</th>
            <th class="sorting_by sorting_icon hidden-xs @if($order['sortby'] == 'DateModified') sorting_{{$order['sortorder']}}_icon @endif hide" data-field="{{ SiteHelpers::encrypt_id('DateModified') }}" data-hide="phone,tablet">Modified Date</th>
            <th class="sorting_by sorting_icon hidden-xs hidden-sm @if($order['sortby'] == 'Mobile') sorting_{{$order['sortorder']}}_icon @endif" data-field="{{ SiteHelpers::encrypt_id('Mobile') }}"  data-hide="phone">Contact</th>
                            <!-- @if(in_array('MOTHER_REG',$write_permission))
                                <th class="hidden-xs hidden-sm">View</th>
                                @endif -->
                                @if(in_array('MOTHER_REG',$write_permission))
                                <th class="hidden-xs">View Baby</th>
                                <th class="hidden-xs">Add Baby</th>
                                @endif
                                <th class="hidden-xs">Preview</th>
                                @if(in_array('MOTHER_REG',$delete_permission))
                                <th class="hidden-xs">Delete</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($results) > 0 )
                            @for ($i = 0; $i <  @count($results); $i++)
                            <tr>
                                <td width="200">
                                    <a class="icon @if(!in_array('MOTHER_REG',$write_permission)) permission-denied @endif edit-content-link" href=" @if(in_array('MOTHER_REG',$write_permission)) {{ action('Registration\MotherController@edit', SiteHelpers::encrypt_id($results[$i]->MotherId)) }} @else javascript:void(0); @endif">
                                        @if($results[$i]->MotherName != '' || $results[$i]->MotherLastName != '')
                                        {{  $results[$i]->MotherName }} {{  $results[$i]->MotherLastName }}
                                        @else
                                           -
                                        @endif
                                    </a>  
                                </td>
                                <td class="hidden-xs">{{  $results[$i]->PartnerName }}</td>
                                <td>{{  $results[$i]->MMrNo }}</td>
                                <td class="visible-xs"><a href="#"><span class="glyphicon glyphicon-calendar hidden-lg" aria-hidden="true"  data-toggle="tooltip" data-original-title="Added Date : {!! date('d-m-Y', strtotime($results[$i]->DateAdded)) !!} &#13;  Modified Date: {!! date('d-m-Y', strtotime($results[$i]->DateModified)) !!} &#13; Contact:{!! $results[$i]->Mobile != 0 ?  $results[$i]->Mobile :''!!}"></span></a> </td>
                                <td class="hidden-xs hide">{{  date('d-m-Y', strtotime($results[$i]->DateAdded)) }}</td>
                                <td class="hidden-xs hide">{{  date('d-m-Y', strtotime($results[$i]->DateModified)) }}</td>
                                <td class="hidden-xs hidden-sm">{{  $results[$i]->Mobile != 0 ?  $results[$i]->Mobile :'' }}</td>
                                @if(in_array('MOTHER_REG',$write_permission))
                                @php
                                $babies_count = \SiteHelpers::getBabiesCount($results[$i]->MotherId);
                                @endphp
                                <td  class="hidden-xs">
                                    <a class="linkss view_baby_icon bs-tooltip" href="{{url('baby-registration')}}?search_txt={{$results[$i]->MotherId}}" title="View Babies">
                                        <img src="{{ url('/') }}/public/img/icons/menu/baby.png" width="20" height="40">
                                        <span>{{ $babies_count }}</span>
                                    </a>
                                </td>
                                <td  class="hidden-xs">
                                    <a class="linkss view_baby_icon bs-tooltip" href="{{ url('baby-registration/create') }}/{{ SiteHelpers::encrypt_id($results[$i]->MotherId) }}" title="Add Baby">
                                        <img src="{{ url('/') }}/public/img/icons/menu/baby_add.png" width="30" height="40">
                                    </a>
                                </td>
                                @endif
                                <td  class="hidden-xs">
                                    <a class="icon btn btn-info btn-view" href="javascript:void(0);" id="mother-{{$results[$i]->MotherId}}" onclick="ShowModal({!!  $results[$i]->MotherId !!});" title="View Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </td>
                                @if(in_array('MOTHER_REG',$delete_permission))
                                <td  class="hidden-xs">
                                    <a class="icon btn btn-danger btn-remove" href="javascript:void(0);" onclick="DeleteData({{ $results[$i]->MotherId}}, {{$results[$i]->hasBaby}})" title="Delete Record">
                                        <i class="fa fa-trash"></i> 
                                    </a>
                                </td>
                                @endif
                            </tr>
                            @endfor
                            @else
                            <tr>
                                <td colspan="10" style="text-align: center;" ><span> No Record Found </span></td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-12">
                          <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                              <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                {{ Lang::get('home.mother_showing') }} {{$pagination['limit'][0]}} {{ Lang::get('home.mother_to') }} {{$pagination['limit'][1]}} {{ Lang::get('home.mother_of') }} {{$pagination['total']}} {{ Lang::get('home.mother_entries') }} {{ @$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '' }}
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <div class="dataTables_paginate paging_bootstrap pagination_footer">
                            <ul class="pagination">    
                              <li class="prev @if(Request::query('page') == '' || Request::query('page') == $pagination['start']) disabled @endif">
                                <a class="@if(Request::query('page') != $pagination['start'] &&  Request::query('page') != '') sort_with_page @endif" href="@if(Request::query('page') == $pagination['start'] || Request::query('page') == '') javascript:void(0); @else {{ url('mother-registration?page='.$pagination['previous']) }}@endif">&#8592; {{ Lang::get('home.mother_previous') }}</a>
                            </li>
                            @for ($i = $pagination['start']; $i <= $pagination['end']; $i++) 
                            <li class="@if($i == Request::query('page')) active @elseif(Request::query('page') == '' && $i == $pagination['start']) active @endif">
                                <a class='sort_with_page' href="{{ url('mother-registration?page='.$i) }}">{{$i}}</a>
                            </li>  
                            @endfor
                            <li class="next @if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) disabled @endif">
                                <a class="@if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']) sort_with_page @endif" href="@if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']) javascript:void(0); @else {{ url('mother-registration?page='.$pagination['next']) }}@endif">{{ Lang::get('home.mother_next') }} &#8594; </a>  
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
<!-- DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK -->                    
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}                    
</div>
<!-- /.row -->
<!-- /Page Content -->
<div class="modal fade bs-example-modal-lg mother-list-modal modal-default" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close modal-close" data-dismiss="modal" aria-hidden="true" style="color:white">
                    <i class="fa fa-times"></i>
                </button>
                <h4 id="myModalLabel" class="modal-title color-white" style="display: contents;">Mother Details</h4>
            </div>                        
            <div class="modal-body">
                <div class="container-fluid pt-15">
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Name:</label>
                            <span class="col-name col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Partner Name:</label>
                            <span class="col-partnername col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Contact:</label>
                            <span class="col-mobile col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Partner Contact:</label>
                            <span class="col-partnercontact col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">DOB:</label>
                            <span class="col-dob"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Partner DOB:</label>
                            <span class="col-partnerdob col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Occupation:</label>
                            <span class="col-occupation col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Partner Occupation:</label>
                            <span class="col-partneroccupation col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Address 1:</label>
                            <span class="col-address1 col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">City:</label>
                            <span class="col-city col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Address2:</label>
                            <span class="col-address2 col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">State:</label>
                            <span class="col-state col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Address3:</label>
                            <span class="col-address3 col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Country:</label>
                            <span class="col-country col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Address4:</label>
                            <span class="col-address4 col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Email:</label>
                            <span class="col-email col-md-6"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Father Spoken Languages :</label>
                            <span class="col-fspoken col-md-6"></span>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <label class="col-md-6">Mother Spoken Languages:</label>
                            <span class="col-mspoken col-md-6"></span>
                        </div>
                    </div>
                   <!--  <div class="row">
                        <div class="col-md-6">
                            <label class="col-md-6">Landline:</label>
                            <span class="col-landline col-md-6"></span>
                        </div>
                    </div> -->
                    <div class="row mgplan modal-fixed">
                        <div class="modal-footer" >
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
    function ShowModal(id) {
        $("#basicModal").modal({
            backdrop: 'static',
            keyboard: false
        });
        $('#mother-'+id).css({'cursor' : 'not-allowed', 'pointer-events' : 'none', 'opacity' : 0.8});
        $.ajax({
           type    :"GET",
           url     :"{{ url('/get-data/')}}",
           data    :{ id:id },
           success :function(response){
            Datas = JSON.parse(response);
            $(".modal-title").html(Datas['MotherName']);
            $(".col-name").html(Datas['MotherName']);
            $(".col-partnername").html(Datas['PartnerName']);
            
            var email = Datas['Email'];
            if (email == '' || email == null) {
                email = Datas['MotherEmail'];
            }
            else if (Datas['MotherEmail'] != '' && Datas['MotherEmail'] != null) {
                email = Datas['Email'] + ', ' + Datas['MotherEmail']; 
            }
            
            $(".col-email").html(email);
            

            var mobile = Datas['Mobile'];
            if (mobile == '' || mobile == null) {
                mobile = Datas['LandLine'];
            }
            else if (Datas['LandLine'] != '' && Datas['LandLine'] != null) {
                mobile = Datas['Mobile'] + ', ' + Datas['LandLine']; 
            }
            $(".col-mobile").html(mobile);

            

            var partnercontact = Datas['PartnerContact'];
            if (partnercontact == '' || partnercontact == null) {
                partnercontact = Datas['PartnerMobile'];
            }
            else if (Datas['PartnerMobile'] != '' && Datas['PartnerMobile'] != null) {
                partnercontact = Datas['PartnerContact'] + ', ' + Datas['PartnerMobile']; 
            }


            $(".col-partnercontact").html(partnercontact);
            $(".col-city").html(Datas['Address3']);
            $(".col-address1").html(Datas['Address1']);
            $(".col-address2").html(Datas['Address2']);
            $(".col-address3").html(Datas['Address3']);
            $(".col-address4").html(Datas['Address4']);
            $(".col-country").html(Datas['Address5']);
            $(".col-partneroccupation").html(Datas['PartnerOccupation']);
            $(".col-partnerdob").html(Datas['PartnerDOB']);
            $(".col-dob").html(Datas['MotherDOB']);
            // $(".col-landline").html(Datas['LandLine']);
            $(".col-occupation").html(Datas['Occupation']);

            $(".col-fspoken").html(Datas['FatherSpokenLanguages']);
            $(".col-mspoken").html(Datas['MotherSpokenLanguages']);     
        },
        complete: function(){
            $('#basicModal').modal('show');
        }
    });
    }

    $('#basicModal').on('hidden.bs.modal', function () {
        $('.icon.btn.btn-info.btn-view').css({'cursor' : 'default', 'pointer-events' : 'auto', 'opacity' : 1});
    });
    function DeleteData(id, hasBaby) {

        if (hasBaby) {
         Showalert('warning','Access denied : This mother refered to a baby record !');
     } else {
        bootbox.confirm("Are you sure?",function(confirmed){
          if(confirmed){
            $("#DeleteForm").attr('action',"{{ action('Registration\MotherController@index') }}/"+id);
            $("#DeleteForm").submit();
        }
    });
    }
    
    
}

$( "#search" ).click(function() {
    $( "#search-form" ).submit();
});

$('.sorting_by').on('click', function(e) {
    e.preventDefault();
    var sortby       = $(this).data('field');
    pagination(sortby);
});

$('.sort_with_page').click(function(e){
    e.preventDefault();
    var sorting_param = $('#limit-form').serialize();
    var link      = $(this).attr('href');
    var searchText    = $('input[name="search_txt"]').val();
    window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
});

$('select[name="limit"]').on('change',function(e) {
    e.preventDefault();
    pagination();
});
function pagination(sortby) {
  var pagination_url = $('#limit-form').attr('action');
  var limit          = $('select[name="limit"] option:selected').val();
  var searchText     = $('input[name="search_txt"]').val();    
  var sorting_param  = $('#limit-form').serialize();
  var sorting_param1 = sorting_param.split('&sortorder=')[0];
  var sorting_param2 = sorting_param.split('&sortorder=')[1];
  if (sortby) {
    $('#sortby').val(sortby);
    if (sorting_param2 == 'desc') {
      var sortorder = 'asc';
      // $("[data-field='"+ sortby +"']").removeClass('sorting_icon');
      // $("[data-field='"+ sortby +"']").addClass('sorting_asc_icon');
      $('#sortorder').val(sortorder);
  } else {
      var sortorder = 'desc';
      // $("[data-field='"+ sortby +"']").removeClass('sorting_icon');
      // $("[data-field='"+ sortby +"']").addClass('sorting_desc_icon');
      $('#sortorder').val(sortorder);
  }
  window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
} else {
    window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
}

}

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
      placement : 'top'
  });
});

</script>
@endsection
