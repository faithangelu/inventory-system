

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Inventory
      <small>(Admin)</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Inventory</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-md-12 col-xs-12">

        <div id="messages"></div>

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
          <div class="box-header">
            <h3 class="box-title">Manage</h3>
          </div>
          <!-- /.box-header -->
          <form role="form" action="<?php base_url('orders/create') ?>" method="post" class="form-horizontal">
              <div class="box-body">
<!--            <script>
              $(function(){
            $('#value1, #value2, #value3, #value4').keyup(function(){
               var value1 = parseFloat($('#value1').val()) || 0;
               var value2 = parseFloat($('#value2').val()) || 0;
               var value3 = parseFloat($('#value3').val()) || 0;
               var value4 = parseFloat($('#value4').val()) || 0;
               $('#sumfirst').val(value1 + value2);
               $('#sumlast').val(value3 + value4);
               var sumf = parseFloat($('#sumfirst').val()) || 0;
               var suml = parseFloat($('#sumlast').val()) || 0;
               $('#sumfinal').val(sumf - suml);  

            });
         });

       </script>
-->

                <br /> <br/>
                <table id="manageTable" class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width:15%; text-align: center;">Product Discreption</th>
                      <th style="width:7%; text-align: center;">Case Size (PCS)</th>
                      <th style="width:30%; text-align: center;" colspan="3">Beg. Inventory (B.I)</th>
                      <th style="width:10%; text-align: center;">Delivery Case</th>
                      <th style="width:30%; text-align: center;" colspan="3">End. Inventory (E.I)</th>
                      <th style="width:7%; text-align: center;">Total Offtake Case</th>
                    </tr>
                  </thead>


                <tr>
                        <th></th>
                        <th></th>
                        <th><b>WHSE(CASE)</b></th>
                        <th><b>S/A(CASE)</b></th>
                        <th><b>TOTAL B.I(CASE)</b></th>
                        <th></th>
                        <th><b>WHSE(CASE)</b></th>
                        <th><b>S/A(CASE)</b></th>
                        <th><b>TOTAL B.I(CASE)</b></th>
                
              </tr>
              </thead>
              <td>
              </td>
            <td>
              <input type="number">
            </td>
              <td>
              <input type="number">
            </td>
            <td>
              <input type="number">
            </td>
            <td>
              <input type="number">
            </td>
            <td>
              <input type="number">
            </td>
            <td>
              <input type="number">
            </td>
            <td>
              <input type="number">
            </td>
                        <td>
              <input type="number">
            </td>
                        <td>
              <input type="number">
            </td>

            </table>
                <br /> <br/>


              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" name="service_charge_rate" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                <input type="hidden" name="vat_charge_rate" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="<?php echo base_url('orders/') ?>" class="btn btn-warning">Back</a>
              </div>
            </form>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- col-md-12 -->
    </div>
    <!-- /.row -->
    

  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<script type="text/javascript">
var manageTable;
var base_url = "<?php echo base_url(); ?>";

$(document).ready(function() {

  $("#mainOrdersNav").addClass('active');
  $("#manageOrdersNav").addClass('active');

  // initialize the datatable 
  manageTable = $('#manageTable').DataTable({
    'ajax': base_url + 'orders/fetchProductData',
    'order': []
  });

});

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
        data: { order_id:id }, 
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