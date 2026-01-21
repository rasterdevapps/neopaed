<script type="text/javascript">
$(document).ready(function() {
  $('.mas-collecton-site').click(function() {
      $('#collecton-site-modal').modal('show');
      $('input[name="Name[]"]').val('')
  });

  $('.mas-collecton-method').click(function() {
      $('#mas-collecton-method-modal').modal('show');
      $('input[name="Name[]"]').val('')

  });

  $('.mas-order-physician').click(function() {
    $('#mas-order-physician-modal').modal('show');
  });

  $('.mas-diagnosis-add').click(function() {
      $('#mas-diagnosis-modal').modal('show');
  });

  $('#save-collection-site').click(function() {
          $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'POST',
              data:$( "#collection-site-post" ).serialize(),
              url: "{{ url('collection-site-update-master') }}",
              success:function(response) {
                 Showalert(response.messageType,response.message);
                 $('#collecton-site-modal').modal('hide');
                 var options1 = '<option value="'+response.data.id+'">'+response.data.name+'</option>';
                  $('select[name="collection_site"]').each(function() {
                      $(this).append(options1)
                  });
              }
            });

    });

  $('#save-collection-method').click(function() {
          $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'POST',
              data:$( "#collection-method-post" ).serialize(),
              url: "{{ url('collection-method-update-master') }}",
              success:function(response) {
                Showalert(response.messageType,response.message);
                 $('#mas-collecton-method-modal').modal('hide');
                
                 var options1 = '<option value="'+response.data.id+'">'+response.data.name+'</option>';
                  $('select[name="collection_method"]').each(function() {
                      $(this).append(options1)
                  });
                  
               
              }
            });

    });

  $('#save-doctors').click(function() {
          $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'POST',
              data:$( "#master-doctors-post" ).serialize(),
              url: "{{ url('doctors-update-master') }}",
              success:function(response) {
                Showalert(response.messageType,response.message);
                 $('#mas-collecton-method-modal').modal('hide');
                
                 var options1 = '<option value="'+response.data.id+'">'+response.data.name+'</option>';
                  $('select[name="order_physician"]').each(function() {
                      $(this).append(options1);
                  });                  
              }
            });

    });

  $('#save-diagnosis-master').click(function() {
        $.ajax({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              type:'POST',
              data:$( "#master-diagnosis-post" ).serialize(),
              url: "{{ url('icd-update-master') }}",
              success:function(response) {
                Showalert(response.messageType,response.message);
                 $('#mas-diagnosis-modal').modal('hide');
                
                 var options1 = '<option value="'+response.data.ICDCode+'">'+response.data.ICDDescription+'-'+response.data.ICDCode+'</option>';
                  $('select[name="diagnosis[]"]').each(function() {
                      $(this).append(options1)
                  });
                  
               
              }
        });
  });   


});
</script>