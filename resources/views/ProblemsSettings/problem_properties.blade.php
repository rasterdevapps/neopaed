@if($formType == 'modal')
  <div class="modal fade problem-properties" id="component_parameter_form" tabindex="-1" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
      {!! Form::model(null,['url' => action('ProblemsSettings\ProblemsSettingController@store'),'id'=>'fields-form', 'class'=>'m-0']) !!}    
        <div class="modal-header problem-modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
          <h4 id="myModalLabel" class="modal-title"> {!! $componentHeading !!}</h4>
        </div>
        <div class="modal-body row plr-15">
     	    {!! Form::hidden('param_id',0)  !!}
          {!! Form::hidden('component_type',@$typeofComponent,['class'=>'form-control']) !!}
          <div class="error-message display-none"> <b> The highlighted fields are mandatory ! </b></div>
          <div class="col-md-12 content-component">
              <div class="form-group">
      			    {!! Form::label('component_label','Label :',['class'=>'label-shadow']) !!}
                {!! Form::text('component_label',null,['class'=>'form-control input-background','required'=>'true']) !!}
      			  </div>
              <div class="form-group">
                {!! Form::label('component_name','Name :',['class'=>'label-shadow']) !!} 
                <span class="charonly">use only character</span>
                {!! Form::text('component_name',null,['class'=>'form-control input-background','required'=>'true']) !!}
              </div>
            @if($typeofComponent == 'type-text' || $typeofComponent == 'type-number' || $typeofComponent == 'type-decimal')
              <div class="form-group">
                  {!! Form::label('component_placeholder','Placeholder :',['class'=>'label-shadow']) !!}
                  {!! Form::text('component_placeholder',null,['class'=>'form-control input-background']) !!}
              </div>  
            @endif
          
            @if($typeofComponent  == 'type-label')
              <div class="form-group">
                <table class="table">
                  <thead>
                    <tr>
                      <th>{!! Form::label('component_fontsize','Font size :',['class'=>'label-shadow']) !!}</th>
                      <th></th>
                    </tr>  
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type ="range" id="range_fontsize" name="range_fontsize" value="14" min ="14" max="40" oninput="document.getElementById('component_fontsize').value = this.value;" class="form-control input-background" step ="1"/> </td>
                      <td>{!! Form::text('component_fontsize',14,['class'=>'form-control  input-width-mini input-background','readonly'=>true,'id'=>'component_fontsize']) !!}</td>
                    </tr>
                  </tbody>
                </table>
              </div>  
            @endif
            
            @if($typeofComponent =='type-textarea')
              <table class="table form-check-option">
                <thead>
                  <tr>
                      <th>{!! Form::label('component_row','No of Row:',['class'=>'label-shadow']) !!}</th> 
                      <th>{!! Form::label('component_col','No of column:',['class'=>'label-shadow']) !!}</th>                              
                  </tr>
                </thead>
                <tbody>
                  <tr>
                      <td>{!! Form::number('component_row',null,['class'=>'form-control input-background','min'=>3]) !!}</td>
                      <td>{!! Form::number('component_col',null,['class'=>'form-control input-background','min'=>3]) !!}</td>
                  </tr>
                </tbody> 
              </table>
            @endif
           

            @if($typeofComponent == 'type-drugs')
              <div class="hidden">
                 {!! Form::select('temp_medicine',$Medications,null) !!}
              </div>
            @endif

            @if($typeofComponent == 'type-antibiotic')
              <div class="hidden">
                 {!! Form::select('temp_antibiotic',$Antibiotic,null) !!}
              </div>
            @endif
                        
            @if($typeofComponent == 'type-select' )
             <!--  <div class="form-group">
                {!! Form::label('component_option_type','Option Type:') !!}
                <label class="radio-inline">
                  {!! Form::radio('component_option_type[]',1,true) !!}<b>Master</b>
                </label>
                <label class="radio-inline">
                  {!! Form::radio('component_option_type[]',2,false) !!}<b> Customs  </b> 
                </label> 
              </div>
              <div class="form-group select-drop-option-master">
                  {!! Form::label('component_option_master','Option Masters:') !!}
                  {!! Form::select('component_option_master',$option_masters,null,['class'=>'form-control']) !!}
              </div> -->
            @endif

            @if($typeofComponent == 'type-select')
              <div class="form-group select-drop-option-custom">
                <table class="table form-com-option">
                  <thead>
                    <tr>
                      <th>{!! Form::label('component_option','Option Name:',['class'=>'label-shadow']) !!}</th> 
                      <th>{!! Form::label('component_option','Option Value:',['class'=>'label-shadow']) !!}</th>
                      <th>{!! Form::label('sction','Action:',['class'=>'label-shadow']) !!}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <tr>
                      <td>{!! Form::text('component_option_name[]','',['class'=>'form-control input-background']) !!}</td>
                      <td>{!! Form::text('component_option_value[]','',['class'=>'form-control input-background']) !!}</td>
                      <td>
                        <span class="select-options-drop btn btn-default fa fa-plus add-button"></span>
                        <span class="fa fa-remove btn btn-default remove-select remove-button"></span>
                      </td>
                    </tr>
                  </tbody> 
                </table>
              </div>
            @endif 

            @if($typeofComponent == 'type-horizontal-selector')
              <div class="form-group select-drop-option-custom">
                <table class="table form-com-hoption">
                  <thead>
                    <tr>
                      <th>{!! Form::label('component_option','Option Name:',['class'=>'label-shadow']) !!}</th> 
                      <th>{!! Form::label('component_option','Option Value:',['class'=>'label-shadow']) !!}</th>
                      <th>{!! Form::label('component_option','Option Color:',['class'=>'label-shadow']) !!}</th>
                      <th>{!! Form::label('sction','Action:',['class'=>'label-shadow']) !!}</th>
                    </tr>
                  </thead>
                  <tbody> 
                    <tr>
                      <td>{!! Form::text('hcomponent_option_name[]','',['class'=>'form-control input-background']) !!}</td>
                      <td>{!! Form::text('hcomponent_option_value[]','',['class'=>'form-control input-background']) !!}</td>
                      <td>{!! Form::text('hcomponent_option_color[]',null,['class'=>'form-control input-background input-width-small']) !!}</td>
                      <td>
                        <span class="select-options-hdrop btn btn-default fa fa-plus add-button"></span>
                        <span  class="fa fa-remove btn btn-default remove-select remove-button"></span>
                      </td>                     
                    </tr>
                  </tbody> 
                </table>
              </div>
            @endif 

            @if($typeofComponent == 'type-check-box' || $typeofComponent == 'type-radio')
              <div class="form-group check-box-option">
                <table class="table form-check-option">
                  <thead>
                      <tr>
                          <th>{!! Form::label('component_chkop','Option Name:',['class'=>'label-shadow']) !!}</th> 
                          <th>{!! Form::label('component_chkop','Option Value:',['class'=>'label-shadow']) !!}</th>                              
                          <th></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>{!! Form::text('component_chkop_name[]',null,['class'=>'form-control input-background']) !!}</td>
                          <td>{!! Form::text('component_chkop_value[]',null,['class'=>'form-control input-background']) !!}</td>
                          <td>
                            <span class="check-option btn btn-default add-button fa fa-plus"></span>
                            <span class="fa fa-remove btn btn-default remove-button remove-select"></span>
                          </td>
                      </tr>
                  </tbody> 
                </table>
              </div>
            @endif
            @if($typeofComponent == 'type-toggle')
            <div class="form-group">
              {!! Form::label('component_toggle','Toggle :') !!}
              <table class="table">
                <thead>
                  <tr>
                    <th>{!! Form::label('component_toggle_on','Label On :',['class'=>'label-shadow']) !!}</th>
                    <th>{!! Form::label('component_toggle_off','Label Off :',['class'=>'label-shadow']) !!}</th>
                    <th>{!! Form::label('component_toggle_width','Width :',['class'=>'label-shadow']) !!}</th>
                  </tr>
                </thead>
                <tbody>     
                  <tr>
                    <td>{!! Form::text('component_toggle_on',null,['class'=>'form-control input-background','data-dependancy'=>'toggle_dependancy_on']) !!}</td>
                    <td>{!! Form::text('component_toggle_off',null,['class'=>'form-control input-background','data-dependancy'=>'toggle_dependancy_off']) !!}</td>
                    <td>{!! Form::text('component_toggle_width',null,['class'=>'form-control input-background']) !!}</td>                                
                  </tr>
                </tbody>
              </table>
            </div>
            @endif
            
            @if($typeofComponent == 'type-number' || $typeofComponent == 'type-decimal') 
            <div class="form-group">
                {!! Form::label('component_number','Validation :',['class'=>'label-shadow']) !!}
                <table class="table">
                    <thead>
                        <tr>
                            <th>{!! Form::label('component_min','Min :',['class'=>'label-shadow']) !!}</th>
                            <th>{!! Form::label('component_max','Max :',['class'=>'label-shadow']) !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th>{!! Form::number('component_min',null,['class'=>'form-control input-background']) !!}</th>
                            <th>{!! Form::number('component_max',null,['class'=>'form-control input-background']) !!}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif

            @if($typeofComponent == 'type-text' || $typeofComponent == 'type-select')
            <div class="form-group">
               {!! Form::label('component_addmore','Do you want to make this components with add more option ? :',['class'=>'label-shadow']) !!}
               {!! Form::checkbox('component_addmore',1,false,['class'=>'input-background']) !!} 
            </div> 
            @endif

            @if($typeofComponent == 'type-number' || $typeofComponent == 'type-decimal' || $typeofComponent == 'type-text' || $typeofComponent == 'type-textarea')
             <div class="form-group">
               {!! Form::label('component_val_req','Do you want to make this components as required ?',['class'=>'label-shadow']) !!}
               {!! Form::checkbox('component_val_req',1,false,['class'=>'input-background']) !!} 
             </div> 
            @endif

            @if($typeofComponent =='type-text' && $typeofComponent =='type-textarea')
              <div class="form-group">
                {!! Form::label('component_validation','Is requierd:',['class'=>'label-shadow']) !!}
                 <label class="radio-inline">
                   {!! Form::checkbox('component_option_type[]',2,false,['class'=>'input-background']) !!}<b> Customs  </b> 
                </label> 
              </div>
            @endif  
             <div class="form-group">
               {!! Form::label('component_discharge','Hide in discharge summary:',['class'=>'label-shadow']) !!}
               {!! Form::checkbox('component_discharge',1,false,['class'=>'input-background']) !!} 
             </div> 

            @if($baseLayout == 2)     
      			 <div class="form-group">
      			     {!! Form::label('component_position','Component position :',['class'=>'label-shadow']) !!}
      			     {!! Form::select('component_position',['problem-fields-left'=>'Left','problem-fields-right'=>'Right'],null,['class'=>'form-control input-background']) !!}
      			 </div>
            @endif 
            
         </div>
        </div>    
        <div class="modal-footer">  
              <button class="btn btn-primary problem-submits btn-basic-shadow" type="submit"> Add</button>
        </div>
      {!! Form::close(); !!}
      </div>
    </div>
  </div>
@elseif($formType == 'sidebar')

  {!! Form::model(null,['url' => '','id'=> 'component-property']) !!}
    <div class="form-group">
      {!! Form::label('fcomponent_label','Label :') !!}
      {!! Form::text('fcomponent_label',null,['class'=>'form-control field-property','data-og-element-id'=>'para_label'.$groupId]) !!}
    </div>
    @if($typeofComponent  != 'type-drugs')
    <div class="form-group">
       {!! Form::label('fcomponent_name','Name :') !!}
       {!! Form::text('fcomponent_name',null,['class'=>'form-control field-property','data-og-element-id'=>'para_name'.$groupId]) !!}
    </div>
    @endif

    @if($typeofComponent == 'type-text' || $typeofComponent == 'type-number' || $typeofComponent == 'type-decimal')
      <div class="form-group">
         {!! Form::label('fcomponent_placeholder','Placeholder :') !!}
         {!! Form::text('fcomponent_placeholder',null,['class'=>'form-control field-property','data-og-element-id'=>'para_placeholder'.$groupId]) !!}
      </div>
    @endif  
   
    @if($typeofComponent  == 'type-label')
      <div class="form-group">
        <table class="table">
          <thead>
            <tr>
              <th>{!! Form::label('fcomponent_fontsize','Font size :',['class'=>'label-shadow']) !!}</th>
              <th></th>
            </tr>  
          </thead>
          <tbody>
            <tr>
              <td><input type ="range" id="range_fontsize" name="range_fontsize" value="14"  min="14" max="40" oninput="document.getElementById('fcomponent_fontsize').value = this.value;" class="form-control input-background field-property-fontsize" data-og-element-id="para_fontsize{{ $groupId }}" step ="1"/> </td>
              <td>{!! Form::text('fcomponent_fontsize',14,['class'=>'form-control  input-width-mini ','readonly'=>true,'data-og-element-id'=>'para_fontsize'.$groupId,'id'=>'fcomponent_fontsize']) !!}</td>
            </tr>
          </tbody>
        </table>
    </div>  
    @endif

    @if($typeofComponent =='type-textarea')
      <div class="form-group">
         {!! Form::label('fnorow','No of Row :') !!}
         {!! Form::number('fnorow',null,['class'=>'form-control field-property','data-og-element-id'=>'para_row'.$groupId,'min'=>3]) !!}
      </div>
      <div class="form-group">
          {!! Form::label('fnocolumn','No of Column :') !!}
          {!! Form::number('fnocolumn',null,['class'=>'form-control field-property','data-og-element-id'=>'para_column'.$groupId,'min'=>3,'max'=>5]) !!}
      </div>
    @endif

    @if($typeofComponent == 'type-select')
      <div class="form-group drop-options">
        {!! Form::label('foption','Options :') !!} 
        <table class="table">
          <thead>
            <tr>
               <th>{!! Form::label('Name','Name :',['class'=>'label-shadow']) !!} </th>
               <th> {!! Form::label('Value','Value :',['class'=>'label-shadow']) !!} </th> 
               <th> </th> 
            </tr>
          </thead>
          <tbody>
            <tr>
               <td>{!! Form::text('foption_name[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'para_option_name'.$groupId]) !!}</td>
               <td>{!! Form::text('foption_value[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'para_option_value'.$groupId]) !!}</td>
              <td>
                   <a href="javascript:void(0);" class="add-drop-option  add-button-round"> <i class="fa fa-plus" aria-hidden="true"></i></a>
                   <a href="javascript:void(0);" class="close-option   remove-button-round "><i class="fa fa-times" aria-hidden="true"></i></a>
              </td> 
            </tr>
          </tbody>
        </table>
      </div>
    @endif
    
    @if($typeofComponent == 'type-horizontal-selector')
      <div class="form-group drop-options">
        {!! Form::label('foption','Options :') !!} 
        <table class="table">
          <thead>
            <tr>
               <th>{!! Form::label('Name','Name :',['class'=>'label-shadow']) !!} </th>
               <th> {!! Form::label('Value','Value :',['class'=>'label-shadow']) !!} </th> 
               <th> {!! Form::label('Color','Color :',['class'=>'label-shadow']) !!} </th> 
               <th> </th> 
            </tr>
          </thead>
          <tbody>
            <tr>
               <td>{!! Form::text('hfoption_name[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'hpara_option_name'.$groupId]) !!}</td>
               <td>{!! Form::text('hfoption_value[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'hpara_option_value'.$groupId]) !!}</td>
               <td>{!! Form::text('hfoption_color[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'hpara_option_color'.$groupId]) !!}</td>
              <td>
                   <a href="javascript:void(0);" class="add-drop-option  add-button-round"> <i class="fa fa-plus" aria-hidden="true"></i></a>
                   <a href="javascript:void(0);" class="close-option   remove-button-round "><i class="fa fa-times" aria-hidden="true"></i></a>
              </td> 
            </tr>
          </tbody>
        </table>
      </div>
    @endif


    @if($typeofComponent == 'type-toggle')
    <div class="form-group">
      {!! Form::label('ftoggleon','Toggle On :') !!}
      {!! Form::text('ftoggleon',null,['class'=>'form-control field-property','data-og-element-id'=>'para_toggle_on'.$groupId]) !!}
    </div>
    <div class="form-group">
      {!! Form::label('ftoggleoff','Toggle Off :') !!}
      {!! Form::text('ftoggleoff',null,['class'=>'form-control field-property','data-og-element-id'=>'para_toggle_off'.$groupId]) !!}
    </div>
    <div class="form-group">
      {!! Form::label('ftogglewidth','Toggle Width :') !!}
      {!! Form::number('ftogglewidth',null,['class'=>'form-control field-property','min'=>'100','max'=>'600','data-og-element-id'=>'para_toggle_width'.$groupId]) !!}
    </div>
    @endif

    @if($typeofComponent == 'type-number' || $typeofComponent == 'type-decimal' || $typeofComponent == 'type-text' || $typeofComponent == 'type-textarea')
      <div class="form-group">
        {!! Form::label('fval_required','Required :') !!}
        {!! Form::checkbox('fval_required',1,false,['class'=>'field-required-property','data-og-element-id'=>'para_required'.$groupId]) !!} 
      </div> 
    @endif

    @if($typeofComponent == 'type-text' || $typeofComponent == 'type-select')
        <div class="form-group">
           {!! Form::label('fcomponent_addmore','Do you need add more option ? :') !!}
           {!! Form::checkbox('fcomponent_addmore',1,false,['class'=>'input-background field-required-property','data-og-element-id'=>'para_addmore'.$groupId,'id'=>'fcomponent_addmore']) !!} 
        </div> 
    @endif

      <div class="form-group">
        {!! Form::label('fcomponent_discharge','Hide in discharge summary :',['class'=>'label-shadow']) !!}
        {!! Form::checkbox('fcomponent_discharge',1,false,['class'=>'input-background field-required-property','data-og-element-id'=>'para_discharge'.$groupId,'id'=>'fcomponent_discharge']) !!} 
      </div>  

    @if($typeofComponent == 'type-number' || $typeofComponent == 'type-decimal') 
    <div class="form-group">
        {!! Form::label('component_number','Validation :') !!}
        <table class="table">
            <thead>
                <tr>
                    <th>{!! Form::label('component_min','Min :') !!}</th>
                    <th>{!! Form::label('component_max','Max :') !!}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>{!! Form::number('fmin',null,['class'=>'form-control field-property','data-og-element-id'=>'para_min'.$groupId]) !!}</th>
                    <th>{!! Form::number('fmax',null,['class'=>'form-control field-property','data-og-element-id'=>'para_max'.$groupId]) !!}</th>
                </tr>
            </tbody>
        </table>
    </div>
    @endif

    @if($typeofComponent =='type-check-box')
    <div class="chk-options">
      {!! Form::label('foption','Options :') !!}  
        
        <table class="table">
          <thead>
            <tr>
               <th> Name :</th>
               <th> Value :</th> 
               <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{!! Form::text('fchkop_name[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'para_chkop_name'.$groupId]) !!}</td>
              <td>{!! Form::text('fchkop_value[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'para_chkop_value'.$groupId]) !!}</td>
              <td>
                <a href="javascript:void(0);" class="add-drop-option add-button-round"> <i class="fa fa-plus" aria-hidden="true"></i></a>
                <a href="javascript:void(0);" class="close-option remove-button-round"><i class="fa fa-times" aria-hidden="true"></i></a>
              </td> 
            </tr>
          </tbody>
        </table>
    </div>
    @endif

    @if($typeofComponent =='type-radio')
    <div class="rdop-options">
      {!! Form::label('foption','Options:') !!}  
        <table class="table">
          <thead>
            <tr>
               <th> Name :</th>
               <th> Value :</th> 
               <th></th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{!! Form::text('frdop_name[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'para_rdop_name'.$groupId]) !!}</td>
              <td>{!! Form::text('frdop_value[]',null,['class'=>'form-control options-collection field-property','data-og-element-id'=>'para_rdop_value'.$groupId]) !!}</td>
              <td>
                <a href="javascript:void(0);" class="add-drop-option add-button-round"> <i class="fa fa-plus" aria-hidden="true"></i></a>
                <a href="javascript:void(0);" class="close-option remove-button-round"><i class="fa fa-times" aria-hidden="true"></i></a>
              </td> 
            </tr>
          </tbody>
        </table>
    </div>
    @endif
   
 {!! Form::close(); !!}   
@endif

