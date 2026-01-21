@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
 <ul id="breadcrumbs" class="breadcrumb">
   <li><i class="icon-home"></i> <a href="{{ url('/') }}">Dashboard</a></li>
   <li><a href="{{ action('Masters\AdmissionmodeController@index') }}">Admission Mode</a></li>       
   <li class="current"><a>Create</a></li>                                                 
 </ul>

</div>
<!-- /Breadcrumbs line -->
<!-- Page Header -->
<!-- <div class="page-header"> -->
	<!-- </div> -->
	<!-- /Page Header -->
	<!--=== Page Content ===-->
	<div class="row row-spacing select-container-main">
		<div class="master-layout">
      {!! Form::open(['url' => action('Masters\AdmissionmodeController@store'),'id'=>'admission-mode']) !!}
      <div class="col-md-12 overflow-auto">
        <table class="master_admission_mode table table-add-more full-width-fi">
          <thead>
            <tr>
             <th>Mode Name</th>
             <th>Status</th>                    
             <th>
              <span>
                <a class="btn btn-success master_admission_add btn-view btn_add" href="javascript:void(0);"><i class="fa fa-plus"></i></a>
              </span>                
            </th>                                                
          </tr>
        </thead>
        <tbody>
          <tr data-len="0">
           <td>
            <input type="text" name="Mode_name[]" value="" class="form-control input-width-large input-fields-shadow name" />
          </td>
          <td>
           <select name="Status[]" class="form-control input-width-medium input-fields-shadow">
            <option value="1">Active</option>
            <option value="0">Inactive</option>                                             
          </select>
        </td>
        <td>
         <span class="fa fa-trash btn btn-danger btn-view remove"></span>
       </td>
     </tr>
   </tbody>
   <tfoot>
    <tr>
      <td colspan="4">
        <div class="master-btn-layout">
          <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium">
           <i class="fa fa-floppy-o"></i> Save
         </button>
         <a href="{{ action('Masters\AdmissionmodeController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();">
           <i class="fa fa-exclamation-circle"></i> 
           Cancel
         </a>
       </div>
     </td>
   </tr>
 </tfoot>
</table>  
</div>
{!! Form::close() !!}
@include('errors.list')
</div> <!-- /.col-md-12 -->

</div> <!-- /.row -->
<!-- /Page Content -->

@endsection
@section('scripts')

<script type="text/javascript">

// jQuery.validator.addMethod("allRequired", function(value, elem){
//         // Use the name to get all the inputs and verify them
//         var name = elem.name;
//         return  $('input[name="'+name+'"]').map(function(i,obj){return $(obj).val();}).get().every(function(v){ return v; });
// });


// $( "#admission-mode" ).validate({
//   rules: {
//     'Mode_name[]':'allRequired',
//     'Status[]':'allRequired',     
//   },
//  messages: {
//     'Mode_name[]': {
//       allRequired: "Please Enter Mode Name!",
//     },
//     'Status[]':{
//       required:"Please Choose Status!",
//     } 
//   },
//   errorPlacement: function(error, element) {
//     $('input[name="'+element.attr('name')+'"]').each(function(){
//          if($(this).val()==''){
//            error.insertAfter($(this));
//          }
//     });
//   },
//    debug:true,

// });


$(document).ready(function() {

  $('#admission-mode .btn.btn-primary').on('click', function(event) {

    $('#admission-mode input.name').each(function() {
      $(this).rules("add", {
        required: true
      });
    });

    if($('#admission-mode').validate().form()) {
        $(this).prop('disabled', true);

              $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
              $('#admission-mode').submit();
      return true;
    } else {
      return false;
    }
  });

  $('#admission-mode').validate();

});
</script>

@endsection




