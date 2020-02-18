 <!-- Navigation-->
   <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?php echo base_url('dashboard') ?>">Start Bootstrap</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="<?php echo base_url('dashboard') ?>">
            <i class="fa fa-fw fa-dashboard"></i>
            <span class="nav-link-text">Dashboard</span>
          </a>
        </li>
        
        <?php if ($user_permission) : ?>     
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Inventory">
            <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseInventory" data-parent="#exampleAccordion">
              <i class="fa fa-fw fa-cubes"></i>
              <span class="nav-link-text">Inventory</span>
            </a>
            <ul class="sidenav-second-level collapse" id="collapseInventory">
              <li>
                <a href="<?php echo base_url('inventory') ?>">Store Inventory Count</a>
              </li>            
            </ul>
          </li>
        
       
          <?php if (in_array('viewReports', $user_permission)) : ?>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Reports">
              <a class="nav-link" href="<?php echo base_url('reports') ?>">
                <i class="fa fa-fw fa-bar-chart-o"></i>
                <span class="nav-link-text">Reports</span>
              </a>
            </li>
          <?php endif; ?>

        
          <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>      
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Components">
              <a class="nav-link nav-link-collapse collapsed" data-toggle="collapse" href="#collapseSettings" data-parent="#exampleAccordion">
                <i class="fa fa-fw fa-gears"></i>
                <span class="nav-link-text">Settings</span>
              </a>
              <ul class="sidenav-second-level collapse" id="collapseSettings">
                <li>
                  <a href="<?php echo base_url('users') ?>">Users</a>
                </li>
                <li>
                  <a href="<?php echo base_url('groups') ?>">Roles</a>
                </li>
              </ul>
            </li>
          <?php endif; ?>
            
          <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
            <a class="nav-link" href="#">
              <i class="fa fa-fw fa-link"></i>
              <span class="nav-link-text">Company</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>


      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">       
        <form class="form-inline my-2 my-lg-0 mr-lg-2">
          <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for...">
            <span class="input-group-btn">
              <button class="btn btn-primary" type="button">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>      
        <?php if (in_array('viewProfile', $user_permission)) : ?>  
          <li class="nav-item">          
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-user"></i>Hi, User</a>
          </li>
          <?php endif; ?>  

        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">   