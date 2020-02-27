<div class="row">
  <div class="col-md-12 col-xs-12">
    
    <?php if($this->session->flashdata('success')): ?>
      <div class="alert alert-success alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('success'); ?>
      </div>
    <?php elseif($this->session->flashdata('error')): ?>
      <div class="alert alert-error alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <?php echo $this->session->flashdata('error'); ?>
      </div>
    <?php endif; ?>

    <div class="box">
      
      <form role="form" action="<?php base_url('groups/update') ?>" method="post">
        <div class="box-body">

          <?php echo validation_errors(); ?>
          <div class="form-group">
            <label for="permission">Permission</label>

            <?php $serialize_permission = unserialize($group_data['group_permission']); ?>
            
            <div class="card mb-3">
              <div class="card-header">
                <i class="fa fa-table"></i> Data Table Example
              </div>
              <div class="card-body">
                
                <div class="table-responsive">
                  <div class="form-group">
                  <label for="group_name">Group Name</label>
                  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter group name" value="<?php echo $group_data['group_name']; ?>">
                </div>
                  <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th></th>
                            <th>Create</th>
                            <th>Update</th>
                            <th>View</th>
                            <th>Delete</th>
                          </tr>
                        </thead>
                        <tbody>                          
                          
                          <?php foreach ($modules as $k => $role) : ?>
                          <tr>
                            <td><?php echo $role['modules']; ?></td>
                            
                            <td>
                              <label class="switch">
                                <input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="create<?php echo $role['modules']; ?>" <?php if($serialize_permission) {
                                  if(in_array('create' . $role['modules'], $serialize_permission)) { echo "checked"; } 
                                } ?> >
                                <span class="slider round"></span>
                              </label>  
                            </td>
                            <td>
                              <label class="switch">
                                <input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="update<?php echo $role['modules']; ?>" <?php if($serialize_permission) {
                                  if(in_array('update' . $role['modules'], $serialize_permission)) { echo "checked"; } 
                                } ?> >
                                <span class="slider round"></span>
                              </label>  
                            </td>
                            <td>
                              <label class="switch">
                                <input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="view<?php echo $role['modules']; ?>" <?php if($serialize_permission) {
                                  if(in_array('view' . $role['modules'], $serialize_permission)) { echo "checked"; } 
                                } ?> >
                                <span class="slider round"></span>
                              </label>  
                            </td>
                            <td>
                              <label class="switch">
                                <input type="checkbox" class="minimal" name="permission[]" id="permission" class="minimal" value="view<?php echo $role['modules']; ?>" <?php if($serialize_permission) {
                                  if(in_array('delete' . $role['modules'], $serialize_permission)) { echo "checked"; } 
                                } ?> >
                                <span class="slider round"></span>
                              </label>  
                            </td>
                          </tr> 
                          <?php endforeach;?>                          
                        </tbody>
                      </table>
                </div>
              </div>
              <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
            </div>
            
          </div>
        </div>
        <!-- /.box-body -->

        <div class="box-footer">
          <button type="submit" class="btn btn-primary">Update Changes</button>
          <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning">Back</a>
        </div>
      </form>
    </div>
    <!-- /.box -->
  </div>
  <!-- col-md-12 -->
</div>


   
