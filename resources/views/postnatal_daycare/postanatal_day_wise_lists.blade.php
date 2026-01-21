@extends('app')
@section('content')
<?php $write_permission = session('write_permission');?>
<?php $delete_permission = session('delete_permission'); ?>
@php $hide=false ; @endphp
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
  <ul id="breadcrumbs" class="breadcrumb">
    <li>
      <i class="icon-home"></i>
      <a href="{{ url('/') }}">Dashboard</a>
    </li>
    <li>
      <a href="{{ action('Admission\PostnatalDaycareController@index') }}">Postnatal Daycare</a>
    </li>
    <li>
      <a href="{{ action('Admission\PostnatalDaycareController@postnatalSublist',SiteHelpers::encrypt_id($baby_id))}}"> Postnatal History of {{ $baby_name }}</a>
    </li>
    <li class="current">
      <a href="javascript:void(0);"> {{ $admission }}</a>
    </li>
  </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
  <div class="col-md-12">
    <div class="widget box table-view-shadow">
      <div class="widget-header">
        <h4>Postnatal Daycare</h4>
        @if(in_array('POST_DAY',$write_permission))
        <a href="{{ action('Admission\PostnatalDaycareController@show', SiteHelpers::encrypt_id($baby_details->NeonatalId.'-'.$baby_details->AdmissionId.'-'.$baby_details->BabyId)) }}" title="Create New" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right">
         <i class="fa fa-plus "></i>
         <span>Create New</span>
       </a>
       @endif
     </div>
     <div class="widget-content inherittable">
      <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
        <div>
          <table class="table table-striped table-bordered datatable table-responsive"  id="data-list">
            <thead>
              <tr>
                <th>S.No.</th>
                <th>Days</th>
                <th>Date</th>
                @if($hide==false)                   
                <th class="center-align-phone">Print</th>
                <th class="center-align-phone hide">Edited Print</th>
                @endif
        @if(in_array('POST_DAY',$delete_permission))
                <th class="center-align-phone">Delete</th>
       @endif
              </tr>
            </thead>



              <tbody>
                @php( $i =count($results) )
                @php( $j = 0 )
                @foreach($results as $res_key => $result)
                  <tr>
                <td>{{ ++$j }}</td>
                <td> 
                  <a class="icon @if(!in_array('POST_DAY',$write_permission)) permission-denied  @endif" href="@if(in_array('POST_DAY',$write_permission)) {{ action('Admission\PostnatalDaycareController@edit', SiteHelpers::encrypt_id($result->PDayId)) }} @else javascript:void(0); @endif">
                    Day {{ $i }} 
                  </a>
                </td>
                <td>{{  date('d-m-Y',strtotime($result->DayDate)) }}</td>
                @if($hide==false)
                <td  class="center-align-phone">
                  <a class="btn btn-warning btn-view" title="Generated Print" href="{{ action('Admission\PostnatalDaycareController@printData',SiteHelpers::encrypt_id($result->PDayId)) }}">
                    <i class="fa fa-print"></i> 
                  </a>
                </td>
                  @if(in_array('POST_DAY',$delete_permission))
                <td  class="center-align-phone">
                  <a class="btn btn-danger btn-view" href="javascript:void(0);" onclick="DeleteData({{ $result->PDayId }})">
                    <i class="fa fa-trash"></i> 
                  </a>
                </td>
                  @endif
                <td  class="center-align-phone hide">
                  @if ($result->edited)
                  <a class="btn btn-default btn-view open-doc-editor" title="Final Print" href="{{ action('Admission\PostnatalDaycareController@getAbbreviatedsummaryShow',$result->PDayId) }}">
                    <i class="fa fa-file-word-o"></i> 
                  </a>
                  @else
                  -
                  @endif
                </td>
                
                @endif

                @php( $i--)
                @endforeach
                </tbody>
            </table>

          
        </div>
        <div class="row">
         <div class="col-md-12">
         </div>
       </div>
     </div> <!-- /.col-md-12 -->
   </div> <!-- /.row -->
   <!-- /Page Content -->

<!--
  DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK
-->
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
@endsection
@section('scripts')
<script type="text/javascript">
  function ShowModal(id,url1){
    $.ajax({
      type    :"GET",
      url     : url1,
      data    :{ id:id },
      success :function(response){
        Datas = JSON.parse(response);
        EditLink = '';
        @if(in_array('POST_DAY',$write_permission))
        EditLink = '<a href="/postnatal-daycare/'+Datas['PDayId']+'/edit" class=""><i class="fa fa-pencil"></i></a>';
        @endif
        PrintLink = '<a href="/postnatal-daycare/'+Datas['PDayId']+'/printdata" class=""><i class="fa fa-print"></i></a>';
        $(".modal-title").html(Datas['BabyName']+' '+EditLink + ' '+PrintLink);

        $(".col-name").html(Datas['BabyName']);
        $(".col-bmrno").html(Datas['BMrNo']);
        $(".col-sex").html(Datas['Sex']);
        $(".col-birthweight").html(Datas['BirthWeight']);
        $(".col-dob").html(Datas['DOB']);

        $(".col-dayoflife").html(Datas['DayOfLife']);

        $(".col-date").html(Datas['DayDate']);
        $(".col-time").html(Datas['DayTime']);

        $(".col-currentprobs").html(Datas['CurrentProblems']);
        $(".col-previousprobs").html(Datas['PreviousProblems']);
        $(".col-background").html(Datas['Background']);

      },
      complete: function(){
        $('#basicModal').modal('show');
      }
    });
  }
  function DeleteData(id){
    bootbox.confirm("Are you sure?",function(confirmed){
      if(confirmed){
        $("#DeleteForm").attr('action',"{{ action('Admission\PostnatalDaycareController@index') }}/"+id);
        $("#DeleteForm").submit();
      }
    });
  }

  $('.sorting_by').click(function(e){
    e.preventDefault();
    $('#sortby').val($(this).data('field'));
    if($('#sortorder').val()=='desc'){
      $('#sortorder').val('asc');
    }else{
      $('#sortorder').val('desc');
    }
    $('#limit-form').submit();

  });

</script>
@endsection
