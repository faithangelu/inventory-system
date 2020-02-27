<!-- <div class="card mb-3">
  <div class="card-header">
  <i class="fa fa-table"></i> Users List 
  </div>
  <div class="card-body"> -->

    <div class="table-responsive">    
      <form id="form-data-inventory" role="form" action="<?php echo base_url('stores/create') ?>" method="post" id="createForm">
  
      <table class="table table-bordered" width="100%" cellspacing="0">
        <thead>
          <tr class="title-inputs">
            <th class="fixed-side">Name</th>
            <th>OSP</th>
            <th>WHSE Case</th>
            <th>S/A Case</th>
            <th>Delivery Case</th>
            <th>Stock Transfer Case</th>
            <th>Note</th>
          </tr>
        </thead>        
        <tbody>
            <?php if($store_branch): ?>                  
                 
            <?php foreach ($store_branch as $k => $v): ?>
              <tr class="inputs-inputs">
                <td><?php echo $v['product_name']; ?></td>
                <td><input type="text" name="osp[]" class="form-control"></td>
                <td><input type="text" name="warehouse[]" class="form-control"></td>
                <td><input type="text" name="selling_area[]" class="form-control"></td>
                <td><input type="text" name="delivery[]" class="form-control"></td>
                <td><input type="text" name="stock_tansfer[]" class="form-control"></td>
                <td><input type="text" name="note" class="form-control"></td>             
    
              </tr>              
            <?php endforeach ?>
            <?php endif; ?>
           <!--  <tr class="button-inputs">
              <td></td> -->
              <!-- <td class="col-xs-6 d-none"><input type="text" id="row-1-age" name="row-1-age" value="61" class="form-control"></td> -->
              <!-- <td class=""><button>Send</button></td>
              <td class="d-none"><button>Send</button></td>
              <td class="d-none"><button>Send</button></td>
              <td class="d-none"><button>Send</button></td>
              <td class="d-none"><button>Send</button></td>
              <td class="d-none"><button>Send</button></td>
            </tr>    -->
        </tbody>
      </table>
      <button type="submit" name="submit" id="btn-inventory" class="btn btn-primary btn-sm">Submit</button>     
    </form> 
    </div>
  <!-- </div>
  <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
</div> -->

<script type="text/javascript"> var app_url = "<?php echo base_url(); ?>"</script>
<script type="text/javascript">

    // $('#btn-inventory').click(function(e) {
    //   e.preventDefault(); 
    //   $('tr').find('th:nth-child(3), td:nth-child(3)').removeClass('d-none');
    //   console.log();
    // }) 

    $('#form-data-inventory').submit( function(e) {
        e.preventDefault();
        var form_data = $(this).serialize();
        console.log(form_data);
      
        $.ajax({
            method: "post" , 
            url: app_url + 'inventory/create_data',
            data: form_data,
            success: function(response)
            {
                console.log(response);
            }
        });
    });


// validation
// $('#form-data-inventory input[type="text"]').blur(function(){
//     if(!$(this).val()){
//         $(this).addClass("error");
//     } else{
//         $(this).removeClass("error");
//     }
// });


</script>
