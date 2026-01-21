@extends('app')
@section('content')
<?php 
$read_permissions = session('read_permission');
$write_permission = session('write_permission');
?>
<style type="text/css">
    table .btn-warning > i, table .btn-success > i, table .btn-danger::before {
    vertical-align: unset;
    }
</style>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="{{ url('/') }}">Dashboard</a>
        </li>
        <li>
            <a href="{{ action('Nurse\NurseSheetController@index') }}">Nurse Sheets</a>
        </li>
        <li class="current">
            <a href="javascript::void(0);">{{ isset($baby_details->BabyName) ? 'Admission History of ' : ''  }}<b class="color-black">{{ isset($baby_details->BabyName) ? $baby_details->BabyName.'-'.$baby_details->BMrNo : ''  }}</b></a>
        </li>
    </ul>
        <div class="pull-right">
            @php 
                $mrn = $baby_details->BMrNo; 

                echo \SiteHelpers::menuList($mrn, 0, 'nurse_sheet_day_list');
            @endphp
      </div>
    @php $closewinlink = isset($closewinlink) && !empty($closewinlink) ? $closewinlink : 'nicu-nurse-sheets'; @endphp
    {{ Form::hidden('closewinlink', @$closewinlink) }}
    {{ Form::hidden('baby_id', @$baby_details->BabyId) }}
    {{ Form::hidden('admission_id', @$admission_id) }}
    <a href="{{ url($closewinlink) }}" class="close-nav pull-right"><i class="fa fa-times"></i></a>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Nurse Hour Wise Daycare</h4>
                @php 
                    $pacs_link = \SiteHelpers::pacsViewerLink(); 
                    $pacs_link = str_replace('MRN', $mrn, $pacs_link);


                    $pacs_link = url('get-pacs-viewer').'/'.$mrn;
                @endphp

                <a href="{{$pacs_link}}" target="_blank" class="btn btn-default create-btn-spacing btn-basic-shadow pull-right btn-custom-pacs">
                <i class="fas fa-x-ray"></i>
                <span>PACS</span>
                </a>   
                @if(in_array('NICU_MODULE_SHEET',$write_permission))
                <a href="{{ action('Nurse\NurseSheetController@show',\SiteHelpers::encrypt_id($latest_admission_id.'-'.$baby_details->BabyId)) }}" title="Create New" class="btn  create-btn-spacing btn-basic-shadow btn-info pull-right"><i class="fa fa-plus "></i> <span>Create New</span></a>   
                @endif 
                <select class="admission-filter form-control input-width-medium pull-right m-5-must"></select> 
                <!-- <button class="btn btn-info pull-right m-5-must" id="export" data-bmrn-no="{{\SiteHelpers::encrypt_id($baby_details->BMrNo)}}" data-admission-id="{{\SiteHelpers::encrypt_id($latest_admission_id)}}">Export</button> -->
            </div>
            <div class="widget-content inherittable">
                <table class="table table-striped table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th>Days</th>
                            <th>Date</th>
                            <th class="center-align-phone">View / Print</th>
                            <th class="center-align-phone">Weekly Chart</th>
                            <th class="center-align-phone">Prescription</th>
                            <th class="center-align-phone">Graphical View</th>
                            <th class="center-align-phone">Lab Result</th>
                            <th>All-In-One chart</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($day_list) != 0)
                        @php  $i = count($day_list); @endphp
                        @foreach($day_list as $list)
                        <tr>
                            <td>
                                <a class="pull-left input-width-small @if(!in_array('NICU_MODULE_SHEET',$write_permission)) permission-denied @endif" href="@if(in_array('NICU_MODULE_SHEET',$write_permission)) {{ action('Nurse\NurseSheetController@edit',\SiteHelpers::encrypt_id($list->id))}} @endif">
                                Day {{ $i }}
                                </a>
                                <span class="pull-left">
                                    @if (isset($file_list[$list->id]))
                                        @foreach($file_list[$list->id] as $type => $count)
                                            @include('registration.media_list')
                                        @endforeach
                                    @endif
                                </span>
                            </td>
                            <td>{{  date('d-m-Y', strtotime($list->sheet_date)) }}</td>
                            <td class="center-align-phone">
                                <a class="btn btn-success btn-xs btn-custom" href="{{ action('Nurse\NurseSheetController@print',\SiteHelpers::encrypt_id($list->id)) }}/{{$closewinlink}}"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                            </td>
                            <td class="center-align-phone">
                                <a class="btn btn-danger btn-xs btn-custom" href="{{ url('nicu-nurse-sheets/get-weekly-observations/'.\SiteHelpers::encrypt_id($list->admission_id).'/'.date('d-m-Y', strtotime($list->sheet_date))) }}?closewinlink={{ $closewinlink }}"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                            </td>
                            <td class="center-align-phone">
                                @if (in_array('PRESCRIPTION',$write_permission))
                                <a class="btn btn-warning btn-xs btn-custom" href="{{ url('prescription/'.\SiteHelpers::encrypt_id($list->BabyId.'-'.$list->admission_id).'/').'/'.$closewinlink}}"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                                @else
                                <a class="btn btn-warning btn-xs btn-custom" href="{{ url('prescription-print/'.\SiteHelpers::encrypt_id($list->BabyId).'/'.\SiteHelpers::encrypt_id($list->admission_id).'/'.date('d-m-Y').'/'.$closewinlink) }}"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                                @endif
                            </td>
                            <td class="center-align-phone">
                                <a class="btn btn-info btn-xs btn-custom" href="{{ action('Nurse\NurseChartController@graphicalview',[\SiteHelpers::encrypt_id($list->BabyId), \SiteHelpers::encrypt_id($list->admission_id)]) }}?date={{ $list->sheet_date }}&closewinlink={{ $closewinlink }}"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View</span></a>
                            </td>
                            <td class="center-align-phone">
                                <a class="btn btn-primary btn-xs btn-custom" href="{{ url('lab-value-print')}}?mrn={{\SiteHelpers::encrypt_id($mrn)}}&closewinlink=nicu-nurse-sheet-day&closewinlink2={{ $closewinlink }}&admission_id={{$list->admission_id}}"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                            </td>
                            <td>
                                <a class="btn btn-secondary btn-xs btn-custom" href="{{ url('multiple-chart').'/'.\SiteHelpers::encrypt_id($list->BabyId).'/'.\SiteHelpers::encrypt_id($list->admission_id).'/'.$list->sheet_date.'/'.$closewinlink }}"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View</span></a>
                               <!--  <a class="btn btn-secondary btn-xs btn-custom" href="{{ url('live-chart') }}?baby_id={{SiteHelpers::encrypt_id($list->BabyId)}}&admission_id={{SiteHelpers::encrypt_id($list->admission_id)}}" id="live-chart">
                                <i class="fa fa-line-chart" aria-hidden="true"></i>
                                Live Chart
                                </a> -->
                            </td>
                        </tr>
                        @php $i--; @endphp
                        @endforeach
                        @else
                        <tr>
                            <td colspan="8" align="center">No Records Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->      
@endsection
@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
      var baby_id = $('input[name="baby_id"]').val();
      var admission_id = $('input[name="admission_id"]').val();
    
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: "{{ url('nicu-nurse-sheets/get-admission-list') }}/"+baby_id,
        success: function(response) {
          if (response.type == 'success') {
            var admission_list = response.admission_list;
            var option = '';
            $.each(admission_list, function(key, value) {
              if (value.AdmissionId == admission_id) {
                option += '<option value="'+value.AdmissionId+'" selected="selected">'+value.episodes+'</option>';
              } else {
                option += '<option value="'+value.AdmissionId+'">'+value.episodes+'</option>';
              }
            });
            $(".admission-filter").html(option);
            // $(".admission-filter option:last").attr("selected", "selected").trigger('change');
          }
        }
      });
    
      $('.admission-filter').trigger('change');
    
      $('.admission-filter').on('change', function() {
        var admission_id = $(this).val();
        var closewinlink = $('input[name="closewinlink"]').val();
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'GET',
          url: "{{ url('nicu-nurse-sheet-day') }}/"+admission_id+'/'+closewinlink,
          success: function(response) {
            if (response.type == 'success') {
              var day_list = [];
              var day_list_temp = response.day_list;
              var content_temp = '';
              var i = 1;
    
              $.each(day_list_temp, function(key, value) {
                day_list.push(value);
              });
    
              day_list.sort((a, b) => (a.sheet_date > b.sheet_date) ? 1 : -1);
    
              $.each(day_list, function(key, value) {
                var content = '';
                var sheetdate = value.sheet_date;
                var id = value.id;
                var admission_id = value.admission_id;
                var BabyId = value.BabyId
    
                var sheet_date = sheetdate.split('-');
                sheet_date = new Date(sheet_date[0], (sheet_date[1] - 1), sheet_date[2]);
    
                var sheet_day = (sheet_date.getDate() > 9) ? sheet_date.getDate() : '0' + sheet_date.getDate();
                var sheet_month = ((sheet_date.getMonth() + 1) > 9) ? (sheet_date.getMonth() + 1) : ('0' + (sheet_date.getMonth() + 1));
                var sheet_year = sheet_date.getFullYear();
    
                var sheet_date = sheet_day + '-' + sheet_month + '-' + sheet_year;
                
                var edit = "{{ url('nicu-nurse-sheets') }}/"+value.encrypted_id+"/edit";
                var nurse_sheet_print = "{{ url('nicu-nurse-sheet-print') }}/"+value.encrypted_id+"/"+closewinlink;
                var weekly_observartion_print = "{{ url('nicu-nurse-sheets/get-weekly-observations') }}/"+value.encrypted_admission_id+"/"+sheet_date+"?closewinlink="+closewinlink;
                var prescription = "{{ url('prescription') }}/"+value.encrypted_baby_admission_id+"/"+closewinlink;
                var graphical_view = "{{ url('nicu-nurse-sheet-graph') }}/"+value.encrypted_baby_id+"/"+value.encrypted_admission_id+"?date="+sheet_date+"&closewinlink="+closewinlink;
                var lab_print = "{{ url('lab-value-print')}}?mrn={{\SiteHelpers::encrypt_id($mrn)}}&closewinlink=nicu-nurse-sheet-day&closewinlink2="+closewinlink+'&admission_id='+admission_id;
                var all_in_one_chart = "{{ url('multiple-chart') }}/"+value.encrypted_baby_id+"/"+value.encrypted_admission_id+"/"+sheetdate+"/"+closewinlink;
    
                content += '<tr>';
                content += '<td>';
                content += '<a href="'+edit+'">';
                content += 'Day '+i;
                content += '</a>';
                content += '</td>';
                content += '<td>'+sheet_date+'</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-success btn-xs btn-custom" href="'+nurse_sheet_print+'"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-danger btn-xs btn-custom" href="'+weekly_observartion_print+'"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-warning btn-xs btn-custom" href="'+prescription+'"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-info btn-xs btn-custom" href="'+graphical_view+'"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm">View</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-primary btn-xs btn-custom" href="'+lab_print+'"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td>';
                content += '<a class="btn btn-secondary btn-xs btn-custom" href="'+all_in_one_chart+'"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm">View</span></a>';
                content += '</td>';
                content += '</tr>';
    
                content_temp = content + content_temp;
    
                i++;
              });
    
              if (content_temp == '') {
                content_temp = '<tr><td colspan="8" align="center">No Records Found</td></tr>';
              }
              $('table tbody').html(content_temp);

              var menu_list = response.menu_list;

              $('.nicu-ward-menu').parent().html(menu_list);

            }
          }
        });
    });
      $('#export').click(function() {
          var babyMrn = $(this).attr('data-bmrn-no');
          var admission = $(this).attr('data-admission-id');
          window.location = "{{ url('baby-data') }}" + '/' + babyMrn + '/' + admission;
      });
    });
</script>
@endsection
