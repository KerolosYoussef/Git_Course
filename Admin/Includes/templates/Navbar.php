<nav class="navbar navbar-inverse navbar-dark bg-primary">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php"><?php echo language("Admin-Home") ?></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav">
      <li><a class='navbar-brand' href="categories.php"><?php echo language('Admin-Categories')?></a></li>
      <li><a class='navbar-brand' href="items.php"><?php echo language('Admin-Items')?></a></li>
      <li><a class='navbar-brand' href="Members.php"><?php echo language('Admin-Members')?></a></li>
      <li><a class='navbar-brand' href="comments.php"><?php echo language('Admin-Comments')?></a></li>
      
    </ul>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
          <a class="navbar-brand" data-toggle="dropdown" href="#"><?php echo $_SESSION['Username'];?><span class="caret"></span></a>
          <ul class="dropdown-menu">
          <li><a href="../User/index.php" target='_blank'>Visit Shop</a></li>
            <li><a href="Members.php?page=Edit&id=<?php echo $_SESSION['UserID']?>"><?php echo language('Admin-EditProfile')?></a></li>
            <li><a href="#"><?php echo language('Admin-Settings')?></a></li>
            <li><a href="logout.php"><?php echo language('Admin-Logout')?></a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>