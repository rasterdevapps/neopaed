$(document).ready(function() {
	if (!$('.navbar-fixed-top > .container > .navbar-nav.navbar-left > li:last-child > a > i').hasClass('fa-plug')) {
		window.Echo.channel('patient-bed-log-update').listen('WardEvent', function (data) {
			console.log(data);
			var data = data.bed_log_update;
			var admission_id = data.admission_id;
			if (data.status == 'TRANSFER' || data.status == 'WARD_TRANSFER' || data.status == 'DISCHARGE') {
				if (data.status == 'WARD_TRANSFER') {
					emptyBedContent(admission_id);
				} else {
					emptyBedContent(admission_id);            	
				}
			}
			if (data.status == 'EDIT') {
				updateBabyDetails(data);
			}
			if (data.status != 'DISCHARGE' && data.status != 'TRANSFER' && data.status != 'EDIT' && data.status != 'INDICATION') {
				collectPatientDetails(admission_id);
			}
			if (data.status == 'INDICATION') {
				// Monitor
				if (data.indication_no == 1) {
				}
				// Ventilator
				if (data.indication_no == 2) {
				}
				// Pump
				if (data.indication_no == 3) {
					if (data.active) {
						$('.card-pf-title.details[data-admission-id="' + admission_id + '"]').parent().find('.card-pf-items div[data-title="Pump Connection Status"] span').addClass('text-success').removeClass('text-normal');
					} else {
						$('.card-pf-title.details[data-admission-id="' + admission_id + '"]').parent().find('.card-pf-items div[data-title="Pump Connection Status"] span').addClass('text-normal').removeClass('text-success');
					}
				}
				// Pump Status
				if (data.indication_no == 4) {
					if (data.active) {
						$('.card-pf-title.details[data-admission-id="' + admission_id + '"]').parent().find('.card-pf-items .pump-status-block').addClass('text-success').removeClass('hide');
					} else {
						$('.card-pf-title.details[data-admission-id="' + admission_id + '"]').parent().find('.card-pf-items .pump-status-block').addClass('hide').removeClass('text-success');
					}
				}
			}
		});
	}

	var site_url = $('input[name="site_base_url"]').val();
	function updateBabyDetails(data) {
		var mrn = data.baby_mrn;
		var name = data.baby_name;
		$('.call-hms[data-mrn="' + mrn + '"]').parent().html('<span>' + name + '</span>');
	}

	function collectPatientDetails(admission_id) {
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'GET',
			data: {
				admission_id: admission_id
			},
			url: site_url + "/get-baby-bed-info",
			success: function(response) {
				admitInBed(response);
			}
		});
	}

	function emptyBedContent(admission_id) {
		var bed_layout_id = $('.details[data-admission-id="' + admission_id + '"]').parents('.bed-manager').attr('id');
		if (typeof bed_layout_id !== 'undefined') {
			var tracking_id = bed_layout_id.replace(/[a-zA-z-]/g, '');
			var element_id = $('#bed-manangement-' + tracking_id);
			var old_ward_id = element_id.data('ward-id');
			var old_ward_name = $('#' + bed_layout_id).find('.ward-names').html();
			var old_room_id = element_id.data('room-id');
			var old_room_name = element_id.data('room-name');
			var old_bed_id = element_id.data('bed-id');
			var old_bed_no = element_id.data('bed-name');
			var old_hms_ward_id = element_id.data('hms-ward-id');
			var old_hms_room_id = element_id.data('hms-room-id');
			var old_hms_bed_id = element_id.data('hms-bed-id');
			var old_bed_content = '<div class="card-pf card-pf-view card-pf-view-select card-pf-view-single-select">';
			old_bed_content += '<span class="badge badge-success ward-names" style="display: none;">' + old_ward_name + '</span>';
			old_bed_content += '<span class="badge badge-primary">' + old_bed_no + '</span>';
			old_bed_content += '<div class="card-pf-body" style="height: 283px;">';
			old_bed_content += '<div class="card-pf-top-element" data-bed-name="15" data-ward-id="1" data-room-id="3" data-bed-id="15">';
			old_bed_content += '<span class="card-pf-icon-circle bed-frame" id="bed-frame-15">';
			old_bed_content += '<img src="' + site_url + '/public/img/icons/ward-icon.png" alt="Ward Icon" width="40" height="40" class="baby-warmer-icons bed-transfer-restricted" data-bed-name="' + old_bed_no + '" data-ward-id="' + old_ward_id + '" data-room-id="' + old_room_id + '" data-bed-id="' + old_bed_id + '" class="baby-warmer-icons bed-transfer" id="bed-manangement-' + old_bed_id + '" width="40" height="40" />';
			old_bed_content += '</span>';
			old_bed_content += '</div>';
			old_bed_content += '<div class="bed-details-text-' + old_bed_id + '">';
			old_bed_content += '<h2 class="card-pf-title text-center">';
			old_bed_content += '<a href="javascript:void(0)" class="btn btn-success add-patient" data-add-ward-id="' + old_ward_id + '" data-add-room-id="' + old_room_id + '" data-add-ward-name="' + old_ward_name + '" data-add-room-name="' + old_room_name + '" data-add-bed-id="' + old_bed_id + '" data-add-bed-name="' + old_bed_no + '" data-hms-ward-id="' + old_hms_ward_id + '" data-hms-room-id="' + old_hms_room_id + '" data-hms-bed-id="' + old_hms_bed_id + '">';
			old_bed_content += 'Admit Baby';
			old_bed_content += '</a>';
			old_bed_content += '</h2>';
			old_bed_content += '</div>';
			old_bed_content += '</div>';
			old_bed_content += '</div>';
			$('#bed-layout-' + old_bed_id).html(old_bed_content);
			$('#bed-layout-' + old_bed_id).removeClass('female_baby').removeClass('male_baby');
		}
	}

	function admitInBed(responseData) {
		details = JSON.parse(responseData);
		var baby_id = details.baby_id;
		var admission_id = details.admission_id;
		var en_baby_id = details.en_baby_id;
		var en_admission_id = details.en_admission_id;
		var ward_name = details.ward_name;
		var ward_id = details.ward_id;
		var room_id = details.room_id;
		var room_name = details.number;
		var bed_id = details.bed_id;
		var bed_no = details.bed_no;
		var hms_ward_id = details.hms_ward_id;
		var hms_room_id = details.hms_room_id;
		var hms_bed_id = details.hms_bed_id;
		var baby_mrn = details.BMrNo;
		var ip_number = details.ip_number;
		var baby_name = details.BabyName;
		var dobStr = details.dob;
		var dob_array = dobStr.split('-');
		var dob = dob_array[2] + '-' + dob_array[1] + '-' + dob_array[0];
		var gender = details.Sex;
		var menu_list = details.menu_list;
		var moniter_active = details.moniter_active;
		var ventilator_active = details.ventilator_active;
		var pumb_active = details.pumb_active;
		var new_bed_content = '<div class="card-pf card-pf-view card-pf-view-select card-pf-view-single-select">';
		new_bed_content += '<span class="badge badge-success ward-names" style="display: none;">' + ward_name + '</span>';
		new_bed_content += '<span class="badge badge-primary">' + bed_no + '</span>';
		new_bed_content += menu_list;
		new_bed_content += '<div class="card-pf-body" style="height: 283px;">';
		new_bed_content += '<div class="card-pf-top-element" data-bed-name="' + bed_no + '" data-ward-id="' + ward_id + '" data-room-id="' + room_id + '" data-bed-id="' + bed_id + '">';
		new_bed_content += '<span class="card-pf-icon-circle bed-frame" id="bed-frame-' + bed_id + '">';
		if (gender == 'Male' || gender == 'MALE') {
			new_bed_content += '<img src="' + site_url + '/public/img/icons/baby-boy.png" alt="Male Baby" id="bed-manangement-' + bed_id + '" data-bed-name="' + bed_no + '" data-ward-id="' + ward_id + '" data-room-id="' + room_id + '" data-bed-id="' + bed_id + '" data-room-name="' + room_name + '" data-hms-ward-id="' + hms_ward_id + '" data-hms-room-id="' + hms_room_id + '" data-hms-bed-id="'+hms_bed_id+'" class="baby-warmer-icons bed-transfer" /> ';
		} else if (gender == 'Female' || gender == 'FEMALE') {
			new_bed_content += '<img src="' + site_url + '/public/img/icons/baby-girl.png" alt="Female Baby"  id="bed-manangement-' + bed_id + '" data-bed-name="' + bed_no + '" data-ward-id="' + ward_id + '" data-room-id="' + room_id + '" data-bed-id="' + bed_id + '" data-room-name="' + room_name + '" data-hms-ward-id="' + hms_ward_id + '" data-hms-room-id="' + hms_room_id + '" data-hms-bed-id="'+hms_bed_id+'" class="baby-warmer-icons bed-transfer" />';
		} else {
			new_bed_content += '<img src="' + site_url + '/public/img/icons/ward-icon.png" alt="Ward Icon" width="40" height="40" class="baby-warmer-icons bed-transfer-restricted" data-bed-name="' + bed_no + '" data-ward-id="' + ward_id + '" data-room-id="' + room_id + '" data-bed-id="' + bed_id + '" data-room-name="' + room_name + '" data-hms-ward-id="' + hms_ward_id + '" data-hms-room-id="' + hms_room_id + '" data-hms-bed-id="'+hms_bed_id+'" class="baby-warmer-icons bed-transfer" id="bed-manangement-' + bed_id + '" width="40" height="40" />';
		}
		new_bed_content += '</span>';
		new_bed_content += '</div>';
		new_bed_content += '<div class="bed-details-text-' + bed_id + '">';
		new_bed_content += '<h2 class="card-pf-title text-center details" data-baby-id="' + baby_id + '" data-admission-id="' + admission_id + '">';
		new_bed_content += baby_mrn;
		new_bed_content += '</h2>';
		new_bed_content += '<div class="card-pf-items text-center">';
		new_bed_content += '<div class="card-pf-item bs-tooltip" data-title="Monitor">';
		new_bed_content += '<a href="' + site_url + '/list-monitor-values/' + en_baby_id + '/' + en_admission_id + '">';
		new_bed_content += '<span class="fas fa-pager ' + moniter_active + '"></span>';
		new_bed_content += '</a>';
		new_bed_content += '</div>';
		new_bed_content += '<div class="card-pf-item bs-tooltip" data-title="Ventilator">';
		new_bed_content += '<a href="' + site_url + '/list-vendilator-values/' + en_baby_id + '/' + en_admission_id + '">';
		new_bed_content += '<span class="fas fa-lungs ' + ventilator_active + '"></span>';
		new_bed_content += '</a>';
		new_bed_content += '</div>';
		new_bed_content += '<div class="card-pf-item bs-tooltip" data-title="Pump">';
		new_bed_content += '<a href="' + site_url + '/list-infusion-values/' + en_baby_id + '/' + en_admission_id + '">';
		new_bed_content += '<span class="fas fa-syringe ' + pumb_active + '"></span>';
		new_bed_content += '</a>';
		new_bed_content += '</div>';
		new_bed_content += '</div>';
		new_bed_content += '<p class="card-pf-info text-center text-captialize"> ';
		if ((baby_name.toLowerCase()).indexOf("unknown") != -1) {
			new_bed_content += '<span class="text-danger call-hms" title="Get data from HMS" data-mrn="' + baby_mrn + '">' + baby_name + '  <i class="fa fa-refresh"></i></span>';
		} else {
			new_bed_content += baby_name;
		}
		new_bed_content += '</p>';
		if (dob != '00-00-0000') {
			new_bed_content += '<p class="card-pf-info text-center dob-span"><strong>DOB : </strong>';
			new_bed_content += dob;
		}
		new_bed_content += '</p>';
		new_bed_content += '<p class="card-pf-info text-center"><strong>Visit Number : </strong>';
		new_bed_content += ip_number;
		new_bed_content += '</p>';
		$('#bed-layout-' + bed_id).html(new_bed_content);
		$('#bed-layout-' + bed_id).removeClass('female_baby').removeClass('male_baby').addClass(gender.toLowerCase() + '_baby');
		bedLayoutListner('bed-layout-' + bed_id);
		bedComponentListner('bed-manangement-' + bed_id);
	}
	$('.no-baby-details').css('height', $('.baby-details').height());
	$('.nurse-monitor-list').click(function() {
		window.location = $(this).data('monitor-link');
	});
	$('.nurse-infusion-list').click(function() {
		window.location = $(this).data('infusion-link');
	});
	$('.nurse-vendilator-list').click(function() {
		window.location = $(this).data('vendilator-link');
	});
	$('.nicu-ward-menu').each(function()
	{
		var element = $(this);
		var mrn = element.data('mrn');
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'GET',
			data: {
				baby_mrn: mrn
			},
			url: site_url + "/get-patient-ward-menu",
			success: function(response) {
				var menu_content = response.menu_list;
				element.html(menu_content);
			},
			complete: function() {}
		});
	});
	function bedLog(babyId, admissionId, wardId, roomId, bedId, oldBedId) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "POST",
			url: site_url + "/update-bed-log",
			data: {
				babyId: babyId,
				admissionId: admissionId,
				wardId: wardId,
				roomId: roomId,
				bedId: bedId,
				oldBedId: oldBedId
			},
			async: false,
			success: function(response) {
				Showalert(response.type, response.message);
			},
			error: function(response) {
				Showalert(response.type, response.message);
			}
		});
	}

	$('.bed-transfer').each(function() {
		bedComponentListner($(this).attr('id'));
	});

	$('.bed-manager').each(function() {
		bedLayoutListner($(this).attr('id'));
	});
    //add event listner for basic components 
	function bedLayoutListner(containerId) {
		var baseContainer = document.getElementById(containerId);
		baseContainer.addEventListener('dragover', restricteBabyDrop, false);
		baseContainer.addEventListener('drop', getdropComponent, false);
	}
	function getdropComponent(e) {
		e.preventDefault();
		var dragingComponent = e.dataTransfer.getData("target-text");
		var dragComId = document.getElementById(dragingComponent);
		var dropPosition = document.elementFromPoint(e.clientX, e.clientY);
		if (dragComId.classList.contains('bed-transfer') && dropPosition.classList.contains('bed-transfer-restricted')) {
			bootbox.confirm("Are you sure want to transfer the baby from bed no " + dragComId.dataset.bedName + " to " + dropPosition.dataset.bedName + "?", function(confirmed) {
				if (confirmed) {
					var sourceBedid = $('#' + dragComId.id).data('bed-id');
					var destiBedid = $('#' + dropPosition.id).data('bed-id');
					var sourceImage = dragComId.src;
					var destiImage = dropPosition.src;
					dropPosition.src = sourceImage;
					var babyId = $('.bed-details-text-' + sourceBedid).children('.details').data('baby-id');
					var admissionId = $('.bed-details-text-' + sourceBedid).children('.details').data('admission-id');
					var wardId = $('#' + dropPosition.id).data('ward-id');
					var roomId = $('#' + dropPosition.id).data('room-id');
					var bedId = $('#' + dropPosition.id).data('bed-id');
					var oldBedId = $('#' + dragComId.id).data('bed-id');
					bedLog(babyId, admissionId, wardId, roomId, bedId, oldBedId);
					emptyBedContent(admissionId);
					collectPatientDetails(admissionId);
				}
			});
		} else if (!dropPosition.classList.contains('bed-transfer-restricted')) {
			Showalert('warning', 'You Can\'t interchange the baby');
		}
	}

	//add event listner for basic components 
	function bedComponentListner(componentId) {
		var basicComponent = document.getElementById(componentId);
		basicComponent.addEventListener('dragstart', babyDragComponent, false);
		basicComponent.addEventListener('drop', restricteBabyDrop, false);
	}

	function restricteBabyDrop(e) {
		e.preventDefault();
	}

	/* set the draging object into the events */
	function babyDragComponent(e) {
		e.dataTransfer.setData("target-text", e.target.id);
		e.dataTransfer.setData("target-y", e.clientY);
	}


	$('.baby-tranfer').on('click', function() {
		$("#bed-transfer").validate({
			rules: {
                // roomId: {
                //     required: true
                // },
				bed_no: {
					required: true
				},
			}
		});
		if ($('#bed-transfer').valid() === true) {
			var serial = $($("#bed-transfer")[0].elements).serializeArray();
			$.ajax({
				type: "POST",
				url: site_url + "/update-bed-log",
				data: serial,
				success: function(response) {
					Showalert(response.type, response.message);
					$('#discharge-details-nav').modal('hide');
					var admissionId = $("#bed-transfer input[name='admissionId']").val();
					emptyBedContent(admissionId);
					collectPatientDetails(admissionId);
				},
				complete: function(response) {}
			});
		}
	});

	$(document).on('click', '.call-hms', function () {
		var container_id = $(this).parents('.bed-managerr').attr('id');
		var baby_mrn = $(this).attr('data-mrn');
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: 'GET',
			data: {
				mrn: baby_mrn
			},
			url: site_url + "/update-hms-reg-baby",
			success: function(response) {
				var baby_name = response.baby_name;
				var baby_mrn = response.baby_mrn;
				var content = {
					baby_name: baby_name,
					baby_mrn: baby_mrn
				}
				updateBabyDetails(content);
			}
		});
	});

	$('#quickreg #start-quick-regi').on('click', function(e) {
		e.preventDefault();
		var baby_mrn = $('#quickreg input[name="baby_mrn"]').val();
		if (baby_mrn != '') {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				type: "GET",
				url: site_url + "/patient-status",
				data: {
					baby_mrn: baby_mrn,
				},
				async: false,
				success: function(response) {
					if (response.result == null || response.result.status == 'discharged') {
						$('#quickreg input[name="baby_mrn"]').parent().find('span').addClass('error-message').text('');
					} else {
						$('#quickreg input[name="baby_mrn"]').parent().find('span').addClass('error-message').text('Baby\'s already exist in NICU ward...');
						$('#quickreg input[name="baby_mrn"]').focus();
						return false;
					}
				}
			});
		} else {
			$('#quickreg input[name="baby_mrn"]').parent().find('span').addClass('error-message').text('');
		}
		if ($('#quickreg select[name="gender"]').val() == '' && $('#quickreg input[name="baby_mrn"]').parent().find('span').text() == '') {
			$('#quickreg select[name="gender"]').parent().find('span').addClass('error-message').text('Please select Baby\'s gender');
			$('#quickreg select[name="gender"]').focus();
			return false;
		} else {
			$('#quickreg select[name="gender"]').parent().find('span').addClass('error-message').text('');
		}
		if ($('#quickreg input[name="age"]').val() == '' && $('#quickreg input[name="baby_mrn"]').parent().find('span').text() == '' && $('#quickreg select[name="gender"]').parent().find('span').text() == '') {
			$('#quickreg input[name="age"]').parent().find('span').addClass('error-message').text('Please enter Baby\'s age in days');
			$('#quickreg input[name="age"]').focus();
			return false;
		} else {
			$('#quickreg input[name="age"]').parent().find('span').addClass('error-message').text('');
		}
		if ($('#quickreg input[name="baby_mrn"]').parent().find('span').text() == '' && $('#quickreg select[name="gender"]').parent().find('span').text() == '' && $('#quickreg input[name="age"]').parent().find('span').text() == '') {
			var current_element = $(this);
			current_element.html('<i class="fas fa-spinner fa-pulse"></i> Loading...').prop('disabled', true);
			hmsrequest(current_element);
		}
	});

	function hmsrequest(current_element) {
		var hward_name = $('#quickreg input[name="hward_name"]').attr('data-value');
		var hroom_name = $('#quickreg input[name="hroom_name"]').attr('data-value');
		var hbed_name = $('#quickreg input[name="hbed_name"]').attr('data-value');
		var baby_mrn = $('#quickreg input[name="baby_mrn"]').val();
		var gender = $('#quickreg select[name="gender"]').val();
		var age = $('#quickreg input[name="age"]').val();
		var ward_name = $('#quickreg input[name="ward_name"]').val();
		var room_no = $('#quickreg input[name="room_no"]').val();
		var bed_no = $('#quickreg input[name="bed_no"]').val();
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "POST",
			url: site_url + "/hms-quick-reg",
			data: {
				hward_name: hward_name,
				hroom_name: hroom_name,
				hbed_name: hbed_name,
				ward_name: ward_name,
				room_no: room_no,
				bed_no: bed_no,
				baby_mrn: baby_mrn,
				gender: gender,
				age: age
			},
			success: function(response) {
				if (typeof response.type !== 'undefined' && typeof response.message !== 'undefined') {
					var type = response.type;
					var message = response.message;
					Showalert(type.toLowerCase(), message);
					current_element.html(' Start ').prop('disabled', false);
					$('#nurse-bed-model').modal('hide');
					var admission_id = response.admission_id;
					collectPatientDetails(admission_id);
				}
			},
			complete: function(response) {}
		});
	}
});