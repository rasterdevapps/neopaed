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
            <a href="{{ action('Extras\CultureController@index') }}">Culture Registry</a>
        </li>
        <li class="current">
            <a>Create</a>
        </li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!-- Page Header -->
<div class="page-header"></div>
<!-- /Page Header -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    @include('errors.list')
    {!! Form::model($baby,['url' => action('Extras\CultureController@store'), 'id'=>'culture-registry']) !!}
    <div class="col-md-12 col-sm-12">
        <div role="tabpanel" class="tabbable tabbable-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#Basicform" role="tab" data-toggle="tab">Basics</a></li>
                <li role="presentation"><a href="#Penicillinform" role="tab" data-toggle="tab">Penicillin</a></li>
                <li role="presentation" class=""><a href="#Cephalosporinsform" role="tab" data-toggle="tab">Cephalosporins</a></li>
                <li role="presentation" class=""><a href="#Monobactumsform" role="tab" data-toggle="tab">Monobactums</a></li>
                <li role="presentation" class=""><a href="#Carbapenemsform" role="tab" data-toggle="tab">Carbapenems</a></li>
                <li role="presentation" class=""><a href="#Aminoglycosidesform" role="tab" data-toggle="tab">Aminoglycosides</a></li>
                <li role="presentation" class=""><a href="#Macrolidesform" role="tab" data-toggle="tab">Macrolides</a></li>
                <li role="presentation" class=""><a href="#Fluoroquinolonesform" role="tab" data-toggle="tab">Fluoroquinolones</a></li>
                <li role="presentation" class=""><a href="#Sulphonamidesform" role="tab" data-toggle="tab">Sulphonamides</a></li>
                <li role="presentation" class=""><a href="#Chloramphenicolform" role="tab" data-toggle="tab">Chloramphenicol</a></li>
                <li role="presentation" class=""><a href="#Tetracyclinesform" role="tab" data-toggle="tab">Tetracyclines</a></li>
                <li role="presentation" class=""><a href="#Peptidesform" role="tab" data-toggle="tab">Peptides</a></li>
                <li role="presentation" class=""><a href="#Lincosamidesform" role="tab" data-toggle="tab">Lincosamides</a></li>
                <li role="presentation" class=""><a href="#Oxazolidinonesform" role="tab" data-toggle="tab">Oxazolidinones</a></li>
                <li role="presentation" class=""><a href="#Othersform" role="tab" data-toggle="tab">Others</a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content tab-view-shadow">
                <div role="tabpanel" class="tab-pane active" id="Basicform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                {!! Form::hidden('BabyId') !!}
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BabyName','Baby Name:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BabyName',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('BirthWeight','Birth Weight (In Gms):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BirthWeight',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('Gestation','Gestation (In Weeks):') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('Gestation',SiteHelpers::decode_gestation(),['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div> -->

                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control" style="margin-top: 25px;">
                                        {!! Form::label('Gestation','Gestation:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input clear-xs">
                                        <div class="row col-md-12 display-flex">
                                            <div>
                                                <small>(In Weeks)</small>
                                                {!! Form::text('g_weeks',null,['class'=>'form-control','readonly']) !!}
                                                <label class="error help-block" for="g_weeks" generated="true"></label> 
                                            </div>
                                            <div class="inbeween_two_fields">
                                                <span>+</span>
                                            </div>
                                            <div>
                                                <small>(In Days)</small>
                                                {!! Form::text('g_days',null,['class'=>'form-control', 'readonly']) !!}
                                                <label class="error help-block" for="g_days" generated="true"></label> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Sex','Sex:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Sex',['Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control','disabled']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DOB','DOB:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DOB',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('SeenBy','Seen By:', ['class'=>'required-label']) !!}
                                        <a href="javascript:void(0)" class="add_master_data" data-modal_header="Seen By" data-destination_elements="SeenBy" data-option_value="id" data-option_text="Name" data-mas_table="mas_doctors">
                                            <i class="fa fa-info-circle bs-tooltip add-neo-consultant" data-placement="right" data-original-title="Add Seen By"></i>
                                        </a>
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('SeenBy',[''=>'N/A']+ValuelistHelpers::mas_doctors_list(),null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Specimen','Specimen:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Specimen',[""=>"N/A","Blood"=>"Blood","Urine (SPA)"=>"Urine (SPA)","Urine (Clean Catch)" => "Urine (Clean Catch)","Urine (Catheter)" => "Urine (Catheter)","CSF"=>"CSF","Swab (Eye)"=>"Swab (Eye)","Swab (Umbilicus)"=>"Swab (Umbilicus)","Swab"=>"Swab","Stool"=>"Stool"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BMrNo', Lang::get('home.mrn').':') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BMrNo',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BirthStatus','Birth Status:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('BirthStatus',null,['class'=>'form-control','readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('EntryDate','Date:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('EntryDate',date('d-m-Y'),['class'=>'form-control datepicker', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CollectionDate','Date of Collection:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('CollectionDate',date('d-m-Y'),['class'=>'form-control datepicker', 'readonly']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('DayOfLife','Day Of Life:', ['class'=>'required-label']) !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('DayOfLife',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Isolate','Isolate:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Isolate',[""=>"N/A","CONS"=>"CONS","E.Coli"=>"E.Coli","Yeast"=>"Yeast","Staphylococcus aureus" => "Staphylococcus aureus", "Enterococcus" => "Enterococcus", "Alpha hemolytic Streptococci" => "Alpha hemolytic Streptococci", "Streptococcus viridans" => "Streptococcus viridans", "Klebsiella" => "Klebsiella", "Pseudomonas" => "Pseudomonas", "Salmonella" => "Salmonella", "Enterobacter" => "Enterobacter", "Citrobacter" => "Citrobacter", "Acinetobacter" => "Acinetobacter", "Proteus" => "Proteus", "Burkholderia" => "Burkholderia", "Yeast" => "Yeast", "Candida" => "Candida"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Penicillinform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('AmoxycillinClavulanate','Amoxycillin Clavulanate:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AmoxycillinClavulanate',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('AmpicillinSulbactum','Ampicillin Sulbactum:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AmpicillinSulbactum',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Methicillin','Methicillin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Methicillin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control mt-0">
                                        {!! Form::label('PiperacillinTazobactum','Piperacillin Tazobactum:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PiperacillinTazobactum',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Carbenicillin','Carbenicillin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Carbenicillin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PenicillinG','Penicillin G:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PenicillinG',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Cephalosporinsform">
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefotaxime','Cefotaxime:') !!}
                                    </div>
                                      <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefotaxime',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Ceftriaxone','Ceftriaxone:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Ceftriaxone',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefuroxime','Cefuroxime:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefuroxime',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefazolin','Cefazolin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefazolin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefepime','Cefepime:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefepime',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefoxitin','Cefoxitin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefoxitin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefpodoxime','Cefpodoxime:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefpodoxime',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefaclor','Cefaclor:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefaclor',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefixime','Cefixime:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefixime',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cefoperazone','Cefoperazone:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cefoperazone',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Ceftazidime','Ceftazidime:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Ceftazidime',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Monobactumsform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Aztreonam','Aztreonam:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Aztreonam',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Carbapenemsform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Imipenem','Imipenem:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Imipenem',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Meropenem','Meropenem:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Meropenem',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Faropenem','Faropenem:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Faropenem',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Ertapenem','Ertapenem:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Ertapenem',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Aminoglycosidesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Amikacin','Amikacin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Amikacin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Gentamicin','Gentamicin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Gentamicin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Tobramycin','Tobramycin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Tobramycin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Netillin','Netillin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Netillin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Macrolidesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Azithromycin','Azithromycin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Azithromycin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Erythromycin','Erythromycin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Erythromycin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Fluoroquinolonesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Ciprofloxacin','Ciprofloxacin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Ciprofloxacin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Levofloxacin','Levofloxacin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Levofloxacin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Ofloxacin','Ofloxacin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Ofloxacin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Norfloxacin','Norfloxacin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Norfloxacin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Sulphonamidesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CoTrimoxazole','Co Trimoxazole:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('CoTrimoxazole',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Chloramphenicolform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Chloramphenicol','Chloramphenicol:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Chloramphenicol',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Tetracyclinesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Doxycycline','Doxycycline:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Doxycycline',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Tetracycline','Tetracycline:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Tetracycline',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Peptidesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Vancomycin','Vancomycin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Vancomycin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Teicoplanin','Teicoplanin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Teicoplanin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Colistin','Colistin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Colistin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PolymyxinB','Polymyxin B:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PolymyxinB',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Lincosamidesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Clindamycin','Clindamycin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Clindamycin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Oxazolidinonesform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Linezolid','Linezolid:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Linezolid',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="Othersform">
                    <div class="col-md-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NalidixicAcid','Nalidixic Acid:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NalidixicAcid',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Nitrofurantoin','Nitrofurantoin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Nitrofurantoin',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Tigecycline','Tigecycline:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Tigecycline',[''=>'N/A','Sensitive' => "Sensitive","Resistant"=>"Resistant","Not done"=>"Not done"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-11 col-sm-12">
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <button type="submit" class="btn btn-primary form-control save-button-shadow btn-block culture-save-btn"><i class="fa fa-floppy-o"></i> <span>{!! $SubmitButtonText !!}</span></button>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <input type="hidden" name="print_flag" value="0" id="print_flag" />
                        <button type="button" class="btn btn-block save-button-shadow btn-info form-control culture-save-btn" data-flag="1"><i class="fa fa-print"></i> <span>Print</span></button>
                    </div>
                    <div class="col-md-3 col-sm-4 col-xs-12">
                        <a href="{{ action('Extras\CultureController@index') }}" class="btn btn-default save-button-shadow form-control btn-block" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> <span>Cancel</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
<!-- /.col-md-12 -->                    
</div> <!-- /.row -->
<!-- /Page Content -->
@endsection
@section('scripts')
<script type="text/javascript">
    /* PLUGIN USED FOR FORM LOCAL STORAGE */
    $( "form" ).sisyphus({  customKeySuffix: "culture", locationBased: true });
    $('#EntryDate').change(function()
    {
        var dob = $('#DOB').val();
        var entryDate = $('#EntryDate').val();

        dobDate        = stringToDate(dob,'dd-mm-yyyy','-');
       entryDate  = stringToDate(entryDate,'dd-mm-yyyy','-');

       var tempDays = calculateDays(dobDate, entryDate);
       $('#DayOfLife').val(tempDays);

    });

    var dob = $('#DOB').val();
    var entryDate = $('#EntryDate').val();

    dobDate        = stringToDate(dob,'dd-mm-yyyy','-');
    entryDate  = stringToDate(entryDate,'dd-mm-yyyy','-');

    var tempDays = calculateDays(dobDate, entryDate);
    $('#DayOfLife').val(tempDays);

$(document).on('click', '.culture-save-btn', function(e){
    if ($('#culture-registry').valid() === true) {
        e.preventDefault();
        var print_flag = $(this).data('flag');
        $('#print_flag').val(print_flag);
        $('.culture-save-btn').prop('disabled', true);
        var current_clicked_element = $(this);
        $(this).html('<i class="fas fa-spinner fa-pulse"></i> Loading...');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            data: $('#culture-registry input, #culture-registry select, #culture-registry textarea').serialize(),
            url: "{{ action('Extras\CultureController@store') }}",
            success: function (response) {
                if (print_flag == 1) {
                    Showalert('success', ' Culture Registry Details Stored Successfully');
                    window.location.href = response.print_url;
                }
                else
                {
                    Showalert('success', ' Culture Registry Details Stored Successfully');
                    window.location.href = response.list_url;
                }
            },
            error: function()
            {
                Showalert('error', 'Something went wrong, Please try again later...!');
                $('.culture-save-btn').prop('disabled', false);
            }
        });
    }
});
</script>
@endsection
    
