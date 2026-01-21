@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li><i class="icon-home"></i><a href="{{ url('/') }}">Dashboard</a></li>
        <li><a href="{{ action('Registration\PediatricOpController@index') }}">Pediatric OP Registration</a></li>
        <li class="current"><a href="javascript:void(0);">History of <span class="text-captialize">{{ $baby_name }}</span></a></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Pediatric OP Registration</h4>
                @if(in_array('PEDIATRICS_OP_REG',$write_permission))
                <a href="{{ url('out-patient/vaccine-chart-print/') }}/{{ \SiteHelpers::encrypt_id($visite_list[0]->BabyId) }}" class="btn btn-warning create-btn-spacing pull-right vaccine-chart-print-btn"> PRINT VACCINE CHART</a>
                <a href="{{ action('Registration\PediatricOpController@chooseBaby') }}" title="" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right mr-15"><i class="fa fa-plus "></i> <span>Create New</span></a> 
                @endif           
                @if(in_array('LABREQUEST',$write_permission))   
                    <a href="{{ action('Nurse\NurseSheetController@overallLabValuePrint', $visite_list[0]->BMrNo).'?closewinlink=pediatric-op-visit-list' }}" class="btn btn-primary create-btn-spacing mr-15 pull-right">
                        <i class="fa fa-print"></i>
                        <span>Lab Report</span>
                    </a> 
                @endif                                
            </div>
            <div class="widget-content inherittable">
                <table class="table table-striped table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th>Visits</th>
                            <th data-hide="phone,tablet">{{ Lang::get('home.ip') }}</th>
                            <th data-hide="phone,tablet">Op Date</th>
                            <th class="center-align-phone">Print</th>
                            <th class="center-align-phone">Print All</th>
                            @if(in_array('PEDIATRICS_OP_REG',$delete_permission))
                            <th class="center-align-phone">Delete</th>
                            @endif            
                        </tr>
                    </thead>
                    <tbody>
                        @php  $i = 0; @endphp 
                        @foreach($visite_list as $key => $value)
                        @php  $j = $i @endphp 
                        <tr>
                            <td>
                                <a class="icon @if(!in_array('PEDIATRICS_OP_REG',$write_permission)) permission-denied @endif" href="@if(in_array('PEDIATRICS_OP_REG',$write_permission)) {{ action('Registration\PediatricOpController@edit', SiteHelpers::encrypt_id($value->id)) }} @else javascript:void(0); @endif">
                                @php $visit_count = count($visite_list) - $i; @endphp
                                @if (strlen($visit_count) == 1)
                                Visit-00{{ $visit_count }}
                                @elseif (strlen($visit_count) == 2)
                                Visit-0{{ $visit_count }}
                                @endif
                                </a> 
                            </td>
                            <td>{{ $value->visit_number }}</td>  
                            <td>{{  date('d-m-Y',strtotime($value->op_date)) }}</td>
                            <td  class="center-align-phone">
                                <a class="btn btn-warning btn-view" href="{{ action('Registration\PediatricOpController@show', SiteHelpers::encrypt_id($value->id)) }}" title="Generated Print">
                                <i class="fa fa-print"></i> 
                                </a>
                            </td>
                            <td  class="center-align-phone">
                                <a class="btn btn-warning btn-view" href="{{ action('Registration\PediatricOpController@print', SiteHelpers::encrypt_id($value->id)) }}" title="Generated Print">
                                <i class="fa fa-print"></i> 
                                </a>
                            </td>
                            @if(in_array('PEDIATRICS_OP_REG',$delete_permission))
                            <td  class="center-align-phone">
                                <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData({{ $value->id}})">
                                <i class="fa fa-trash"></i> 
                                </a>
                            </td>
                            @endif                         
                        </tr>
                        @php  $i++; @endphp 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
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
             $("#DeleteForm").attr('action',"{{ action('Registration\PediatricOpController@index') }}/"+id);
             $("#DeleteForm").submit();
         }
     });
    }
</script>
@endsection
