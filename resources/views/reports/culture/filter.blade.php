@extends('app')
@section('content')
				<!-- Breadcrumbs line -->
				<div class="crumbs bread-crumbs-shadow">
					<ul id="breadcrumbs" class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="{{ url('/') }}">Dashboard</a>
						</li>
						<li>
							<a href="{{ action('Reports\CultureReportController@index') }}">Culture Registry Report</a>
						</li>       
					</ul>
<!--				<ul class="crumb-buttons">
						<li><a href="" title=""><i class="icon-signal"></i><span>Statistics</span></a></li>
					</ul>-->
				</div>
				<!-- /Breadcrumbs line -->

				<!-- Page Header -->
				<div class="page-header">
<!--					<div class="page-title">
						<h3>Dashboard</h3>
					</div>-->
				</div>
				<!-- /Page Header -->

				<!--=== Page Content ===-->
				<div class="row">
					<div class="col-md-12">
                       {!! Form::open(['url' => action('Reports\CultureReportController@index')]) !!}
                            <div class="col-md-5 ">
                                <div class="form-group">
                                    {!! Form::label('StartDate','Start Date:') !!}
                                    {!! Form::text('StartDate',null,['class'=>'form-control datepicker','readonly']) !!}
                                </div>    
                                <div class="form-group">
                                    {!! Form::label('Sex','Sex:') !!}
                                    {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],'',['class'=>'form-control']) !!}
                                </div>     
                                <div class="form-group">
                                    {!! Form::label('Specimen','Specimen:') !!}
                                    {!! Form::select('Specimen',[""=>"N/A","Blood"=>"Blood","Urine (SPA)"=>"Urine (SPA)","Urine (Clean Catch)" => "Urine (Clean Catch)","Urine (Catheter)" => "Urine (Catheter)","CSF"=>"CSF","Swab (Eye)"=>"Swab (Eye)","Swab (Umbilicus)"=>"Swab (Umbilicus)","Swab"=>"Swab","Stool"=>"Stool"],null,['class'=>'form-control']) !!}
                                </div>                                                                                        
                             </div>
                             <div class="col-md-offset-1 col-md-5">
    
                                <div class="form-group">
                                    {!! Form::label('EndDate','End Date:') !!}
                                    {!! Form::text('EndDate',null,['class'=>'form-control datepicker','readonly']) !!}
                                </div>      
                                                 
                                <div class="form-group">
                                    {!! Form::label('SeenBy','Seen By:') !!}
                                    {!! Form::select('SeenBy',[''=>'N/A','1'=>'RK','2'=>'PK'],'',['class'=>'form-control']) !!}
                                </div>  
                                <div class="form-group">
                                      {!! Form::label('Isolate','Isolate:') !!}
                                    {!! Form::select('Isolate',[""=>"N/A","CONS"=>"CONS","E.Coli"=>"E.Coli","Yeast"=>"Yeast"],null,['class'=>'form-control']) !!}
                                </div>                                        
                            </div>

							<div class="button-row">
                             <div class="col-md-2">
                  <button type="submit" class="btn btn-primary form-control"><i class="fa fa-filter"></i> <span>{!! $SubmitButtonText !!}</span></button>
                                
                             </div>
                             <div class="col-md-2">
                              <a href="javascript:void(0);" class="btn btn-default form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i><span>Clear</span></a>
                              </div>
                       </div>
                       {!! Form::close() !!}
					</div> <!-- /.col-md-12 -->
				</div> <!-- /.row -->
				<!-- /Page Content -->
@endsection
