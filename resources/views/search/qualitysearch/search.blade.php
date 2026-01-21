@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
		<li><a href="{{ action('Quality\QualityController@index') }}"> Quality Indicator</a></li>
    <li class="current"><a>Create Baby</a></li>                                                
  </ul>
  <div class="pull-right">
    @if(isset($silabingsdays) && is_array($silabingsdays))
    <table class="table">
      <tr>
        <td> @if(isset($silabingsdays['first']) &&  !empty($silabingsdays['first']))<a class="forward-boot-class" href="{{ $silabingsdays['first'] }}"><i class="fa fa-fast-backward fa-2x" title="Previous Page" aria-hidden="true"></i></a>@endif </td>
        <td> @if(isset($silabingsdays[0]) &&  !empty($silabingsdays[0]))<a class="forward-boot-class"  href="{{ $silabingsdays[0] }}"><i class="fa fa-backward fa-2x" title="Previous Page"  aria-hidden="true"></i></a>@endif</td>
        <td> @if(isset($silabingsdays[1]) &&  !empty($silabingsdays[1]))<a class="forward-boot-class" href="{{ $silabingsdays[1] }}"><i class="fa fa-forward fa-2x" title="Next Page" aria-hidden="true"></i></a>@endif </td>
        <td> @if(isset($silabingsdays['last']) &&  !empty($silabingsdays['last']))<a class="forward-boot-class"  href="{{ $silabingsdays['last'] }}"><i class="fa fa-fast-forward fa-2x" title="Next Page"  aria-hidden="true"></i></a>@endif</td>
      </tr>
    </table>
    @endif    
  </div>
  <div class="pull-right">
    <table class="mt-5">
      <tr>
      <!--   @if(Session::has('record'))
        <td class="no-record plr-10">Record : {{ Session::get('record') }}</td>
        @endif -->
        @if(Session::has('quality_count'))
        <td class="no-record plr-10">No.Record : {{ Session::get('quality_count') }}</td>
        @endif
        @if(count($baby) == 1)
        <td><a class="btn btn-info btn-basic-shadow mlr-10" href="{{ action('Search\SearchQualityController@create') }}"> Reset </a></td>
        <td><a class="btn btn-info btn-basic-shadow export" href="{{ url('daycare-search-export') }}"> Export </a></td>
        @endif
      </tr>
    </table>
  </div>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row mt-10 col-md-9 col-sm-9 col-xs-9 plr-0 quality row-spacing">
	<div class="col-md-12 col-sm-12 col-xs-12 pr-0">


   {!! Form::model(@$baby,['method' => 'GET','action' => 'Search\SearchQualityController@index']) !!}
   <div role="tabpanel" class="tabbable tabbable-custom">
    <ul class="nav nav-tabs" role="tablist">
      <li role="presentation" class="active">
       <a href="#form-1" role="tab" data-toggle="tab">Form 1</a>
     </li>
     <li role="presentation">
      <a href="#form-2" role="tab" data-toggle="tab">Form 2</a>
    </li>
    <li role="presentation">
      <a href="#form-3" role="tab" data-toggle="tab">Form 3</a>
    </li>
  </ul>  
  <div class="tab-content tab-view-shadow">
    <div role="tabpanel" class="tab-pane active" id="form-1">
      @include('search.qualitysearch.quality_first_search')
    </div>
    <div role="tabpanel" class="tab-pane" id="form-2">
     @include('search.qualitysearch.quality_secound_search')
   </div>
   <div role="tabpanel" class="tab-pane" id="form-3">
     @include('search.qualitysearch.quality_thrid_search')
   </div>
   <div class="col-md-12 pt-10"> 
    @if(count($baby) == 0) 
    <div class="col-md-4 pt-10">
     <button type="submit"  class="btn btn-info btn-shadow form-control">
      <i class="fa fa-floppy-o"> Search</i>
    </button>
  </div>
  @endif
  <div class="col-md-4 pt-10">
   <a  type="button" href="{{ action('Quality\QualityController@index') }}" class="btn btn-warning btn-shadow form-control"><i class="fa fa-exclamation-circle"> Cancel</i></a>
 </div>
</div>  
</div> 


{!! Form::close(); !!}             	

</div> <!-- /.col-md-12 -->



</div> <!-- /.row -->
</div>
<div class="col-md-3 col-sm-3 col-xs-3 custom-fields-search-list-sidebar" style="margin-left: 0px; left: 50px;">
  <table class="table table-striped table-bordered  table-responsive"  id="data-list">
    <thead>
      <tr class="hide">
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {{--*/ $babyList = (Session::has('babyList')) ? Session::get('babyList') : array(); /*--}}
      @if(Session::has('babyList') && count(Session::get('babyList')) > 0)
      @foreach(Session::get('babyList') as $quality_key => $quality_details)
      <tr>
        <td>
          <div class="fields-search-list baby-admission-list @if(Request::segment(2) == $quality_details['id']) search-list-active @endif"" >
            <a href="{{ action('Search\SearchQualityController@qualitysearchview',$quality_details['id']) }}">
              {{ $quality_details['baby_name'] }}  
            </a>
          </div>
        </td>
      </tr>
      @endforeach
    </div>
    @else
    <tr>
      <td>
        <div class="text-center">No Records Found </div>  
      </td>
    </tr>
    @endif     
  </tbody>
</table>

<?php 
if (Session::has('babyList')) {
  $getTotal = count(\Session::get('babyList'));
  $total = \Session::get('quality_count');
  $page = \Session::get('qualitycurrentpage');
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
}
$page = isset($page) ? $page : 1;
?>
<div class="dataTables_footer clearfix">
  <div class="col-md-12 col-sm-12 col-xs-12 pagination-xs">
    <div class="dataTables_paginate paging_bootstrap pagination_footer">
      <ul class="pagination">
        <li class="prev @if($page == '' || $page == @$pagination['start']) disabled @endif">
          <a class="@if($page != @$pagination['start'] &&  $page != '') sort_with_page @endif" href="@if($page == @$pagination['start'] || $page == '') javascript:void(0); @else {{url('quality-indicator-search?page='.@$pagination['previous'])}}@endif">&#8592; {{ Lang::get('home.neonatal_previous') }}</a>
        </li>
        @if (@$getTotal > 0)
        @for ($i = @$pagination['start']; $i <= @$pagination['end']; $i++) 
        <li class="@if($i == $page) active @elseif($page == '' && $i == @$pagination['start']) active @endif">
          <a class='sort_with_page' href="{{url('quality-indicator-search?page='.$i)}}">{{$i}}</a>
        </li>
        @endfor
        @endif
        <li class="next @if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) disabled @endif">
          <a class="@if($page != @$pagination['end'] && @$pagination['start'] != @$pagination['end']) sort_with_page @endif" href="@if($page == @$pagination['end'] || @$pagination['total'] <= @$pagination['limits']) javascript:void(0); @else {{url('quality-indicator-search?page='.@$pagination['next'])}}@endif">{{ Lang::get('home.neonatal_next') }} → </a>  
        </li>
      </ul>
    </div>
  </div>
</div>

</div>  

@php $quality_list =  Config('exportfields.quality_export'); @endphp
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
        {!! Form::open(['url' => action('Search\SearchQualityController@qualityListdownload'),'method' => 'post', 'id'=>'export-sheet']) !!}
        <div class="col-md-12">
          <div class="col-md-6">
           <div class="form-group">
             {!! Form::label('file_name','Save As Name') !!}
             {!! Form::text('file_name','quality-search-list',['class'=>'form-control'] ) !!}
           </div>
         </div>
         <div class="col-md-6">
          <div class="form-group">
           {!! Form::label('file_format','Save As Format') !!}
           {!! Form::select('file_format',['xlsx'=>'xlsx','xlsm'=>'xlsm','csv'=>'csv'],null,['class'=>'form-control'] ) !!}
         </div>
       </div>
     </div> 
     {!! Form::hidden('quality_export_list') !!}
     <div class="col-md-12 plr-30">
      <select multiple="multiple" size="10" id="daycare-options" name="daycare-options">
        @foreach( $quality_list as $listkey => $listvalue)
        <option value="{{ $listkey }}">{{ $listvalue }}</option>
        @endforeach   
      </select>
    </div>
    {!! Form::close(); !!}
  </div>  
  <div class="modal-footer">
    <button type="submit" class="btn btn-info btn-basic-shadow pull-right get-values">Export</button>
  </div>
</div>
</div>
</div>

<!-- /Page Content -->     
@endsection
@section('scripts')
<script type="text/javascript">
 //export option

 $('.export').click(function(e){
  e.preventDefault();           
  $('#exportModal').modal('show');
});
 $(document).ready(function(){
  new DualListbox("#daycare-options", {
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
 $('.get-values').click(function() {
        var value_list = [];
        $('.dual-listbox__selected li').each(function(){
            value_list.push($(this).attr('data-id'));
        });
  var validate    =  false;
  $('.error-export').remove();
  $('input[name="quality_export_list"]').val(JSON.stringify(value_list));
  if ($('input[name="file_name"]').val() == '') {
   validate = true;
   $('input[name="file_name"]').after('<span class="error-export"> This fields required</span>');
 } 
        if (value_list.length == 0) {
   validate = true;
   $('select[name="daycare-options_helper2"]').after('<span class="error-export"> Please Choose The Fields required</span>');
 }
 if (!validate) {
   $('#export-sheet').submit();
   $('#exportModal').modal('hide');
 }
});
    //export option


    $(".submitbtn").click(function(){
      selectval = $("#BabyId option:selected").val();
      window.location = $(".cancel-btn").attr('href')+'/'+selectval;	

    });
    function update() {

      var currentMenu = $('.nav.nav-tabs  .active').children('li').children('a').attr('href');

      if(currentMenu == '#form-3') {

        $('#save_flag').val('1');
        $('#nurse-form').submit();

      } else {

        $('#save_next').val($('.nav.nav-tabs  .active').next('li').children('a').attr('href'));
        $('#save_flag').val('0');
        $('#nurse-form').submit();
      }
    }

    $('.nav.nav-tabs li a').click(function() {

     if ($(this).attr('href') == '#form-3') {

      $('.save-next').text('Finish');

    } else {
     $('.save-next').text('Save Next');
   }

 });

 //hanldeRecorder();
 $('.container').addClass('advance-search');
 $('#container').addClass('advance-search');

</script>
@endsection





