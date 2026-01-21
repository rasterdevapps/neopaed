@php $site_url = url('/').'/public'; @endphp
<script type="text/javascript">

$(document).ready(function(){
  
  	@if(@$results->Surfactant_therapy_nicu == 'No' || is_null(@$results->Surfactant_therapy_nicu))
      $('#Surfactant_therapy_nicu').bootstrapToggle('off');
	  @endif

    @if(@$results->Stools == 'Bowels not opened'  || is_null(@$results->Stools))
      $('#Stools').bootstrapToggle('off');
    @endif

  	@if(@$results->Hypoglycemia == 0 || is_null(@$results->Hypoglycemia))
         $('#Hypoglycemia').bootstrapToggle('off');
  	@endif

    @if(@$results->Hyperglycemia == 0  || is_null(@$results->Hyperglycemia))
        $('#Hyperglycemia').bootstrapToggle('off');
    @endif

    @if(@$results->InsulinTherapy == 0 || is_null(@$results->InsulinTherapy))
        $('#InsulinTherapy').bootstrapToggle('off');
    @endif

    @if(@$results->Hyponatremia == 0 || is_null(@$results->Hyponatremia))
        $('#Hyponatremia').bootstrapToggle('off');
    @endif

    @if(@$results->Hypernatremia==0 || is_null(@$results->Hypernatremia))
        $('#Hypernatremia').bootstrapToggle('off');
    @endif

    @if(@$results->Hypokalemia == 0 || is_null(@$results->Hypokalemia))
       $('#Hypokalemia').bootstrapToggle('off');
    @endif

    @if(@$results->Hyperkalemia==0 || is_null(@$results->Hyperkalemia))
       $('#Hyperkalemia').bootstrapToggle('off');
    @endif

    @if(@$results->Hypocalcemia==0 || is_null(@$results->Hypocalcemia))
       $('#Hypocalcemia').bootstrapToggle('off');
    @endif

    @if(@$results->Hypercalcemia==0 || is_null(@$results->Hypercalcemia))
       $('#Hypercalcemia').bootstrapToggle('off');
    @endif

    @if(@$results->intercostaldrain==1 || is_null(@$results->intercostaldrain))
       $('#intercostaldrain').bootstrapToggle('off');
    @endif
    @if(@$results->needlethoracentesis==1 || is_null(@$results->needlethoracentesis))
       $('#needlethoracentesis').bootstrapToggle('off');
    @endif
    @if(@$results->ultrasoundabdominal == 1 || is_null(@$results->ultrasoundabdominal))
           $('#ultrasoundabdominal').bootstrapToggle('off');
    @endif

    @if(@$results->renalultrasound ==1 || is_null(@$results->renalultrasound))
        $('#renalultrasound').bootstrapToggle('off');
    @endif
    @if(@$results->neuro_sonogram =='Not performed' || is_null(@$results->neuro_sonogram))
       $('#neuro_sonogram').bootstrapToggle('off');
    @endif
    @if(@$results->mrict_brain_status == 1 || is_null(@$results->mrict_brain_status))
       $('#mrict_brain_status').bootstrapToggle('off');
    @endif
    @if(@$results->viral_meningitis == 1 || is_null(@$results->viral_meningitis))
       $('#viral_meningitis').bootstrapToggle('off');
    @else 
        $('#viral_meningitis').bootstrapToggle('on');
    @endif
     @if(@$results->ultrasound_spine == 1 || is_null(@$results->ultrasound_spine))
       $('#ultrasound_spine').bootstrapToggle('off');
    @endif

    
    @if(@$results->eeg_cfm == 1 || is_null(@$results->eeg_cfm))
        $('#eeg_cfm').bootstrapToggle('off');
    @endif

    @if(@$results->dilution_exchange == 1 || is_null(@$results->dilution_exchange))
        $('#dilution_exchange').bootstrapToggle('off');
    @endif

    @if(@$results->chronic_lung == 1 || is_null(@$results->chronic_lung))
        $('#chronic_lung').bootstrapToggle('off');
    @endif

});

function getCurserbasedHtml(editor) {

    var sel = editor.getSelection();
    var cursePostion = sel.getRanges()[0];
    var text  = cursePostion.endContainer.getText();
    return text;

}


// function getSelectionHtml(editor) {

//     var sel = editor.getSelection();
//     var ranges = sel.getRanges();
//     var el = new CKEDITOR.dom.element("div");
//     for (var i = 0, len = ranges.length; i < len; ++i) {
//         el.append(ranges[i].cloneContents());
//         ranges[i].deleteContents();
//     }
//     return el.getHtml();
// }

// var Editorarray = ['CurrentProblems','PreviousProblems'];

// $.each(Editorarray,function(index,value){
//    CKEDITOR.replace( value);
// });


// $('.current_problem_down').click(function(){

//     var currentProblem     = getCurserbasedHtml(CKEDITOR.instances["CurrentProblems"]);
//     var tempcurrentProblem = CKEDITOR.instances["CurrentProblems"].getData();  
//     tempcurrentProblem     = tempcurrentProblem.replace(currentProblem," ","/");
//     CKEDITOR.instances["CurrentProblems"].setData(tempcurrentProblem);  
//     currentProblem  += CKEDITOR.instances["PreviousProblems"].getData();
//     CKEDITOR.instances["PreviousProblems"].setData(currentProblem);

// });

// $('.previous_problem_up').click(function(){
//     var previousProblem  = getCurserbasedHtml(CKEDITOR.instances["PreviousProblems"]);
//     var temppreviousproblem = CKEDITOR.instances["PreviousProblems"].getData(); 
//         temppreviousproblem=temppreviousproblem.replace(previousProblem," ");
//         CKEDITOR.instances["PreviousProblems"].setData(temppreviousproblem);  
//         previousProblem += CKEDITOR.instances["CurrentProblems"].getData();
//     CKEDITOR.instances["CurrentProblems"].setData(previousProblem);

// });




var dropButton = ['respiratory_problem','Cardiovascular_problem','gastrointestinal_problem','central_problem','sedation_paralysis',''];
$.each(dropButton,function(index,value){
     togglebuttons(value);
});


$('.send_message').click(function(){

  var phone = $('input[name="phone"]').val().trim();
  var message = $('textarea[name="send_message"]').val();
  $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
  });


  $.ajax({
         type:'GET',
         url:'{{ url("daycare-message-doctor") }}',
         data:{to:phone,message:message},
         success:function(data){
          Showalert('success','Your messsage sent successfully !');

         },
         error:function(data){
              Showalert('error','Your messsage failed to sent !');

         }
       });

});



</script>
