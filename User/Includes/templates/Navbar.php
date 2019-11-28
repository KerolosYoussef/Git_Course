<nav class=' upper-nav'>
  <a href='home.php' class='site-name pull-left'>
    <span>A-Commerce</span>
  </a>
<?php
  if(isset($_SESSION['User'])){
    ?>
    <div class='container'>
      <div class='pull-right username-info login'>
        <span><a href='#'><?php echo $_SESSION['User']?></a></span>
      </div>
    </div>
    <?php
} else {
    ?>
    <a class='pull-right login' href="login.php">
      <span class=' log'>Log In/Sign Up</span>
    </a>
    <?php 
  }
?>
  
</nav>
<nav class="navbar navbar-inverse navbar-dark bg-primary">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">Homepage</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
    <ul class="nav navbar-nav navbar-right">
      <?php
      $categorie = getCat();
      foreach($categorie as $cat){
        echo "<li><a class='navbar-brand' href='categories.php?name=".str_replace(' ','-',$cat['Name'])."&id=".$cat['ID']."'>".$cat['Name']."</a></li>";
      }
    ?>
    <li>
    
    </li>
    </ul>
    </div>
  </div>
</nav>