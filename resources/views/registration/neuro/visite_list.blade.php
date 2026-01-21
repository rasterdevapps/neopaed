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
        <li><a href="{{ action('Registration\NeuroController@index') }}">Neuro Development</a></li>
        <li class="current"><a href="javascript:void(0);">History of <span class="text-captialize">{{ $baby_name }}</span></a></li>                                                 
    </ul>                   
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
           <div class="widget-header">
            <h4>Neuro Devolpement</h4>
            @if(in_array('NEURO_DEVELOPMENT',$write_permission))
                <a href="{{ action('Registration\NeuroController@create').'/'.SiteHelpers::encrypt_id($baby_id) }}" title="Create New" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right create-btn">
                    <i class="fa fa-plus"></i>
                    <span>Create New</span>
                </a>  
            @endif 
            @if(in_array('LABREQUEST',$write_permission))   
                <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $baby_mrn).'?closewinlink=neuro-visit-list' }}" class="btn btn-primary create-btn-spacing mr-15 pull-right">
                    <i class="fa fa-print"></i>
                    <span>Lab Report</span>
                </a> 
            @endif                                  
        </div>
        <div class="widget-content inherittable">
            <table class="table table-striped table-bordered table-responsive"  id="data-list">
                <thead>
                    <tr>
                        <th class="vertical-align-center" rowspan="2">Visits</th>
                        <th class="vertical-align-center" rowspan="2" data-hide="phone,tablet">{{ Lang::get('home.ip') }}</th>
                        <th class="vertical-align-center" rowspan="2" data-hide="phone,tablet">Op Date</th>
                        <th class="center-align-phone">Neuro OP Print</th>   
                        <th class="center-align-phone">Assessment Print</th>   
                        @if(in_array('NEURO_DEVELOPMENT',$delete_permission))
                            <th class="center-align-phone">Delete</th>                                                    
                        @endif
                        <th class="center-align-phone">Neonatal OP Print</th>                                                    
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
                            @if (isset($neuro_op_visit))     
                                <td class="text-left">
                                    <a class="pull-left input-width-small @if(!in_array('NEURO_DEVELOPMENT',$write_permission)) permission-denied @endif" href="@if(in_array('NEURO_DEVELOPMENT',$write_permission)) {{ action('Registration\NeuroController@edit', SiteHelpers::encrypt_id($neuro_op_visit->id)) }} @else javascript:void(0); @endif">
                                        @php $visit_count = $total_count - $i; @endphp
                                        @if (strlen($visit_count) == 1)
                                            Visit-00{{ $visit_count }}
                                        @elseif (strlen($visit_count) == 2)
                                            Visit-0{{ $visit_count }}
                                        @endif
                                    </a> 
                                    <span class="pull-left">
                                        @if (isset($file_list[$neuro_op_visit->id]))
                                        @foreach($file_list[$neuro_op_visit->id] as $type => $count)
                                        @include('registration.media_list')
                                        @endforeach
                                       @endif
                                    </span>
                                </td>
                                <td>{{ $neuro_op_visit->visit_number }}</td>  
                                <td>{{ date('d-m-Y',strtotime($neuro_op_visit->visit_date)) }}</td>  
                                <td class="center-align-phone">
                                    <a class="btn btn-warning btn-view" href="{{ action('Registration\NeuroController@show', SiteHelpers::encrypt_id($neuro_op_visit->id)).'?closewinlink=list-view' }}" title="Final Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td> 
                                <td class="center-align-phone">
                                    <a class="btn btn-warning btn-view" href="{{ action('Registration\NeuroController@assessmentprint', SiteHelpers::encrypt_id($neuro_op_visit->id)).'?closewinlink=list-view' }}" title="Final Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td>
                                @if(in_array('NEURO_DEVELOPMENT',$delete_permission))
                                    <td  class="center-align-phone">
                                        <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData({{ $neuro_op_visit->id}})">
                                            <i class="fa fa-trash"></i> 
                                        </a>
                                    </td> 
                                @endif
                            @elseif (isset($neonatal_op_visit))         
                                <td class="neonatal-op-color text-left">
                                    @php $visit_count = $total_count - $i; @endphp
                                    @if (strlen($visit_count) == 1)
                                        Visit-00{{ $visit_count }}
                                    @elseif (strlen($visit_count) == 2)
                                        Visit-0{{ $visit_count }}
                                    @endif
                                </td>
                                <td>{{ $neonatal_op_visit->visit_number }}</td>  
                                <td class="neonatal-op-color">{{ date('d-m-Y',strtotime($neonatal_op_visit->visit_date)) }}</td>
                                <td class="neonatal-op-color">-</td>
                                <td class="neonatal-op-color">-</td>
                                <td class="neonatal-op-color">-</td>
                            @endif
                            @if (isset($neonatal_op_visit))         
                                <td  class="center-align-phone {{!isset($neuro_op_visit) ? 'neonatal-op-color' : ''}}">
                                    <a class="btn btn-warning btn-view" href="{{ action('Registration\OpController@show', SiteHelpers::encrypt_id($neonatal_op_visit->OpId)).'?closewinlink=neuro-op-list-view' }}" title="Generated Print">
                                        <i class="fa fa-print"></i> 
                                    </a>
                                </td>
                            @else       
                                <td>-</td>
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
             $("#DeleteForm").attr('action',"{{ action('Registration\NeuroController@index') }}/"+id);
             $("#DeleteForm").submit();
         }
     });
   }
</script>
@endsection
