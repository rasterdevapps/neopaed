@extends('app')
@section('content')
<style type="text/css">
  .patient-search-table {
    overflow: auto;
  }
  .patient-search-table, .patient-search-table th, .patient-search-table td {
    border: 1px solid black;
  }
  .patient-search-table th {
    border-top: 0px;
  }
  .patient-search-table th:first-child, .patient-search-table td:first-child {
    border-left: 0px;
  }
  .patient-search-table th:last-child, .patient-search-table td:last-child {
    border-right: 0px;
  }
  .patient-search-table th, .patient-search-table td {
    padding: 10px;
    white-space: nowrap;
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
      <a title="Search Daycare" href="{{ action('Admission\DaycareController@index') }}">Daycare</a>
    </li>
    <li class="current">
      <a title="Search Daycare">Search </a>
    </li>
  </ul>
  <div class="pull-right">
    @if(isset($silabingsdays) && is_array($silabingsdays))
    <table class="table">
     <tr>
      <td> @if(isset($silabingsdays[0]) &&  !empty($silabingsdays[0]))<a class="forward-boot-class" href="{{ $silabingsdays[0] }}"><i class="fa fa-fast-backward  fa-2x" title="Previous Page" aria-hidden="true"></i></a>@endif </td>
      <td> @if(isset($silabingsdays[1]) &&  !empty($silabingsdays[1]))<a class="forward-boot-class"  href="{{ $silabingsdays[1] }}"><i class="fa fa-fast-forward  fa-2x" title="Next Page"  aria-hidden="true"></i></a>@endif</td>
    </tr>
  </table>  
  @endif    
</div>
<div class="pull-right reset-search">
  <table>
    <tr>
      @if(Session::has('dayIds'))
      <td class="p-10">No.Records : <span>{{ count(unserialize(Session::get('dayIds'))) }}</span></td>
      @endif
      @if(count($daycareList) > 0)
      <td><a class="btn btn-info btn-basic-shadow reset-btn2" href="{{ action('Search\SearchDaycareController@daycareSearchview', SiteHelpers::encrypt_id($current_id)) }}"> Search View </a></td>
      <td><a class="btn btn-info btn-basic-shadow reset-btn2" href="{{ action('Search\SearchDaycareController@create') }}"> Reset </a></td>
      <td><a class="btn btn-info btn-basic-shadow export reset-btn2" href="{{ url('daycare-search-export') }}"> Export </a></td>
      @endif

    </tr>
  </table>
</div>
</div>

<!-- /Breadcrumbs line -->


<div class="row">
  <div class="col-md-12 mt-10">
   
    <div class="col-md-9">
     {!! Form::select('field_visits',$daycareListheadings,0,['class'=>'select2 col-md-9','multiple'=>'true']) !!}
   </div>
 </div> 

 <div class="col-md-12 mt-10">   
  <!-- <div class=""> -->
    <div class="patient-search-table">
      <div  class="daycare-main-list special-search-table2 special-search-table"> 
       <table id="special-daycare-search">
        <thead>  
          <tr>
           @include('search.daycaresearch.searchlistheadings')  
         </tr>
       </thead>   
       <tbody>
         @include('search.daycaresearch.searchlist')
       </tbody> 
     </table>                                
   </div>
 </div>           
</div>   
<div class="col-md-12 pt-10">  
  <div class="col-md-9">
   <input type="hidden" value="{{ $daycareList->lastPage() }}" name="lastpage">
   <input type="hidden" value="{{ $daycareList->currentPage() }}" name="currentpage">
 </div>       
 <div class="col-md-3 pull-right text-right">
  <button class="btn btn-info load-more-records btn-basic-shadow"> More...</button>
</div> 
</div>

@php $daycare_list =  Config('exportfields.daycare'); asort($daycare_list); @endphp
<div class="modal fade" id="exportModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" class="close-font">&times;</span>
        </button>
        <h5 class="modal-title">
          <h3 class="text-center text-white">Choose Fields To Be Export</h3>
            </h5>
      </div>
      {!! Form::open(['url' => action('Search\SearchDaycareController@daycareListdownload'),'method' => 'post', 'id'=>'export-sheet']) !!}
      <div class="modal-body row">
        <div class="col-md-12">
          <div class="col-md-6">
           <div class="form-group">
             {!! Form::label('file_name','Save As Name') !!}
             {!! Form::text('file_name','daycare-search-list',['class'=>'form-control'] ) !!}
           </div>
         </div>
         <div class="col-md-6">
          <div class="form-group">
           {!! Form::label('file_format','Save As Format') !!}
           {!! Form::select('file_format',['xlsx'=>'xlsx','xlsm'=>'xlsm','csv'=>'csv'],null,['class'=>'form-control'] ) !!}
         </div>
       </div>
     </div> 
     {!! Form::hidden('daycare_export_list') !!}
     <div class="col-md-12 plr-30">
      <select multiple="multiple" size="10" id="daycare-options" name="daycare-options">
        @foreach( $daycare_list as $listkey => $listvalue)
        <option value="{{ $listkey }}">{{ $listvalue }}</option>
        @endforeach   
      </select>
    </div>
  </div>  
  <div class="modal-footer plr-20">
   <button type="button" class="btn btn-info pull-right btn-basic-shadow get-values">Export</button>
 </div>
 {!! Form::close(); !!}
</div>
</div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">

  
  $('.export').click(function(e) {
   e.preventDefault();           
   $('#exportModal').modal('show');

 });


  $(document).ready(function() {
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

    
        // var searchList = $('#special-daycare-search').dataTable({
        //                     // "sScrollY": "100%",
        //                     // "sScrollX": "100%",
        //                     // "sScrollXInner": "150%",
        //                     // "bScrollCollapse": true,
        //                      "bPaginate": false
        
        //                 });
       // new FixedColumns( searchList,{ leftColumns: 3 });


       $('.load-more-records').click(function() {

         if (parseInt($('input[name="currentpage"]').val()) == 1) {

          var page     = parseInt($('input[name="currentpage"]').val()) +1;
        } else {
          var page     = parseInt($('input[name="currentpage"]').val());
          
        }
        var lastpage = $('input[name="lastpage"]').val();


        if (lastpage >= page) {
         
          $.ajax({
            url:'{{ action("Search\SearchDaycareController@daycareListview",$current_id) }}',
            
            method:"GET",
            
            data:{page:page},
            
            dataType:'JSON',
            
            async: false,

            beforeSend:function(data){
              
              $('.load-more-records').html('More... <i class="fa fa-spinner fa-pulse fa-1x mirth-search-loading" aria-hidden="true"></i>');

            },
            success:function(data){
              $('input[name="currentpage"]').val(page+1);
              $('#special-daycare-search tbody').append(data.tableresultssecond);
                          // data.tableresultssecond = JSON.parse(data.tableresultssecond)
                          // searchList.fnAddData(data.tableresultssecond);
                          //   // searchList.fnDestroy();

                          //    console.log(searchList);
                                  //new FixedColumns( searchList,{ leftColumns: 3 });

                                  $('.load-more-records').html('More...');
                                },
                                complete:function(data){

                                 $('.load-more-records').html('More...');
                                 Showalert('success','Records Loaded...');

                               } 

                             });
        }else{

          Showalert('info','No more records found');
        }  


      });

     });

  
  $('.get-values').click(function(){

    var value_list = [];
    $('.dual-listbox__selected li').each(function(){
        value_list.push($(this).attr('data-id'));
    });
    
    var validate    =  false;

    $('.error-export').remove();
    
    $('input[name="daycare_export_list"]').val(JSON.stringify(value_list));

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



  $('input[name="list_filter"]').blur(function(){

    if($(this).val().length != 0){

     var tableHeader =  $(this).val();

     $('.special-search-table2 thead tr th').each(function(){


      if(tableHeader == $(this).text()){

        var verticalposition = $(this).position().left;


        currentTableposition = $('.special-search-table2 thead tr th').position().left;


        verticalposition  = (currentTableposition < 1) ? verticalposition - currentTableposition : verticalposition + currentTableposition ;
        

        $('.daycare-seach-sub-main').animate({

          scrollLeft: verticalposition

        }, 300);

      }


    });
     
   }else{

     $('.daycare-seach-sub-main').animate({

      scrollLeft: 0

    }, 300);
   }
 });
  
  $("select[name='field_visits']").change(function() {
    var unHide  = $(this).val();

    
    if(unHide != null) {

     $('.flex-filter').addClass('hide');
     $.each(unHide, function(index, value) {

      $('.'+value).removeClass('hide');

    });

   } else {

     $('.flex-filter').removeClass('hide');
   }
   
   
   

 });
  

  
</script>


@endsection

