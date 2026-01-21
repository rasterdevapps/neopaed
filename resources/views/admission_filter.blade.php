<select class="form-control patient-filter input-width-small display-inline-block">
	<option value="" disabled>-- Filter --</option>
	<option value="inpatient" @if(isset($_GET['status']) && $_GET['status'] == 'inpatient' || isset($status) && $status == 'inpatient') selected="selected" @endif>Inpatient</option>
	<option value="discharged" @if(isset($_GET['status']) && $_GET['status'] == 'discharged' || isset($status) && $status == 'discharged') selected="selected" @endif>Discharge</option>
	<option value="All" @if(isset($_GET['status']) && $_GET['status'] == 'All' || isset($status) && $status == 'All') selected="selected" @endif>All</option>
</select>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#search').click(function(e) {
	        e.preventDefault();
	        pagination();
	    });
	    $('#search-form').submit(function(e) {
	        e.preventDefault();
	        pagination(); 
	    })
	    $('.sorting_by').on('click', function(e) {
	        e.preventDefault();
	        var sortby = $(this).data('field');
	        pagination(sortby);
	    });
	    $('select[name="limit"]').on('change', function(e) {
	        e.preventDefault();
	        pagination();
	    });
	    $('.sort_with_page').click(function(e) {
	        e.preventDefault();
	        var sorting_param = $('#limit-form').serialize();
	        var link = $(this).attr('href');
	        var status = '?status='+$('.patient-filter').val();
	        var searchText = $('input[name="search_txt"]').val();
	        window.location = link + status + '&search_txt=' + searchText + '&' + sorting_param;
	    });
	    function pagination(sortby) {
	        var pagination_url = $('#limit-form').attr('action');
	        var status = '?status='+$('.patient-filter').val();
	        pagination_url = pagination_url + status;
	        var limit = $('select[name="limit"] option:selected').val();
	        var searchText = $('input[name="search_txt"]').val();
	        var sorting_param = $('#limit-form').serialize();
	        var sorting_param1 = sorting_param.split('&sortorder=')[0];
	        var sorting_param2 = sorting_param.split('&sortorder=')[1];
	        if (sortby) {
	            $('#sortby').val(sortby);
	            if (sorting_param2 == 'desc') {
	                var sortorder = 'asc';
	                $('#sortorder').val(sortorder);
	            } else {
	                var sortorder = 'desc';
	                $('#sortorder').val(sortorder);
	            }
	            window.location = pagination_url + '&page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
	        } else {
	            window.location = pagination_url + '&page=1&search_txt=' + searchText + '&' + sorting_param;
	        }
	    }
	    $('#search-reset').click(function(e) {
	        e.preventDefault();
	        var link = $(this).attr('href');
	        var status = '?status='+$('.patient-filter').val();
	        window.location = link + status;
	    });

    	var base_url = $("input[name='site_base_url']").val();
		$('.patient-filter').on('change', function() {
			var link = window.location.href.replace(window.location.search, '');
			var status = '?status='+$(this).val();
			var search_context = window.location.search.split('&');
				search_context[0] = status;
				search_context[1] = 'page=';
			var search = search_context.join("&");
			window.location = link + search;
		});

		$('.dataTables_paginate.pagination_footer li a').on('click', function(e) {
			e.preventDefault();
			var page_url = $(this).attr('href');
			var current_location = page_url.split('?page=')[0];
			var page = 'page='+page_url.split('?page=')[1];
			var status = '?status='+$('.patient-filter').val();
			var search_context = window.location.search.split('&');
				search_context[0] = status;
				search_context[1] = page;
			var search = search_context.join("&");
			window.location = current_location + search;
		});
	});
</script>