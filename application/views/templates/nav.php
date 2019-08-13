  <nav class="navbar navbar-default header-color" role="navigation">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed nav-button" data-toggle="collapse" data-target="#navbar-header-app" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a href="home" style="text-decoration: none; color: white"><span class="navbar-brand" style="color: white">LeanMed</span></a>
      </div>
      <div id="navbar-header-app" class="navbar-collapse collapse">
        <ul id="header-navbar" class="nav navbar-nav navbar-left header-color">
          <li id="lookupHeader"><a href="home" style="text-decoration: none; color: white"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> Look Up</a></li>
          <li id="inventoryHeader"><a href="inventory" style="text-decoration: none; color: white"><span class="glyphicon glyphicon-book" aria-hidden="true"></span> Inventory</a></li>
          <?php if ($this->session->userdata('user')['userType'] == 1) { ?>
          <li id="adminHeader"><a href="admin" style="text-decoration: none; color: white"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span> Admin</a></li>
          <?php } ?>
          <!--<li id="aboutHeader"><a href="about" style="text-decoration: none; color: white"><span class="glyphicon glyphicon-info-sign"></span> About</a></li>-->
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li id="activityHeader"><a href="activity" style="text-decoration: none; color: white"><span class="glyphicon glyphicon-th-large"></span> Activity Center</a></li>
          <li id="userHeader"><a href="#" style="text-decoration: none; color: white"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?= $this->session->userdata('user')['emailId']?></a></li>
          <li id="logoutHeader"><a href="home/logout" style="text-decoration: none; color: white"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>