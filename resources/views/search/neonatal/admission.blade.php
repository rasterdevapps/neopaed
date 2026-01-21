<ul class="nav nav-tabs" role="tablist" id="neonate-next">
    <li role="presentation" class="active">
        <a class="tab-main-menu" href="#babyform" aria-controls="babyform" role="tab" data-toggle="tab">Baby Details</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#motherform" aria-controls="motherform" role="tab" data-toggle="tab">Parental Details</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#obform" aria-controls="obform" role="tab" data-toggle="tab">Obstetric History</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#pgform" aria-controls="pgform" role="tab" data-toggle="tab">Pregnancy</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#pgcform" aria-controls="pgcform" role="tab" data-toggle="tab">Pregnancy Contd</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#labform" aria-controls="labform" role="tab" data-toggle="tab">Labour</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#delform" aria-controls="delform" role="tab" data-toggle="tab">Delivery</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#apgarform" aria-controls="apgarform" role="tab" data-toggle="tab">APGAR</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#resform" aria-controls="resform" role="tab" data-toggle="tab">Resuscitation Details</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#essform" aria-controls="essform" role="tab" data-toggle="tab">Essential Details</a>
    </li>

    <li role="presentation">
        <a class="tab-main-menu" href="#newbornform" aria-controls="newbornform" role="tab" data-toggle="tab">New Born Examination</a>
    </li>

</ul>
<!-- Tab panes -->
<div class="tab-content tab-curve tab-view-shadow">
    <div role="tabpanel" class="tab-pane active" id="babyform">
        {!! Form::hidden('BabyId',null) !!}
        {!! Form::hidden('MotherId',null) !!}
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    {!! Form::hidden('BabyId',null) !!}
                    {!! Form::hidden('MotherId',null) !!}
                    {!! Form::hidden('AdmissionId',null) !!}
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('TestDate','Data Entry Date:') !!} (DD-MM-YYYY)
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('TestDate',null,['class'=>'form-control baby-dob']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BabyName','Baby Name:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('BabyName',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DOB','DOB:') !!} (DD-MM-YYYY)
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('DOB',null,['class'=>'form-control baby-dob']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('time_of_birth','TOB:') !!} (HH:MM:AM or PM)

                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('time_of_birth',null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BirthStatus','Birth Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('BirthStatus', [''=>'N/A', 'Outborn'=>'Outborn', 'Inborn'=>'Inborn'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BirthWeight','Birth Weight:') !!}
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                            <div class="row">
                                <div class="col-xs-6">
                                    <small>(In Grams)</small>
                                </div>
                                <div class="col-xs-6">
                                    <small>(In Kilo Grams)</small>
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::input('text','BirthWeight',null,['class'=>'form-control input-width-medium']) !!}
                                </div>
                                <div class="col-xs-6">
                                    @php $birthweight = (isset($results->BirthWeight) && is_numeric($results->BirthWeight)) ?  $results->BirthWeight/1000 : '' ; @endphp
                                    {!! Form::input('text','birth_weight',$birthweight,['class'=>'form-control width-125','readonly'=>'true']) !!}
                                </div>
                            </div>
                            <label class="error help-block" for="BirthWeight" generated="true"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Gestation','Gestation:') !!}
                        </div>
                        <div class="col-md-9 custom-input clear-xs">
                            <div class="row col-md-12 display-flex">
                                <div>
                                    <small>(In Weeks)</small>
                                    {!! Form::text('g_weeks',null,['class'=>'form-control input-width-medium']) !!}
                                    <label class="error help-block" for="g_weeks" generated="true"></label> 
                                </div>
                                <div class="inbeween_two_fields">
                                    <span>+</span>
                                </div>
                                <div>
                                    <small>(In Days)</small>
                                    {!! Form::text('g_days',null,['class'=>'form-control  input-width-medium']) !!}
                                    <label class="error help-block" for="g_days" generated="true"></label> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('entry_time','Data Entry Time:') !!} (HH:MM:AM or PM)
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('entry_time',null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BabyBloodGroup','Baby\'s Blood Group:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('BabyBloodGroup',[''=>'N/A']+ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('BirthOrder','Birth Order:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('BirthOrder',[''=>'N/A']+['Singleton'=>'Singleton']+ValuelistHelpers::mptypeNobabies('All'),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Sex','Sex:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Sex',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Length','Birth Length (cm):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Length',null,['class'=>'form-control','maxlength'=>'4']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('OFC','Birth Head Circumference (cm):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('OFC',null,['class'=>'form-control','maxlength'=>'4']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Transfer Status','Transfer Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('transfer_status',ValuelistHelpers::getTransferstatus(), null,['class'=>'form-control', 'id'=>'transfer_status']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane top-specing" id="motherform">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> Mother Details</h4>
                </div>
                <div class="widget-content">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherTitle','Title:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('MotherTitle',[''=>'N/A','Ms.'=>'Ms.','Mrs.'=>'Mrs.','Miss.'=>'Miss.','Dr.'=>'Dr.'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherInitial','Initial:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherInitial',null,['class'=>'form-control text-convertion-upper']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('MotherName','First Name:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::text('MotherName',null,['class'=>'form-control text-convertion-title']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MotherLastName','Last Name:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('MotherLastName',null,['class'=>'form-control text-convertion-title']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MotherDOB','DOB:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('MotherDOB',null,['class'=>'form-control parents-dob','readonly'=>true]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MothercYear','Completed Years:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('MothercYear',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('education_status','Mother\'s Education Level:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Occupation','Occupation Type:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Occupation',null,['class'=>'form-control text-convertion-title']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('occupation_status','Current Occupation Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Mobile','Contact No 1 :') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Mobile',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('LandLine','Contact No 2 :') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('LandLine',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MotherEmail','Email :') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('MotherEmail',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right  label-control">
                            {!! Form::label('MotherSpokenLanguages','Mother Spoken Languages:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('MotherSpokenLanguages',null,['class'=>'form-control text-convertion-title']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="divider">&nbsp;</p>
                    </div>
                </div>
            </div>
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> Permanent Address</h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="Address1">Address Line 1 :<br><small class="input-small">(Door /Flat No /Home Name)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Address1',null,['class'=>'form-control', 'id'=>'Address1']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="Address2">Address Line 2 :<br><small class="input-small">(Street Name/Building Name)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Address2',null,['class'=>'form-control', 'id'=>'Address2']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="Address3">Address Line 3 :<br><small class="input-small">(City)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Address3',null,['class'=>'form-control', 'id'=>'Address3']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="Address4">Address Line 4 :<br><small class="input-small">(Pin code/Zip code)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Address4',null,['class'=>'form-control', 'id'=>'Address4']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="Address5">Address Line 5 :<br><small class="input-small">(Country)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Address5',null,['class'=>'form-control', 'id'=>'Address5']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <p class="divider">&nbsp;</p>
                    </div>
                </div>
            </div>
        </div>
        <div class=" col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> Father Details</h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right  label-control">
                            {!! Form::label('PartnerTitle','Title:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('PartnerTitle',[''=>'N/A','Mr.'=>'Mr.','Dr.'=>'Dr.'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnerInitial','Initial:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnerInitial',null,['class'=>'form-control text-convertion-upper']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnerName','First Name:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnerName',null,['class'=>'form-control text-convertion-title']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnerLastName','Last Name:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnerLastName',null,['class'=>'form-control text-convertion-title']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnerDOB','DOB:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnerDOB',null,['class'=>'form-control parents-dob','readonly'=>'true']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnercYear','Completed Years:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnercYear',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('partner_education_status','Father\'s Education Level:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('partner_education_status',ValuelistHelpers::getEducationstatus(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnerOccupation','Occupation Type:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnerOccupation',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('partner_occupation_status','Current Occupation Status:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('partner_occupation_status',ValuelistHelpers::getOccupationstatus(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnerContact','Contact No 1:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnerContact',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PartnerMobile','Contact No 2 :') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PartnerMobile',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Email','Email:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Email',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('FatherSpokenLanguages','Father Spoken Languages:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('FatherSpokenLanguages',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> Mailing Address</h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="FatherAddress1">Address Line 1 :<br><small class="input-small">(Door /Flat No /Home Name)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('FatherAddress1',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="FatherAddress2">Address Line 2 :<br><small class="input-small">(Street Name/Building Name)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('FatherAddress2',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="City">Address Line 3 :<br><small class="input-small">(City)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('City',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="Postcode">Address Line 4 :<br><small class="input-small">(Pin code/Zip code)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Postcode',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            <label for="Country">Address Line 5 :<br><small class="input-small">(Country)</small></label>
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('Country',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div role="tabpanel" class="tab-pane top-specing" id="obform">
        <div class="widget box">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content row mx-0">
                <div class="col-md-12">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Consanguinity','Consanguinity:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Consanguinity', [''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-6 overflow-auto">
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="medi table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th width="20%">
                                            Medical Problems 
                                        </th>
                                        <th width="20%">Medications/Dose/Frequency</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div class="hidden">
                                        {!! Form::select('temp_medi_probs',$medicalproblems) !!}
                                    </div>
                                    @if(isset($ob_medicalproblem) && count($ob_medicalproblem) > 0)
                                    @foreach ($ob_medicalproblem as $medical)
                                    <tr>
                                        <td>{!! Form::select('Problems[]',[''=>'N/A']+$medicalproblems,$medical['Problem'],["class"=>'form-control input-width-xlarge']) !!}</td>
                                        <td><input type="text" name="Medications[]" value="{!! $medical['Medication']; !!}" class="form-control input-width-xlarge" /></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td>{!! Form::select('Problems[]',[''=>'N/A']+$medicalproblems,'',["class"=>"form-control input-width-xlarge"]) !!}</td>
                                        <td><input type="text" name="Medications[]" class="form-control input-width-xlarge" value="" /></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <table>
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><label for="Medications[]" generated="true" class="error help-block"></label></td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 overflow-auto">
                    <div class="col-md-5 pl-0">
                        <table class="gravida col-md-7 text-center">
                            <thead>
                                <tr>
                                    <th>Gravida</th>
                                    <th>Para</th>
                                    <th>Livebirth</th>
                                    <th>Abortion</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="form-group">{!! Form::text('G_Value',null,['class'=>'form-control']) !!}</td>
                                    <td class="form-group">{!! Form::text('P_Value',null,['class'=>'form-control']) !!}</td>
                                    <td class="form-group"> {!! Form::text('L_Value',null,['class'=>'form-control']) !!}</td>
                                    <td class="form-group">{!! Form::text('A_Value',null,['class'=>'form-control']) !!}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-md-5">
                        <label class="error help-block" for="G_Value" generated="true"></label>
                        <label class="error help-block" for="P_Value" generated="true"></label>
                        <label class="error help-block" for="L_Value" generated="true"></label>
                        <label class="error help-block" for="A_Value" generated="true"></label>   
                    </div>
                </div>
                <div class="col-md-12 overflow-auto">
                    <div class="form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="delivery table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th>Year</th>
                                        <th>Place</th>
                                        <th>Delivery</th>
                                        <th>Complications</th>
                                        <th>Gender</th>
                                        <th>GA (wks)</th>
                                        <th>B.Wt (grams)</th>
                                        <th>Health</th>
                                        <th class="input-width">Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($ob_delivery) && count($ob_delivery) > 0)
                                    @foreach ($ob_delivery as $com_data)
                                    <tr>
                                        <td><input type="text" class="form-control input-width-mini" id="OH_YEAR" name="Year[]" value="{!! $com_data['Year']; !!}" /></td>
                                        <td><input type="text" class="form-control" name="Place[]" value="{!! $com_data['Place']; !!}" /></td>
                                        <td class="input-width-medium">{!! Form::select('Delivery[]',[''=>'N/A','Vaginal'=>'Vaginal','LSCS'=>'LSCS','Instrumental'=>'Instrumental','Breech'=>'Breech'], $com_data['Delivery'], ['class'=>'form-control']) !!}</td>
                                        <td><input type="text" class="form-control" name="Complications[]" value="{!! $com_data['Complications']; !!}" /></td>
                                        <td class="input-width-medium">{!! Form::select('Gender[]',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'], $com_data['Gender'], ['class'=>'form-control']) !!}</td>
                                        <td><input type="text" class="form-control input-width-mini" name="GA[]" value="{!! $com_data['GA']; !!}" /></td>
                                        <td><input type="text" class="form-control input-width-mini" name="BW[]" value="{!! $com_data['BW']; !!}" /></td>
                                        <td class="input-width-medium">{!! Form::select('Health[]',[''=>'N/A','Alive'=>'Alive','Died'=>'Died','Unhealthy'=>'Unhealthy'], $com_data['Health'], ['class'=>'form-control']) !!}</td>
                                        <td><input type="text" name="details[]" class="form-control input-width" value="{!! isset($com_data['details']) ? $com_data['details'] : ''; !!}" /></td>
                                    </tr>
                                    @endforeach
                                    @else 
                                    <tr>
                                        <td><input type="text" class="form-control input-width-mini" id="OH_YEAR" name="Year[]" value="" /></td>
                                        <td><input type="text" class="form-control" name="Place[]" value="" /></td>
                                        <td>{!! Form::select('Delivery[]',[''=>'N/A','Vaginal'=>'Vaginal','LSCS'=>'LSCS','Instrumental'=>'Instrumental','Breech'=>'Breech'], null, ['class'=>'form-control']) !!}</td>
                                        <td><input type="text" class="form-control" name="Complications[]" value="" /></td>
                                        <td>{!! Form::select('Gender[]',[''=>'N/A','Male'=>'Male','Female'=>'Female','Indeterminate'=>'Indeterminate'], null, ['class'=>'form-control']) !!}</td>
                                        <td><input type="text" class="form-control input-width-mini" name="GA[]" value="" /></td>
                                        <td><input type="text" class="form-control input-width-mini" name="BW[]" value="" /></td>
                                        <td>{!! Form::select('Health[]',[''=>'N/A','Alive'=>'Alive','Died'=>'Died','Unhealthy'=>'Unhealthy'], null, ['class'=>'form-control']) !!}</td>
                                        <td><input type="text" name="details[]" class="form-control input-width" value="" /></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- PGform -->
    <div role="tabpanel" class="tab-pane top-specing" id="pgform">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Conception','Conception:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Conception',[''=>'N/A','Not Known'=>'Not Known','Spontaneous'=>'Spontaneous','Medical ART'=>'Medical ART','ART'=>'ART'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row" id="TypeofARTDiv">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('TypeofART','Type of ART:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('TypeofART',[''=>'N/A','Not Known'=>'Not Known', 'SO'=>'SO','CC10'=>'CC10','CC50'=>'CC50','CC100'=>'CC100','IUI'=>'IUI','SO/IUI'=>'SO/IUI','IVF'=>'IVF','ICSI'=>'ICSI','ICSI - DEP'=>'ICSI - DEP','ICSI - DOP'=>'ICSI - DOP','ICSI - Donor Sperm'=>'ICSI - Donor Sperm','GIFT'=>'GIFT','ZIFT'=>'ZIFT'], null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row" id="EmbryoTransferDiv">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('EmbryoTransfer','Embryo Transfer:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('EmbryoTransfer',[''=>'N/A','Not Known'=>'Not Known','Not applicable'=>'Not applicable','Fresh Embryo Transfer'=>'Fresh Embryo Transfer','Frozen Embryo Transfer'=>'Frozen Embryo Transfer'], null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row" id="PlaceofARTDiv">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PlaceofART','Place of ART:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('PlaceofART',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('LMP','LMP:') !!} (DD-MM-YYYY)
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('LMP',null,['class'=>'form-control previous-one-year']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('EDDbyUSG','EDD by USG:') !!} (DD-MM-YYYY)
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('EDDbyUSG',null,['class'=>'form-control next-one-year']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('EDDbyDates','EDD by Dates:') !!} (DD-MM-YYYY)
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('EDDbyDates',null,['class'=>'form-control next-one-year']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MotherBloodGroup',"Mother's Blood Group:") !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('MotherBloodGroup',[''=>'N/A']+ValuelistHelpers::Blood_groups(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('HIV','HIV:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('HIV',[''=>'N/A','Non-reactive'=>'Non-reactive','Reactive'=>'Reactive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('HepatitisB','HepatitisB:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('HepatitisB',[''=>'N/A','Negative'=>'Negative','Positive'=>'Positive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('VDRL','VDRL:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('VDRL',[''=>'N/A','Non-reactive'=>'Non-reactive','Reactive'=>'Reactive','Unknown'=>'Unknown'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Booked','Booked:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Booked',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Booking','Place of Booking:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Booking', [''=>'N/A']+ValuelistHelpers::mas_referral_list(), null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Supervised','Supervised:') !!}
                        </div>
                        <div class="col-md-9 custom-input">   
                            {!! Form::select('Supervised',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PlaceofSupervision','Place of Supervision:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('PlaceofSupervision', [''=>'N/A']+ValuelistHelpers::mas_referral_list(), null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('adjustedtrisomies','Adjusted Risk for Trisomies available:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('adjustedtrisomies',[''=>'N/A','1'=>'No','2'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('AdjustedRiskForTrisomy21','Adjusted Risk For Trisomy21:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('AdjustedRiskForTrisomy21',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row @if(@$results->AdjustedRiskForTrisomy21 != 'Others') display-none @endif">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('another_adjusted_risk_for_trisomy21','Another Adjusted Risk For Trisomy21:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('another_adjusted_risk_for_trisomy21',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('AdjustedRiskForTrisomy18','Adjusted Risk For Trisomy18:') !!}  
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('AdjustedRiskForTrisomy18',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row @if(@$results->AdjustedRiskForTrisomy18 != 'Others') display-none @endif">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('another_adjusted_risk_for_trisomy18','Another Adjusted Risk For Trisomy18:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('another_adjusted_risk_for_trisomy18',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('AdjustedRiskForTrisomy13','Adjusted Risk For Trisomy13:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('AdjustedRiskForTrisomy13',null,['class'=>'form-control', 'id'=> 'AdjustedRiskForTrisomy13']) !!}
                        </div>
                    </div>
                    <div class="form-group row @if(@$results->AdjustedRiskForTrisomy13 != 'Others') display-none @endif">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('another_adjusted_risk_for_trisomy13','Another Adjusted Risk For Trisomy13:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('another_adjusted_risk_for_trisomy13',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('OtherInvestigations','Other Investigations:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('OtherInvestigations',null,['class'=>'form-control','rows'=>'5']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Pregnancy Contd -->
    <div role="tabpanel" class="tab-pane top-specing" id="pgcform">
        <div class="widget box col-md-12">
            <div class="widget-header">
                <h4><i class="fa fa-reorder"></i> </h4>
            </div>
            <div class="widget-content">
                <div class="col-md-5 ">
                    <div class="form-group row">
                        <div class="col-md-5 text-right label-control">
                            {!! Form::label('MultiplePregnancy','MultiplePregnancy:') !!}
                        </div>
                        <div class="col-md-7 custom-input"> 
                            {!! Form::select('MultiplePregnancy',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-5 text-right label-control">
                            {!! Form::label('PregnancyComplications','Pregnancy Complications:') !!}
                        </div>
                        <div class="col-md-7 custom-input">
                            {!! Form::select('PregnancyComplications', [''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control'] ) !!}
                        </div>
                    </div>
                </div>
                <div class="col-md-12 complication-disable overflow-auto">
                    <div class="col-md-7 form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="complication table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th>Complication
                                        </th>
                                        <th>Treatment</th>
                                        <th colspan="2">Duration </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <div class="hidden">
                                        {!! Form::select('temp_complications',$complications,'',["class"=>"form-control input-width-small"]) !!}
                                    </div>
                                    @if (isset($complication) && is_array($complication) && count($complication) > 0)
                                    @php $l = 0; @endphp
                                    @foreach ($complication as $com_data)
                                    @php $com_data['duration_in_weeks'] = isset($com_data['duration_in_weeks']) ? $com_data['duration_in_weeks'] : '';  @endphp
                                    <tr>
                                        <td class="form-group">{!! Form::select('Complication[]',[''=>'N/A']+$complications,$com_data['Complication'],["class"=>"complication-disabled complication-search","id"=>"complication-search-".$l, "style"=>"width: 257px;"]) !!}</td>
                                        <td class="form-group"> {!!Form::text('Treatments[]',$com_data['Treatment'],['class'=>'form-control input-width-large complication-disabled']) !!}</td>
                                        <td class="form-group"> {!!Form::text('duration_in_weeks[]',$com_data['duration_in_weeks'],['class'=>'form-control input-width-medium complication-disabled','id' => 'duration_in_weeks']) !!}</td>
                                        <td class="form-group"> {!!Form::select('duration_unit[]',ValuelistHelpers::getdurationUnit(),$com_data['duration_unit'],['class'=>'form-control input-width-medium complication-disabled']) !!}</td>
                                    </tr>
                                    @php $l++; @endphp
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="form-group">{!! Form::select('Complication[]',[''=>'N/A']+$complications,null,["class"=>"complication-disabled complication-search","id"=>"complication-search-0", "style"=>"width: 257px;"]) !!}</td>
                                        <td class="form-group"> {!!Form::text('Treatments[]',null,['class'=>'form-control input-width-large complication-disabled']) !!}</td>
                                        <td class="form-group"> {!!Form::text('duration_in_weeks[]',null,['class'=>'form-control input-width-medium complication-disabled','id' => 'duration_in_weeks']) !!}</td>
                                        <td class="form-group"> {!!Form::select('duration_unit[]',ValuelistHelpers::getdurationUnit(),null,['class'=>'form-control input-width-medium complication-disabled']) !!}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                            <table>
                                <tbody>
                                    <tr>
                                        <td colspan="4"><label for="duration_in_weeks" generated="true" class="error help-block"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <h3><br><u><b>Antenatal Ultrasound Findings</b></u> </h3>
                </div>
                <div class="col-md-9">
                    <div class="col-md-7 plr-0 form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="usg table table-add-more full-width-fix">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="bg-theme">Dating Scan</th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h5><strong>Gestation In Weeks</strong></h5>
                                        </th>
                                        <th>
                                            <h5><strong>Findings</strong></h5>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="form-group"><input type="text" value="{{ @$datingScan['Gestation'] }}" class="form-control input-width-medium"  name="datinggestations" /></td>
                                        <td class="form-group"><input type="text" value="{{ @$datingScan['Finding'] }}" name="datingfindings" class="form-control input-width-large"  /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label for="datinggestations" generated="true" class="error help-block"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-7 plr-0 form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="usg table table-add-more full-width-fix">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="bg-theme">Anomaly Scan</th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <h5><strong>Gestation In Weeks</strong></h5>
                                        </th>
                                        <th>
                                            <h5><strong>Findings</strong></h5>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td  class="form-group"><input type="text" name="analoggestations" value="{{ @$analogScan['Gestation'] }}" class="form-control input-width-medium" /></td>
                                        <td  class="form-group"><input type="text" name="analogfindings"   value="{{ @$analogScan['Finding'] }}"  class="form-control input-width-large"  /></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><label for="analoggestations" generated="true" class="error help-block"></label></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="col-md-7 plr-0 form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="any-further-scan usg table table-add-more full-width-fix">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="bg-theme">Any further scan ?</th>
                                    </tr>
                                    <tr class="master-add-header">
                                        <th>Gestation In Weeks</th>
                                        <th>Findings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($otherScan) && is_array($otherScan) && count($otherScan) > 0)
                                    @foreach($otherScan as $scanKey => $scanValue)
                                    <tr>
                                        <td  class="form-group"><input type="text" value="{{ @unserialize($scanValue['Gestation']) !== false ? '' : $scanValue['Gestation'] }}" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                        <td  class="form-group"><input type="text" value="{{ @unserialize($scanValue['Finding']) !== false ? '' : $scanValue['Finding'] }}" name="otherfindings[]" class="form-control input-width-large"  /></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="othergestations[]" /></td>
                                        <td  class="form-group"><input type="text" name="otherfindings[]" class="form-control input-width-large"  /></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <span><label for="othergestations[]" generated="true" class="error help-block"></label></span>
                </div>
                <div class="col-md-9 bottom-specing">
                    <div class="col-md-7 plr-0 form-group row">
                        <div class="col-md-12 custom-input">
                            <table class="doppler-scan usg table table-add-more full-width-fix">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="bg-theme">Doppler Scan</th>
                                    </tr>
                                    <tr class="master-add-header">
                                        <th>Gestation In Weeks</th>
                                        <th>Findings</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($dopplerScan) && is_array($dopplerScan) && count($dopplerScan) > 0)
                                    @foreach($dopplerScan as $dopplerKey => $dopplerValue)
                                    <tr>
                                        <td  class="form-group"><input type="text" value="{{ $dopplerValue['Gestation'] }}" class="form-control input-width-medium"  name="dopplergestations[]"/></td>
                                        <td  class="form-group"><input type="text"  value="{{ $dopplerValue['Finding']  }}" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td  class="form-group"><input type="text" class="form-control input-width-medium"  name="dopplergestations[]" /></td>
                                        <td  class="form-group"><input type="text" name="dopplerfindings[]" class="form-control input-width-large"  /></td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <span><label for="dopplergestations[]" generated="true" class="error help-block"></label></span>
                </div>
            </div>
        </div>
    </div>
    <!-- Labour Form -->
    <div role="tabpanel" class="tab-pane top-specing" id="labform">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('AntenatalSteroids','Antenatal Steroids:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('AntenatalSteroids',[''=>'N/A','No'=>'No', 'Yes'=>'Yes'], null,['class'=>'form-control']) !!}                   
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('antenatal_MgSO4','Antenatal MgSO4 For Neuroprotection:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('antenatal_MgSO4',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('typeofsteroids','Type of Steroids:',['class'=>'title']) !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('typeofsteroids', [''=>'N/A','Dexa'=>'Dexa','Beta'=>'Beta'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('LastDoseDeliveryInterval','Last Dose Delivery Interval:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('LastDoseDeliveryInterval', [ "" => "N/A", "< 24 hrs" => '< 24 hrs','24 hrs - 7 days'=>'24 hrs - 7 days',  "> 7 days" => "> 7 days"],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('SteroidCourse','Steroid Course:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('SteroidCourse',[''=>'N/A','Complete'=>'Complete','Partial/Incomplete'=>'Partial/Incomplete','Multiple'=>'Multiple'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Labour','Labour:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Labour',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('NatureofLabour','Nature of Labour:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('NatureofLabour',[''=>'N/A','Spontaneous'=>'Spontaneous','Induced'=>'Induced'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Syntocinon','Syntocinon:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Syntocinon',[''=>'N/A']+ValuelistHelpers::getSyntocinon(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CommentOnLiquor','Comment On Liquor:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('CommentOnLiquor',[''=>'N/A','Clear'=>'Clear','Meconium Stained'=>'Meconium Stained','Blood Stained'=>'Blood Stained','Foul Smelling'=>'Foul Smelling'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('sepsis_in_mother',' Risk Factors For Sepsis In Mothers:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('sepsis_in_mother', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control"> 
                            {!! Form::label('sepsis_in_mother_type','Risk Factors:') !!}
                            {!! Form::hidden('sepsis_in_mother_type[]','0')  !!}
                            <br>
                        </div>
                        <div class="col-md-9 custom-input">
                            @php $sepsis_in_mother_type = isset($results->sepsis_in_mother_type) && is_array($results->sepsis_in_mother_type) ? $results->sepsis_in_mother_type : [0];  @endphp  
                            @php $sepsis_in_mother_type1 = in_array('1', $sepsis_in_mother_type) ? true : false; @endphp  
                            @php $sepsis_in_mother_type2 = in_array('2', $sepsis_in_mother_type) ? true : false; @endphp  
                            @php $sepsis_in_mother_type3 = in_array('3', $sepsis_in_mother_type) ? true : false; @endphp  
                            @php $sepsis_in_mother_type4 = in_array('4', $sepsis_in_mother_type) ? true : false; @endphp  
                            @php $sepsis_in_mother_type5 = in_array('5', $sepsis_in_mother_type) ? true : false; @endphp  
                            @php $sepsis_in_mother_type6 = in_array('6', $sepsis_in_mother_type) ? true : false; @endphp  
                            <div>
                                {!! Form::checkbox('sepsis_in_mother_type[]','1',$sepsis_in_mother_type1) !!}
                                {!! Form::label('chorioamnionitis','Chorioamnionitis',['class'=>'title']) !!}
                            </div>
                            <div>
                                {!! Form::checkbox('sepsis_in_mother_type[]','2',$sepsis_in_mother_type2) !!}
                                {!! Form::label('unclean_vaginal_examination','Unclean vaginal examination / > 3 PV examination',['class'=>'title']) !!}
                            </div>
                            <div>
                                {!! Form::checkbox('sepsis_in_mother_type[]','3',$sepsis_in_mother_type3) !!}
                                {!! Form::label('leaking_pv','Leaking PV > 18hours / pPROM',['class'=>'title']) !!}
                            </div>
                            <div>
                                {!! Form::checkbox('sepsis_in_mother_type[]','4',$sepsis_in_mother_type4) !!}
                                {!! Form::label('gbs_in_maternal_recto-vaginal_swab','GBS in maternal recto-vaginal swab',['class'=>'title']) !!}
                            </div>
                            <div>
                                {!! Form::checkbox('sepsis_in_mother_type[]','5',$sepsis_in_mother_type5) !!}
                                {!! Form::label('uti_in_mother','UTI in mother',['class'=>'title']) !!}
                            </div>
                            <div>
                                {!! Form::checkbox('sepsis_in_mother_type[]','6',$sepsis_in_mother_type6) !!}
                                {!! Form::label('maternal_fever','Maternal fever',['class'=>'title']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MaternalPyrexia','Maternal Pyrexia:') !!}
                        </div>
                        <div class="col-md-9 custom-input">   
                            {!! Form::select('MaternalPyrexia', [''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}                                                      
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('maternal_pyrexia_temp','Maternal Pyrexia Temperature:') !!}
                        </div>
                        @php $order_changed = \SiteHelpers::temperatureOrder(); @endphp
                        <div class="col-md-9 custom-input clear-xs">
                            @if ($order_changed)
                            <div class="row">
                                <div class="col-xs-6">
                                    <small>(In Fahrenheit)</small>
                                </div>
                                <div class="col-xs-6">
                                    <small>(In Celsius)</small>
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::text('maternal_pyrexia_fahrenheit',null,['class'=>'form-control fahrenheit']) !!}
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::text('maternal_pyrexia_celsius',null,['class'=>'form-control celsius']) !!}
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-xs-6">
                                    <small>(In Celsius)</small>
                                </div>
                                <div class="col-xs-6">
                                    <small>(In Fahrenheit)</small>
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::text('maternal_pyrexia_celsius',null,['class'=>'form-control celsius']) !!}
                                </div>
                                <div class="col-xs-6">
                                    {!! Form::text('maternal_pyrexia_fahrenheit',null,['class'=>'form-control fahrenheit']) !!}
                                </div>
                            </div>
                            @endif
                            <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PROM','PROM:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('PROM',[''=>'N/A','No'=>'No', 'Yes'=>'Yes'], null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DurationOfROM','Duration Of PROM:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('DurationOfROM',['' => 'N/A','Less than 6 hrs' => 'Less than 6 hrs','6 - 12' => '6 - 12','12 - 18' => '12- 18','18 - 24' => '18 - 24','More than 24 ' => 'More than 24 ','Unknown' => 'Unknown'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    @php $maternal_status=[''=>'N/A', 'Not known'=>'Not known','No'=>'No','Yes'=>'Yes'] @endphp
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Maternal_antibiotics_status','Maternal Antibiotics:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('Maternal_antibiotics_status',$maternal_status,null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row Maternal_antibiotics_status">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MaternalAntibiotics','Maternal Antibiotics Type:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <table class="MaternalAntibiotics table table-add-more full-width-fix">
                                <thead>
                                    <tr class="master-add-header">
                                        <th class="full-width">
                                            <i class="fa fa-reorder"></i>Add More
                                        </th>
                                    </tr>
                                </thead>
                                @php $maternal_antibiotics = isset($results->MaternalAntibiotics) ? json_decode($results->MaternalAntibiotics) : array(); @endphp    
                                <tbody>
                                    @if(isset($maternal_antibiotics) && count($maternal_antibiotics) > 0)
                                    @foreach($maternal_antibiotics as $antibiotics)
                                    <tr>
                                        <td class="form-group full-width">{!! Form::text('MaternalAntibiotics[]',$antibiotics,['class'=>'form-control ']) !!}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="full-width">{!! Form::text('MaternalAntibiotics[]','',['class'=>'form-control ']) !!}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('TimeofLastDose','Time of Last Dose:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('TimeofLastDose',['' => 'N/A','Less than 4 hours' => 'Less than 4 hours','More than 4 hours' => 'More than 4 hours','Unknown' => 'Unknown'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delivery Form -->
    <div role="tabpanel" class="tab-pane top-specing" id="delform">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ModeOfDelivery','Mode Of Delivery:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('ModeOfDelivery',[""=>"N/A","Normal Vaginal"=>"Normal Vaginal","Preterm Vaginal"=>"Preterm Vaginal","Forceps"=>"Forceps","Ventouse"=>"Ventouse","Assisted Breech"=>"Assisted Breech","Emergency Caesarian"=>"Emergency Caesarian","Elective Caesarian"=>"Elective Caesarian","Caesarian"=>"Caesarian"],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="hidden">
                        {!! Form::select('temp_indication',$delivery_indications,null) !!}
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Indication','Indication:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            <table class="indication-add table table-add-more add-border-bottom">
                                <thead>
                                    <tr class="master-add-header">
                                        <th class="full-width">
                                            <i class="fa fa-reorder"></i>Add More
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $indication = isset($results->Indication) ? json_decode($results->Indication) : array(); $i = 0; @endphp
                                    @if(isset($indication) && count($indication) > 0) 
                                    @foreach($indication as $indication_value)
                                    <tr>
                                        <td class="full-width">{!! Form::select('Indication[]',['N/A'=>'N/A']+$delivery_indications,$indication_value,['class'=>'delivery-indications-search full-width', 'id'=>'delivery-indications-search-'.$i]) !!}</td>
                                    </tr>
                                    @php  $i++; @endphp
                                    @endforeach
                                    @else
                                    <tr>
                                        <td class="full-width">{!! Form::select('Indication[]',['N/A'=>'N/A']+$delivery_indications,null,['class'=>'delivery-indications-search full-width', 'id'=>'delivery-indications-search-0']) !!}</td>
                                    </tr>
                                    @endif 
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Presentation','Presentation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Presentation',[""=>"N/A","Not Known"=>"Not Known","Cephalic"=>"Cephalic","Breech"=>"Breech","Twins"=>"Twins","Transverse Lie"=>"Transverse Lie","Other"=>"Other"],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('FoetalDistress','Fetal Distress:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('FoetalDistress',[""=>"N/A",'Not Known'=>'Not Known','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CTG','CTG:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('CTG',[""=>"N/A","Normal"=>"Normal","Abnormal"=>"Abnormal","Not Known"=>"Not Known"],null,['class'=>'form-control','id' => 'CTG','data-color'=>ValuelistHelpers::setColorvalue('reactive',4)]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CTGDetails','CTG Details:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('CTGDetails',null,['class'=>'form-control','id' => 'CTGDetails']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CordBloodGas','Cord Blood Gas:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('CordBloodGas',[""=>"N/A","Not done"=>"Not done","Not indicated"=>"Not indicated","Arterial"=>"Arterial","Venous"=>"Venous","Capillary"=>"Capillary"],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CordpH','Cord pH:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('CordpH',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CordHCO3','Cord HCO3:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('CordHCO3',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CordBE','Cord BE:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('CordBE',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('TypeofAnesthesia','Type of Anesthesia:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('TypeofAnesthesia',[""=>"N/A","Local"=>"Local","Spinal"=>"Spinal","Epidural"=>"Epidural","General"=>"General","None"=>"None"],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('GastricAspirate','Gastric Aspirate:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('GastricAspirate',[''=>'N/A']+ValuelistHelpers::GastricAspirate(),null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('delayed_cord_clamping','Delayed Cord Clamping:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('delayed_cord_clamping',[''=>'N/A']+ValuelistHelpers::get_comman_options(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('Delayedcord',4)]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('reason_dcc','Reason for No DCC:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('reason_dcc',null,['class'=>'form-control'])!!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('duration_dcc','Duration of DCC (seconds):') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::text('duration_dcc',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('umbilicalcordmilking','Umbilical Cord Milking:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('umbilicalcordmilking',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('cutcordmilking','Cut Cord Milking:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('cutcordmilking',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Apgar Form -->
    <div role="tabpanel" class="tab-pane top-specing" id="apgarform">
        <div class="col-md-12 overflow-auto">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group">
                        {!! Form::label('known_field','APGAR:', ['class' => 'control-label']) !!}
                        {!! Form::select('known_field',[''=>'N/A', '1'=>'Known', '2'=>'Unknown'],null, ['class'=>'form-control']) !!}
                        <br><br>
                    </div>
                    <div class="form-group dispaly_apgar">
                        <table>
                            <tr>
                                <td></td>
                                <td><strong>1 minute</strong></td>
                                <td><strong>5 minutes</strong></td>
                                <td><strong>10 minutes</strong></td>
                                <td><strong>15 minutes</strong></td>
                                <td><strong>20 minutes</strong></td>
                            </tr>
                            <tr>
                                <td>Colour</td>
                                <td> {!! Form::select('Colour1',[''=>'N/A']+ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour1','type'=>'numeric','onchange'=>"Calculate(1);"]) !!}</td>
                                <td> {!! Form::select('Colour5',[''=>'N/A']+ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour5','onchange'=>"Calculate(5);"]) !!}</td>
                                <td> {!! Form::select('Colour10',[''=>'N/A']+ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour10','onchange'=>"Calculate(10);"]) !!}</td>
                                <td> {!! Form::select('Colour15',[''=>'N/A']+ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour15','onchange'=>"Calculate(15);"]) !!}</td>
                                <td> {!! Form::select('Colour20',[''=>'N/A']+ValuelistHelpers::getApgarScore('colour'),null,['class'=>'form-control','id'=>'Colour20','onchange'=>"Calculate(20);"]) !!}</td>
                            </tr>
                            <tr>
                                <td>HR</td>
                                <td> {!! Form::select('HR1',[''=>'N/A']+ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR1','onchange'=>"Calculate(1);"]) !!}</td>
                                <td> {!! Form::select('HR5',[''=>'N/A']+ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR5','onchange'=>"Calculate(5);"]) !!}</td>
                                <td> {!! Form::select('HR10',[''=>'N/A']+ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR10','onchange'=>"Calculate(10);"]) !!}</td>
                                <td> {!! Form::select('HR15',[''=>'N/A']+ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR15','onchange'=>"Calculate(15);"]) !!}</td>
                                <td> {!! Form::select('HR20',[''=>'N/A']+ValuelistHelpers::getApgarScore('hr'),null,['class'=>'form-control','id'=>'HR20','onchange'=>"Calculate(20);"]) !!}</td>
                            </tr>
                            <tr>
                                <td>Reflex</td>
                                <td> {!! Form::select('Reflex1',[''=>'N/A']+ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex1','onchange'=>"Calculate(1);"]) !!}</td>
                                <td> {!! Form::select('Reflex5',[''=>'N/A']+ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex5','onchange'=>"Calculate(5);"]) !!}</td>
                                <td> {!! Form::select('Reflex10',[''=>'N/A']+ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex10','onchange'=>"Calculate(10);"]) !!}</td>
                                <td> {!! Form::select('Reflex15',[''=>'N/A']+ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex15','onchange'=>"Calculate(15);"]) !!}</td>
                                <td> {!! Form::select('Reflex20',[''=>'N/A']+ValuelistHelpers::getApgarScore('reflex'),null,['class'=>'form-control','id'=>'Reflex20','onchange'=>"Calculate(20);"]) !!}</td>
                            </tr>
                            <tr>
                                <td>Tone</td>
                                <td> {!! Form::select('Tone1',[''=>'N/A']+ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone1','onchange'=>"Calculate(1);"]) !!}</td>
                                <td> {!! Form::select('Tone5',[''=>'N/A']+ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone5','onchange'=>"Calculate(5);"]) !!}</td>
                                <td> {!! Form::select('Tone10',[''=>'N/A']+ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone10','onchange'=>"Calculate(10);"]) !!}</td>
                                <td> {!! Form::select('Tone15',[''=>'N/A']+ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone15','onchange'=>"Calculate(15);"]) !!}</td>
                                <td> {!! Form::select('Tone20',[''=>'N/A']+ValuelistHelpers::getApgarScore('tone'),null,['class'=>'form-control','id'=>'Tone20','onchange'=>"Calculate(20);"]) !!}</td>
                            </tr>
                            <tr>
                                <td>Respiration</td>
                                <td> {!! Form::select('Respiration1',[''=>'N/A']+ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration1','onchange'=>"Calculate(1);"]) !!}</td>
                                <td> {!! Form::select('Respiration5',[''=>'N/A']+ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration5','onchange'=>"Calculate(5);"]) !!}</td>
                                <td> {!! Form::select('Respiration10',[''=>'N/A']+ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration10','onchange'=>"Calculate(10);"]) !!}</td>
                                <td> {!! Form::select('Respiration15',[''=>'N/A']+ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration15','onchange'=>"Calculate(15);"]) !!}</td>
                                <td> {!! Form::select('Respiration20',[''=>'N/A']+ValuelistHelpers::getApgarScore('respiration'),null,['class'=>'form-control','id'=>'Respiration20','onchange'=>"Calculate(20);"]) !!}</td>
                            </tr>
                            <tr></tr>
                            <tr>
                                <td>Total</td>
                                <td> {!! Form::text('Apgars1min',null,['class'=>'form-control Apgars1min total1min']) !!}</td>
                                <td> {!! Form::text('Apgars5min',null,['class'=>'form-control Apgars5min total5min']) !!}</td>
                                <td> {!! Form::text('Apgars10min',null,['class'=>'form-control Apgars10min total10min']) !!}</td>
                                <td> {!! Form::text('Apgars15min',null,['class'=>'form-control Apgars15min total15min']) !!}</td>
                                <td> {!! Form::text('Apgars20min',null,['class'=>'form-control Apgars20min total20min']) !!}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><label for="Apgars1min" generated="true" class="error help-block"></label></td>
                                <td><label for="Apgars5min" generated="true" class="error help-block"></label></td>
                                <td><label for="Apgars10min" generated="true" class="error help-block"></label></td>
                                <td><label for="Apgars15min" generated="true" class="error help-block"></label></td>
                                <td><label for="Apgars20min" generated="true" class="error help-block"></label></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td align="left"><span class="btn btn-xs 1min_reset" onclick="ResetData('1min_reset')">Reset</span></td>
                                <td align="left"><span class="btn btn-xs  5min_reset" onclick="ResetData('5min_reset')">Reset</span></td>
                                <td align="left"><span class="btn btn-xs 10min_reset" onclick="ResetData('10min_reset')">Reset</span></td>
                                <td align="left"><span class="btn btn-xs 15min_reset" onclick="ResetData('15min_reset')">Reset</span></td>
                                <td align="left"><span class="btn btn-xs  20min_reset" onclick="ResetData('20min_reset')">Reset</span></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Resuscitation Form -->
    <div role="tabpanel" class="tab-pane top-specing" id="resform">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('FacialOxygen','Facial Oxygen:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('FacialOxygen', [''=>'N/A', 'No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DurationOfOxygen','Duration of Oxygen (min):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('DurationOfOxygen',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('maximum_fio2_required','Maximum FiO2 required (%):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('maximum_fio2_required',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Resuscitation','Resuscitation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('Resuscitation',[''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('initial_steps', 'Initial Steps:')!!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('initial_steps',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    @if (isset($results->timeofgasp_status) && $results->timeofgasp_status == 1) 
                    @php $results->timeofgasp_status = 'Known'; @endphp
                    @elseif (isset($results->timeofgasp_status) && $results->timeofgasp_status == 0)
                    @php $results->timeofgasp_status = 'Unknown'; @endphp
                    @endif
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('timeofgasp_status','Time of 1st Gasp:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('timeofgasp_status', [''=>'N/A','Known'=>'Known','Unknown'=>'Unknown'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('TimeOf1stGasp','Time of 1st Gasp (min):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('TimeOf1stGasp',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    @if (isset($results->regularrespiration_status) && $results->regularrespiration_status == 1)
                    @php $results->regularrespiration_status = 'Known'; @endphp
                    @elseif (isset($results->regularrespiration_status) && $results->regularrespiration_status == 0)
                    @php $results->regularrespiration_status = 'Unknown'; @endphp
                    @endif
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('regularrespiration_status','Regular Respiration:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('regularrespiration_status', [''=>'N/A','Known'=>'Known','Unknown'=>'Unknown'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('RegularRespiration','Regular Respiration (min):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('RegularRespiration',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('delivery_room_cpap','Delivery Room CPAP:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('delivery_room_cpap',[''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('bag_mask_ventilator','Bag Mask Ventilation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('bag_mask_ventilator',[''=>'N/A', 'No'=>'No', 'Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {{ Form::label('bag_mask_ventilator_duration', 'Bag Mask Ventilation Duration:') }}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('bag_mask_ventilator_duration', [''=>'N/A', 'known'=>'Known', 'Unknown'=>'Unknown'],null,['class'=>'form-control'])  !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('bag_mask_ventilator_min','Bag Mask Ventilator Min:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('bag_mask_ventilator_min',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group row ">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Intubation','Intubation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('Intubation',[''=>'N/A', 'No'=>'No','Yes'=>'Yes'], null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ETTSize','ETT Size (mm):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('ETTSize',[''=>'N/A','0'=>'None','2.0'=>'2.0','2.5'=>'2.5','3.0'=>'3.0','3.5'=>'3.5','4.0'=>'4.0'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    @if (isset($results->insertion_status) && $results->insertion_status == 1)
                    @php $results->insertion_status = 'Known'; @endphp
                    @elseif (isset($results->insertion_status) && $results->insertion_status == 0)
                    @php $results->insertion_status = 'Unknown'; @endphp
                    @endif
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('insertion_status','Depth Of Insertion:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('insertion_status',[''=>'N/A','Known'=>'Known','Unknown'=>'Unknown'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DepthOfInsertion','Depth Of Insertion (cm):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('DepthOfInsertion',null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('PPV','PPV (BTV):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('PPV',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    @if (isset($results->ppv_status) && $results->ppv_status == 1)
                    @php $results->ppv_status = 'Known'; @endphp
                    @elseif (isset($results->ppv_status) && $results->ppv_status == 0)
                    @php $results->ppv_status = 'Unknown'; @endphp
                    @endif
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ppv_status','Duration of PPV:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('ppv_status',[''=>'N/A','Known'=>'Known','Unknown'=>'Unknown'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DurationOfPPV','Duration of PPV (min):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('DurationOfPPV',null,['class'=>'form-control ', 'onkeypress' => 'return ISNumber(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('CPR','CPR:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('CPR', [''=>'N/A', 'No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    @if (isset($results->cpr_status) && $results->cpr_status == 1)
                    @php $results->cpr_status = 'Known'; @endphp
                    @elseif (isset($results->cpr_status) && $results->cpr_status == 0)
                    @php $results->cpr_status = 'Unknown'; @endphp
                    @endif
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('cpr_status','Duration of CPR:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('cpr_status',[''=>'N/A', 'Known'=>'Known', 'Unknown'=>'Unknown'],null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('duration_of_cpr','Duration of CPR (min):') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::text('duration_of_cpr',null,['class'=>'form-control', 'onkeypress' => 'return ISNumber(event);']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Drugs','Drugs:') !!}
                        </div>
                        <div class="col-md-9 custom-input">  
                            {!! Form::select('Drugs',[''=>'N/A', 'No'=>'No','Yes'=>'Yes'], null, ['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="hidden">
                        {!! Form::select('temp_resusciatation_drugs',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),null) !!}
                    </div>
                    <div class="col-md-10 plr-0">
                        <div class="form-group row drug-main">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('Drug','Drugs:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                <table class="drugs table table-add-more full-width-fix">
                                    <thead>
                                        <tr class="master-add-header">
                                            <th class="full-width">
                                                <i class="fa fa-reorder"></i>Add More
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $resusciatation_drugs = isset($results->resusciatation_drugs) ? json_decode($results->resusciatation_drugs) : array() @endphp
                                        @if (isset($resusciatation_drugs) && count($resusciatation_drugs) > 0)
                                        @foreach ($resusciatation_drugs as $data)
                                        <tr>
                                            <td  class="form-group">
                                                {!! Form::select('resusciatation_drugs[]',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),$data,["class"=>"form-control input-width-xlarge"]) !!}
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td  class="form-group">
                                                {!! Form::select('resusciatation_drugs[]',[''=>'N/A']+ValuelistHelpers::resuscitationMedication(),null,["class"=>"form-control input-width-xlarge"]) !!}
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('OtherInformation','Resuscitation Details:') !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::textarea('OtherInformation',null,['class'=>'form-control','rows'=>'5']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Essential Form -->
    <div role="tabpanel" class="tab-pane top-specing" id="essform">
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="">
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('VitaminK','VitaminK:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('VitaminK',[''=>'N/A','Not known'=>'Not known','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('vitamin_k',4)]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('DoseVitK','Dose VitK:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('DoseVitK',[''=>'N/A','1 mg'=>'1 mg','0.5 mg'=>'0.5 mg'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-3 text-right label-control">
                                {!! Form::label('RouteVitK','Route VitK:') !!}
                            </div>
                            <div class="col-md-9 custom-input">
                                {!! Form::select('RouteVitK',[''=>'N/A','IM'=>'IM','IV'=>'IV','Oral'=>'Oral'],null,['class'=>'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('InitialExamination','Summary of Initial Examination Following Birth:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('InitialExamination',null,['class'=>'form-control','rows'=>'5']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('Malformation','Malformation:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('Malformation',[''=>'N/A','No'=>'No','Yes'=>'Yes'],null,['class'=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('MalformationType','Malformation Type:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::textarea('MalformationType',null,['class'=>'form-control','rows'=>'5']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('ict','ICT:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('ict',[''=>'N/A']+ValuelistHelpers::Ict(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('ict',4)]) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3 text-right label-control">
                            {!! Form::label('DCT','DCT:') !!}
                        </div>
                        <div class="col-md-9 custom-input">
                            {!! Form::select('DCT',[''=>'N/A']+ValuelistHelpers::Dct(),null,['class'=>'form-control','data-color'=>ValuelistHelpers::setColorvalue('dct',4)]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12 col-sm-12">
            <div class="mt-10 widget box">
                <div class="widget-header">
                    <h4><i class="fa fa-reorder"></i> </h4>
                </div>
                <div class="widget-content">
                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('Background','Background:') !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::textarea('Background',null,['class'=>'form-control','rows'=>'5']) !!}
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            {!! Form::label('PLAN','PLAN:') !!}
                        </div>
                        <div class="col-md-12">
                            {!! Form::textarea('PLAN',null,['class'=>'form-control','rows'=>'5']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- New Born Examination -->
    <div role="tabpanel" class="tab-pane top-specing" id="newbornform">
        <div class="tabbable tabbable-custom mlr-5">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"  class="active">
                    <a class="tab-sub-menu" href="#vitals" aria-controls="vitals" role="tab" data-toggle="tab">VITALS</a>
                </li>
                <li role="presentation">
                    <a class="tab-sub-menu" href="#gpe" aria-controls="gpe" role="tab" data-toggle="tab">GPE</a>
                </li>
                <li role="presentation">
                    <a class="tab-sub-menu" href="#cvs" aria-controls="cvs" role="tab" data-toggle="tab">CVS</a>
                </li>
                <li role="presentation">
                    <a class="tab-sub-menu" href="#rs" aria-controls="rs" role="tab" data-toggle="tab">RS</a>
                </li>
                <li role="presentation">
                    <a class="tab-sub-menu" href="#abdomen" aria-controls="abdomen" role="tab" data-toggle="tab">ABDOMEN</a>
                </li>
                <li role="presentation">
                    <a class="tab-sub-menu" href="#cns" aria-controls="cns" role="tab" data-toggle="tab">CNS</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content mb-20">
                <div role="tabpanel" class="tab-pane top-specing active" id="vitals">
                    <div class=" col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NbHR','HR in bpm:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('NbHR',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NbRR','RR:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('NbRR',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-8 text-right label-control">
                                        {!! Form::label('newbornStatus','Is the rest of the newborn examination normal ?') !!}
                                    </div>
                                    <div class="col-md-3 custom-input">
                                        {!! Form::select('newbornStatus', ['0'=>'N/A','1'=>'No','2'=>'Yes'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CentralPulses','Central Pulses:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('CentralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NbCFT','CFT:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NbCFT',[''=>'N/A','< 3 Seconds' => "< 3 Seconds",'3-5 Seconds' => "3-5 Seconds",'>5 Seconds' => ">5 Seconds","Prolonged"=>"Prolonged"],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('TemperatureF','Temperature (F/C):') !!}
                                    </div>
                                    @php $order_changed = \SiteHelpers::temperatureOrder(); @endphp
                                    <div class="col-md-9 custom-input clear-xs">
                                        @if ($order_changed)
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Fahrenheit)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Celsius)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::text('','',['class'=>'form-control fahrenheit']) !!}
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::text('TemperatureF',null,['class'=>'form-control celsius']) !!}
                                            </div>
                                        </div>
                                        @else
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <small>(In Celsius)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                <small>(In Fahrenheit)</small>
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::text('TemperatureF',null,['class'=>'form-control celsius']) !!}
                                            </div>
                                            <div class="col-xs-6">
                                                {!! Form::text('','',['class'=>'form-control fahrenheit']) !!}
                                            </div>
                                        </div>
                                        @endif
                                        <label class="error help-block" for="BirthWeight" generated="true" style="display: none;"></label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NbSpO2','SpO2:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('NbSpO2',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PeripheralPulses','Peripheral Pulses:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PeripheralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Colour','Colour:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Colour',[''=>'N/A','Yellow'=>'Yellow','Pink'=>'Pink','Acral Cyanosis'=>'Acral Cyanosis','Central Cyanosis'=>'Central Cyanosis'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane top-specing" id="gpe">
                    <div class=" col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Pallor','Pallor:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Pallor',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="hidden">
                                    {!! Form::select('tempscalp',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],null,['class'=>'form-control input-width-large']) !!}
                                </div>
                                <div class="form-group">
                                    <div class="form-group row">
                                        <div class="col-md-3 text-right label-control">
                                            {!! Form::label('Scalp','Scalp:') !!}
                                        </div>
                                        <div class="col-md-9 custom-input">
                                            <table class="scalp-content table table-add-more full-width-fix">
                                                <thead>
                                                    <tr class="master-add-header">
                                                        <th class="full-width">
                                                            <i class="fa fa-reorder"></i>Add More
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if(isset($results->Scalp) && count($results->Scalp) > 0)
                                                    @foreach($results->Scalp as $key => $scalpValue)
                                                    <tr>
                                                        <td class="full-width">{!! Form::select('Scalp[]',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],$scalpValue,['class'=>'form-control']) !!}</td>
                                                    </tr>
                                                    @endforeach  
                                                    @else
                                                    <tr>
                                                        <td class="full-width">{!! Form::select('Scalp[]',[''=>'N/A','Normal'=>'Normal',"Caput Succedaneum"=>"Caput Succedaneum","Cephalhematoma"=>"Cephalhematoma","Bruises"=>"Bruises","Laceration"=>"Laceration"],null,['class'=>'form-control']) !!}</td>
                                                    </tr>
                                                    @endif 
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Eyes','Eyes:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Eyes',[''=>'N/A','Normal with Red reflex'=>'Normal with Red reflex','Subconjunctival Hemorrhage'=>'Subconjunctival Hemorrhage','Cataract'=>'Cataract','Microophthalmos'=>'Microophthalmos'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Ears','Ears:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Ears',[''=>'N/A','Normal'=>'Normal','Low Set'=>'Low Set','Preauricular tag Rt'=>'Preauricular tag Rt','Preauricular tag Lt'=>'Preauricular tag Lt','Preauricular tag Bilateral'=>'Preauricular tag Bilateral'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Nose','Nose:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Nose',[''=>'N/A','Normal'=>'Normal','Depressed nasal bridge'=>'Depressed nasal bridge'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Nostrils','Nostrils:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Nostrils',[''=>'N/A','Patent'=>'Patent','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Rt'=>'Choanal Atresia Rt','Choanal Atresia Lt'=>'Choanal Atresia Lt','Choanal Atresia Bilateral'=>'Choanal Atresia Bilateral'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Lips','Lips:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Lips',[''=>'N/A','Normal'=>'Normal','Cleft Lip'=>'Cleft Lip'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Palate','Palate:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Palate',[''=>'N/A','Normal'=>'Normal','Cleft Palate'=>'Cleft Palate'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Neck','Neck:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Neck',[''=>'N/A','Normal'=>'Normal','Cystic Hygroma'=>'Cystic Hygroma','Sternomastoid tumor'=>'Sternomastoid tumor'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Nipples','Nipples:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Nipples',[''=>'N/A','Normal'=>'Normal','Supernumerary'=>'Supernumerary'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Esophagus','Esophagus:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Esophagus',[''=>'N/A','Patent'=>'Patent','TEF/Atresia'=>'TEF/Atresia'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Umbilicus','Umbilicus:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Umbilicus',[''=>'N/A','Normal'=>'Normal','Omphalocele'=>'Omphalocele','Gastroschisis'=>'Gastroschisis','Hernia'=>'Hernia','Meconium Stained' => 'Meconium Stained','Large' => 'Large','Shrivelled' => 'Shrivelled'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('UmbilicalCord','UmbilicalCord:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('UmbilicalCord',[''=>'N/A','Normal'=>'Normal','Single Umbilical Artery'=>'Single Umbilical Artery'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AnteriorFontanelle','Anterior Fontanelle:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AnteriorFontanelle',[''=>'N/A','Normal'=>'Normal','Depressed'=>'Depressed','Bulging'=>'Bulging'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Jaundice','Jaundice:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Jaundice',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('HernialOrifices','Hernial Orifices:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('HernialOrifices',[''=>'N/A','No hernia'=>'No hernia','Right Inguinal hernia'=>'Right Inguinal hernia','Left Inguinal hernia'=>'Left Inguinal hernia','Umbilical/para umbilical hernia'=>'Umbilical/para umbilical hernia','Obstructed/strangulated'=>'Obstructed/strangulated'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('FemoralPulses','Femoral Pulses:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('FemoralPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Genitalia','Genitalia:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Genitalia',[''=>'N/A','Normal'=>'Normal','Clitoromegaly'=>'Clitoromegaly','Hypospadias'=>'Hypospadias','Cryptorchidism'=>'Cryptorchidism','Chordee'=>'Chordee','Ambiguous'=>'Ambiguous'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Hips','Hips:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Hips',[''=>'N/A','Normal'=>'Normal','DDH Rt'=>'DDH Rt','DDH Lt'=>'DDH Lt','DDH Bilateral'=>'DDH Bilateral'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Anus','Anus:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Anus',[''=>'N/A','Patent'=>'Patent','Imperforate'=>'Imperforate'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Spine','Spine:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Spine',[''=>'N/A','Normal'=>'Normal','Kyphoscoliosis'=>'Kyphoscoliosis','Sacral dimple'=>'Sacral dimple'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('RtUL','Rt UL:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('RtUL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('RtLL','Rt LL:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('RtLL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('LtUL','Lt UL:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('LtUL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Clinodactyly'=>'Clinodactyly','Single Crease'=>'Single Crease'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('LtLL','Lt LL:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('LtLL',[''=>'N/A','Normal'=>'Normal','Polydactyly'=>'Polydactyly','Syndactyly'=>'Syndactyly','Positional tallipes'=>'Positional tallipes','Fixed tallipes'=>'Fixed tallipes'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Skin','Skin:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Skin',[''=>'N/A','Normal'=>'Normal','Blueberry muffin spots'=>'Blueberry muffin spots','Mongolian spots'=>'Mongolian spots','Erythema toxicum'=>'Erythema toxicum','Milia'=>'Milia','Miliaria'=>'Miliaria'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Hairs','Hairs:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Hairs',[''=>'N/A','Normal'=>'Normal','Alopecia'=>'Alopecia'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AnyOtherAbnormality','Any Other Abnormality:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('AnyOtherAbnormality',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane top-specing" id="cvs">
                    <div class=" col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('PrecordialActivity','Precordial Activity:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('PrecordialActivity',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('ApicalImpulse','Apical Impulse:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('ApicalImpulse',[''=>'N/A','Normal'=>'Normal','Right Side'=>'Right Side'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BoundingPulses','Bounding Pulses:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('BoundingPulses',[''=>'N/A','Normal'=>'Normal','Bounding'=>'Bounding','Feeble/Weak'=>'Feeble/Weak','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('other_cvs_findings','Other CVS findings:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('other_cvs_findings',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('S1S2','S1S2:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('S1S2',[''=>'N/A','Normal'=>'Normal','Abnormal'=>'Abnormal'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Murmur','Murmur:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Murmur',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('CharacterofMurmur','Character of Murmur:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('CharacterofMurmur',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('SiteofMurmur','Site of Murmur:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('SiteofMurmur',[''=>'N/A','N/A'=>'Not applicable','Apical Area'=>'Apical Area','Aortic Area'=>'Aortic Area','Aortic Area'=>'Aortic Area','Pulmonary Area'=>'Pulmonary Area','Tricuspid Area'=>'Tricuspid Area','Rt Parasternal Area'=>'Rt Parasternal Area','Lt Parasternal Area'=>'Lt Parasternal Area'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane top-specing" id="rs">
                    <div class=" col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NbChestMovement','Chest Movement:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NbChestMovement',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('BreathSounds','Breath Sounds:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('BreathSounds',[''=>'N/A','Normal Vesicular'=>'Normal Vesicular','Abnormal'=>'Abnormal'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AirEntry','Air Entry:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AirEntry',[''=>'N/A','Equal'=>'Equal','Reduced Bilateral'=>'Reduced Bilateral','Reduced Rt'=>'Reduced Rt','Reduced Lt'=>'Reduced Lt'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('other_rs_findings','Other RS findings:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('other_rs_findings',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AddedSounds','Added Sounds:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AddedSounds',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control m-0">
                                        {!! Form::label('CharacterOfAddedSounds','Character Of Added Sounds:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('CharacterOfAddedSounds',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control m-0">
                                        {!! Form::label('SiteofAddedSounds','Site of Added Sounds:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('SiteofAddedSounds',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane top-specing" id="abdomen">
                    <div class=" col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('AbdomenShape','Abdomen Shape:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('AbdomenShape',[''=>'N/A','Normal'=>'Normal','Scaphoid'=>'Scaphoid','Distended'=>'Distended'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Hepatomegaly','Hepatomegaly:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Hepatomegaly',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('LiverSpan','Liver Span:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('LiverSpan',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Splenomegaly','Splenomegaly:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Splenomegaly',[''=>'N/A','Present'=>'Present','Absent'=>'Absent'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('SpleenSpan','Spleen Span:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('SpleenSpan',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Flanks','Flanks:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Flanks',[''=>'N/A','Normal'=>'Normal','Full'=>'Full'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('other_pa_findings','Other PA findings:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('other_pa_findings',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane top-specing" id="cns">
                    <div class=" col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('LevelOfConsciousness','Level Of Consciousness:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('LevelOfConsciousness',[''=>'N/A','Normal'=>'Normal','Drowsy'=>'Drowsy','Comatosed'=>'Comatosed','Hyperalert'=>'Hyperalert','Irritable'=>'Irritable'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Seizures','Seizures:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Seizures',[''=>'N/A','Yes'=>'Yes','No'=>'No'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row" id="TypeofSeizureDiv"  {!! @$displaystyle !!}>
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('TypeofSeizure','Type of Seizure:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('TypeofSeizure',[''=>'N/A','Subtle'=>'Subtle','Tonic'=>'Tonic','Clonic'=>'Clonic','Myoclonus'=>'Myoclonus'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('GeneralBodyMovements','General Body Movements:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('GeneralBodyMovements',[''=>'N/A','Symmetrical'=>'Symmetrical','Asymmetrical'=>'Asymmetrical'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('other_cns_findings','Other CNS findings:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::text('other_cns_findings',null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="mt-10 widget box">
                            <div class="widget-header">
                                <h4><i class="fa fa-reorder"></i> </h4>
                            </div>
                            <div class="widget-content">
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('SpontaneousActivity','Spontaneous Activity:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('SpontaneousActivity',[''=>'N/A','Normal'=>'Normal','Decreased'=>'Decreased','Increased'=>'Increased'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('Cry','Cry:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('Cry',[''=>'N/A','Normal consolable'=>'Normal consolable','Abnormal Inconsolable'=>'Abnormal Inconsolable'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NbTone','Tone:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NbTone',[''=>'N/A','Normal'=>'Normal','Hypotonia'=>'Hypotonia','Hypertonia'=>'Hypertonia'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-3 text-right label-control">
                                        {!! Form::label('NeonatalReflexes','Neonatal Reflexes:') !!}
                                    </div>
                                    <div class="col-md-9 custom-input">
                                        {!! Form::select('NeonatalReflexes',[''=>'N/A','Normal'=>'Normal','Suppressed'=>'Suppressed','Absent'=>'Absent','Exaggerated'=>'Exaggerated'],null,['class'=>'form-control']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 mt-15">
        @if(isset($neonatallist) && count($neonatallist) < 1)
        <div class="col-md-6">
            <button type="submit" class="btn btn-primary save-button-shadow btn-block form-control">
                <i class="fa fa-floppy-o"></i> 
                <span>Search</span>
            </button>
        </div>
        @endif
        <div class="col-md-6">
            <a href="{{ action('Registration\NeonatalController@index') }}" class="btn btn-default save-button-shadow btn-block form-control" onclick="$('form')[0].reset();"><i class="fa fa-exclamation-circle"></i> 
                <span>Cancel</span>
            </a>
        </div>
    </div>
</div>
