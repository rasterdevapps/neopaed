

    <div class="row select-option-container">
    	<div class="col-md-12">
    
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
            {!! Form::label('short_code','Short Code:') !!}
          </div>
          <div class="col-md-9 custom-input">
            {!! Form::text('short_code',null,['class'=>'form-control input-fields-shadow']) !!}
          </div>
        </div> 
        <div class="form-group row">
          <div class="col-md-3 text-right label-control">
              {!! Form::label('Shortcode Description', 'Shortcode Description:') !!}
          </div>
           <div class="col-md-9 custom-input">
            <div class="tinymce-body" id="description">
                     {!! $results->description !!}
            </div>
               <!-- {!! Form::textarea('description', null , ['id' => 'description', 'class' => 'tinymce-body form-control']) !!} -->
           </div>
        </div>
                                   
       <div class="form-group row">
        <div class="col-md-3 text-right label-control">
          {!! Form::label('active','Status:') !!}
        </div>
        <div class="col-md-9 custom-input">
         {!! Form::select('active',['1'=>'Active','0'=>'Inactive'],null,['class'=>'form-control input-fields-shadow']) !!}
       </div>
     </div>                        		
   </div>
  <div class="col-md-12 select-container-main">
    <button type="submit" class="btn btn-primary form-control btn-basic-shadow input-width-medium">
      <i class="fa fa-floppy-o"></i> 
      <span>{!! $SubmitButtonText !!}</span>
    </button>
    <a href="{{ action('Masters\ShortcodeController@index') }}" class="btn btn-default form-control btn-basic-shadow input-width-medium" onclick="$('form')[0].reset();">
      <i class="fa fa-exclamation-circle"></i> 
      <span>Cancel</span>
    </a>
  </div>
 </div>

<script>
  $(document).ready(function() {
    // Initialize TinyMCE editor on the 'description' textarea
    // tinymce.init({
    //     selector: '#description',
    //     height: 300, // Targeting the textarea with id 'description'
    //     menubar: false,
    //     inline: false,
    //     plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
    //     toolbar: [
    //           'undo redo | bold italic underline strikethrough | fontfamily fontsize blocks',
    //           'alignleft aligncenter alignright alignjustify | numlist bullist | forecolor backcolor casechange | preview | table'
    //       ],
    //   });
    tinymce.init({
      selector: '.tinymce-body',
      menubar: false,
      inline: true,
      plugins: 'preview powerpaste casechange importcss autolink link table lists tinymcespellchecker',
      toolbar: ['undo redo | bold italic underline strikethrough | fontfamily fontsize blocks', 'alignleft aligncenter alignright alignjustify |  numlist bullist | forecolor backcolor casechange | preview | table']
    });
  });
</script>
