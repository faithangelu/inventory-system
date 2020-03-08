<style type="text/css">

  .swiper-container {
    /*width: 600px;*/
    height: 170px;
  }

  .input-sm {
    border-radius: 0;
  }

  .name { white-space:   nowrap; }
  
  .box {
    display: block;
    /*padding-bottom: 25px;*/
    border-top: 2px solid #eaeaea;
    border-bottom: 2px solid #eaeaea;
  }
  .first-col {
    width: 42%;
    float: left;
    border-left: 2px solid #eaeaea;
    border-right: 1px solid #eaeaea;
  }
  .second-col {
    width: calc(100% - 42%);
    float: right;
    border-right: 2px solid #eaeaea;
    border-left: 1px solid #eaeaea;
  }

  #inventory-count ul li {
    padding: 5px!important;
    overflow: hidden;
    min-height: 15px;
    font-size: 1rem;
    line-height: 1.2;
    border-bottom: 2px solid #eaeaea;
  }

  #inventory-count ul li:last-child {
    border-bottom: 0;
  }

  .swiper-pagination-bullet {
    border: 1px solid gray;
    background: white;
  }
  .swiper-pagination-bullet-active {
    background: gray;
  }

</style>
<div class="container" id="inventory-count">
  <form role="form" action="<?php echo base_url('inventory/create') ?>" method="post" id="form-data-inventory">
    <div class="row">
      <div class="box first-col">
        <ul class="list-group list-group-flush d-flex">
          <li class="list-group font-weight-bold text-center">Product Name</li>
          <?php foreach ($store_branch as $key => $value) : ?>
            <input type="hidden" name="product_id[]" value="<?php echo $value->product_id?>">
            <input type="hidden" name="store_id[]" value="<?php echo $value->store_id?>">
            <input type="hidden" name="user_id[]" value="<?php echo $logged_in['id']; ?>">
            <li class="list-group"> 
            <?php echo $value->product_name ?>  
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="box second-col">
        <div class="swiper-container">        
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <ul class="list-group list-group-flush font-weight-bold text-center">
              <li class="list-group px-3">OSP</li>
              <?php foreach ($store_branch as $key => $value) : ?>
                  <li class="list-group name"><input type="text" name="osp[]" class="form-control input-sm"></li>
              <?php endforeach; ?>
              </ul>
            </div>
            <div class="swiper-slide">
              <ul class="list-group list-group-flush font-weight-bold text-center">
              <li class="list-group px-3">Warehouse </li>
              <?php foreach ($store_branch as $key => $value) : ?>
              <li class="list-group name"><input type="text" name="warehouse[]" class="form-control input-sm"></li>
              <?php endforeach; ?>
              </ul>
            </div>
            <div class="swiper-slide">
              <ul class="list-group list-group-flush font-weight-bold text-center">
              <li class="list-group px-3">Selling Area </li>
              <?php foreach ($store_branch as $key => $value) : ?>
              <li class="list-group name"><input type="text" name="selling_area[]" class="form-control input-sm"></li>
              <?php endforeach; ?>
              </ul> 
            </div>
            <div class="swiper-slide">
              <ul class="list-group list-group-flush font-weight-bold text-center">
              <li class="list-group px-3">Delivery </li>
              <?php foreach ($store_branch as $key => $value) : ?>
              <li class="list-group name"><input type="text" name="delivery[]" class="form-control"></li>
              <?php endforeach; ?>
              </ul>
            </div> 
            <div class="swiper-slide">
              <ul class="list-group list-group-flush font-weight-bold text-center">
              <li class="list-group px-3">Stock Transfer </li>
              <?php foreach ($store_branch as $key => $value) : ?>
              <li class="list-group name"><input type="text" name="stock_transfer[]" class="form-control input-sm"></li>
              <?php endforeach; ?>
              </ul>
            </div>
            <div class="swiper-slide">
              <ul class="list-group list-group-flush font-weight-bold text-center">
                <li class="list-group px-3">Notes </li>
                <?php foreach ($store_branch as $key => $value) : ?>
                    <li class="list-group name"><input type="text" name="notes[]" class="form-control input-sm"></li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
          <div class="swiper-pagination"></div>
        </div>
      </div>
    </div>
    <div class="m-2"></div>
    <div class="row d-flex justify-content-end">
      <div class="col-xs-12">
        <button class="btn btn-default btn-sm"> Submit Inventory</button>
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  // submit the create from 
  // $("#createForm").unbind('submit').on('submit', function() {
  //   var form = $(this);

  //   // remove the text-danger
  //   // $(".text-danger").remove();

  //   $.ajax({
  //     url: form.attr('action'),
  //     type: form.attr('method'),
  //     data: form.serialize(), // /converting the form data into array and sending it to server
  //     dataType: 'json',
  //     success:function(response) {

  //       manageTable.ajax.reload(null, false); 

  //       // if(response.success === true) {
  //       //   $("#messages").html('<div class="alert alert-success alert-dismissible" role="alert">'+
  //       //     '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
  //       //     '<strong> <span class="glyphicon glyphicon-ok-sign"></span> </strong>'+response.messages+
  //       //   '</div>');


  //       //   // hide the modal
  //       //   $("#addModal").modal('hide');

  //       //   // reset the form
  //       //   $("#createForm")[0].reset();
  //       //   $("#createForm .form-group").removeClass('has-error').removeClass('has-success');

  //       // } else {

  //       //   if(response.messages instanceof Object) {
  //       //     $.each(response.messages, function(index, value) {
  //       //       var id = $("#"+index);

  //       //       id.closest('.form-group')
  //       //       .removeClass('has-error')
  //       //       .removeClass('has-success')
  //       //       .addClass(value.length > 0 ? 'has-error' : 'has-success');
              
  //       //       id.after(value);

  //       //     });
  //       //   } else {
  //       //     $("#messages").html('<div class="alert alert-warning alert-dismissible" role="alert">'+
  //       //       '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
  //       //       '<strong> <span class="glyphicon glyphicon-exclamation-sign"></span> </strong>'+response.messages+
  //       //     '</div>');
  //       //   }
  //       // }
  //       console.log(response);
  //     }
  //   }); 

  //   return false;
  // });



    $('#form-data-inventory').submit( function(e) {
        e.preventDefault();
        var form = $(this);
        // console.log(form); return false;
        
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success: function(response)
            {
                console.log(response);
            }
        });
    });
 
 </script>