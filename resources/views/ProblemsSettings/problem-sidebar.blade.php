 <div class="sidebar-right component-panel panel panel-default">
      
        <div class="form-group layout-options">
            {!! Form::label('base_layout','Layout:') !!}
            <div>
                <label class="radio-inline">
                  @if(@$problems->problem_layout == 1)
                    {!! Form::radio('base_layout[]',1,true) !!}<b> Single-column </b>
                  @else
                    {!! Form::radio('base_layout[]',1,false) !!}<b> Single-column </b>
                  @endif
                </label>
                <label class="radio-inline">
                  @if(@$problems->problem_layout == 2) 
                    {!! Form::radio('base_layout[]',2,true) !!}<b> Double-column  </b> 
                  @else
                    {!! Form::radio('base_layout[]',2,false) !!}<b> Double-column  </b> 
                  @endif  
                </label> 
            </div>      
        </div>
        <div role="tabpanel" class="tabbable tabbable-custom">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#basic-component" role="tab" data-toggle="tab">Components</a></li>
                    <li role="presentation" class=""><a href="#field-propertice" role="tab" data-toggle="tab">Components properties</a></li>

                </ul>
          <!-- Tab panes -->
          <div class="tab-content tab-label-shadow">
            <!-- General Form -->
            <div role="tabpanel" class="tab-pane active" id="basic-component">
                <div class="basic-component"> 
                  <div class="basic-component-group list-group">
                      <div class="basic-component-fields" id="label" data-feild-type="type-label" draggable="true">
                        <i class="fa fa-tag" aria-hidden="true"></i> Label
                      </div>
                      <div class="basic-component-fields" id="single-line" data-feild-type="type-text" draggable="true">
                        <i class="fa fa-align-justify" aria-hidden="true"></i> Single Line
                      </div>
                      <div class="basic-component-fields" id="single-number" data-feild-type="type-number" draggable="true">
                        <i class="fa fa-sort-numeric-asc"></i> Digits
                      </div>
                      <div class="basic-component-fields" id="single-decimal" data-feild-type="type-decimal" draggable="true">
                        <i class="fa fa fa-list-ol"></i> Decimal
                      </div>
                      <div class="basic-component-fields" id="multiple-line" data-feild-type="type-textarea" draggable="true">
                        <i class="fa fa-bars" aria-hidden="true"></i> Multiple Line
                      </div>
                      <div class="basic-component-fields" id="drop-down" data-feild-type="type-select" draggable="true">
                        <i class="fa fa-caret-square-o-down"></i> Dropdown
                      </div>
                       <div class="basic-component-fields" id="toggle-b" data-feild-type="type-toggle" draggable="true">
                        <i class="fa fa-toggle-on"></i> Toggle
                      </div>
                       <div class="basic-component-fields" id="horizontal-selector" data-feild-type="type-horizontal-selector" draggable="true">
                        <i class="fa fa-ellipsis-h"></i> Horizontal Selector
                      </div>
                       <div class="basic-component-fields" id="check-box" data-feild-type="type-check-box" draggable="true">
                        <i class="fa fa-check-square"></i> Checkbox
                      </div>
                       <div class="basic-component-fields" id="radio" data-feild-type="type-radio" draggable="true">
                        <i class="fa fa-circle"></i> Radio
                       </div>
                       <div class="basic-component-fields" id="drug-master" data-feild-type="type-drugs" draggable="true">
                          <i class="fa fa-medkit"></i> Drug Master Group
                       </div>
                        <div class="basic-component-fields" id="antibiotic-master" data-feild-type="type-antibiotic" draggable="true">
                          <i class="fa fa-medkit"></i> Antibiotic Master Group
                       </div>
                    </div>
                </div>
           </div>
          <div role="tabpanel" class="tab-pane" id="field-propertice"> 
            <div class="form-properties list-group">
                <div class="form-properties-lists">

                    
                </div>
            </div>
          </div>  
      </div>    
    </div> 
</div>  
	



