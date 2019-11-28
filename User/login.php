<?php 
    session_start();
    // preventing the navbar from showing in the login page
    $pagetitle='Log In';
    
    if(isset($_SESSION['User'])){
        header("location:index.php");
        exit();
    }
    include "init.php";
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $hashedpass = sha1($password);
        // check if this username exist
        $stmt =$con->prepare("SELECT UserName , Password , UserID  FROM users WHERE UserName = ? AND Password = ?  LIMIT 1");
        $stmt->execute(array($username,$hashedpass));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count>0){
            // Register the session
            $_SESSION['User']=$username;
            $_SESSION['ID'] = $row['UserID'];
            header('location:index.php');
            exit();
        }
        else{
            ?>
                <div class='container' style='max-width:600px;margin-top:20px'>
                    <div class='alert alert-danger'>Username or Password are incorrect</div>
                </div>
            <?php
            }
        }
?>
<div class='container login-signup'>
<h1 class='text-center'>
            <span class='x-active' data-class='login-form'>Login</span> | 
            <span data-class='sign-form'>Sign Up</span>
        </h1>
    <div class='y login-page'>
        <form class='login-form' action="<?php echo $_SERVER['PHP_SELF'];?>" method='POST'>
            <div class='col-sm-20 astr-fix'>
                <input required class='form-control' type="text" name='username' autocomplete='off' placeholder='Username'>
            </div>
            <div class='col-sm-20 astr-fix'>
                <input required class='form-control' type="password" name='password' autocomplete='new-password' placeholder='Password'>
            </div>
                <input class='btn btn-primary btn-block' type="submit" value='Login'>
        </form>
    </div>
    <div class='singup-page'>
        <form class='sign-form' action="">
            <div class='col-sm-20 astr-fix'>
                <input required class='form-control' type="text" name='username' autocomplete='off' placeholder='Enter Your Username'>
            </div>
            <div class='col-sm-20 astr-fix'>
                <input required class='password form-control' type="password" name='password' autocomplete='new-password' placeholder='Enter Your Password'>
            </div>
            <div class='col-sm-20 astr-fix'>
                <input required class='checkpassword form-control' type="password" name='checkpassword' autocomplete='new-password' placeholder='Enter Your Password Again'>
            </div>
            <div  class='error alert alert-danger'><p>Your Password doesn't match</p></div>
            <div class='col-sm-20 astr-fix'>
                <input required class='form-control' type="email" name='email' autocomplete='off' placeholder='Enter Your Email'>
            </div>
            <input class='sign-up-btn btn btn-success btn-block' type="submit" value='Sign Up'>
        </form>
    </div>
</div>
<?php include $tpl . "footer.php"; ?>