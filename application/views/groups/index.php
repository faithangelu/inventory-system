<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <div class="row">
      <div class="col-md-10">
        <!-- <i class="fa fa-table"></i> <?php echo $page_title  ?> -->
      </div>
      <div class="col-md-2">
        <a href="<?php echo base_url('groups/create') ?>" class="btn-sm btn btn-primary float-right" data-toggle="modal" data-target="#addModal"> Add <?php echo $page_title; ?></a>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Group Name</th>
            <?php if(in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
            <th>Action</th>
            <?php endif; ?>
          </tr>
        </thead>
        <tbody>
          <?php if ($groups_data) : ?>
            <?php foreach ($groups_data as $k => $v) : ?>
              <tr>
                <td><?php echo $v['group_id']; ?></td>
                <td><?php echo $v['group_name']; ?></td>
               
                <?php if (in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                  <td>
                    <?php if (in_array('updateGroup', $user_permission)) : ?>
                      <button onclick="window.location.href = '<?php echo base_url('groups/edit/'.$v['group_id']) ?>'"  tooltip-toggle="tooltip" data-placement="top" title="Permission" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-lock"></i></button>
                    <?php endif; ?>
                    <?php if (in_array('deleteGroup', $user_permission)) : ?>
                      <button onclick="window.location.href = '<?php echo base_url('groups/delete/'.$v['group_id']) ?>'" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    <?php endif; ?>
                  </td>
                <?php endif; ?>
              </tr>
            <?php endforeach ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>

<?php if(in_array('createCategory', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form role="form" action="<?php echo base_url('category/form/add') ?>" method="post" id="createForm">

        <div class="modal-body">

          <table class="table table-responsive">
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
              <tr>
                <td>Users</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="createUser" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateUser" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewUser" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="deleteUser" class="minimal"></td>
              </tr>
              <tr>
                <td>Groups</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="createGroup" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateGroup" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewGroup" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="deleteGroup" class="minimal"></td>
              </tr>
              <tr>
                <td>Brands</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="createBrand" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateBrand" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewBrand" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="deleteBrand" class="minimal"></td>
              </tr>
              <tr>
                <td>Category</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="createCategory" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateCategory" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewCategory" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="deleteCategory" class="minimal"></td>
              </tr>
              <tr>
                <td>Stores</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="createStore" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateStore" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewStore" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="deleteStore" class="minimal"></td>
              </tr>
              <tr>
                <td>Products</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="createProduct" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateProduct" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewProduct" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="deleteProduct" class="minimal"></td>
              </tr>
              <tr>
                <td>Inventory</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="createOrder" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateOrder" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewOrder" class="minimal"></td>
                <td><input type="checkbox" name="permission[]" id="permission" value="deleteOrder" class="minimal"></td>
              </tr>
              <tr>
                <td>Reports</td>
                <td> - </td>
                <td> - </td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewReports" class="minimal"></td>
                <td> - </td>
              </tr>
              <tr>
                <td>Profile</td>
                <td> - </td>
                <td> - </td>
                <td><input type="checkbox" name="permission[]" id="permission" value="viewProfile" class="minimal"></td>
                <td> - </td>
              </tr>
              <tr>
                <td>Setting</td>
                <td>-</td>
                <td><input type="checkbox" name="permission[]" id="permission" value="updateSetting" class="minimal"></td>
                <td> - </td>
                <td> - </td>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('updateCategory', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form role="form" action="<?php echo base_url('category/form/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <div class="form-group">
            <label for="edit_brand_name">Category Name</label>
            <input type="text" class="form-control" id="edit_category_name" name="category_name" placeholder="Enter category name" autocomplete="off">
            <div id="error-category_name"></div>
          </div>
          <div class="form-group">
            <label for="edit_active">Status</label>
            <select class="form-control" id="edit_category_status" name="category_status">
              <option value="0">Inactive</option>
              <option value="1">Active</option>
            </select>
            <div id="error-category_status"></div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>

      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

<?php if(in_array('deleteCategory', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove Category</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form role="form" action="<?php echo base_url('category/form/remove') ?>" method="post" id="removeForm">
        <div class="modal-body">
          <p>Do you really want to remove?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>


    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php endif; ?>

