@extends('app')
@section('content')
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li>
		   <i class="icon-home"></i>
		   <a href="{{ url('/') }}">Dashboard</a>
		</li>
		<li class="current">
		   <a href="{{ action('Reports\AnnualReportsController@create') }}">Annual Reports</a>
		</li>                                                
	</ul>
</div>

<div class="row row-spacing">
    @include('errors.list')
    {!! Form::model(null,['url' =>  action('Reports\AnnualReportsController@store')]) !!} 
    <div class="col-md-9">  
   <!--   Start Primary Year -->    	 
       <div class="col-md-9"> 
          <table class="table col-md-9"> 
            <thead>
              <tr>
                <th>{!! Form::label('startdate','Start Date:') !!}</th>
                <th>{!! Form::label('enddate','End Date:') !!}</th>
              </tr>
            </thead> 
            <tbody>  
              <tr>
                <td>
                  <div class="form-group">
          	          {!! Form::text('startdate',null,['class'=>'form-control input-fields-shadow  datepicker hasDatepicker"','readonly']) !!}
                  </div>
                </td>
                <td>  
                  <div class="form-group">
                       {!! Form::text('enddate',null,['class'=>'form-control input-fields-shadow  datepicker hasDatepicker"','readonly']) !!}
                  </div>
                </td>  
              </tr>
            </tbody>
          </table>    
       </div>
   <!--   end Primary Year -->    

   <!--   start Comparing Year -->       
      <div class="col-md-9">
        <div class="form-group">
          {!! Form::label('comparing_years','Period Of Comparison:') !!}
        </div>
        <table class="table annual-reports-comparing col-md-9">
          <thead>
            <tr>
              <th>{!! Form::label('compare_start_date','Start Date:') !!}</th>
              <th>{!! Form::label('compare_end_date','End Date:') !!}</th>
              <th></th>
            </tr>
          </thead> 
          <tbody>
            <tr>
              <td>
                 <div class="form-group">
                   {!! Form::text('compare_start_date[]',null,['class'=>'form-control input-fields-shadow datepicker hasDatepicker"','readonly']) !!}
                 </div> 
              </td>
              <td>
                 <div class="form-group">
                   {!! Form::text('compare_end_date[]',null,['class'=>'form-control input-fields-shadow datepicker hasDatepicker"','readonly']) !!}
                 </div> 
              </td>
              <td><span class="fa fa-remove btn btn-default save-button-shadow remove"></span></td>
            </tr>
          </tbody>
        </table>  
        <div class="form-group">
          <a href="" class="btn btn-primary save-button-shadow annual_compare_dates"> Add More</a>
        </div>
        <div class="form-group">
          {!! Form::label('presented_by','Presented By:') !!}
          {!! Form::text('presented_by',null,['class'=>'form-control input-fields-shadow']) !!}
        </div>
      </div>
         <!--  end Comparing Year -->       

    </div>  
    <div class="col-md-3">
      <!-- start Chart Settings  -->
      <div class="form-group">
          {!! Form::label('chart_type','Chart Type:') !!}
          {!! Form::select('chart_type',$chartTypes,null,['class'=>'form-control input-fields-shadow']) !!}
      </div>
       <div class="form-group" id="ChartImage">
          <img src="">
       </div>
       {!! Form::hidden('image_url',url('/'),['class'=>'input-fields-shadow']); !!}
       

       <!-- end  Chart Settings  -->

    </div> 
   
  <div class="col-md-12">
      <div class="button-row">
          <div class="col-md-3 col-sm-4">
          <button type="submit" class="btn btn-primary save-button-shadow form-control btn-block"><i class="fa fa-print"></i> <span>Print</span></button>
         </div>
      </div>  
  </div>
 
</div>
 
 </div>

 
   {!! Form::close() !!}



@endsection
@section('scripts')

<script type="text/javascript">

  function chartTypechange(){

    var url = $("input[name='image_url']").val();
      if($('#chart_type').val() == 1){
         $('#ChartImage').html('<img src="'+url+'/public/img/charts/single.jpg">');
      }else if($('#chart_type').val() == 2){
         $('#ChartImage').html('<img src="'+url+'/public/img/charts/multiple.jpg">');
      }

  }
  chartTypechange();

  $('#chart_type').change(function(){
      chartTypechange();
  });

	$("form").validate({
   rules:{
   	 startdate:{
   	 	  required:true,
   	 },
   	 enddate:{
   	 	required:true,
   	 },
   	

   	},
   	messages:{
      startdate:{
      	   required:'Please Choose Start date !',
      },
      enddate:{
      	   required:'Please Choose End date !',
      },	
     

   	},
   	 showErrors: function (errorMap, errorList) {

      if (typeof errorList[0] != "undefined") {
          var position = $(errorList[0].element).position().top;
          $('html, body').animate({
              scrollTop: position
          }, 300);
      }
      this.defaultShowErrors();
   } 
   
});

</script>


@endsection
