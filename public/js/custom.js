/*
 * custom.js
 *
 * Place your code here that you need on all your pages.
 */

"use strict";

$(document).ready(function(){

	//===== Sidebar Search (Demo Only) =====//
	$('.sidebar-search').submit(function (e) {
		//e.preventDefault(); // Prevent form submitting (browser redirect)

		$('.sidebar-search-results').slideDown(200);
		return false;
	});

	$('.sidebar-search-results .close').click(function() {
		$('.sidebar-search-results').slideUp(200);
	});

	//===== .row .row-bg Toggler =====//
	$('.row-bg-toggle').click(function (e) {
		e.preventDefault(); // prevent redirect to #

		$('.row.row-bg').each(function () {
			$(this).slideToggle(200);
		});
	});

	//===== Sparklines =====//

	// $("#sparkline-bar").sparkline('html', {
	// 	type: 'bar',
	// 	height: '35px',
	// 	zeroAxis: false,
	// 	barColor: App.getLayoutColorCode('red')
	// });

	// $("#sparkline-bar2").sparkline('html', {
	// 	type: 'bar',
	// 	height: '35px',
	// 	zeroAxis: false,
	// 	barColor: App.getLayoutColorCode('green')
	// });

	//===== Refresh-Button on Widgets =====//

	$('.widget .toolbar .widget-refresh').click(function() {
		var el = $(this).parents('.widget');

		App.blockUI(el);
		window.setTimeout(function () {
			App.unblockUI(el);
			noty({
				text: '<strong>Widget updated.</strong>',
				type: 'success',
				timeout: 1000
			});
		}, 1000);
	});

	//===== Fade In Notification (Demo Only) =====//
	setTimeout(function() {
		$('#sidebar .notifications.demo-slide-in > li:eq(1)').slideDown(500);
	}, 3500);

	setTimeout(function() {
		$('#sidebar .notifications.demo-slide-in > li:eq(0)').slideDown(500);
	}, 7000);

	$('form').attr('autocomplete','off');
});



// adding custom validations

// 2 or 3 digits only 

jQuery.validator.addMethod('threeDigits', function (value, element) {
        return this.optional(element) || /^\d{0,3}?$/i.test(value);
    }, 'Enter number may include one decimal places only !');

//3 digits with 1 decimal maximum

jQuery.validator.addMethod('decimal_range_one', function (value, element) {
        return this.optional(element) || /^\d{0,3}(\.\d{0,1})?$/i.test(value);
    }, 'Enter number may include one decimal places only !');

//3 digits with 2 decimal maximum
jQuery.validator.addMethod('decimal_range_two', function (value, element) {
        return this.optional(element) || /^\d{0,3}(\.\d{0,2})?$/i.test(value);
    }, 'Enter number may include two decimal places only !');


//2 digits with 1 decimal maximum
jQuery.validator.addMethod('digitstwodecimalone', function (value, element) {
        return this.optional(element) || /^\d{0,3}(\.\d{0,1})?$/i.test(value);
    }, 'Enter number may include one decimal places only !');

//1 digits with 2 decimal  maximum
jQuery.validator.addMethod('digitonedecimaltwo', function (value, element) {
        return this.optional(element) || /^\d{0,1}(\.\d{0,2})?$/i.test(value);
    }, 'Enter number may include two decimal places only !');

//2 digits with 1 decimal 1 maximum with +/-
jQuery.validator.addMethod('digitstwodecimaloneplus', function (value, element) {
        return this.optional(element) ||/^\s*[+-\s](\d{0,2})(\.\d{0,1})?$/i.test(value);
    }, 'Enter number may include one decimal places only !');


//only allow alpha bets and numbers with may include  /
jQuery.validator.addMethod('mrnumber', function (value, element) {
        return this.optional(element) || /([A-Za-z0-9/\s])$/.test(value);
    }, 'Enter only alpha numeric values and special character "/" !');

//only allow alpha bets and numbers with may include  /
jQuery.validator.addMethod('ipnumber', function (value, element) {
        return this.optional(element) || /([A-Za-z0-9/\s])$/.test(value);
    }, 'Enter only alpha numeric values and special character "/" !');

//only characters 

jQuery.validator.addMethod('characteronly', function (value, element) {
        return this.optional(element) || /([A-Za-z\s])$/.test(value);
    }, 'Enter only alphabets !');

//character and comma
jQuery.validator.addMethod('charactercomma', function (value, element) {
        return this.optional(element) || /([A-Za-z,\s])$/i.test(value);
    }, 'Enter only alphabets !');

//alpha numeric with / and # values

jQuery.validator.addMethod('addressno', function (value, element) {
        return this.optional(element) || /([A-Za-z0-9/#])$/.test(value);
    }, 'Enter only alpha numeric and special character "/,#" !');


jQuery.validator.addMethod('characterwithslash', function (value, element) {
        return this.optional(element) || /([A-Za-z0-9/\s])$/.test(value);
    }, 'Enter only alpha numeric values and special character "/" !');


jQuery.validator.addMethod('charactersformedication', function (value, element) {
        return this.optional(element) || /([A-Za-z0-9/\s.-])$/.test(value);
    }, 'Enter alpha numeric values and special characters "/,.,-" only!');

//only allow alpha bets and numbers with may include  /
jQuery.validator.addMethod('alphanumeric', function (value, element) {
        return this.optional(element) || /([A-Za-z0-9/\s])$/.test(value);
    }, 'Enter only alpha numeric values.');

jQuery.validator.addMethod('onedigitonedecimal',function(value,element){
        return this.optional(element) || /^\d{0,1}(\.\d{0,1})?$/i.test(value);
},'Enter number may include 1 digits and 1 decimals');

jQuery.validator.addMethod('twodigitstwodecimal',function(value,element){
        return this.optional(element) || /^\d{0,2}(\.\d{0,2})?$/i.test(value);
},'Enter number may include 2 digits and 2 decimals');

jQuery.validator.addMethod('plusorminustwodigitsonedecimal',function(value,element){
         return this.optional(element) || /^([+-])\d{0,2}(\.\d{0,1})?$/i.test(value);
},'Enter number may include +/- 2 digits and 2 decimals');

jQuery.validator.addMethod('plusorminustwodigitstwodecimal',function(value,element){
         return this.optional(element) || /^([+-])\d{0,2}(\.\d{0,2})?$/i.test(value);
},'Enter number may include +/- 2 digits and 2 decimals');

jQuery.validator.addMethod('fourdigitsonedecimal',function(value,element){
        return this.optional(element) || /^\d{0,4}(\.\d{0,1})?$/i.test(value);
},'Enter number may include 4 digits and 1 decimals');


jQuery.validator.addMethod('ip_number_validate',function(value,element){
        return this.optional(element) || /IP\/\d\d\d\d\d\d\d/.test(value);
},'Enter valid IP number');

jQuery.validator.addMethod('gestationweeksdays',function(value,element){
	if (this.optional(element) || /^\d{0,2}[+](\d{0,1})?$/i.test(value)) {
         return true;
     } else if (this.optional(element) || /^\d{0,2}?$/i.test(value)) {
         return true;
     }  else  {
         return false;
     } 
},'Enter valid Gestation 2 digits + 1 digits');

jQuery.validator.addMethod('growthdayonlyrequired',function(value,element){

	var growth_chart_day = JSON.parse($('input[name="head_circumference"]').attr('data-growthchart'));

	var selected_date = $('#DayDate').val();
		selected_date = selected_date.split('-');
	var selected_day = selected_date[0];
	var selected_month = selected_date[1];
	var selected_year = selected_date[2];

	const weekday = ["Sun","Mon","Tue","Wed","Thu","Fri","Sat"];

	const d = new Date(selected_year, selected_month - 1, selected_day);
	let day = weekday[d.getDay()];

	var valid = true;

	$('input[name="head_circumference"]').addClass('check-zero');

	$.each(growth_chart_day, function(day_key, day_value) {
		if (day == day_value) {
			if (value == '') {
		    	valid = false;
			}
		} else {
			$('input[name="head_circumference"]').removeClass('check-zero');
		}
	}); 

	return valid;
},'This field is mandatory.');

jQuery.validator.addMethod('omitZeros',function(value,element){
        var hospital_name = $('input[name="hospital_name"]').val();
	if (value > 0 || (($('form').attr('id') == 'daycare-form' && (element.name == 'head_circumference' || element.name == 'length') && !$('input[name="head_circumference"]').hasClass('check-zero')) || (value == '' && hospital_name == 'Saraswathi Nursing Home'))) {
		return true;
	}
	return false;
});




