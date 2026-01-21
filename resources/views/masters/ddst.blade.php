@extends('app')
@section('content')
<style type="text/css">
  @media screen and (max-width: 1024px) {
    .widget.box.table-view-shadow {
      display: inline-block;
    }
  }
</style>
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
  <ul id="breadcrumbs" class="breadcrumb">
    <li>
      <i class="icon-home"></i>
      <a href="{{ url('/') }}">Dashboard</a>
    </li>
    <li class="current">
      <a href="{{ action('Masters\DdstController@index') }}">DDST</a>
    </li>
  </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
  <div class="col-md-12">
    <div class="widget box table-view-shadow">
      <div class="widget-header">
        <h4>DDST
        </div>
        <div class="widget-content">
          <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
            <thead>
              <tr>
                <th class="hide">Id</th>
                <th>Task Id</th>
                <th class="">Name</th>
                <th class="">Percentage</th>
                <th class="">Move At</th>
                <th class="">Edit</th>
              </tr>
            </thead>
            <tbody>
              @if(count($results) > 0 )
              @foreach($results as $key => $value)
              <tr id="row-{{ $value->id }}">
                <td class="hide" id="ddst_id" data-type="text">{{ $value->id }}</td>
                <td>{{ $value->task_id }}</td>
                <td>{{ $value->name }}</td>
                <td id="percentage" data-type="text">{{ $value->percentage }}</td>
                <td id="percentage_align" data-type="radio">{{ $value->percentage_align ? 'Right' : 'Left' }}</td>
                <td class="center-align-phone">
                  <a class="btn btn-info btn-view ddst-edit" data-id="{{ $value->id }}" href="javascript:void(0);" title="Edit Record">
                    <i class="fa fa-edit"></i>
                  </a>
                </td>
              </tr>
              @endforeach
              @else
              <tr>
                <td colspan="5" class="text-center"><span> No Record Found </span></td>
              </tr>
              @endif
            </tbody>
          </table>
          <div class="row">
            <div class="col-md-12">
              <div class="dataTables_footer clearfix">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> <!-- /.col-md-12 -->
  </div> <!-- /.row -->
  <!-- /Page Content -->
  @endsection
  @section('scripts')
  <script type="text/javascript">
    $(document).on('click', '.ddst-edit', function() {
      var id = $(this).attr('data-id');
      $('#row-'+id+' td').each(function() {
        var type = $(this).attr('data-type');
        switch(type) {
          case 'text':
          var html_content = $(this).html();
          var field_name = $(this).attr('id');
          var field = '<input type="number" name="'+field_name+'" value="'+html_content+'" class="form-control" />';
          $(this).html(field);
          break;
          case 'radio':
          var html_content = $(this).html();
          var field_name = $(this).attr('id');
          var field = '<input type="radio" name="'+field_name+'" value="0" '+(html_content == "Left" ? "checked" : "")+' /> Left';
          field += '<br/>';
          field += '<input type="radio" name="'+field_name+'" value="1" '+(html_content == "Right" ? "checked" : "")+' /> Right';
          $(this).html(field);
          break;
        }
      });
      $('.ddst-edit').attr('disabled', true);
      $(this).removeClass('btn-info ddst-edit').addClass('btn-primary save-settings').attr('disabled', false).find('i').removeClass('fa-edit').addClass('fa-save');
    });
    $(document).on('click', '.save-settings', function() {
      var id = $(this).attr('data-id');
      var html_content = '';

      var id = $('#row-'+id+' input[name="ddst_id"]').val();
      var percentage = $('#row-'+id+' input[name="percentage"]').val();
      var percentage_align = $('#row-'+id+' input[name="percentage_align"]:checked').val();

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
          percentage: percentage,
          percentage_align: percentage_align,
        },
        type: 'PATCH',
        url: "{{ url('masters/ddst') }}" + '/' + id,
        success: function(response) {
          if (response.messageType == 'success') {
            $("#row-"+id+" #ddst_id").html(id);
            $("#row-"+id+" #percentage").html(percentage);
            percentage_align = percentage_align == 1 ? 'Right' : 'Left';
            $("#row-"+id+" #percentage_align").html(percentage_align);
            $("#row-"+id).find('.save-settings').removeClass('btn-primary save-settings').addClass('btn-info ddst-edit').find('i').removeClass('fa-save').addClass('fa-edit');
            $('.ddst-edit').attr('disabled', false);
          }
        },
        error: function(responseText) {}
      });
    });
  </script>
  @endsection
