<?php $__env->startSection('content'); ?>
<?php $write_permission = session('write_permission'); ?>
<?php $hide='false'; ?>
<?php echo e(Session::put('daycare-create-slug','1'), false); ?>

<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
	<ul id="breadcrumbs" class="breadcrumb">
		<li><i class="icon-home"></i><a href="<?php echo e(url('/'), false); ?>"><?php echo e(Lang::get('home.daycare_dashboard'), false); ?></a></li>
		<li class="current"><a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>"><?php echo e(Lang::get('home.daycare_name'), false); ?></a></li>                                                
	</ul>
  <ul class="pull-right list-none daycare-search">
    <li><a href="<?php echo e(action('Search\SearchDaycareController@create'), false); ?>" class="btn btn-info btn-basic-shadow mr-15 search-btn">
      <i class="fa fa-search"></i>  
    <span><?php echo e(Lang::get('home.daycare_search'), false); ?></span>
  </a>
  </li>
  </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
	<div class="col-md-12">
		<div class="widget box table-view-shadow">
			<div class="widget-header">
				<h4><?php echo e(Lang::get('home.daycare_name'), false); ?></h4>
                <?php echo $__env->make('admission_filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php if(in_array('NICU_DAY',$write_permission)): ?>
					<a href="<?php echo e(action('Admission\DaycareController@create'), false); ?>" title="" class="btn btn-basic-shadow create-btn-spacing  btn-info pull-right create-btn"><i class="fa fa-plus "></i> <span><?php echo e(Lang::get('home.daycare_create_new'), false); ?></span></a>  
        <?php endif; ?>                              
			</div>
			<div class="widget-content">
       <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
        <div class="row">
          <div class="dataTables_header clearfix" >
            <div class="col-xs-4 col-md-6 col-sm-6">
              <div id="data-list_length" class="dataTables_length">
                <label class="data_limit">
                  <?php echo Form::open(['url' => action('Admission\DaycareController@index'), 'method' => 'get', 'id' => 'limit-form']); ?>

                        <select name="limit"  size="1" aria-controls="data-list">
                          <option value="10"   <?php if($pagination['limits'] == 10): ?> selected="selected" <?php endif; ?>  >10</option>
                          <option value="25"   <?php if($pagination['limits'] == 25): ?> selected="selected" <?php endif; ?>>25</option>
                          <option value="50"   <?php if($pagination['limits'] == 50): ?> selected="selected" <?php endif; ?>>50</option>
                          <option value="100"  <?php if($pagination['limits'] == 100): ?> selected="selected" <?php endif; ?>>100</option>
                          <option value="1000" <?php if($pagination['limits'] == 1000): ?> selected="selected" <?php endif; ?>>All</option>
                        </select><span class="hidden-xs"><?php echo e(Lang::get('home.daycare_records'), false); ?></span>
                        <?php echo Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']); ?>

                        <?php echo Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']); ?>

               <?php echo Form::close(); ?>

                    </label>
                   </div>
                 </div>
        <?php echo Form::open(['url' => action('Admission\DaycareController@index'), 'method' => 'get', 'id' => 'search-form','class' => 'search_form']); ?> 
                <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                <div class="input-group">
                     <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                      <input type="text" aria-controls="data-list" class="form-control" name="search_txt" value="<?php echo e($search['search_txt'], false); ?>" placeholder="<?php echo e(Lang::get('home.daycare_search_placeholder'), false); ?>">
                     <a href="<?php echo e(action('Admission\DaycareController@index'), false); ?>" class="input-group-addon" id="search-reset"><i class="glyphicon glyphicon-remove"></i></a>
                  </div>                
                </div>
       <?php echo Form::close(); ?>

               </div>
              </div>
            </div>
	     <table class="table table-bordered table-responsive"  id="data-list">
        <thead>
            <tr >
                <th><?php echo e(Lang::get('home.daycare_sno'), false); ?></th>
                <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'BabyName'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('BabyName'), false); ?>"><?php echo e(Lang::get('home.daycare_baby_name'), false); ?></th>
                <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'BMrNo'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('BMrNo'), false); ?>"><?php echo e(Lang::get('home.mrn'), false); ?></th>
              
                <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'DOB'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('DOB'), false); ?>" data-hide="tablet,phone"><?php echo e(Lang::get('home.daycare_dob'), false); ?></th>
             <?php if($hide=='true'): ?>
               <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'DayDate'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('DayDate'), false); ?>" data-hide="tablet,phone"><?php echo e(Lang::get('home.daycare_date'), false); ?></th>
                <?php if(in_array('NICU_DAY',$write_permission)): ?>
                <th ><?php echo e(Lang::get('home.daycare_edit'), false); ?></th>  
                <th ><?php echo e(Lang::get('home.daycare_delete'), false); ?></th>
                <?php endif; ?>   
                <th><?php echo e(Lang::get('home.daycare_preview'), false); ?></th>
                <th><?php echo e(Lang::get('home.daycare_Print'), false); ?></th>   
             <?php endif; ?>                                                                                
            </tr>
        </thead>
        <tbody>
      <?php if(count($results) > 0): ?>  
        <?php for($i = 0; $i <  @count($results); $i++): ?>
          <tr class="<?php echo e($results[$i]->rowcolor, false); ?>">
              <td><?php echo e($i+1, false); ?></td>
              <td>
                <?php if(isset($results[$i]->NeonatalId)): ?>
             <a href="<?php echo e(url('daycare-admission/daycare-baby-admissionlist/'.\SiteHelpers::encrypt_id($results[$i]->BabyId)), false); ?>" class="check-neonatal" data-neonatal-id="<?php echo e($results[$i]->NeonatalId, false); ?>" data-baby-id="<?php echo e(SiteHelpers::encrypt_id($results[$i]->BabyId), false); ?>">
              <?php echo e($results[$i]->BabyName, false); ?> 
              </a>
              <?php else: ?>
             <a class="check-neonatal" data-neonatal-id="<?php echo e($results[$i]->NeonatalId, false); ?>" data-baby-id="<?php echo e(SiteHelpers::encrypt_id($results[$i]->BabyId), false); ?>">
              <?php echo e($results[$i]->BabyName, false); ?> 
              </a>
              <?php endif; ?>
              </td>
              <td><?php echo e($results[$i]->BMrNo, false); ?></td>
              <td><?php echo e(date('d-m-Y',strtotime($results[$i]->DOB)), false); ?></td>
              <?php if($hide=='true'): ?>
               <td><?php echo e($results[$i]->DayDate, false); ?></td>

              <?php if(in_array('NICU_DAY',$write_permission)): ?>
              <td  class="center-align-phone">
                <a class="icon" href="<?php echo e(action('Admission\DaycareController@edit', $results[$i]->DayId), false); ?>">
                  <i class="fa fa-pencil"></i> 
                  <span class="hidden-phone"><?php echo e(Lang::get('home.daycare_edit'), false); ?></span>
                </a>
              </td>
              <td  class="center-align-phone">
                <a class="icon" href="javascript:void(0);" onclick="DeleteData(<?php echo e($results[$i]->DayId, false); ?>)">
                   <i class="fa fa-remove"></i> 
                   <span class="hidden-phone"><?php echo e(Lang::get('home.daycare_delete'), false); ?></span>
                </a>
              </td>
              <?php endif; ?>
              <td  class="center-align-phone">
                 <a class="icon" onclick="ShowModal(<?php echo $results[$i]->DayId; ?>,'<?php echo e(action('Admission\DaycareController@getData',$results[$i]->DayId), false); ?>')" href="javascript:void(0);">
                   <i class="fa fa-eye"></i> 
                   <span class="hidden-phone"><?php echo e(Lang::get('home.daycare_view'), false); ?></span>
                 </a>
              </td>          
              <td  class="center-align-phone"><a class="icon" href="<?php echo e(action('Admission\DaycareController@printData',$results[$i]->DayId), false); ?>">
              <i class="fa fa-print"></i> 
              <span class="hidden-phone"><?php echo e(Lang::get('home.daycare_Print'), false); ?></span>
              </a>
              </td> 
              <?php endif; ?>                               
          </tr>
        <?php endfor; ?>
      <?php else: ?>
           <tr><td colspan="4" class="text-center"><span>No Record Found</span> </td></tr>
      <?php endif; ?>             
      </tbody>
    </table>
        <div class="row">
          <div class="col-md-12">
            <div class="dataTables_footer clearfix">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                <?php echo e(Lang::get('home.daycare_showing'), false); ?> <?php echo e($pagination['limit'][0], false); ?> <?php echo e(Lang::get('home.daycare_to'), false); ?> <?php echo e($pagination['limit'][1], false); ?> <?php echo e(Lang::get('home.daycare_of'), false); ?> <?php echo e($pagination['total'], false); ?> <?php echo e(Lang::get('home.daycare_entries'), false); ?> <?php echo e($search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '', false); ?>

                </div>
              </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="dataTables_paginate paging_bootstrap pagination_footer">
                    <ul class="pagination">    
                      <li class="prev <?php if(Request::query('page') == '' || Request::query('page') == $pagination['start']): ?> disabled <?php endif; ?>">
                        <a class="<?php if(Request::query('page') != $pagination['start'] &&  Request::query('page') != ''): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['start'] || Request::query('page') == ''): ?> javascript:void(0); <?php else: ?> <?php echo e(url('daycare-admission?page='.$pagination['previous']), false); ?><?php endif; ?>">&#8592; <?php echo e(Lang::get('home.daycare_previous'), false); ?></a>
                      </li>
                    <?php for($i = $pagination['start']; $i <= $pagination['end']; $i++): ?> 
                      <li class="<?php if($i == Request::query('page')): ?> active <?php elseif(Request::query('page') == '' && $i == $pagination['start']): ?> active <?php endif; ?>">
                        <a class='sort_with_page' href="<?php echo e(url('daycare-admission?page='.$i), false); ?>"><?php echo e($i, false); ?></a>
                      </li>  
                    <?php endfor; ?>
                      <li class="next <?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> disabled <?php endif; ?>">
                        <a class="<?php if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> javascript:void(0); <?php else: ?> <?php echo e(url('daycare-admission?page='.$pagination['next']), false); ?><?php endif; ?>"><?php echo e(Lang::get('home.daycare_next'), false); ?> &#8594; </a>  
                      </li>
                    </ul>
                  </div>
                </div>
            </div>
          </div>
        </div> 
    		</div>
       </div>
	</div> <!-- /.col-md-12 -->
</div> <!-- /.row -->
				<!-- /Page Content -->
 
<!--
	DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
-->   
<?php echo Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']); ?>

<?php echo Form::close(); ?>        
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
function ShowModal(id,url1){
	  $.ajax({
			  type    :"GET",
			  url     : url1,
			  data    :{ id:id },
			  success :function(response){
				  Datas = JSON.parse(response);
				  EditLink = '';
				  <?php if(in_array('NICU_DAY',$write_permission)): ?>
				  EditLink = '<a href="/daycare-admission/'+Datas['DayId']+'/edit" class=""><i class="fa fa-pencil"></i></a>';
				  <?php endif; ?>
				 PrintLink = '<a href="/daycare-admission/'+Datas['DayId']+'/printdata" class=""><i class="fa fa-print"></i></a>';
				  $(".modal-title").html(Datas['BabyName']+' '+EditLink + ' '+PrintLink);						  			  
				 
				  $(".col-name").html(Datas['BabyName']);
				  $(".col-bmrno").html(Datas['BMrNo']);
				  $(".col-sex").html(Datas['Sex']);
				  $(".col-cga").html(Datas['CGA']);				  				  				  				
				  $(".col-birthweight").html(Datas['BirthWeight']);				  				  				  				
				  $(".col-dob").html(Datas['DOB']);		
				  $(".col-dayoflife").html(Datas['DayOfLife']);				  				  				  				
  				  $(".col-care").html(Datas['Care']);				  
				  $(".col-date").html(Datas['DayDate']);				  				  				  				
				  $(".col-time").html(Datas['DayTime']);				  				  				  				 				

				  $(".col-admissionage").html(Datas['AgeOnAdmission']);				  				  				  								  

				  $(".col-currentprobs").html(Datas['CurrentProblems']);				  				  				  								  				   								  
				  $(".col-previousprobs").html(Datas['PreviousProblems']);
				  $(".col-background").html(Datas['Background']);				  				  				  				
				  
				  },
			  complete: function(){
			  	$('#basicModal').modal('show');
			  }
		});
}
function DeleteData(id){
	  bootbox.confirm("Are you sure?",function(confirmed){
		  if(confirmed){
			  $("#DeleteForm").attr('action',"<?php echo e(action('Admission\DaycareController@index'), false); ?>/"+id);
			  $("#DeleteForm").submit();
		  }
	  });
}

// $('#search').click(function() {
//     $('#search-form').submit();
// });

// $('.sorting_by').on('click', function(e) {
//     e.preventDefault();
//     var sortby       = $(this).data('field');
//     pagination(sortby);
// });

// $('.sort_with_page').click(function(e){
//     e.preventDefault();
//     var sorting_param = $('#limit-form').serialize();
//     var link      = $(this).attr('href');
//     var searchText    = $('input[name="search_txt"]').val();
//     window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
// });

// $('select[name="limit"]').on('change',function(e) {
//     e.preventDefault();
//     pagination();
// });

// function pagination(sortby) {
//   var pagination_url = $('#limit-form').attr('action');
//   var limit          = $('select[name="limit"] option:selected').val();
//   var searchText     = $('input[name="search_txt"]').val();    
//   var sorting_param  = $('#limit-form').serialize();
//   var sorting_param1 = sorting_param.split('&sortorder=')[0];
//   var sorting_param2 = sorting_param.split('&sortorder=')[1];

//   if (sortby) {
//     $('#sortby').val(sortby);
//     if (sorting_param2 == 'desc') {
//       var sortorder = 'asc';
//       $('#sortorder').val(sortorder);
//     } else {
//       var sortorder = 'desc';
//       $('#sortorder').val(sortorder);
//     }
//     window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
//   } else {
//     window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
//   }

// }

$(document).on('click', '.check-neonatal', function(e) {
  var neonatal_id = $(this).attr('data-neonatal-id');
  var baby_id = $(this).attr('data-baby-id');
  if (neonatal_id == '') {    
    e.preventDefault();
    // bootbox.confirm("Please, complete the 'Neonatal Performa'.",function(confirmed){
    //   if(confirmed){
    //     window.location = "<?php echo e(action('Registration\NeonatalController@create'), false); ?>/"+baby_id;
    //   }
    // });
    bootbox.dialog({
      message: "Please, complete the 'Neonatal Performa'.",
      buttons: {
        ok: {
          label: "Later",
          className: "btn-danger"
        },
        confirm: {
          label: "Go To Neonatal Performa",
          className: "btn-success",
          callback: function() {
            window.location = "<?php echo e(action('Registration\NeonatalController@create'), false); ?>/"+baby_id;
          }
        }
      }
    });
  }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>