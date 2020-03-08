<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <div class="row">
      <div class="col-md-8">
        All <?php echo $page_title  ?>
      </div>
      <div class="col-md-4 float-right d-flex justify-content-end">
        <a href="<?php echo base_url('stores/store_details') ?>" class="btn-sm btn btn-primary " data-toggle="modal" data-target="#addModal"> Add Area of Responsibility</a> 
      </div>
    </div>
  </div>
  
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="manageTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>#</th>
            <th>Area of Responsibility</th>
            <th>Area of Responsibility Description</th>
            <th>Status</th>
            <th>Action</th>                        
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div> 
  </div>

  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div>


<div class="modal fade" id="file_upload" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php echo form_open(site_url('stores/file_import'), array('class'=>'dropzone', 'id'=>'dropzone')); ?>
        <div class="fallback">
          <input name="file" type="file" class="hide" />
        </div>
        <?php echo form_close(); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?php if(in_array('createStore', $user_permission)): ?>
<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Area of Responsibility</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form role="form" action="<?php echo base_url('stores/form/add') ?>" method="post" id="createForm">

        <div class="modal-body">
          <input type="hidden" name="page" value="<?php echo $this->uri->segment(3) ?>">
          <div class="form-group">
            <label for="brand_name">Area of Responsibility</label>
            <input type="text" class="form-control" id="store_area_of_responsibility_name" name="store_area_of_responsibility_name" placeholder="Enter Area of Responsibility" autocomplete="off">
            <div id="error-store_area_of_responsibility_name"></div>
          </div>
          <div class="form-group">
            <label for="brand_name">Area of Responsibility Description</label>
            <input type="text" class="form-control" id="store_area_of_responsibility_description" name="store_area_of_responsibility_description" placeholder="Enter Area of Responsibility Description" autocomplete="off">
            <div id="error-store_area_of_responsibility_description"></div>
          </div>
          <div class="form-group">
            <label for="active">Status</label>
            <select class="form-control" id="store_area_of_responsibility_status" name="store_area_of_responsibility_status">
              <option value="0">Inactive</option>
              <option value="1" selected>Active</option>
            </select>
            <div id="error-store_area_of_responsibility_status"></div>
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

<?php if(in_array('updateStore', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Edit Area of Responsibility  </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form role="form" action="<?php echo base_url('stores/form/update') ?>" method="post" id="updateForm">

        <div class="modal-body">
          <input type="hidden" name="page" value="<?php echo $this->uri->segment(3) ?>">
          <div class="form-group">
            <label for="edit_brand_name">Area of Responsibility Name</label>
            <input type="text" class="form-control" id="edit_store_area_of_responsibility_name" name="store_area_of_responsibility_name" placeholder="Enter Area of Responsibility Name" autocomplete="off">
            <div id="error-store_area_of_responsibility_name"></div>
          </div>
          <div class="form-group">
            <label for="brand_name">Area of Responsibility Description</label>
            <input type="text" class="form-control" id="edit_store_area_of_responsibility_description" name="store_area_of_responsibility_description" placeholder="Enter Area of Responsibility Description" autocomplete="off">
            <div id="error-store_area_of_responsibility_description"></div>
          </div>
          <div class="form-group">
            <label for="edit_active">Status</label>
            <select class="form-control" id="edit_store_area_of_responsibility_status" name="store_area_of_responsibility_status">
              <option value="0">Inactive</option>
              <option value="1">Active</option>
            </select>
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

<?php if(in_array('deleteStore', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Remove ADP</h4>
      </div>

      <form role="form" action="<?php echo base_url('stores/form/delete') ?>" method="post" id="removeForm">
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



<script type="text/javascript"> var app_url = '<?php echo base_url() ?>';  </script>
<script type="text/javascript">
var manageTable;

$(document).ready(function() {

  // $("#storeNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': app_url + 'stores/fetch_area_of_responsibility',
    'order': []
  });

  // submit the create from 
  $("#createForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // remove the text-danger
    $(".text-danger").remove();

    $.ajax({
      url: form.attr('action'),
      type: form.attr('method'),
      data: form.serialize(), // /converting the form data into array and sending it to server
      dataType: 'json',
      success:function(response) {
        
        manageTable.ajax.reload(null, false); 

        if(response.success === true) {
          // hide the modal
          $("#addModal").modal('hide');

          // reset the form
          $("#createForm")[0].reset();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

        } else {

          // displays individual error messages
          if (response.errors) {
            for (var form_name in response.errors) {
              $('#error-' + form_name).html(response.errors[form_name]);
              // console.log(response.errors[form_name]);
            }
          }
        }
      }
    }); 

    return false;
  });

});

// edit function
function editFunc(id)
{ 
  $.ajax({
    url: app_url + 'stores/fetch_area_of_responsibility_user/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
      console.log(response);
      $("#edit_store_area_of_responsibility_name").val(response.store_area_of_responsibility_name);
      $("#edit_store_area_of_responsibility_description").val(response.store_area_of_responsibility_description);
      $("#edit_store_area_of_responsibility_status").val(response.store_area_of_responsibility_status);

      // submit the edit from 
      $("#updateForm").unbind('submit').bind('submit', function() {
        var form = $(this);

        // remove the text-danger
        $(".text-danger").remove();

        $.ajax({
          url: form.attr('action') + '/' + id,
          type: form.attr('method'),
          data: form.serialize(), // /converting the form data into array and sending it to server
          dataType: 'json',
          success:function(response) {

            manageTable.ajax.reload(null, false); 

            if(response.success === true) {

              // hide the modal
              $("#editModal").modal('hide');
              // reset the form 
              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

            } else {

              if(response.messages instanceof Object) {
                $.each(response.messages, function(index, value) {
                  var id = $("#"+index);

                  id.closest('.form-group')
                  .removeClass('has-error')
                  .removeClass('has-success')
                  .addClass(value.length > 0 ? 'has-error' : 'has-success');
                  
                  id.after(value);

                });
              } else {
                 // displays individual error messages
                  if (response.errors) {
                    for (var form_name in response.errors) {
                      $('#error-' + form_name).html(response.errors[form_name]);
                      // console.log(response.errors[form_name]);
                    }
                  }

              }
            }
          }
        }); 

        return false;
      });

    }
  });
}

// remove functions 
function removeFunc(id)
{
  if(id) {
    $("#removeForm").on('submit', function() {

      var form = $(this);

      // remove the text-danger
      $(".text-danger").remove();

      $.ajax({
        url: form.attr('action'),
        type: form.attr('method'),
        data: { adp_id:id }, 
        dataType: 'json',
        success:function(response) {

          manageTable.ajax.reload(null, false); 

          if(response.success === true) {
            $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
            '</div>');

            // hide the modal
            $("#removeModal").modal('hide');

          } else {

            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>'); 
          }
        }
      }); 

      return false;
    });
  }
}


</script>