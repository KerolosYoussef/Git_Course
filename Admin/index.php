<?php
    session_start();
    // preventing the navbar from showing in the login page
    $noNavbar='';
    $pagetitle='Log In';
    // if the user is logged in , redirect him to dashboard
    if(isset($_SESSION['Username'])){
        header('location:dashboard.php');
    }
    else {

    }
    include "init.php";
    // Check if user coming from HTTP POST REQUEST
    
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedpass = sha1($password); // Convert Password Into Protected Code 
        
        //Check if the user exist in the database
        $stmt = $con->prepare("SELECT UserName,Password,UserID,GroupID FROM users WHERE UserName=? AND Password = ? AND GroupId=1 LIMIT 1");
        $stmt->execute(array($username,$hashedpass));
        $row= $stmt->fetch(); 
        $count = $stmt->rowCount();
        if($count>0){
            $_SESSION['Username'] = $username;// Register Session name
            $_SESSION['UserID']   = $row['UserID'];// Register Session Id
            header('location:dashboard.php'); // Redirect to Dashboard
            exit();
        }
        else {

        }
    }
?>
    <form class='login' action="<?php echo $_SERVER['PHP_SELF'];?>" method='POST'>
        <h3 class='text-center'>Admin Log In</h3>
        <input class='form-control form-control-lg' type='text' name='username' placeholder='Username' autocomplete='off'>
        <input class='form-control form-control-lg' type='password' name='password' placeholder='Password'>
        <input class='index-btn btn btn-primary btn-lg btn-block' type='submit' name='submit' value='Log In'>
    </form>
<?php 
    include $tpl . "footer.php";
?>