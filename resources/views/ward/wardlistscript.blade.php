<script type="text/javascript">


   /* restricte the droping object  */
   function restricteBabyDrop(e) {

     e.preventDefault();
   }

   /* set the draging object into the events */
   function babyDragComponent(e) {
         
     e.dataTransfer.setData("target-text", e.target.id);
     e.dataTransfer.setData("target-y", e.clientY);

   }

   function findParentNodeClass(el,className) {

      className = className.toLowerCase();

      while (el && el.parentElement) {
        el = el.parentElement;
        if (el.classList.contains(className)) {
          return el;
        }
      }
      return null;

  }

   function getdropComponent(e) 
   {
       e.preventDefault();
       var dragingComponent         = e.dataTransfer.getData("target-text");

       var dragComId                = document.getElementById(dragingComponent);
       var dropPosition             = document.elementFromPoint(e.clientX,e.clientY);
       var sourceYaxis              = e.dataTransfer.getData("target-y");
       var sourceContainer          = dragComId.parentNode;

       if (dragComId.classList.contains('bed-transfer') && dropPosition.classList.contains('bed-transfer-restricted')) {


            bootbox.confirm("Are you sure want to transfer the baby?",function(confirmed) {

             if (confirmed) {



               var tempSourceResource       = findParentNodeClass(dragComId, 'bed-manager'); 
               var tempDestinationResource  = findParentNodeClass(dropPosition, 'bed-manager'); 
               var sourceBedid              = $('#'+dragComId.id).data('bed-id');
               var destiBedid               = $('#'+dropPosition.id).data('bed-id');

               var tempSourceResourceHtml            = tempSourceResource.innerHTML;
               var tempDestinationResourceHtml       = tempDestinationResource.innerHTML;

                   // tempDestinationResource.innerHTML = tempSourceResourceHtml;
                   // tempSourceResource.innerHTML      = tempDestinationResourceHtml;
                      var sourceImage      = dragComId.src; 
                      var destiImage       = dropPosition.src;
                          dragComId.src    = destiImage;
                          dropPosition.src = sourceImage;
                      var babyId      = $('.bed-details-text-'+sourceBedid).children('table').data('baby-id');
                      var admissionId = $('.bed-details-text-'+sourceBedid).children('table').data('admission-id');

                      var sourceHtml        = $('.bed-details-text-'+sourceBedid).html();
                      var destinationHtml   = $('.bed-details-text-'+destiBedid).html();
              
                      $('.bed-details-text-'+sourceBedid).html(destinationHtml);
                      $('.bed-details-text-'+destiBedid).html(sourceHtml);

                       var destinationDevice =  $('.image-border-line-'+destiBedid).html();
                       var sourceDevice      =  $('.image-border-line-'+sourceBedid).html();
                          $('.image-border-line-'+destiBedid).html(sourceDevice);
                          $('.image-border-line-'+sourceBedid).html(destinationDevice);

                      $('#'+dragComId.id).addClass('bed-transfer-restricted').removeClass('bed-transfer');
                      $('#'+dropPosition.id).addClass('bed-transfer').removeClass('bed-transfer-restricted');

                      $('#'+tempSourceResource.id).addClass('bed-available').removeClass('bed-occupied');
                      $('#'+tempDestinationResource.id).addClass('bed-occupied').removeClass('bed-available');




                      var wardId    = $('#'+dropPosition.id).data('ward-id');
                      var roomId    = $('#'+dropPosition.id).data('room-id');
                      var bedId     = $('#'+dropPosition.id).data('bed-id');
                      var oldBedId  = $('#'+dragComId.id).data('bed-id');

                      bedLog(babyId, admissionId, wardId, roomId, bedId, oldBedId);
                      bedComponentListner(dropPosition.id);





            }
          });

        } else if(!dropPosition.classList.contains('bed-transfer-restricted')) {

                      var tempSourceResource       = findParentNodeClass(dragComId, 'bed-manager'); 
                      var tempDestinationResource  = findParentNodeClass(dropPosition, 'bed-manager'); 

                      var sourceBedid              = $('#'+dragComId.id).data('bed-id');
                      var destiBedid               = $('#'+dropPosition.id).data('bed-id');

                      var sourceImage      = dragComId.src; 
                      var destiImage       = dropPosition.src;
                          dragComId.src    = destiImage;
                          dropPosition.src = sourceImage;
                      var babyIdone        = $('.bed-details-text-'+sourceBedid).children('table').data('baby-id');
                      var admissionIdone   = $('.bed-details-text-'+sourceBedid).children('table').data('admission-id');

                      var babyIdtwo        = $('.bed-details-text-'+destiBedid).children('table').data('baby-id');
                      var admissionIdtwo   = $('.bed-details-text-'+destiBedid).children('table').data('admission-id');

              

                      var sourceHtml      = $('.bed-details-text-'+sourceBedid).html();
                      var destinationHtml = $('.bed-details-text-'+destiBedid).html();
              
                      $('.bed-details-text-'+sourceBedid).html(destinationHtml);
                      $('.bed-details-text-'+destiBedid).html(sourceHtml);


                      var wardIdone      = $('#'+dropPosition.id).data('ward-id');
                      var roomIdone      = $('#'+dropPosition.id).data('room-id');
                      var bedIdone       = $('#'+dropPosition.id).data('bed-id');
                      var oldBedIdone    = $('#'+dragComId.id).data('bed-id');

                      var wardIdtwo      = $('#'+dragComId.id).data('ward-id');
                      var roomIdtwo      = $('#'+dragComId.id).data('room-id');
                      var bedIdtwo       = $('#'+dragComId.id).data('bed-id');
                      var oldBedIdtwo    = $('#'+dropPosition.id).data('bed-id');

                         
                      bedLogInterChange(babyIdone, admissionIdone, wardIdone, roomIdone, bedIdone, oldBedIdone, 
                                        babyIdtwo, admissionIdtwo, wardIdtwo, roomIdtwo, bedIdtwo, oldBedIdtwo);


        }  

   }

   // function bedLog(babyId, admissionId, wardId, roomId, bedId, oldBedId) {

   //      $.ajaxSetup({
   //        headers: {
   //            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
   //        }
   //      });
        

   //     $.ajax({
   //        type    :"POST",
   //        url     :"{{ action('Ward\BabyWardController@getupdatebedlog') }}",
   //        data    :{ babyId:babyId, admissionId:admissionId, wardId:wardId, roomId:roomId, bedId:bedId, oldBedId:oldBedId },
   //        success :function(response) {
   //          Showalert(response.type,response.message);
            
   //          setTimeout(function() {
   //             location.reload();
   //          },5000)
            
   //        },
   //        error:function(response) {
   //          Showalert(response.type,response.message);
   //        }
   //    });


   // }

   function bedLogInterChange(babyIdone, admissionIdone, wardIdone, roomIdone, bedIdone, oldBedIdone, 
                              babyIdtwo, admissionIdtwo, wardIdtwo, roomIdtwo, bedIdtwo, oldBedIdtwo) {

        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        $.ajax({
            type    :"GET",
            url     :"{{ action('Ward\BabyWardController@getbabyinterchange') }}",
            data    :{ babyIdone:babyIdone, admissionIdone:admissionIdone, wardIdone:wardIdone, roomIdone:roomIdone, bedIdone:bedIdone, oldBedIdone:oldBedIdone,
                       babyIdtwo:babyIdtwo, admissionIdtwo:admissionIdtwo, wardIdtwo:wardIdtwo, roomIdtwo:roomIdtwo, bedIdtwo:bedIdtwo, oldBedIdtwo:oldBedIdtwo},
            success :function(response) {
              Showalert(response.type,response.message);
            },
            error:function(response) {
              Showalert(response.type,response.message);
            }
        });

   }

   //add event listner for basic components 
   function bedComponentListner(componentId) {

       var  basicComponent = document.getElementById(componentId);
            basicComponent.addEventListener('dragstart',babyDragComponent,false);
            basicComponent.addEventListener('drop',restricteBabyDrop,false);
   }

   //add event listner for basic components 
   function bedLayoutListner(containerId) {
      var  baseContainer =  document.getElementById(containerId);
           baseContainer.addEventListener('dragover',restricteBabyDrop,false);
           baseContainer.addEventListener('drop',getdropComponent,false);

   }

       //restirct event listner for basic components 
   function restrictComponentListner(componentId) {

       var  basicComponent = document.getElementById(componentId);
            basicComponent.addEventListener('dragstart',restricteBabyDrop,false);
            basicComponent.addEventListener('drop',restricteBabyDrop,false);
   }

    $('.add-patient').click(function() {

        var wardId = $(this).data('add-ward-id');
        var roomId = $(this).data('add-room-id');
        var bedId  = $(this).data('add-bed-id');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         $.ajax({

            type    :"GET",
            url     :"{{ action('Ward\BabyWardController@create') }}",
            data    :{wardId:wardId, roomId:roomId, bedId:bedId},
            success :function(response) {

                var babyList = '';
                $.each(response.baby_list, function(index, value) {
                    babyList +='<option value="'+index+'">'+value+'</option>';
                });

                $('select[name="admission_baby_id"]').attr('data-ward-transfer-id', response.bedDetails.wardid);
                $('select[name="admission_baby_id"]').attr('data-room-transfer-id', response.bedDetails.roomid);
                $('select[name="admission_baby_id"]').attr('data-bed-transfer-id', response.bedDetails.bedid);

                $('select[name="admission_baby_id"]').html(babyList);
                $('#baby-bed-modal').modal({backdrop: 'static', show: true });

            },
            error :function(response) {

                Showalert(response.responseJSON.type, response.responseJSON.message);

                $('select[name="admission_baby_id"]').removeAttr('data-ward-transfer-id');
                $('select[name="admission_baby_id"]').removeAttr('data-room-transfer-id');
                $('select[name="admission_baby_id"]').removeAttr('data-bed-transfer-id');
                
            }
        });     

    }); 

    $('#admitte-baby-bed').click(function() {

 
         var babyid     =  $('select[name="admission_baby_id"]').val();
         var wardid     =  $('select[name="admission_baby_id"]').data('ward-transfer-id');
         var roomid     =  $('select[name="admission_baby_id"]').data('room-transfer-id');
         var bedid      =  $('select[name="admission_baby_id"]').data('bed-transfer-id');
         var deivceList = $('#admission_device_id').val();
         $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
         });
         
         $.ajax({
            type    :"GET",
            url     :"{{ action('Ward\BabyWardController@getaddbabytobed') }}",
            data    :{babyid:babyid, wardid:wardid, roomid:roomid, bedid:bedid, deivceList:deivceList},
            success :function(response) {
                 Showalert(response.type,response.message);
                 $("#baby-bed-modal").modal("hide");
                  location.reload(); 
            },
            error:function(response) {
                Showalert(response.type,response.message);
                 $("#baby-bed-modal").modal("hide");

            }
        });     


    });

function getRemoveSyringePump(wardId, roomId, bedId, babyId, admissionId) {

   $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         $.ajax({

            type    :"PATCH",
            url     :"{{ action('Syringepump\SyrangePumpController@update', 0) }}",
            data    :{wardId:wardId, roomId:roomId, bedId:bedId, babyId:babyId, admissionId:admissionId},
            success :function(response) {
                Showalert(response.type,response.message);

                location.reload(); 

            },
            error :function(response) {
                Showalert(response.type,response.message);
                location.reload(); 
            }
        });
}  

function getRemoveInfusionPump(wardId, roomId, bedId, babyId, admissionId) {

   $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

         $.ajax({

            type    :"PATCH",
            url     :"{{ action('infusion\InfusionController@update', 0) }}",
            data    :{wardId:wardId, roomId:roomId, bedId:bedId, babyId:babyId, admissionId:admissionId},
            success :function(response) {
                Showalert(response.type,response.message);
                
               location.reload(); 

            },
            error :function(response) {
                Showalert(response.type,response.message);
               location.reload(); 
            }
        });
}   

    // $.contextMenu({
    //   selector: '.discharge-patient',
    //     items: {
    //         RemoveSyringePump: {
    //             name: "Remove Syringe Pump",
    //             callback: function(key, opt){
    //               var wardId      = $(this).data('add-ward-id');
    //               var roomId      = $(this).data('add-room-id');
    //               var bedId       = $(this).data('add-bed-id');
    //               var babyId      = $(this).data('add-baby-id');
    //               var admissionId = $(this).data('add-admission-id');
    //               getRemoveSyringePump(wardId, roomId, bedId, babyId, admissionId);
    
    //             }
    //         },
    //         RemoveInfusionPump: {
    //             name: "Remove Infusion Pump",
    //             callback: function(key, opt){
    //                   var wardId      = $(this).data('add-ward-id');
    //                   var roomId      = $(this).data('add-room-id');
    //                   var bedId       = $(this).data('add-bed-id');
    //                   var babyId      = $(this).data('add-baby-id');
    //                   var admissionId = $(this).data('add-admission-id');
    //                 getRemoveInfusionPump(wardId, roomId, bedId, babyId, admissionId);
    //             }
    //         }
            
    //     }
    // });


    $('.view-details-in-baby').click(function() {

    });


</script>
