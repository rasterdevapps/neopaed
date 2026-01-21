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
      <a href="{{ action('LocalCodeGroupController@index') }}">Local Code Group</a>
    </li>
  </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
  <div class="col-md-12">
    <div class="widget box table-view-shadow">
      <div class="widget-header">
        <h4>Local Code Group
        </div>
        <div class="widget-content">
          <table class="table table-striped table-bordered table-responsive datatable dataTable"  id="data-list">
            <thead>
              <tr>
                <th class="hidden">Local Code Id</th>
                <th class="">Local Code</th>
                <th class="">Local Description</th>
                <th class="">Acronym</th>
                <th class="">Active Flag</th>
                <th class="">Observation Name</th>
                <th class="">Priority</th>
                <th class="">Color (Hex)</th>
                <th class="">Chart Status</th>
                <th class="">Interfacing Based Chart</th>
                <th class="">Manual Based Chart</th>
                <th class="">Chart Type</th>
                <th class="">Module Type</th>
                <th class="">Approval Paramater Order</th>
                <th class="">Edit</th>
              </tr>
            </thead>
            <tbody>
              @if(count($results) > 0 )
              @foreach($results as $key => $value)
              <tr id="row-{{ $value->id }}">
                <td class="hidden" id="local_code_id" data-type="text">{{ $value->id }}</td>
                <td id="local_code" data-type="text">{{  $value->local_code }}</td>
                <td id="local_description" data-type="text">{{  $value->local_description }}</td>
                <td id="acronym" data-type="text">{{  $value->acronym }}</td>
                <td id="active_flag" data-type="radio">{{  $value->active_flag }}</td>
                <td id="observation_name" data-type="text">{{  $value->observation_name }}</td>
                <td id="parameter_priority" data-type="text">{{  $value->parameter_priority }}</td>
                <td id="color_code" data-type="color" data-color="{{ $value->color_code }}"><span style="width: 50px; height: 5px; display: flex; margin: auto; padding: 12px 5px; background-color:{{ $value->color_code }};"><b class="hidden">{{ $value->color_code }}</b></span></td>
                <td id="chart_status" data-type="radio1">{{ $value->chart_status ? 'True' : 'False' }}</td>
                <td id="interfacing_chart" data-type="radio1">{{ $value->interfacing_chart ? 'True' : 'False' }}</td>
                <td id="manual_chart" data-type="radio1">{{ $value->manual_chart ? 'True' : 'False' }}</td>
                <td id="chart_type" data-type="radio2">{{ $value->chart_type ? 'Box' : 'Dot' }}</td>
                <td id="module_type" data-type="text">{{ $value->module_type }}</td>
                <td id="approval_parameter_priority" data-type="text">{{ $value->approval_parameter_priority }}</td>
                <td class="center-align-phone">
                  <a class="btn btn-info btn-view local-code-edit" data-id="{{ $value->id }}" href="javascript:void(0);" title="Edit Record">
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
    $(document).on('click', '.local-code-edit', function() {
      var id = $(this).attr('data-id');
      $('#row-'+id+' td').each(function() {
        var type = $(this).attr('data-type');
        switch(type) {
          case 'text':
          var html_content = $(this).html();
          var field_name = $(this).attr('id');
          var field = '<input type="text" name="'+field_name+'" value="'+html_content+'" class="form-control" />';
          $(this).html(field);
          break;
          case 'radio':
          var html_content = $(this).html();
          var field_name = $(this).attr('id');
          var field = '<input type="radio" name="'+field_name+'" value="Y" '+(html_content == "Y" ? "checked" : "")+' /> Yes';
          field += '<br/>';
          field += '<input type="radio" name="'+field_name+'" value="N" '+(html_content == "N" ? "checked" : "")+' /> No';
          $(this).html(field);
          break;
          case 'radio1':
          var html_content = $(this).html();
          var field_name = $(this).attr('id');
          var field = '<input type="radio" name="'+field_name+'" value="True" '+(html_content == "True" ? "checked" : "")+' /> Yes';
          field += '<br/>';
          field += '<input type="radio" name="'+field_name+'" value="False" '+(html_content == "False" ? "checked" : "")+' /> No';
          $(this).html(field);
          break;
          case 'radio2':
          var html_content = $(this).html();
          var field_name = $(this).attr('id');
          var field = '<input type="radio" name="'+field_name+'" value="Box" '+(html_content == "Box" ? "checked" : "")+' /> Box';
          field += '<br/>';
          field += '<input type="radio" name="'+field_name+'" value="Dot" '+(html_content == "Dot" ? "checked" : "")+' /> Dot';
          $(this).html(field);
          break;
          case 'color':
          var html_content = $(this).attr('data-color');
          var field_name = $(this).attr('id');
          var field = '<input type="text" name="'+field_name+'" value="'+html_content+'" class="form-control" />';
          $(this).html(field);
          break;
        }
      });
      $('.local-code-edit').attr('disabled', true);
      $(this).removeClass('btn-info local-code-edit').addClass('btn-primary save-local-code').attr('disabled', false).find('i').removeClass('fa-edit').addClass('fa-save');
    });
    $(document).on('click', '.save-local-code', function() {
      var id = $(this).attr('data-id');
      var html_content = '';

      var id = $('#row-'+id+' input[name="local_code_id"]').val();
      var local_code = $('#row-'+id+' input[name="local_code"]').val();
      var local_description = $('#row-'+id+' input[name="local_description"]').val();
      var active_flag = $('#row-'+id+' input[name="active_flag"]:checked').val();
      var observation_name = $('#row-'+id+' input[name="observation_name"]').val();
      var parameter_priority = $('#row-'+id+' input[name="parameter_priority"]').val();
      var color_code = $('#row-'+id+' input[name="color_code"]').val();
      var acronym = $('#row-'+id+' input[name="acronym"]').val();
      var chart_status = $('#row-'+id+' input[name="chart_status"]:checked').val();
      var interfacing_chart = $('#row-'+id+' input[name="interfacing_chart"]:checked').val();
      var manual_chart = $('#row-'+id+' input[name="manual_chart"]:checked').val();
      var chart_type = $('#row-'+id+' input[name="chart_type"]:checked').val();
      var module_type = $('#row-'+id+' input[name="module_type"]').val();

      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
          id: id,
          local_code: local_code,
          local_description: local_description,
          active_flag: active_flag,
          observation_name: observation_name,
          acronym: acronym,
          parameter_priority: parameter_priority,
          color_code: color_code,
          chart_status: chart_status,
          interfacing_chart: interfacing_chart,
          manual_chart: manual_chart,
          chart_type: chart_type,
          module_type: module_type,
        },
        type: 'PATCH',
        url: "{{ url('local-code-group') }}" + '/' + id,
        success: function(response) {
          if (response.messageType == 'success') {
            $("#row-"+id+" #local_code_id").html(id);
            $("#row-"+id+" #local_code").html(local_code);
            $("#row-"+id+" #local_description").html(local_description);
            $("#row-"+id+" #active_flag").html(active_flag);
            $("#row-"+id+" #observation_name").html(observation_name);
            $("#row-"+id+" #acronym").html(acronym);
            $("#row-"+id+" #parameter_priority").html(parameter_priority);
            $("#row-"+id+" #color_code").html('<span style="width: 50px; height: 5px; display: flex; margin: auto; padding: 12px 5px; background-color: '+color_code+'"></span>');
	    $("#row-"+id+" #chart_status").html(chart_status);
            $("#row-"+id+" #interfacing_chart").html(interfacing_chart);
            $("#row-"+id+" #manual_chart").html(manual_chart);
            $("#row-"+id+" #chart_type").html(chart_type);
            $("#row-"+id+" #module_type").html(module_type);
            $("#row-"+id).find('.save-local-code').removeClass('btn-primary save-local-code').addClass('btn-info local-code-edit').find('i').removeClass('fa-save').addClass('fa-edit');
            $('.local-code-edit').attr('disabled', false);
          }
        },
        error: function(responseText) {}
      });
    });
  </script>
  @endsection
