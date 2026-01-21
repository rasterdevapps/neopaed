<?php $__env->startSection('content'); ?>
<?php $write_permission = session('write_permission'); ?>
<?php $delete_permission = session('delete_permission'); ?>
<?php if(!Session::has('NeonatalDichargeList')): ?>
<?php $actionUrl = action('Registration\NeonatalController@index') ?>
<?php else: ?>
<?php $actionUrl = action('Registration\NeonatalController@neonatalDichargelist') ?>
<?php endif; ?>
<!-- Breadcrumbs line -->
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?php echo e(url('/'), false); ?>"><?php echo e(Lang::get('home.neonatal_dashboard'), false); ?></a>
        </li>
        <li class="current">
            <?php if(Session::has('NeonatalDichargeList')): ?>
            <a href="<?php echo e($actionUrl, false); ?>">Neonatal Discharge Details</a>
            <?php else: ?>
            <a href="<?php echo e($actionUrl, false); ?>"><?php echo e(Lang::get('home.neonatal_proforma'), false); ?></a>
            <?php endif; ?>
        </li>
    </ul>
    <ul class="pull-right list-none">
        <li>
            <a href="<?php echo e(action('Search\NeonatalController@create'), false); ?>" title="search" class="btn btn-info btn-basic-shadow create-btn-spacing pull-right mr-33 search-btn">
            <i class="fa fa-search"></i> 
            <span><?php echo e(Lang::get('home.neonatal_advanced_search'), false); ?></span>
            </a>  
        </li>
    </ul>
</div>
<?php $hides='true'; ?>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12 col-sm-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4><?php if(Session::has('NeonatalDichargeList')): ?> Neonatal Discharge Details <?php else: ?> <?php echo e(Lang::get('home.neonatal_proforma'), false); ?><?php endif; ?></h4>
                <?php if(in_array('NEONATAL',$write_permission) && !Session::has('NeonatalDichargeList')): ?>
                <a href="<?php echo e(action('Registration\NeonatalController@chooseBaby'), false); ?>" title="" class="btn btn-info btn-basic-shadow create-btn-spacing pull-right create-btn">
                <i class="fa fa-plus "></i> 
                <span><?php echo e(Lang::get('home.neonatal_create_new'), false); ?> </span>
                </a>  
                <?php endif; ?>                     
            </div>
            <div class="widget-content">
                <div id="data-list_wrapper" class="dataTables_wrapper form-inline" role="grid">
                    <div class="row">
                        <div class="dataTables_header clearfix">
                            <div class="col-xs-4 col-md-6">
                                <div id="data-list_length" class="dataTables_length">
                                    <label class="data_limit">
                                    <?php echo Form::open(['url' => $actionUrl, 'method' => 'get', 'id' => 'limit-form']); ?>

                                    <select name="limit"  size="1" aria-controls="data-list">
                                    <option value="10" <?php if($pagination['limits'] == 10): ?> selected="selected" <?php endif; ?>  >10</option>
                                    <option value="25" <?php if($pagination['limits'] == 25): ?> selected="selected" <?php endif; ?>>25</option>
                                    <option value="50" <?php if($pagination['limits'] == 50): ?> selected="selected" <?php endif; ?>>50</option>
                                    <option value="100" <?php if($pagination['limits'] == 100): ?> selected="selected" <?php endif; ?>>100</option>
                                    <option value="1000" <?php if($pagination['limits'] == 1000): ?> selected="selected" <?php endif; ?>>All</option>
                                    </select><span class="hidden-xs"><?php echo e(Lang::get('home.neonatal_records'), false); ?></span>
                                    <?php echo Form::hidden('sortby',SiteHelpers::encrypt_id($order['sortby']),['id'=>'sortby']); ?>

                                    <?php echo Form::hidden('sortorder',$order['sortorder'],['id'=>'sortorder']); ?>

                                    <?php echo Form::close(); ?>

                                    </label>
                                </div>
                            </div>
                            <?php echo Form::open(['url' => $actionUrl , 'method' => 'get', 'id' => 'search-form','class' => 'search_form']); ?>

                            <div class="col-xs-8 col-sm-6 col-md-4 pull-right">
                                <div class="input-group">
                                    <span id="search" class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>
                                    <input type="text" aria-controls="data-list" class="form-control" name="search_txt"  value="<?php echo @$search['search_txt']; ?>" placeholder="Search">
                                    <a href="<?php echo e($actionUrl, false); ?>"  class="input-group-addon"><i class="glyphicon glyphicon-remove"></i></a>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>

                        </div>
                    </div>
                </div>
                <table class="table table-striped table-bordered  table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'BabyName'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('BabyName'), false); ?>"><?php echo e(Lang::get('home.neonatal_baby_name'), false); ?></th>
                            <th class="sorting_by sorting_icon <?php if($order['sortby'] == 'BMrNo'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('BMrNo'), false); ?>" data-hide="phone,tablet" ><?php echo e(Lang::get('home.mrn'), false); ?></th>
                            <th class="visible-xs">More</th>
                            <th class="sorting_by sorting_icon hidden-xs <?php if($order['sortby'] == 'TestDate'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>" data-field="<?php echo e(SiteHelpers::encrypt_id('TestDate'), false); ?>" data-hide="phone,tablet"><?php echo e(Lang::get('home.neonatal_entry_date'), false); ?></th>
                            <th class="sorting_by sorting_icon hidden-xs <?php if($order['sortby'] == 'DOB'): ?> sorting_<?php echo e($order['sortorder'], false); ?>_icon <?php endif; ?>"  data-field="<?php echo e(SiteHelpers::encrypt_id('DOB'), false); ?>"data-hide="phone,tablet"><?php echo e(Lang::get('home.neonatal_dob'), false); ?></th>
                            <th class="hidden-xs"> Print</th>
                            <th class="hidden-xs hide"> Edited Print</th>
                            <?php if($hides=='true'): ?>
                            <?php if(in_array('NEONATAL',$delete_permission)): ?>
                            <th class="hidden-xs"><?php echo e(Lang::get('home.neonatal_delete'), false); ?></th>
                            <?php endif; ?>
                            <?php endif; ?>                              
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($results) > 0 ): ?>
                        <?php for($i = 0; $i <  @count($results); $i++): ?>
                        <tr>
                            <td>
                                <a class="icon <?php if(!in_array('NEONATAL',$write_permission)): ?> permission-denied <?php endif; ?> edit-content-link" href="<?php if(in_array('NEONATAL',$write_permission)): ?> <?php echo e(action('Registration\NeonatalController@edit', SiteHelpers::encrypt_id($results[$i]->NeonatalId)), false); ?> <?php else: ?> javascript:void(0); <?php endif; ?>">
                                <?php echo e($results[$i]->BabyName, false); ?>

                                </a>
                            </td>
                            <td><?php echo e($results[$i]->BMrNo, false); ?></td>
                            <td class="visible-xs">
                                <a href="#">
                                <span class="glyphicon glyphicon-calendar hidden-lg" aria-hidden="true"  data-toggle="tooltip" data-original-title="Test Date : <?php echo date('d-m-Y',strtotime($results[$i]->TestDate)); ?> &#13; Date of birth: <?php echo date('d-m-Y',strtotime($results[$i]->DOB)); ?>"></span>
                                </a> 
                            </td>
                            <td class="hidden-xs"><?php echo e(date('d-m-Y',strtotime($results[$i]->TestDate)), false); ?></td>
                            <td class="hidden-xs"><?php if(date('Y',strtotime($results[$i]->DOB)) > 1970): ?> <?php echo e(date('d-m-Y',strtotime($results[$i]->DOB)), false); ?> <?php endif; ?></td>
                            <?php if($hides=='true'): ?>
                            <?php $neo_id=SiteHelpers::encrypt_id($results[$i]->NeonatalId) ; ?>
                            <?php endif; ?>  
                            <td class="hidden-xs">
                                <a class="icon btn btn-warning btn-view" href="<?php echo e(action('Registration\NeonatalController@show', SiteHelpers::encrypt_id($results[$i]->NeonatalId)), false); ?>" title="Generated Print">
                                <i class="fa fa-print"></i> 
                                </a>
                            </td>
                            <td class="hidden-xs text-center hide">
                                <?php if($results[$i]->edited): ?>
                                <a class="icon btn btn-default btn-view open-doc-editor" href="<?php echo e(action('Registration\NeonatalController@getAbbreviatedsummaryShow', \SiteHelpers::encrypt_id($results[$i]->BabyId) .'?id='. $results[$i]->NeonatalId), false); ?>" title="Final Print">
                                <i class="fa fa-file-word-o"></i> 
                                </a>
                                <?php else: ?> 
                                -
                                <?php endif; ?>
                            </td>
                            <?php if(in_array('NEONATAL',$delete_permission)): ?>
                            <td class="hidden-xs text-center">
                                <a class="icon btn btn-danger btn-remove mr-10" href="javascript:void(0);" onclick="DeleteData(<?php echo e($results[$i]->NeonatalId, false); ?>, <?php echo e($results[$i]->hasAdmission, false); ?>)" title="Remove Record">
                                <i class="fa fa-trash"></i> 
                                </a>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endfor; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center"><span> No Record Found </span></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_footer clearfix">
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <div class="dataTables_info pagination_info" id="DataTables_Table_0_info">
                                    <?php echo e(Lang::get('home.neonatal_showing'), false); ?> <?php echo e($pagination['limit'][0], false); ?> <?php echo e(Lang::get('home.neonatal_to'), false); ?> <?php echo e($pagination['limit'][1], false); ?> <?php echo e(Lang::get('home.neonatal_of'), false); ?> <?php echo e($pagination['total'], false); ?> <?php echo e(Lang::get('home.neonatal_entries'), false); ?> <?php echo e(@$search['search_txt'] != '' ? '(filtered from '. $getTotal .' total entries)' : '', false); ?>

                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 pagination-xs">
                                <div class="dataTables_paginate paging_bootstrap pagination_footer">
                                    <ul class="pagination">
                                        <li class="prev <?php if(Request::query('page') == '' || Request::query('page') == $pagination['start']): ?> disabled <?php endif; ?>">
                                            <a class="<?php if(Request::query('page') != $pagination['start'] &&  Request::query('page') != ''): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['start'] || Request::query('page') == ''): ?> javascript:void(0); <?php else: ?> <?php echo e(url($actionUrl.'?page='.$pagination['previous']), false); ?><?php endif; ?>">&#8592; <?php echo e(Lang::get('home.neonatal_previous'), false); ?></a>
                                        </li>
                                        <?php for($i = $pagination['start']; $i <= $pagination['end']; $i++): ?> 
                                        <li class="<?php if($i == Request::query('page')): ?> active <?php elseif(Request::query('page') == '' && $i == $pagination['start']): ?> active <?php endif; ?>">
                                            <a class='sort_with_page' href="<?php echo e(url('neonatal?page='.$i), false); ?>"><?php echo e($i, false); ?></a>
                                        </li>
                                        <?php endfor; ?>
                                        <li class="next <?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> disabled <?php endif; ?>">
                                            <a class="<?php if(Request::query('page') != $pagination['end'] && $pagination['start'] != $pagination['end']): ?> sort_with_page <?php endif; ?>" href="<?php if(Request::query('page') == $pagination['end'] || $pagination['total'] <= $pagination['limits']): ?> javascript:void(0); <?php else: ?> <?php echo e(url($actionUrl.'?page='.$pagination['next']), false); ?><?php endif; ?>"><?php echo e(Lang::get('home.neonatal_next'), false); ?> → </a>  
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
<!--
    DELETE FORM IS POSTED MANUALLY USING THE DELETEDATA() JAVSCRIPT FUNCTION WHEN USER CLICK 
    -->                
<?php echo Form::open(['method'=> 'DELETE','url' => '','id'=>'DeleteForm']); ?>

<?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
    function DeleteData(id, hasAdmission) {
      if (hasAdmission == true) {
       Showalert('warning','Access denied : This neonatal proforma refered to a postnatal or nicu admission !');
     } else {
    
      bootbox.confirm("Are you sure?",function(confirmed){
        if(confirmed){
          $("#DeleteForm").attr('action',"<?php echo e($actionUrl, false); ?>/"+id);
          $("#DeleteForm").submit();
        }
      });
    
    }
    
    }
    $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({
      placement : 'top'
    });
    });
    
    $('#search').click(function() {
    $('#search-form').submit();
    });
    
    $('.sorting_by').on('click', function(e) {
    e.preventDefault();
    var sortby       = $(this).data('field');
    pagination(sortby);
    });
    
    $('.sort_with_page').click(function(e){
    e.preventDefault();
    var sorting_param = $('#limit-form').serialize();
    var link      = $(this).attr('href');
    var searchText    = $('input[name="search_txt"]').val();
    window.location   = link + '&search_txt=' + searchText + '&' + sorting_param;
    });
    
    $('select[name="limit"]').on('change',function(e) {
    e.preventDefault();
    pagination();
    });
    
    function pagination(sortby) {
    var pagination_url = $('#limit-form').attr('action');
    var limit          = $('select[name="limit"] option:selected').val();
    var searchText     = $('input[name="search_txt"]').val();    
    var sorting_param  = $('#limit-form').serialize();
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
      window.location = pagination_url + '?page=1&search_txt=' + searchText + '&limit=' + limit + '&sortby=' + sortby + '&sortorder=' + sortorder;
    } else {
      window.location = pagination_url + '?page=1&search_txt=' + searchText + '&' + sorting_param;
    }
    
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>