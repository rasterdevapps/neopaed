<?php $__env->startSection('content'); ?>
<?php $write_permission = session('write_permission'); ?>
<!-- Breadcrumbs line -->
<style type="text/css">
  .btn.active {
    background-color: #D9EDF7;
    color: black;
    font-weight: bold;
}
.toggle-on, .toggle-on:hover {
    background: #DFF0D8;
    color: black;
    font-weight: bold;
}
</style>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?php echo e(url('/'), false); ?> "><?php echo e(Lang::get('home.nicu_summary_dashboard'), false); ?></a>
        </li>
        <li class="current">
            <a href="<?php echo e(action('Reports\NicuDischargeController@discharge_main_list'), false); ?><?php if(isset($summary_type) && $summary_type == 'interim'): ?>/interim <?php endif; ?>"><?php if(isset($summary_type) && $summary_type == 'interim'): ?> Interim Summary <?php else: ?> <?php echo e(Lang::get('home.nicu_summary_summary'), false); ?> <?php endif; ?></a>
        </li>
    </ul>
    <ul class="pull-right nicu-summary-list discharge-color-code mr-15">
        <li>
            <a href="<?php echo e(action('Reports\NicuDischargeController@DischargeSummarySearch'), false); ?>" class="btn btn-basic-shadow btn-info hidden-xs hidden-sm mtb-3 search-btn">
                <i class="fa fa-search"></i> 
                <span><?php echo e(Lang::get('home.nicu_summry_advanced_search'), false); ?></span>
            </a>
        </li>
        <li><span class="info-tick info"></span> <b class="mb-2"> Inpatient</b></li>
        <li><span class="tick success"></span>  <b class="mb-2"> Discharged or Deceased</b></li>
    </ul>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4><?php if(isset($summary_type) && $summary_type == 'interim'): ?> Interim Summary <?php else: ?> <?php echo e(Lang::get('home.nicu_summary_summary'), false); ?> <?php endif; ?></h4>
                <?php echo $__env->make('admission_filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <a href="<?php echo e(action('Reports\NicuDischargeController@DischargeSummarySearch'), false); ?><?php if(isset($summary_type) && $summary_type == 'interim'): ?>/interim <?php endif; ?>" class="btn btn-basic-shadow btn-info visible-xs visible-sm pull-right mtb-3"><span><?php echo e(Lang::get('home.nicu_summry_advanced_search'), false); ?></span></a>
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-sm-6 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                        <?php if(isset($summary_type) && $summary_type == 'discharged'): ?> 
                                        <?php ($url = action('Reports\NicuDischargeController@discharge_main_list').'/discharged'); ?>
                                        <?php else: ?> 
                                        <?php ($url = action('Reports\NicuDischargeController@discharge_main_list')); ?> 
                                        <?php endif; ?>
                                        <?php echo Form::open(['url' => $url, 'method' => 'get', 'id' => 'limit-form']); ?>

                                        <select name="limit"  size="1" aria-controls="data-list">
                                            <option value="10" <?php if($pagination['limits'] == 10): ?> selected="selected" <?php endif; ?>  >10</option>
                                            <option value="25" <?php if($pagination['limits'] == 25): ?> selected="selected" <?php endif; ?>>25</option>
                                            <option value="50" <?php if($pagination['limits'] == 50): ?> selected="selected" <?php endif; ?>>50</option>
                                            <option value="100" <?php if($pagination['limits'] == 100): ?> selected="selected" <?php endif; ?>>100</option>
                                            <option value="1000" <?php if($pagination['limits'] == 1000): ?> selected="selected" <?php endif; ?>>All</option>
                                        </select><span class="hidden-xs"><?php echo e(Lang::get('home.nicu_summary_records'), false); ?></span>
                                        <?php echo Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']); ?>

                                        <?php echo Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']); ?>

                                        <?php echo Form::close(); ?>

                                    </label>
                                </div>
                            </div>
                            <?php if(isset($summary_type) && $summary_type == 'discharged'): ?> 
                            <?php ($search_url = action('Reports\NicuDischargeController@discharge_main_list').'/discharged'); ?>
                            <?php else: ?> 
                            <?php ($search_url = action('Reports\NicuDischargeController@discharge_main_list')); ?> 
                            <?php endif; ?>
                                    <?php echo Form::open(['url' => $search_url, 'method' => 'get', 'id' => 'search-form','class' => 'search_form']); ?> 
                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                    <!-- <div class="col-md-4 col-xs-6" style="overflow-x: hidden;">                    
                                        <input id="admission_status" data-size="small" data-off="Inpatient" data-on="Discharged" data-width="140" data-toggle="toggle" class="form-control switch-input" type="checkbox" <?php if(isset($summary_type) && $summary_type == 'discharged'): ?> checked <?php endif; ?> value="1">
                                    </div> -->
                                    <div class="input-group">
                                        <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                        <input type="text" aria-controls="data-list" class="form-control" name="search_txt"  value="<?php echo @$search['search_txt']; ?>" placeholder="<?php echo e(Lang::get('home.nicu_summary_search'), false); ?>">
                                        <a href="<?php echo e($url, false); ?>" class="input-group-addon" id="search-reset"><i class="glyphicon glyphicon-remove"></i></a>
                                    </div>
                            </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th><?php echo e(Lang::get('home.nicu_summary_sno'), false); ?></th>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'baby.BabyName'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('baby.BabyName'), false); ?>"><?php echo e(Lang::get('home.nicu_summary_baby_name'), false); ?></th>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'baby.BMrNo'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('baby.BMrNo'), false); ?>" data-hide="phone,tablet"><?php echo e(Lang::get('home.mrn'), false); ?></th>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'DOB'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('DOB'), false); ?>"><?php echo e(Lang::get('home.nicu_summary_dob'), false); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($results)): ?>
                        <?php for($i = 0; $i <  @count($results); $i++): ?>
                        <tr class="<?php echo e($results[$i]->rowcolor, false); ?>">
                            <td><?php echo e($i+1, false); ?></td>
                            <td>
                                <?php if(isset($results[$i]->NeonatalId)): ?>
                                <a href="<?php echo e(url('nicu-discharge-sub-list/'.SiteHelpers::encrypt_id($results[$i]->BabyId)), false); ?><?php if(isset($summary_type) && $summary_type == 'interim'): ?>/interim <?php endif; ?>" class="check-neonatal" data-neonatal-id="<?php echo e($results[$i]->NeonatalId, false); ?>" data-baby-id="<?php echo e(SiteHelpers::encrypt_id($results[$i]->BabyId), false); ?>">
                                    <?php echo e($results[$i]->BabyName, false); ?>

                                </a>
                                <?php else: ?>
                                <a class="check-neonatal" data-neonatal-id="<?php echo e($results[$i]->NeonatalId, false); ?>" data-baby-id="<?php echo e(SiteHelpers::encrypt_id($results[$i]->BabyId), false); ?>">
                                    <?php echo e($results[$i]->BabyName, false); ?>

                                </a>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($results[$i]->BMrNo, false); ?></td>
                            <td>
                                <?php if(date('Y',strtotime($results[$i]->DOB)) > 1970): ?> 
                                <?php echo e(date('d-m-Y',strtotime($results[$i]->DOB)), false); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endfor; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center"> <span><?php echo e(Lang::get('home.nicu_summary_no_records'), false); ?></span></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    <?php echo e(Lang::get('home.nicu_summary_showing'), false); ?> <?php echo e($pagination['limit'][0], false); ?> <?php echo e(Lang::get('home.nicu_summary_to'), false); ?> <?php echo e($pagination['limit'][1], false); ?> <?php echo e(Lang::get('home.nicu_summary_of'), false); ?> <?php echo e($pagination['total'], false); ?> <?php echo e(Lang::get('home.nicu_summary_entries'), false); ?> <?php echo e(@$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '', false); ?>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev <?php if(Request::query('page') == '' || Request::query('page') == $pagination['start']): ?> disabled <?php endif; ?>">
                                            <a class="<?php if(Request::query('page') != $pagination['start'] &&  Request::query('page') != ''): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['start'] || Request::query('page') == ''): ?> javascript:void(0); <?php else: ?> <?php echo e($url, false); ?>?page=<?php echo e($pagination['previous'], false); ?><?php endif; ?>">&#8592; <?php echo e(Lang::get('home.nicu_summary_previous'), false); ?></a>
                                        </li>
                                        <?php for($i = $pagination['start']; $i <= $pagination['end']; $i++): ?> 
                                        <li class="<?php if($i == Request::query('page')): ?> active <?php elseif(Request::query('page') == '' && $i == $pagination['start']): ?> active <?php endif; ?>">
                                            <a class='sort_with_page' href="<?php echo e($url, false); ?>?page=<?php echo e($i, false); ?>"><?php echo e($i, false); ?></a>
                                        </li>
                                        <?php endfor; ?>
                                        <li class="next <?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> disabled <?php endif; ?>">
                                            <a class="<?php if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> javascript:void(0); <?php else: ?> <?php echo e($url, false); ?>?page=<?php echo e($pagination['next'], false); ?><?php endif; ?>"><?php echo e(Lang::get('home.nicu_summary_next'), false); ?> &#8594; </a>  
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.col-md-12 -->
</div>
<!-- /.row -->
<!-- /Page Content -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    
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
    //     var link          = $(this).attr('href');
    //     var searchText    = $('input[name="search_txt"]').val();
    //     window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
    // });
    
    // $('select[name="limit"]').on('change',function(e) {
    //     e.preventDefault();
    //     pagination();
    // });
    
    // function pagination(sortby) {
    //     var pagination_url = $('#limit-form').attr('action');
    //     var limit          = $('select[name="limit"] option:selected').val();
    //     var searchText     = $('input[name="search_txt"]').val();    
    //     var sorting_param  = $('#limit-form').serialize();
    //     var sorting_param1 = sorting_param.split('&sortorder=')[0];
    //     var sorting_param2 = sorting_param.split('&sortorder=')[1];

    //     if (sortby) {
    //         $('#sortby').val(sortby);
    //         if (sorting_param2 == 'desc') {
    //             var sortorder = 'asc';
    //             $('#sortorder').val(sortorder);
    //         } else {
    //             var sortorder = 'desc';
    //             $('#sortorder').val(sortorder);
    //         }
    //         window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
    //     } else {
    //         window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
    //     }
    // }

    // $('#admission_status').change(function () {
    //      var value = $(this).val();
    //     var pagination_url = "<?php echo e(url('nicu-discharge-main-list'), false); ?>";
    //     if ($(this).is(':checked')) {
    //         window.location = pagination_url + '/discharged';
    //     }
    //     else {
    //         window.location = pagination_url ;
    //     }
    // });

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