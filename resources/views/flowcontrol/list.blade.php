@extends('app')
@section('content')
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
			<i class="icon-home"></i>
			<a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
			<a href="{{ action('Flow\FlowController@index') }}">Flow Incomplete List</a>
		</li>                                                
	</ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4>Flow Incomplete List</h4>
                <div class="pull-right">
                     <button  @if(!count($results) > 0) disabled ="true" @endif  class="btn btn-info btn-basic-shadow complete create-btn-spacing"> Mark As Complete</button>
                </div>
			</div>
            <div class="widget-content">
				<table class="table table-striped table-bordered table-hover  table-checkable"  id="data-list">
					<thead>
                        <tr>
                            <th><input type="checkbox" name="mark_complete[]" class="main-list"></th> 
                            <th>BabyName</th>
                            <th class="hidden-xs" data-hide="phone">{{ Lang::get('home.mrn') }}</th>
                            <th data-hide="phone">Module</th>
                            <th class="hidden-xs" data-hide="phone,tablet">Current Module</th>
                            <th class="hidden-xs" data-hide="phone,tablet">Started Date</th>
                            <th> User Name</th>
                        </tr>
                    </thead>
                    <tbody>
                    {!! Form::model('',['method' => 'POST','url' => action('Flow\FlowController@updaterecord'),'id' => 'flow-form']) !!}
                    @if(count($results) > 0)   
                        @for ($i = 0; $i <  @count($results); $i++)
                            <tr>
                                <td><input type="checkbox" name="mark_complete[]" value="{{ $results[$i]['fcid'] }}" class="sub-list"></td> 
                                <td>{{  !empty($results[$i]['babyName']) ? $results[$i]['babyName'] : 'Not Chosen'  }}</td>
                                <td class="hidden-xs">{{  !empty($results[$i]['babyName']) ? $results[$i]['BMrNo'] :  'Not Chosen' }}</td>
                                <td>
                                    <a href="{{ action('Flow\FlowController@resumeFlow', $results[$i]['fcid']) }}">
                                    {{  SiteHelpers::ModuleList($results[$i]['admission_module']) }}
                                    </a>
                                </td>
                                <td class="hidden-xs">{{  SiteHelpers::ModuleList($results[$i]['current_module']) }}</td>
                                <td class="hidden-xs">{{  date('d-m-Y', strtotime($results[$i]['start_date'])) }}</td>
                                <td>{{  @$user_list[$results[$i]['user_id']] }}</td>
                            </tr>
                    	@endfor
                    @else
                        <tr><td colspan="7" class="text-center"> <h3> No Records Found </h3></td> </tr>
                    @endif 
                    {!! Form::close() !!}   
                    </tbody>
				</table> 
   
            </div>
        </div>
	</div> <!-- /.col-md-12 -->
</div> 
@endsection
@section('scripts')
<script type="text/javascript">
$(document).ready(function() {

    $('.main-list').click(function() {
         $('.sub-list').trigger('click');  
    });

    $('.complete').click(function() {
        $('#flow-form').submit();

    });

    $('.complete').prop('disabled', true);
    $(".main-list").on('click',function(){
        val = $(this).is(":checked");
        var sub_val = $(".sub-list").val();
        if(val && typeof sub_val !== 'undefined'){
            $('.complete').prop('disabled', false);        
            $(".sub-list").prop('checked', true);
        }
        else{
            $('.complete').prop('disabled', true);
            $(".sub-list").prop('checked', false);
        }
    });
    $("input[name='mark_complete[]']").on('click',function(){
        var sub_val = $(".sub-list").val();
        if ($("input[name='mark_complete[]']").is(":checked") && typeof sub_val !== 'undefined') {
            $('.complete').prop('disabled', false);        
        } else {
            $('.complete').prop('disabled', true);       
        }
    });

});
</script>

@endsection














