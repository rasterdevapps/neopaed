
$(document).on('click', '.add-vital-signs', function() {	

	var timeHour = $('select[name="temp_time_hour"]').html();
	var timeMin = $('select[name="temp_time_min"]').html();
	var timeSession = $('select[name="temp_time_session"]').html();

	 var option  = '<tr>';
	     option += '<td><input class="form-control" name="core_temp[]" type="text"></td>';
	     option += '<td><input class="form-control" name="skin_temp[]" type="text"></td>';
	     option += '<td><input class="form-control" name="heart_rate[]" type="text"></td>';
	     option += '<td><input class="form-control" name="respiratory_rate[]" type="text"></td>';
	     option += '<td><input class="form-control" name="mean_bp[]" type="text"></td>';
	     option += '<td><select class="form-control" name="time_hour[]">'+timeHour+'</select></td>';
	     option += '<td><select class="form-control" name="time_min[]">'+timeMin+'</select></td>';
	     option += '<td><select class="form-control" name="time_session[]">'+timeSession+'</select></td>';
	     option += '<td><span class="btn btn-error remove-vitals"> <i class="fa fa-times" aria-hidden="true"></i> </span></td>';
	     option += '</tr>';
	$('.vital-signs tbody').append(option);

});

$(document).on('click', '.remove-vitals', function() {
$(this).parent('td').parent('tr').remove();

});