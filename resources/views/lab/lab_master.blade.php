<div class="modal fade" id="collecton-site-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">  
             <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">
                <h3>Collection Site Master</h3>
              </h5>
            </div>
            <div class="modal-body row m-20">
            <form id="collection-site-post">
              <table class="masters-collection-method multi-row col-md-12">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Status</th>                    
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td><input type="text" name="Name[]" value="" class="form-control"/></td>
                      <td>
                          <select name="Status[]" class="form-control">
                            <option selected="selected" value="Active">Active</option>
                            <option value="Inactive">Inactive</option>                                             
                          </select>
                      </td>
                    </tr>
                  </tbody>
                </table>        
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-collection-site" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mas-collecton-method-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">  
             <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">
                <h3>Collection Method Master</h3>
              </h5>
            </div>
            <div class="modal-body row m-20">
            <form id="collection-method-post">
              <table class="masters-collection-method multi-row col-md-12">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Status</th>                    
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="text" name="Name[]" value="" class="form-control" /></td>
                    <td>
                        <select name="Status[]" class="form-control">
                          <option selected="selected" value="Active">Active</option>
                          <option value="Inactive">Inactive</option>                                             
                        </select>
                    </td>
                  </tr>
                </tbody>
              </table>         
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-collection-method" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mas-order-physician-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">  
             <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">
                <h3>Ordering Physician Master</h3>
              </h5>
            </div>
            <div class="modal-body row m-20">
            <form id="master-doctors-post">
             <table class="master_doctors multi-row col-md-12">
                <thead>
                  <tr>
                     <th colspan="2">Doctor's Name</th>
                     <th>Qualification</th>
                     <th>Job Title</th>
                     <th>Status</th> 
                     <th>Type</th>                   
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>
                      <input type="text" name="name_prefix[]" value="Dr" readonly="true" class="form-control input-width-mini"/>
                    </td>
                    <td>
                       <input type="text" name="Name[]" value="" class="form-control input-width-large" />
                    </td>
                    <td>
                       <input type="text" name="Qualification[]" value="" class="form-control input-width-medium" />
                    </td>
                    <td>
                      <input type="text" name="job_title[]" value="" class="form-control input-width-medium">
                    </td>
                    <td>
                      <select name="type[]" class="form-control input-width-small">
                          <option selected="selected" value="1">Doctors</option>
                          <option value="2">Surgeons</option>                                             
                      </select>
                    </td>
                    <td>
                      <select name="status[]" class="form-control input-width-small">
                         <option selected="selected" value="1">Active</option>
                         <option value="0">Inactive</option>                                             
                      </select>
                    </td>
                    
                  </tr>
                </tbody>
              </table>          
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-doctors" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="mas-diagnosis-modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">  
             <button type="button" class="close btn" data-dismiss="modal" aria-label="close"><span aria-hidden="true">&times;</span></button>
              <h5 class="modal-title">
                <h3>Diagnosis Master</h3>
              </h5>
            </div>
            <div class="modal-body row m-20">
            <form id="master-diagnosis-post">
             <table class="master_doctors multi-row col-md-12">
                <thead>
                  <tr>
                    <th><label for="ICDCode">ICD Code:</label></th>
                    <th><label for="ICDDescription">ICD Description:</label></th>
                    <th><label for="ICDFormat">ICD Format:</label></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input class="form-control" name="ICDCode" type="text" id="ICDCode"></td>
                    <td><input class="form-control" name="ICDDescription" type="text" id="ICDDescription"></td>
                    <td><input class="form-control" name="ICDFormat" type="text" id="ICDFormat"></td>
                  </tr>
                </tbody>                
              </table>          
            </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="save-diagnosis-master" class="btn btn-default btn-primary save-button-shadow">Save</button>
            </div>
            </form>
        </div>
    </div>
</div>
