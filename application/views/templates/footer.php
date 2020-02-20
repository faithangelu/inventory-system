  </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
   
    <div class="modal modal-dynamic" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <p></p>
          </div>
         <!--  <div class="modal-footer">
            <button type="button" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div> -->
        </div>
      </div>
    </div>

    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © Your Website 2017</small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="<?php echo base_url('auth/logout') ?>">Logoutsss</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="<?php echo base_url() ?>assets/themes/vendor/jquery/jquery.min.js"></script>
    <script src="<?php echo base_url() ?>assets/themes/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php echo base_url() ?>assets/themes/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <!-- <script src="<?php echo base_url() ?>assets/themes/vendor/chart.js/Chart.min.js"></script> -->
    <script src="<?php echo base_url() ?>assets/themes/vendor/datatables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url() ?>assets/themes/vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php echo base_url() ?>assets/themes/js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="<?php echo base_url() ?>assets/themes/js/sb-admin-datatables.min.js"></script>
    <!-- <script src="<?php echo base_url() ?>assets/themes/js/sb-admin-charts.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>  
    
    <script src="<?php echo base_url() ?>assets/plugins/dropzone/dist/dropzone.js"></script>  
    <script src="<?php echo base_url() ?>assets/plugins/select2/js/select2.min.js"></script>  
    
    <script src="<?php echo base_url() ?>assets/dist/js/pages/custom.js"></script>


  </div>
</body>

</html>