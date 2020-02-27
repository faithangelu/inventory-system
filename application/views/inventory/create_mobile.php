<style type="text/css">
  .table-scroll {
  position:relative;
  max-width:600px;
  margin:auto;
  overflow:hidden;
  border:1px solid #000;
}
.table-wrap {
  width:100%;
  overflow:auto;
}
.table-scroll table {
  width:100%;
  margin:auto;
  border-collapse:separate;
  border-spacing:0;
}
.table-scroll th, .table-scroll td {
  padding:5px 10px;
  border:1px solid #000;
  background:#fff;
  white-space:nowrap;
  vertical-align:top;
}
.table-scroll thead, .table-scroll tfoot {
  background:#f9f9f9;
}
.clone {
  position:absolute;
  top:0;
  left:0;
  pointer-events:none;
}
.clone th, .clone td {
  visibility:hidden
}
.clone td, .clone th {
  border-color:transparent
}
.clone tbody th {
  visibility:visible;
  color:red;
}
.clone .fixed-side {
  border:1px solid #000;
  background:#eee;
  visibility:visible;
}
.clone thead, .clone tfoot{background:transparent;}
</style>
<div id="table-scroll" class="table-scroll">
  <div class="table-wrap">
    <table class="main-table">
      <thead>
        <tr>
          <th class="fixed-side" scope="col">Name</th>
          <th scope="col">Only See Page</th>
          <th scope="col">WHSE Case</th>
          <th scope="col">Selling Area Case</th>
          <th scope="col">Delivery Case</th>
          <th scope="col">Stock Transfer Case</th>
          <th scope="col">Notes</th>
        </tr>
      </thead>
      <tbody>
        <?php if($store_branch): ?>                                  
          <?php foreach ($store_branch as $k => $v): ?>
        
          <tr>
            <th class="fixed-side"><?php echo $v['product_name']; ?></th>
            <td><input type="text" name="osp[]" class="form-control"></td>
            <td><input type="text" name="warehouse[]" class="form-control"></td>
            <td><input type="text" name="selling_area[]" class="form-control"></td>
            <td><input type="text" name="delivery[]" class="form-control"></td>
            <td><input type="text" name="stock_transfer[]" class="form-control"></td>
            <td><input type="text" name="note[]" class="form-control"></td>
            
          </tr>   
          <?php endforeach; ?>       
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<p>See <a href="https://codepen.io/paulobrien/pen/LBrMxa" target="blank">position Sticky version </a>with no JS</p>

<script type="text/javascript">
  // requires jquery library
jQuery(document).ready(function() {
   jQuery(".main-table").clone(true).appendTo('#table-scroll').addClass('clone');   
 });

</script>