<script type="text/javascript">
	$.validator.setDefaults({
		ignore: []
	});
	@if(isset($problem_parameter) && count($problem_parameter) > 0)
	$("#problem_base_daycare").validate({

		rules: {
			@foreach ($problem_parameter as $value)
			@if(isset($value->para_required) && $value->para_required == 1)
			@php $rule = "'".$value->para_name."[]':{ required:true,},";  @endphp
			@php echo $rule; @endphp 
			@endif  
			@if(isset($value->para_min) && !empty($value->para_min))  
			@php $rule = "'".$value->para_name."[]':{ min:".$value->para_min.",},";  @endphp
			@php echo $rule; @endphp 
			@endif
			@if(isset($value->para_max) && !empty($value->para_max))  
			@php $rule = "'".$value->para_name."[]':{ max:".$value->para_max.",},";  @endphp
			@php echo $rule; @endphp 
			@endif
			@endforeach
		},
		messages:{
			@foreach ($problem_parameter as $value)
			@if(isset($value->para_required) && $value->para_required == 1)
			@php $messages = "'".$value->para_name."[]':{ required:'".$value->para_label." is mandatory.',},";  @endphp
			@php echo $messages; @endphp 
			@endif
			@if(isset($value->para_min) && !empty($value->para_min))
			@php $messages = "'".$value->para_name."[]':{ min:'".$value->para_label." must be greater than or equalto ".$value->para_min.".',},";  @endphp
			@php echo $messages; @endphp 
			@endif  
			@if(isset($value->para_max) && !empty($value->para_max))
			@php $messages = "'".$value->para_name."[]':{ max:'".$value->para_label." must be less than or equalto ".$value->para_max.".',},";  @endphp
			@php echo $messages; @endphp 
			@endif      
			@endforeach
		},

		showErrors: function (errorMap, errorList) {

			if (typeof errorList[0] != "undefined") {

      	// var parentSection = $(errorList[0].element).parents('.single-problem').children('.edit-episode').click();
      	var parentSection = $(errorList[0].element).parents('.single-problem');

          // if (parentSection.children('.problem-contents').css('display') == 'none') {
          //       alert();
          // }
          var position = $(errorList[0].element).position().top;
          $('html, body').animate({
          	scrollTop: position
          }, 300);
      }
      this.defaultShowErrors();
  }

});
	@endif

	function initiateDate() {

		$('.datepicker').datepicker({
			dateFormat: 'dd-mm-yy',
			yearRange: "-60:+02",
			changeMonth : true,
			changeYear : true,	

		});
	}

	function getListofproblems(problemId) {
		var episodeProperty = getEpisodecount(); 

		$.ajax({
			type    :"GET",
			url     :"{{ url('problems-systems-components/') }}"+"/"+problemId,
			data    :{episodeCount:episodeProperty.episodeCount},
			success :function(response) {
				addFormbuilder(response.problemForm);
				Showalert(response.status,response.message);
				createToggle();
				createHorizontalselector();
				$('input[data-toggle="toggle"]').each(function() {
					problemToggledepandancy($(this));
				});
			},
			error:function(response) {
				Showalert(response.status,response.message);               
			},
			complete: function(response) {
				initiateDate();
				$('#episodes').modal('hide');
			}
		});

	}	

	function getRemoveEpisode(episodeObject) {

		var episodeId = episodeObject.data('episode-id');

		$.ajax({
			type    :"GET",
			url     :"{{ url('problem-systems-remove/') }}"+"/"+episodeId,
			success :function(response) {
				episodeObject.parent().parent().parent().remove();
				Showalert(response.status, response.message);    
			},
			error:function(response) {
				var results = $.parseJSON(response.responseText);
				Showalert(results.status, results.message);    

			}
		});

	}

	$('#save-antibiotic').click(function() {

		name = $('input[name= "anitibiotic_name"]').val();
		status = $('#anitibiotic_status option:selected').val();
		$.ajax({
			type    :"GET",
			url     :"{{ url('add-anitibiotic') }}",
			data    :{name:name,status:status},
			success :function(response) {
				$('#antibitic-drug').modal('hide');
				location.reload(); 
			},
			error:function(response) {

			}
		});

	});




</script>