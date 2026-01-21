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
        <li><a href="{{ action('Registration\BayleyScaleController@index') }}">{{ Lang::get('menu.side_menu_bayley_scale') }}</a></li>
        <li class="current"><a href="javascript:void(0);">History of <span class="text-captialize"></span></a></li>                                                 
    </ul>                   
</div>
<!-- /Breadcrumbs line -->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
         <div class="widget-header">
            <h4>Neuro Devolpement</h4>
            @if(in_array('BAYLEY_SCALE',$write_permission))
            <a href="{{ action('Registration\BayleyScaleController@create').'/'.SiteHelpers::encrypt_id($baby_id) }}" title="Create New" class="btn btn-basic-shadow create-btn-spacing btn-info pull-right create-btn">
                <i class="fa fa-plus"></i>
                <span>Create New</span>
            </a>  
            @endif                              
        </div>
        <div class="widget-content inherittable">
            <table class="table table-striped table-bordered table-responsive"  id="data-list">
                <thead>
                    <tr>
                        <th class="vertical-align-center" rowspan="2">Visits</th>
                        <th class="vertical-align-center" rowspan="2" data-hide="phone,tablet">{{ Lang::get('home.ip') }}</th>
                        <th class="vertical-align-center" rowspan="2" data-hide="phone,tablet">Visit Date</th>
                        <th class="center-align-phone">Print</th>   
                        @if(in_array('BAYLEY_SCALE',$delete_permission))
                        <th class="center-align-phone">Delete</th>                                                    
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php 
                    $i = 0;
                    @endphp
                    @foreach($visite_list as $key => $value)
                    <tr>
                    <td class="text-left">
                        <a class="pull-left input-width-small @if(!in_array('BAYLEY_SCALE',$write_permission)) permission-denied @endif" href="@if(in_array('BAYLEY_SCALE',$write_permission)) {{ action('Registration\BayleyScaleController@edit', SiteHelpers::encrypt_id($value['id'])) }} @else javascript:void(0); @endif">
                            @php $visit_count = count($visite_list) - $i; @endphp
                            @if (strlen($visit_count) == 1)
                            Visit-00{{ $visit_count }}
                            @elseif (strlen($visit_count) == 2)
                            Visit-0{{ $visit_count }}
                            @endif
                        </a> 
                    </td>
                    <td>{{$value['visit_number']}}</td>  
                    <td>{{ date('d-m-Y',strtotime($value['visit_date'])) }}</td>  
                    <td class="center-align-phone">
                        <a class="btn btn-warning btn-view" href="{{ action('Registration\BayleyScaleController@show', SiteHelpers::encrypt_id($value['id'])).'?closewinlink=list-view' }}" title="Final Print">
                            <i class="fa fa-print"></i> 
                        </a>
                    </td> 
                    @if(in_array('BAYLEY_SCALE',$delete_permission))
                    <td  class="center-align-phone">
                        <a class="btn btn-danger btn-view mr-10" href="javascript:void(0);" onclick="DeleteData({{ $value['id']}})">
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
       $("#DeleteForm").attr('action',"{{ action('Registration\BayleyScaleController@index') }}/"+id);
       $("#DeleteForm").submit();
   }
});
 }
</script>
@endsection
