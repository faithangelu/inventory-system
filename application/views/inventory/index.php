<div class="card mb-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md-10">
                <i class="fa fa-table"></i> <?php echo $page_title ?>                
            </div>
            <div class="col-md-2">
                <a href="<?php echo base_url('stores/create') ?>" class="btn-sm btn btn-primary float-right" data-toggle="modal" data-target="#modal"> Add <?php echo $page_title; ?></a>
            </div>
        </div>
    </div>
    <div class="card-body">

        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Store Name</th>
                        <th>Action</th>                        
                    </tr>

                </thead>
                <tbody>
                    <?php if ($store_data) : ?>
                        <?php foreach ($store_data as $k => $v) : ?>
                            <tr>
                                <td><?php echo $v['store_data']['id']; ?></td>
                                <td><?php echo $v['store_data']['name']; ?></td>
                                <td>
                                    <?php if (in_array('updateUser', $user_permission)) : ?>
                                    <button href="<?php echo base_url('inventory/edit/' . $v['store_data']['id']) ?>" tooltip-toggle="tooltip" data-placement="top" title="Start Inventory" class="btn btn-sm btn-warning"><i class="fa fa-fw fa-file-text-o"></i></button>
                                    <?php endif; ?>
                                    <?php if (in_array('deleteUser', $user_permission)) : ?>
                                    <button href="<?php echo base_url('inventory/delete/' . $v['store_data']['id']) ?>" data-toggle="modal" data-target="#modal" tooltip-toggle="tooltip" data-placement="top" title="Delete" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                    <?php endif; ?>
                                </td>
                            <tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>