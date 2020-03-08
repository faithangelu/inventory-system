
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <div class="row">
      <div class="col-md-10">
        <i class="fa fa-table"></i> <?php echo $page_title  ?>
      </div>
      <div class="col-md-2">
        <?php if(in_array('createUser', $user_permission)): ?>
        <a href="<?php echo base_url('users/form/add') ?>" class="btn-sm btn btn-primary float-right" data-toggle="modal" data-target="#addModal"> Add <?php echo $page_title; ?></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="manageTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Name</th>
            <th>Phone</th>
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

<!-- create brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $page_title ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form role="form" action="<?php echo base_url('users/form/add') ?>" id="createForm" method="post">

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="groups">Groups</label>
                <select class="form-control" id="user_groups" name="user_groups">
                  <option value="">Select Groups</option>
                  <?php foreach ($user_group as $k => $v): ?>
                    <option value="<?php echo $v['group_id'] ?>"><?php echo $v['group_name'] ?></option>
                  <?php endforeach;?>
                </select>
                <div id="error-user_groups"></div>
              </div>

              <div class="col-sm-6">
                <label for="mall">Select Designated Mall</label>
                <select class="form-control js-example-basic-multiple " name="user_stores[]" multiple="multiple">
                  <?php  foreach ($user_stores as $k => $v) :?>
                  <option value="<?php echo $v['store_id']?>"><?php echo $v['store_name']?></option>
                  <?php endforeach; ?> 
                </select>
                <div id="error-user_stores"></div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="user_username" name="user_username" placeholder="Username" autocomplete="off">
                <div id="error-user_username"></div>
              </div>

              <div class="col-sm-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="user_email" name="user_email" placeholder="Email" autocomplete="off">
                <div id="error-user_email"></div>
              </div>
            </div> 

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="user_password" name="user_password" placeholder="Password" autocomplete="off">
                <div id="error-user_password"></div>
              </div>

              <div class="col-sm-6">
                <label for="cpassword">Confirm password</label>
                <input type="password" class="form-control" id="user_confirm_password" name="user_confirm_password" placeholder="Confirm Password" autocomplete="off">
                <div id="error-user_confirm_password"></div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="fname">First name</label>
                <input type="text" class="form-control" id="user_firstname" name="user_firstname" placeholder="First name" autocomplete="off">
                <div id="error-user_firstname"></div>
              </div>

              <div class="col-sm-6">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" id="user_lastname" name="user_lastname" placeholder="Last name" autocomplete="off">
                <div id="error-user_lastname"></div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-2">
                <label for="gender">Gender</label>
                <div class="radio">
                  <label>
                    <input type="checkbox" name="user_gender" id="user_gender" value="1">
                    Male
                  </label>
                  <label>
                    <input type="checkbox" name="user_gender" id="user_gender" value="2">
                    Female
                  </label>
                  <div id="error-user_gender"></div>
                </div>
              </div>

              <div class="col-sm-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="user_phone" name="user_phone" placeholder="Phone" autocomplete="off">
                <span id="error-user_phone" class="text-danger"></span>
              </div> 

              <div class="col-sm-4">
                <label for="edit_active">Status</label>
                <select class="form-control" id="user_status" name="user_status">
                  <option value="0">Inactive</option>
                  <option value="1" selected>Active</option>
                </select>
                <div id="error-user_status"></div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>   
</div>

<?php if(in_array('updateUser', $user_permission)): ?>
<!-- edit brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="editModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $page_title ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form role="form" action="<?php echo base_url('users/form/update') ?>" id="updateForm" method="post">
            <?php echo validation_errors(); ?>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="groups">Groups</label>
                <select class="form-control" id="edit_user_groups" name="user_groups">
                  <option value="">Select Groups</option>
                  <?php foreach ($user_group as $k => $v): ?>
                    <option value="<?php echo $v['group_id'] ?>"><?php echo $v['group_name'] ?></option>
                  <?php endforeach ?>
                </select>
                <div id="error-user_groups"></div>
              </div>

              <div class="col-sm-6">
                <label for="mall">Select Designated Mall</label>
                <select class="form-control js-example-basic-multiple " name="user_stores[]" multiple="multiple" id="edit_stores[]">
                  <?php  foreach ($user_stores as $k => $v) :?>
                  <option value="<?php echo $v['store_id']?>"><?php echo $v['store_name']?></option>
                  <?php endforeach; ?> 
                </select>
                <div id="error-user_stores"></div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="edit_user_username" name="username" placeholder="Username" autocomplete="off">
                <div id="error-user_username"></div>
              </div>

              <div class="col-sm-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="edit_user_email" name="email" placeholder="Email" autocomplete="off">
                <div id="error-user_email"></div>
              </div>
            </div> 

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="edit_user_pword" name="password" placeholder="Password" autocomplete="off">
                <div id="error-user_password"></div>
              </div>
              
              <div class="col-sm-6">
                <label for="cpassword">Confirm password</label>
                <input type="password" class="form-control" id="edit_user_cpword" name="user_confirm_password" placeholder="Confirm Password" autocomplete="off">
                <span id="error-user_confirm_password"></span>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="fname">First name</label>
                <input type="text" class="form-control" id="edit_user_firstname" name="firstname" placeholder="First name" autocomplete="off">
                <div id="error-edit_user_firstname"></div>
              </div>

              <div class="col-sm-6">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" id="edit_user_lastname" name="user_lastname" placeholder="Last name" autocomplete="off">
                <div id="error-user_lastname"></div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-2">
                <label for="gender">Gender</label>
                <div class="radio">
                  <label>
                    <input type="checkbox" name="user_gender" id="edit_user_gender" value="1">
                    Male
                  </label>
                  <label>
                    <input type="checkbox" name="user_gender" id="edit_user_gender" value="2">
                    Female
                  </label>
                </div>
                <div id="error-user_gender"></div>
              </div>

              <div class="col-sm-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="edit_users_phone" name="phone" placeholder="Phone" autocomplete="off">
                <div id="error-user_gender"></div>
              </div> 

              <div class="col-sm-4">
                <label for="user_status">Status</label>
                <select class="form-control" id="user_status" name="user_status">
                  <option value="0">Inactive</option>
                  <option value="1">Active</option>
                </select>
                <div id="error-user_status"></div>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </form>
      </div>
    </div>
  </div>   
</div>
<?php endif; ?>

<?php if(in_array('deleteUser', $user_permission)): ?>
<!-- remove brand modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Remove Store</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>

      <form role="form" action="<?php echo base_url('users/remove') ?>" method="post" id="removeForm">
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

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': app_url + 'users/fetchUsers',
    'order': []
  });

  // $(".js-example-basic-ajax").select2({ dropdownParent: "#modal-container" });
  $(".js-example-basic-multiple").select2({
    allowClear: true,
    width: '100%',
    placeholder :'Malls..'
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
    url: app_url + 'users/fetchUserDataById/'+id,
    type: 'post',
    dataType: 'json',
    success:function(response) {
      
      $("#edit_user_groups").val(response.user_groups);
      $("#edit_user_stores").val(response.user_username);
      $("#edit_user_username").val(response.user_username);
      $("#edit_user_email").val(response.user_email);
      $("#edit_user_firstname").val(response.user_firstname);
      $("#edit_user_lastname").val(response.user_lastname);
      $("#edit_user_phone").val(response.user_phone);
      $("#edit_user_gender[value='" + response.user_gender + "']").attr('checked', 'checked');
      $("#edit_user_status").val(response.user_status);

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
          console.log(response);
            manageTable.ajax.reload(null, false); 

            if(response.success === true) {
              // hide the modal
              $("#editModal").modal('hide');

              // reset the form 
              $("#updateForm .form-group").removeClass('has-error').removeClass('has-success');

              window.location.reload();
            } else {
                // displays individual error messages
                if (response.errors) {
                  for (var form_name in response.errors) {
                    $('#error-' + form_name).html(response.errors[form_name]);

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
        data: { user_id:id }, 
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

$(".alert").fadeTo(2000, 500).slideUp(500, function(){
    $(".alert").slideUp(500);
});

</script>