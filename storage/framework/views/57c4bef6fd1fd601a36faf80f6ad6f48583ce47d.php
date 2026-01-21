<?php $__env->startSection('content'); ?>
<?php 
$read_permissions = session('read_permission');
$write_permission = session('write_permission');
?>
<style type="text/css">
    table .btn-warning > i, table .btn-success > i, table .btn-danger::before {
    vertical-align: unset;
    }
</style>
<div class="crumbs bread-crumbs-shadow">
    <ul id="breadcrumbs" class="breadcrumb">
        <li>
            <i class="icon-home"></i>
            <a href="<?php echo e(url('/'), false); ?>">Dashboard</a>
        </li>
        <li>
            <a href="<?php echo e(action('Nurse\NurseSheetController@index'), false); ?>">Nurse Sheets</a>
        </li>
        <li class="current">
            <a href="javascript::void(0);"><?php echo e(isset($baby_details->BabyName) ? 'Admission History of ' : '', false); ?><b class="color-black"><?php echo e(isset($baby_details->BabyName) ? $baby_details->BabyName.'-'.$baby_details->BMrNo : '', false); ?></b></a>
        </li>
    </ul>
        <div class="pull-right">
            <?php 
                $mrn = $baby_details->BMrNo; 

                echo \SiteHelpers::menuList($mrn, 0, 'nurse_sheet_day_list');
            ?>
      </div>
    <?php $closewinlink = isset($closewinlink) && !empty($closewinlink) ? $closewinlink : 'nicu-nurse-sheets'; ?>
    <?php echo e(Form::hidden('closewinlink', @$closewinlink), false); ?>

    <?php echo e(Form::hidden('baby_id', @$baby_details->BabyId), false); ?>

    <?php echo e(Form::hidden('admission_id', @$admission_id), false); ?>

    <a href="<?php echo e(url($closewinlink), false); ?>" class="close-nav pull-right"><i class="fa fa-times"></i></a>
</div>
<!-- /Breadcrumbs line -->
<!--=== Page Content ===-->
<div class="row row-spacing">
    <div class="col-md-12">
        <div class="widget box table-view-shadow">
            <div class="widget-header">
                <h4>Nurse Hour Wise Daycare</h4>
                <?php 
                    $pacs_link = \SiteHelpers::pacsViewerLink(); 
                    $pacs_link = str_replace('MRN', $mrn, $pacs_link);


                    $pacs_link = url('get-pacs-viewer').'/'.$mrn;
                ?>

                <a href="<?php echo e($pacs_link, false); ?>" target="_blank" class="btn btn-default create-btn-spacing btn-basic-shadow pull-right btn-custom-pacs">
                <i class="fas fa-x-ray"></i>
                <span>PACS</span>
                </a>   
                <?php if(in_array('NICU_MODULE_SHEET',$write_permission)): ?>
                <a href="<?php echo e(action('Nurse\NurseSheetController@show',\SiteHelpers::encrypt_id($latest_admission_id.'-'.$baby_details->BabyId)), false); ?>" title="Create New" class="btn  create-btn-spacing btn-basic-shadow btn-info pull-right"><i class="fa fa-plus "></i> <span>Create New</span></a>   
                <?php endif; ?> 
                <select class="admission-filter form-control input-width-medium pull-right m-5-must"></select> 
                <!-- <button class="btn btn-info pull-right m-5-must" id="export" data-bmrn-no="<?php echo e(\SiteHelpers::encrypt_id($baby_details->BMrNo), false); ?>" data-admission-id="<?php echo e(\SiteHelpers::encrypt_id($latest_admission_id), false); ?>">Export</button> -->
            </div>
            <div class="widget-content inherittable">
                <table class="table table-striped table-bordered table-responsive"  id="data-list">
                    <thead>
                        <tr>
                            <th>Days</th>
                            <th>Date</th>
                            <th class="center-align-phone">View / Print</th>
                            <th class="center-align-phone">Weekly Chart</th>
                            <th class="center-align-phone">Prescription</th>
                            <th class="center-align-phone">Graphical View</th>
                            <th class="center-align-phone">Lab Result</th>
                            <th>All-In-One chart</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($day_list) != 0): ?>
                        <?php  $i = count($day_list); ?>
                        <?php $__currentLoopData = $day_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td>
                                <a class="pull-left input-width-small <?php if(!in_array('NICU_MODULE_SHEET',$write_permission)): ?> permission-denied <?php endif; ?>" href="<?php if(in_array('NICU_MODULE_SHEET',$write_permission)): ?> <?php echo e(action('Nurse\NurseSheetController@edit',\SiteHelpers::encrypt_id($list->id)), false); ?> <?php endif; ?>">
                                Day <?php echo e($i, false); ?>

                                </a>
                                <span class="pull-left">
                                    <?php if(isset($file_list[$list->id])): ?>
                                        <?php $__currentLoopData = $file_list[$list->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php echo $__env->make('registration.media_list', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </span>
                            </td>
                            <td><?php echo e(date('d-m-Y', strtotime($list->sheet_date)), false); ?></td>
                            <td class="center-align-phone">
                                <a class="btn btn-success btn-xs btn-custom" href="<?php echo e(action('Nurse\NurseSheetController@print',\SiteHelpers::encrypt_id($list->id)), false); ?>/<?php echo e($closewinlink, false); ?>"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                            </td>
                            <td class="center-align-phone">
                                <a class="btn btn-danger btn-xs btn-custom" href="<?php echo e(url('nicu-nurse-sheets/get-weekly-observations/'.\SiteHelpers::encrypt_id($list->admission_id).'/'.date('d-m-Y', strtotime($list->sheet_date))), false); ?>?closewinlink=<?php echo e($closewinlink, false); ?>"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                            </td>
                            <td class="center-align-phone">
                                <?php if(in_array('PRESCRIPTION',$write_permission)): ?>
                                <a class="btn btn-warning btn-xs btn-custom" href="<?php echo e(url('prescription/'.\SiteHelpers::encrypt_id($list->BabyId.'-'.$list->admission_id).'/').'/'.$closewinlink, false); ?>"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                                <?php else: ?>
                                <a class="btn btn-warning btn-xs btn-custom" href="<?php echo e(url('prescription-print/'.\SiteHelpers::encrypt_id($list->BabyId).'/'.\SiteHelpers::encrypt_id($list->admission_id).'/'.date('d-m-Y').'/'.$closewinlink), false); ?>"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                                <?php endif; ?>
                            </td>
                            <td class="center-align-phone">
                                <a class="btn btn-info btn-xs btn-custom" href="<?php echo e(action('Nurse\NurseChartController@graphicalview',[\SiteHelpers::encrypt_id($list->BabyId), \SiteHelpers::encrypt_id($list->admission_id)]), false); ?>?date=<?php echo e($list->sheet_date, false); ?>&closewinlink=<?php echo e($closewinlink, false); ?>"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View</span></a>
                            </td>
                            <td class="center-align-phone">
                                <a class="btn btn-primary btn-xs btn-custom" href="<?php echo e(url('lab-value-print'), false); ?>?mrn=<?php echo e(\SiteHelpers::encrypt_id($mrn), false); ?>&closewinlink=nicu-nurse-sheet-day&closewinlink2=<?php echo e($closewinlink, false); ?>&admission_id=<?php echo e($list->admission_id, false); ?>"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm"> View / Print</span></a>
                            </td>
                            <td>
                                <a class="btn btn-secondary btn-xs btn-custom" href="<?php echo e(url('multiple-chart').'/'.\SiteHelpers::encrypt_id($list->BabyId).'/'.\SiteHelpers::encrypt_id($list->admission_id).'/'.$list->sheet_date.'/'.$closewinlink, false); ?>"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm"> View</span></a>
                               <!--  <a class="btn btn-secondary btn-xs btn-custom" href="<?php echo e(url('live-chart'), false); ?>?baby_id=<?php echo e(SiteHelpers::encrypt_id($list->BabyId), false); ?>&admission_id=<?php echo e(SiteHelpers::encrypt_id($list->admission_id), false); ?>" id="live-chart">
                                <i class="fa fa-line-chart" aria-hidden="true"></i>
                                Live Chart
                                </a> -->
                            </td>
                        </tr>
                        <?php $i--; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="8" align="center">No Records Found</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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
    $(document).ready(function() {
      var baby_id = $('input[name="baby_id"]').val();
      var admission_id = $('input[name="admission_id"]').val();
    
      $.ajax({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        url: "<?php echo e(url('nicu-nurse-sheets/get-admission-list'), false); ?>/"+baby_id,
        success: function(response) {
          if (response.type == 'success') {
            var admission_list = response.admission_list;
            var option = '';
            $.each(admission_list, function(key, value) {
              if (value.AdmissionId == admission_id) {
                option += '<option value="'+value.AdmissionId+'" selected="selected">'+value.episodes+'</option>';
              } else {
                option += '<option value="'+value.AdmissionId+'">'+value.episodes+'</option>';
              }
            });
            $(".admission-filter").html(option);
            // $(".admission-filter option:last").attr("selected", "selected").trigger('change');
          }
        }
      });
    
      $('.admission-filter').trigger('change');
    
      $('.admission-filter').on('change', function() {
        var admission_id = $(this).val();
        var closewinlink = $('input[name="closewinlink"]').val();
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: 'GET',
          url: "<?php echo e(url('nicu-nurse-sheet-day'), false); ?>/"+admission_id+'/'+closewinlink,
          success: function(response) {
            if (response.type == 'success') {
              var day_list = [];
              var day_list_temp = response.day_list;
              var content_temp = '';
              var i = 1;
    
              $.each(day_list_temp, function(key, value) {
                day_list.push(value);
              });
    
              day_list.sort((a, b) => (a.sheet_date > b.sheet_date) ? 1 : -1);
    
              $.each(day_list, function(key, value) {
                var content = '';
                var sheetdate = value.sheet_date;
                var id = value.id;
                var admission_id = value.admission_id;
                var BabyId = value.BabyId
    
                var sheet_date = sheetdate.split('-');
                sheet_date = new Date(sheet_date[0], (sheet_date[1] - 1), sheet_date[2]);
    
                var sheet_day = (sheet_date.getDate() > 9) ? sheet_date.getDate() : '0' + sheet_date.getDate();
                var sheet_month = ((sheet_date.getMonth() + 1) > 9) ? (sheet_date.getMonth() + 1) : ('0' + (sheet_date.getMonth() + 1));
                var sheet_year = sheet_date.getFullYear();
    
                var sheet_date = sheet_day + '-' + sheet_month + '-' + sheet_year;
                
                var edit = "<?php echo e(url('nicu-nurse-sheets'), false); ?>/"+value.encrypted_id+"/edit";
                var nurse_sheet_print = "<?php echo e(url('nicu-nurse-sheet-print'), false); ?>/"+value.encrypted_id+"/"+closewinlink;
                var weekly_observartion_print = "<?php echo e(url('nicu-nurse-sheets/get-weekly-observations'), false); ?>/"+value.encrypted_admission_id+"/"+sheet_date+"?closewinlink="+closewinlink;
                var prescription = "<?php echo e(url('prescription'), false); ?>/"+value.encrypted_baby_admission_id+"/"+closewinlink;
                var graphical_view = "<?php echo e(url('nicu-nurse-sheet-graph'), false); ?>/"+value.encrypted_baby_id+"/"+value.encrypted_admission_id+"?date="+sheet_date+"&closewinlink="+closewinlink;
                var lab_print = "<?php echo e(url('lab-value-print'), false); ?>?mrn=<?php echo e(\SiteHelpers::encrypt_id($mrn), false); ?>&closewinlink=nicu-nurse-sheet-day&closewinlink2="+closewinlink+'&admission_id='+admission_id;
                var all_in_one_chart = "<?php echo e(url('multiple-chart'), false); ?>/"+value.encrypted_baby_id+"/"+value.encrypted_admission_id+"/"+sheetdate+"/"+closewinlink;
    
                content += '<tr>';
                content += '<td>';
                content += '<a href="'+edit+'">';
                content += 'Day '+i;
                content += '</a>';
                content += '</td>';
                content += '<td>'+sheet_date+'</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-success btn-xs btn-custom" href="'+nurse_sheet_print+'"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-danger btn-xs btn-custom" href="'+weekly_observartion_print+'"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-warning btn-xs btn-custom" href="'+prescription+'"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-info btn-xs btn-custom" href="'+graphical_view+'"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm">View</span></a>';
                content += '</td>';
                content += '<td class="center-align-phone">';
                content += '<a class="btn btn-primary btn-xs btn-custom" href="'+lab_print+'"><i class="fa fa-print"></i> <span class="hidden-phone hidden-sm">View / Print</span></a>';
                content += '</td>';
                content += '<td>';
                content += '<a class="btn btn-secondary btn-xs btn-custom" href="'+all_in_one_chart+'"><i class="fa fa-eye"></i> <span class="hidden-phone hidden-sm">View</span></a>';
                content += '</td>';
                content += '</tr>';
    
                content_temp = content + content_temp;
    
                i++;
              });
    
              if (content_temp == '') {
                content_temp = '<tr><td colspan="8" align="center">No Records Found</td></tr>';
              }
              $('table tbody').html(content_temp);

              var menu_list = response.menu_list;

              $('.nicu-ward-menu').parent().html(menu_list);

            }
          }
        });
    });
      $('#export').click(function() {
          var babyMrn = $(this).attr('data-bmrn-no');
          var admission = $(this).attr('data-admission-id');
          window.location = "<?php echo e(url('baby-data'), false); ?>" + '/' + babyMrn + '/' + admission;
      });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>