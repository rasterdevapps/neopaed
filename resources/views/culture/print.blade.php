@extends('print')
@section('content')
<div class="temp-container culture-registry">
	<div class="temp-row">
		<div class="col-md-12">
          <img src="{{ ValuelistHelpers::printPagelogo() }}" >
        </div>
    <div class="col-md-12">
          <h3 class="print-head mt-0 temp">Culture Registry</h3>
        </div>
    </div>
    <div class="col-md-12">
      <div class="content-block mt-must-0">
        <h4>Basic Details</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Baby Name:</span>
              <span class="print-value print-label-value"> {!! $results->BabyName; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">DOB:</span>
              <span class="print-value print-label-value"> {!! date("d-m-Y",strtotime($results->DOB)); !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">{{ Lang::get('home.mrn') }}:</span>
              <span class="print-value print-label-value"> {!! $results->BMrNo; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Date of Collection:</span>
              <span class="print-value print-label-value"> {!! $results->CollectionDate; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Gestation (wks):</span>
              <span class="print-value print-label-value"> {!! $results->Gestation; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Birth Weight (In Gms):</span>
              <span class="print-value print-label-value"> {!! $results->BirthWeight; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Date:</span>
              <span class="print-value print-label-value"> {!! $results->EntryDate; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Seen By:</span>
              <span class="print-value print-label-value"> {!! $results->SeenBy; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Sex:</span>
              <span class="print-value print-label-value"> {!! $results->Sex; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Birth Status:</span>
              <span class="print-value print-label-value"> {!! $results->BirthStatus; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Day Of Life:</span>
              <span class="print-value print-label-value"> {!! $results->DayOfLife; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4></h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Specimen:</span>
              <span class="print-value print-label-value"> {!! $results->Specimen; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Isolate:</span>
              <span class="print-value print-label-value"> {!! $results->Isolate; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Penicillin</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Amoxycillin Clavulanate:</span>
              <span class="print-value print-label-value"> {!! $results->AmoxycillinClavulanate; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Ampicillin Sulbactum:</span>
              <span class="print-value print-label-value"> {!! $results->AmpicillinSulbactum; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Methicillin:</span>
              <span class="print-value print-label-value"> {!! $results->Methicillin; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Piperacillin Tazobactum:</span>
              <span class="print-value print-label-value"> {!! $results->PiperacillinTazobactum; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Carbenicillin:</span>
              <span class="print-value print-label-value"> {!! $results->Carbenicillin; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Penicillin G:</span>
              <span class="print-value print-label-value"> {!! $results->PenicillinG; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Cephalosporins</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Cefotaxime:</span>
              <span class="print-value print-label-value"> {!! $results->Cefotaxime; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Ceftriaxone:</span>
              <span class="print-value print-label-value"> {!! $results->Ceftriaxone; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Cefuroxime:</span>
              <span class="print-value print-label-value"> {!! $results->Cefuroxime; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Cefazolin:</span>
              <span class="print-value print-label-value"> {!! $results->Cefazolin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Cefepime:</span>
              <span class="print-value print-label-value"> {!! $results->Cefepime; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Cefoxitin:</span>
              <span class="print-value print-label-value"> {!! $results->Cefoxitin; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Cefpodoxime:</span>
              <span class="print-value print-label-value"> {!! $results->Cefpodoxime; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Cefaclor:</span>
              <span class="print-value print-label-value"> {!! $results->Cefaclor; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Cefixime:</span>
              <span class="print-value print-label-value"> {!! $results->Cefixime; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Cefoperazone:</span>
              <span class="print-value print-label-value"> {!! $results->Cefoperazone; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Ceftazidime:</span>
              <span class="print-value print-label-value"> {!! $results->Ceftazidime; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Monobactums</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Aztreonam:</span>
              <span class="print-value print-label-value"> {!! $results->Aztreonam; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Carbapenems</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Imipenem:</span>
              <span class="print-value print-label-value"> {!! $results->Imipenem; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Meropenem:</span>
              <span class="print-value print-label-value"> {!! $results->Meropenem; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Faropenem:</span>
              <span class="print-value print-label-value"> {!! $results->Faropenem; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Ertapenem:</span>
              <span class="print-value print-label-value"> {!! $results->Ertapenem; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Aminoglycosides</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Amikacin:</span>
              <span class="print-value print-label-value"> {!! $results->Amikacin; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Gentamicin:</span>
              <span class="print-value print-label-value"> {!! $results->Gentamicin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Tobramycin:</span>
              <span class="print-value print-label-value"> {!! $results->Tobramycin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Netillin:</span>
              <span class="print-value print-label-value"> {!! $results->Netillin; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Macrolides</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Azithromycin:</span>
              <span class="print-value print-label-value"> {!! $results->Azithromycin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Erythromycin:</span>
              <span class="print-value print-label-value"> {!! $results->Erythromycin; !!}</span>
            </div>
          </div>
        </div>
      </div>    
      <div class="content-block">
        <h4>Fluoroquinolones</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Ciprofloxation:</span>
              <span class="print-value print-label-value"> {!! $results->Clindamycin; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Levofloxacin:</span>
              <span class="print-value print-label-value"> {!! $results->Levofloxacin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Ofloxacin:</span>
              <span class="print-value print-label-value"> {!! $results->Ofloxacin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Norfloxacin:</span>
              <span class="print-value print-label-value"> {!! $results->Norfloxacin; !!}</span>
            </div>
          </div>
        </div>
      </div>   
      <div class="content-block">
        <h4>Sulphonamides</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Co Trimoxazole:</span>
              <span class="print-value print-label-value"> {!! $results->CoTrimoxazole; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Chloramphenicol</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Chloramphenicol:</span>
              <span class="print-value print-label-value"> {!! $results->Chloramphenicol; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Tetracyclines</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Doxycycline:</span>
              <span class="print-value print-label-value"> {!! $results->Doxycycline; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Tetracycline:</span>
              <span class="print-value print-label-value"> {!! $results->Tetracycline; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Peptides</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Vancomycin:</span>
              <span class="print-value print-label-value"> {!! $results->Vancomycin; !!}</span>
            </div>
            <div class="form-group">
              <span class="print-label print-label-text">Teicoplanin:</span>
              <span class="print-value print-label-value"> {!! $results->Teicoplanin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Colistin:</span>
              <span class="print-value print-label-value"> {!! $results->Colistin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Polymyxin B:</span>
              <span class="print-value print-label-value"> {!! $results->PolymyxinB; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Lincosamides</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Clindamycin:</span>
              <span class="print-value print-label-value"> {!! $results->Clindamycin; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Oxazolidinones</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Linezolid:</span>
              <span class="print-value print-label-value"> {!! $results->Linezolid; !!}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="content-block">
        <h4>Others</h4>
        <div class="content-section">
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Nalidixic Acid:</span>
              <span class="print-value print-label-value"> {!! $results->NalidixicAcid; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Nitrofurantoin:</span>
              <span class="print-value print-label-value"> {!! $results->Nitrofurantoin; !!}</span>
            </div>
          </div>
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
            <div class="form-group">
              <span class="print-label print-label-text">Tigecycline:</span>
              <span class="print-value print-label-value"> {!! $results->Tigecycline; !!}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
