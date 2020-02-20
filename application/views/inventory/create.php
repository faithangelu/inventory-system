<!-- <div class="card mb-3">
  <div class="card-header">
  <i class="fa fa-table"></i> Users List 
  </div>
  <div class="card-body"> -->

    <div class="table-responsive">      
      <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <!-- <th>OSP</th> -->
            <th>WHSE Case</th>
            <!-- <th>S/A Case</th> -->
            <!-- <th>Delivery Case</th> -->
            <!-- <th>Stock Transfer Case</th> -->
            <!-- <th>Note</th> -->
          </tr>
        </thead>        
        <tbody>
           <?php if($store_branch): ?>                  
            <?php foreach ($store_branch as $k => $v): ?>
              <tr>
                <td><?php echo $v['name']; ?></td>
                <!-- <td class="col-xs-6 d-none"><input type="text" id="row-1-age" name="row-1-age" value="61" class="form-control"></td> -->
                <td><input type="text" name="warehouse[]" class="form-control"></td>
                <!-- <td><select size="1" id="row-1-office" name="row-1-office"></select></td> -->
                <!-- <td><select size="1" id="row-1-office" name="row-1-office"></select></td> -->
                <!-- <td><select size="1" id="row-1-office" name="row-1-office"></select></td> -->
                <!-- <td><select size="1" id="row-1-office" name="row-1-office"></select></td> -->
                <!-- <td><select size="1" id="row-1-office" name="row-1-office"></select></td> -->
                <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
               <!--  <td>
                  <?php if(in_array('updateUser', $user_permission)): ?>
                    <button href="<?php echo base_url('users/edit/'.$v['store_branch']['id']) ?>" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit"></i></button>
                  <?php endif; ?>
                  <?php if(in_array('deleteUser', $user_permission)): ?>
                    <button href="<?php echo base_url('users/delete/'.$v['user_info']['id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></button>
                  <?php endif; ?>
                </td> -->
              <?php endif; ?>
              </tr>
            <?php endforeach ?>
          <?php endif; ?>          
        </tbody>
      </table>
    </div>
  <!-- </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div> -->

<script type="text/javascript">
      var table = $('#dataTable').DataTable({
        columnDefs: [{
            orderable: false,
            targets: [1,2,3]
        }]
    });
 
    $('button').click( function() {
        var data = table.$('input, select').serialize();
        alert(
            "The following data would have been submitted to the server: \n\n"+
            data.substr( 0, 120 )+'...'
        );
        return false;
    } );

</script>
