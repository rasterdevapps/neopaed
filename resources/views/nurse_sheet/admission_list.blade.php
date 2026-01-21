@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
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
      <a href="javascript::void(0);">{{ isset($baby_details->BabyName) ? 'Admission History of ' : ''  }}<b class="color-black text-captialize">{{ isset($baby_details->BabyName) ? $baby_details->BabyName.'-'.$baby_details->BMrNo : ''  }}</b></a>
    </li>                                             
  </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
  <div class="col-md-12">
    <div class="widget box table-view-shadow">
      <div class="widget-header">
        <h4>Nurse Daycare Admission History</h4>
        @if(in_array('NICU_MODULE_SHEET',$write_permission))
          <a href="{{ action('Nurse\NurseSheetController@create') }}" title="Create New" class="btn  create-btn-spacing btn-basic-shadow btn-info pull-right"><i class="fa fa-plus "></i> <span>Create New</span></a>   
        @endif  
                                      
      </div>
      <div class="widget-content inherittable">                    
        <table class="table table-striped table-bordered table-responsive datatable dataTable table-hover"  id="data-list">
          <thead>
            <tr>
              <th>Admission</th>
              <th>{{ Lang::get('home.ip') }}</th>
              <th>Date of Admission</th>
              <th>Date of Discharge</th>
            </tr>
          </thead>
          <tbody>
            
  @php $closewinlink = 'nicu-nurse-sheets'; @endphp
          @foreach($admission_list as $list)
            <tr class="row-clickable" data-href="{{ url('nicu-nurse-sheet-day/'.SiteHelpers::encrypt_id($list->AdmissionId).'/'.$closewinlink)}}">
              <td>
                <a href="{{ url('nicu-nurse-sheet-day/'.SiteHelpers::encrypt_id($list->AdmissionId).'/'.$closewinlink)}}">
                  {{  $list->episodes }}
                </a>
              </td>
              <td>{{  $list->ip_number }}</td>
              <td>{{  date('d-m-Y',strtotime($list->AdmissionDate)) }}</td>
              @if(isset($list->DischargeDate) && !is_null($list->DischargeDate)) 
              <td>{{  date('d-m-Y',strtotime($list->DischargeDate)) }}</td>
               @else
               <td></td>
              @endif
             

            </tr>
          @endforeach
          </tbody>
        </table>   
      </div>
    </div>
  </div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
        <!-- /Page Content -->      
         <script type="text/javascript">
          $(document).on('click', '.row-clickable', function()
          {
              window.location = $(this).data("href");
          });
        </script>
@endsection
