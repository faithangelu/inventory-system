
<!-- Example DataTables Card-->
<div class="card mb-3">
  <div class="card-header">
    <div class="row">
      <div class="col-md-10">
        <i class="fa fa-table"></i> <?php echo $page_title  ?>
      </div>
      <div class="col-md-2">
        <?php if(in_array('createUser', $user_permission)): ?>
        <a href="<?php echo base_url('users/create') ?>" class="btn-sm btn btn-primary float-right" data-toggle="modal" data-target="#addModal"> Add <?php echo $page_title; ?></a>
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
        <form role="form" action="<?php echo base_url('users/create') ?>" id="createForm" method="post">
            <?php echo validation_errors(); ?>
            <!-- <div id="messages"></div> -->

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="groups">Groups</label>
                <select class="form-control" id="users_groups" name="groups">
                  <option value="">Select Groups</option>
                  <?php foreach ($user_group as $k => $v): ?>
                    <option value="<?php echo $v['user_group_id'] ?>"><?php echo $v['group_name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="col-sm-6">
                <label for="mall">Select Designated Mall</label>
                <select class="form-control js-example-basic-multiple " name="stores[]" multiple="multiple">
                  <?php  foreach ($user_stores as $k => $v) :?>
                  <option value="<?php echo $v['store_id']?>"><?php echo $v['store_name']?></option>
                  <?php endforeach; ?> 
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="users_username" name="username" placeholder="Username" autocomplete="off">
              </div>

              <div class="col-sm-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="users_email" name="email" placeholder="Email" autocomplete="off">
              </div>
            </div> 

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="users_pword" name="password" placeholder="Password" autocomplete="off">
              </div>

              <div class="col-sm-6">
                <label for="cpassword">Confirm password</label>
                <input type="password" class="form-control" id="users_cpword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="fname">First name</label>
                <input type="text" class="form-control" id="users_fname" name="fname" placeholder="First name" autocomplete="off">
              </div>

              <div class="col-sm-6">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" id="users_lname" name="lname" placeholder="Last name" autocomplete="off">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-2">
                <label for="gender">Gender</label>
                <div class="radio">
                  <label>
                    <input type="checkbox" name="gender" id="users_gender" value="1">
                    Male
                  </label>
                  <label>
                    <input type="checkbox" name="gender" id="users_gender" value="2">
                    Female
                  </label>
                </div>
              </div>

              <div class="col-sm-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="users_phone" name="phone" placeholder="Phone" autocomplete="off">
              </div> 

              <div class="col-sm-4">
                <label for="edit_active">Status</label>
                <select class="form-control" id="active" name="active">
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
      </div>
    </div>
  </div>   
</div>

<?php if(in_array('updateStore', $user_permission)): ?>
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
        <form role="form" action="<?php echo base_url('users/edit') ?>" id="updateForm" method="post">
            <?php echo validation_errors(); ?>
            <div id="messages"></div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="groups">Groups</label>
                <select class="form-control" id="edit_users_groups" name="groups">
                  <option value="">Select Groups</option>
                  <?php foreach ($user_group as $k => $v): ?>
                    <option value="<?php echo $v['group_id'] ?>"><?php echo $v['group_name'] ?></option>
                  <?php endforeach ?>
                </select>
              </div>

              <div class="col-sm-6">
                <label for="mall">Select Designated Mall</label>
                <select class="form-control js-example-basic-multiple " name="stores[]" multiple="multiple" id="edit_stores_name[]">
                  <?php  foreach ($user_stores as $k => $v) :?>
                  <option value="<?php echo $v['store_id']?>"><?php echo $v['store_name']?></option>
                  <?php endforeach; ?> 
                </select>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="edit_users_username" name="username" placeholder="Username" autocomplete="off">
              </div>

              <div class="col-sm-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="edit_users_email" name="email" placeholder="Email" autocomplete="off">
              </div>
            </div> 

           <!--  <div class="form-group row">
              <div class="col-sm-6">
                <label for="password">Password</label>
                <input type="text" class="form-control" id="edit_users_pword" name="password" placeholder="Password" autocomplete="off">
              </div>

              <div class="col-sm-6">
                <label for="cpassword">Confirm password</label>
                <input type="password" class="form-control" id="edit_users_cpword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
              </div>
            </div> -->

            <div class="form-group row">
              <div class="col-sm-6">
                <label for="fname">First name</label>
                <input type="text" class="form-control" id="edit_users_fname" name="fname" placeholder="First name" autocomplete="off">
              </div>

              <div class="col-sm-6">
                <label for="lname">Last name</label>
                <input type="text" class="form-control" id="edit_users_lname" name="lname" placeholder="Last name" autocomplete="off">
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-2">
                <label for="gender">Gender</label>
                <div class="radio">
                  <label>
                    <input type="checkbox" name="gender" id="edit_gender" value="1">
                    Male
                  </label>
                  <label>
                    <input type="checkbox" name="gender" id="edit_gender" value="2">
                    Female
                  </label>
                </div>
              </div>

              <div class="col-sm-6">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="edit_users_phone" name="phone" placeholder="Phone" autocomplete="off">
              </div> 

              <div class="col-sm-4">
                <label for="edit_active">Status</label>
                <select class="form-control" id="edit_active" name="active">
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
      </div>
    </div>
  </div>   
</div>
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

  // submit the create from 
  $("#createForm").unbind('submit').on('submit', function() {
    var form = $(this);

    // console.log(form.serialize()); return false;

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
          $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
            '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
            '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
          '</div>');


          // hide the modal
          $("#addModal").modal('hide');

          // reset the form
          $("#createForm")[0].reset();
          $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

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
            $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
              '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
              '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
            '</div>');
          }
        }
      }
    }); 

    return false;
  });

  // $(".js-example-basic-ajax").select2({ dropdownParent: "#modal-container" });
   $(".js-example-basic-multiple").select2({
        allowClear: true,
        width: '100%',
        // height: '34px',
        placeholder :'Malls..'
        //data: data
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
      console.log(response.gender);
      $("#edit_users_username").val(response.username);
      $("#edit_users_email").val(response.email);
      $("#edit_users_fname").val(response.firstname);
      $("#edit_users_lname").val(response.lastname);
      $("#edit_users_phone").val(response.phone);
      $("#edit_gender[value='" + response.gender + "']").attr('checked', 'checked');
      $("#edit_active").val(response.status);

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
              $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
              '</div>');


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
                $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
                  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
                  '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
                '</div>');
              }
            }
          }
        }); 

        return false;
      });

    }
  });
}

</script>