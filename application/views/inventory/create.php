<div class="card mb-3">
  <div class="card-header">
  <i class="fa fa-table"></i> Users List 
  </div>
  <div class="card-body">

    <div class="table-responsive">      
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Name</th>
            <th>OSP</th>
            <th>WHSE Case</th>
            <th>S/A Case</th>
            <th>Delivery Case</th>
            <th>Stock Transfer Case</th>
            <th>Note</th>
          </tr>
        </thead>        
        <tbody>
           <?php #if($user_data): ?>                  
            <?php #foreach ($user_data as $k => $v): ?>
              <tr>
                <td><?php echo $v['user_info']['name']; ?></td>
                <td><?php echo $v['user_info']['username']; ?></td>
                <td><?php echo $v['user_info']['email']; ?></td>
                <td><?php echo $v['user_info']['firstname'] .' '. $v['user_info']['lastname']; ?></td>
                <td><?php echo $v['user_info']['phone']; ?></td>
                <td><?php echo $v['user_group']['group_name']; ?></td>

                <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>

                <td>
                  <?php if(in_array('updateUser', $user_permission)): ?>
                    <button href="<?php echo base_url('users/edit/'.$v['user_info']['id']) ?>" class="btn btn-default" data-toggle="modal"><i class="fa fa-edit"></i></button>
                  <?php endif; ?>
                  <?php if(in_array('deleteUser', $user_permission)): ?>
                    <button href="<?php echo base_url('users/delete/'.$v['user_info']['id']) ?>" class="btn btn-default"><i class="fa fa-trash"></i></button>
                  <?php endif; ?>
                </td>
              <?php endif; ?>
              </tr>
            <?php #endforeach ?>
          <?php #endif; ?>          
        </tbody>
      </table>
    </div>
  </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>