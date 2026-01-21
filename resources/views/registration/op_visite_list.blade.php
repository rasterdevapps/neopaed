@extends('app')
@section('content')
<?php
$write_permission = session('write_permission');
$delete_permission = session('delete_permission');
?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Registration\OpController@index') }}">OP Registration</a></li>
        <li class="current"><a href="javascript:void(0);">History of <span class="text-captialize">{{ $baby_name }}</span></a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>OP Registration</h4>
                @if(in_array('OP_REG',$write_permission))
                    <a href="{{ action('Registration\OpController@chooseBaby') }}" title="" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right"><i class="fa fa-plus "></i> <span>Create New</span></a>
                @endif
                @if(in_array('LABREQUEST',$write_permission))
                    <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $baby_mrn).'?closewinlink=neonatal-op-visit-list' }}" class="btn btn-primary create-btn-spacing mr-15 pull-right">
                        <i class="fa fa-print"></i>
                        <span>Lab Report</span>
                    </a>
                @endif
                @php
                    $pacs_link = \SiteHelpers::pacsViewerLink();
                    $pacs_link = str_replace('MRN', $baby_mrn, $pacs_link);
                @endphp
                <a href="{{$pacs_link}}" target="_blank" class="btn btn-default create-btn-spacing btn-basic-shadow pull-right btn-custom-pacs">
                    <i class="fas fa-x-ray"></i>
                    <span>PACS</span>
                </a>
            </div>
            <div class="widget-content inherittable">
                <table class="table table-striped table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th class="hidden">No.</th>
                            <th>Visits</th>
                            <th data-hide="phone,tablet">{{ Lang::get('home.ip') }}</th>
                            <th data-hide="phone,tablet">Op Date</th>
                            <th class="center-align-phone">Neonatal OP Print</th>
                            @if(in_array('OP_REG',$delete_permission))
                                <th class="center-align-phone">Delete</th>
                            @endif
                            <th class="center-align-phone">Neuro OP Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 0;
                            $total_count = $visite_list['count'];
                        @endphp
                        @foreach($visite_list['lists'] as $key => $value)
                            @php
                                $neonatal_list = isset($value['neonatal']) ? $value['neonatal'] : [];
                                $neuro_list = isset($value['neuro']) ? $value['neuro'] : [];

                                $neonatal_count = count($neonatal_list);
                                $neuro_count = count($neuro_list);
                                $count = $neuro_count > $neonatal_count ? $neuro_count : $neonatal_count;
                            @endphp
                            @for($k = 0; $k < $count; $k++)
                                <tr>
                                    @php
                                        unset($neonatal_op_visit);
                                        unset($neuro_op_visit);
                                    @endphp
                                    @if (isset($neonatal_list[$k]))
                                        @php
                                            $neonatal_op_visit = (object)$neonatal_list[$k];
                                        @endphp
                                    @endif
                                    @if (isset($neuro_list[$k]))
                                        @php
                                            $neuro_op_visit = (object)$neuro_list[$k];
                                        @endphp
                                    @endif
                                    @if (isset($neonatal_op_visit))
                                        <td class="text-left">
                                            <a class="pull-left input-width-small icon  @if(!in_array('OP_REG',$write_permission)) permission-denied @endif" href="@if(in_array('OP_REG',$write_permission)) {{ action('Registration\OpController@edit', SiteHelpers::encrypt_id($neonatal_op_visit->OpId)) }} @else javascript:void(0); @endif">
                                                @php
                                                $visit_count = $total_count - $i;
                                                @endphp
                                                @if (strlen($visit_count) == 1)
                                                Visit-00{{ $visit_count }}
                                                @elseif (strlen($visit_count) == 2)
                                                Visit-0{{ $visit_count }}
                                                @endif
                                            </a>
                                            <span class="pull-left">
                                                @if (isset($file_list[$neonatal_op_visit->OpId]))
                                                @foreach($file_list[$neonatal_op_visit->OpId] as $type => $count)
                                                @include('registration.media_list')
                                                @endforeach
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $neonatal_op_visit->visit_number }}</td>
                                        <td>{{ date('d-m-Y',strtotime($neonatal_op_visit->visit_date)) }}</td>
                                        <td class="center-align-phone">
                                            <a class="btn btn-warning btn-view" href="{{ action('Registration\OpController@show', SiteHelpers::encrypt_id($neonatal_op_visit->OpId)) }}" title="Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                        @if(in_array('OP_REG',$delete_permission))
                                            <td  class="center-align-phone">
                                                <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData({{ $neonatal_op_visit->OpId}})">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                            </td>
                                        @endif
                                        @if (isset($neuro_op_visit))
                                        <td  class="center-align-phone {{!isset($neonatal_op_visit) ? 'neuro-op-color' : ''}}">
                                            <a class="btn btn-warning btn-view" href="{{ action('Registration\NeuroController@show', SiteHelpers::encrypt_id($neuro_op_visit->id)).'?closewinlink=neonatal-op-list-view' }}" title="Final Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                        @else
                                        <td>-</td>
                                        @endif
                                    @elseif (isset($neuro_op_visit))
                                        <td class="text-left neuro-op-color">
                                            <span class="pull-left input-width-small icon">
                                                @php
                                                $visit_count = $total_count - $i;
                                                @endphp
                                                @if (strlen($visit_count) == 1)
                                                Visit-00{{ $visit_count }}
                                                @elseif (strlen($visit_count) == 2)
                                                Visit-0{{ $visit_count }}
                                                @endif
                                            </span>
                                        </td>
                                        <td class="neuro-op-color">{{ $neuro_op_visit->visit_number }}</td>
                                        <td class="neuro-op-color">{{ date('d-m-Y',strtotime($neuro_op_visit->visit_date)) }}</td>
                                        <td class="neuro-op-color">-</td>
                                        <td class="neuro-op-color">-</td>
                                        <td  class="center-align-phone {{!isset($neonatal_op_visit) ? 'neuro-op-color' : ''}}">
                                            <a class="btn btn-warning btn-view" href="{{ action('Registration\NeuroController@show', SiteHelpers::encrypt_id($neuro_op_visit->id)).'?closewinlink=neonatal-op-list-view' }}" title="Final Print">
                                                <i class="fa fa-print"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                                @php  $i++; @endphp
                            @endfor
                        @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- /.col-md-12 -->
<!-- DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK -->
{!! Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']) !!}
{!! Form::close() !!}
</div>

<!-- /.row -->
<!-- /Page Content -->

@endsection
@section('scripts')
<script type="text/javascript">

    function DeleteData(id){
       bootbox.confirm("Are you sure?",function(confirmed){
          if(confirmed){
             $("#DeleteForm").attr('action',"{{ action('Registration\OpController@index') }}/"+id);
             $("#DeleteForm").submit();
         }
     });
   }
</script>
@endsection
