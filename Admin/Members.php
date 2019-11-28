<?php 
/* 
=============================================================
== Manage member Page 
== You Can ADD||Edit||Delete
=============================================================
*/
ob_start();
$pagetitle='Members';
session_start();
if(isset($_SESSION['Username'])){
    include 'init.php';
    $page = '';
    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    } else {
        $page = 'Manage';
    }
    if($page == 'Manage'){// Manage Page
        $query='';
        $header = 'Manage';
        if(isset($_GET['request']) && $_GET['request']=='pending'){
            $query = 'RegStatus = 0';   
            $header = 'Pending';
        }
        else {
            $query = 1;
        }
        $stmt = $con->prepare("SELECT * FROM users WHERE $query");
        $stmt->execute();
        $row= $stmt->fetchAll();
        $count = countItem('*','users','GroupID!=1');
        ?>
        <h1 class='text-center'><?php echo $header;?> Members</h1>
        <div class='container'>
        <?php
        if($count > 0){?>
            <div class='table-responsive'>
                <table class='text-center main-table table table-bordered'>
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Registered Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach($row as $row)
                    { 
                    echo "<tr>";
                        echo "<td>" . $row['UserID'] . "</td>";
                        if($row['GroupID']==1){
                            echo "<td class='admin'>" . $row['UserName'] . "</td>";
                        }
                        else {
                            echo "<td>" . $row['UserName'] . "</td>";
                        }
                        echo "<td>" . $row['Email'] . "</td>";
                        echo "<td>" . $row['FullName'] . "</td>";
                        echo "<td>" . $row['Date']."</td>";
                        echo "<td>";
                        if($row['GroupID']==0){
                            echo "<a href='Members.php?page=Edit&id=". $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                            <a href='Members.php?page=Delete&id=".$row['UserID']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i>Delete</a>";
                            if($row['RegStatus']==0){
                            echo "<a href='Members.php?page=Activate&id=".$row['UserID']."' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
                            }
                        }
                        else {
                            echo "<span style='font-weigth:bold'>No Action Available</span>";
                        }
                        echo "</td>";
                        echo "</tr>";
                    }
            ?></table>
            </div>
                <?php }
                else {
                    ?> 
                        <div class='alert alert-info'>You Don't Have Any Member</div>
                    <?php
                }
        ?>
            <a href='Members.php?page=Add' class='btn btn-primary'><i class='fa fa-plus'></i> Add New Member</a>
        </div>
                <?php }
    else if($page == 'Add'){ // Add Page?>
        <h1 class='text-center'>Add New Member</h1>
        <div class='container'>
            <form class='form-horizontal' action='?page=Insert' method='POST'>
                <!-- Start Username -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>Username</label>
                    <div class='col-sm-8'>
                        <input  type='text' name='username' class='form-control' autocomplete='off'>
                    </div>
                </div>
                <!-- End Username -->
                <!-- Start Password  -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>Password</label>
                    <div class='col-sm-8'>
                        <input  type='password' name='password' class='password form-control'>
                        <i class='show-pass fa fa-eye fa-2x'></i>
                    </div>
                </div>
                <!-- End Password -->
                <!-- Start Email -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>Email</label>
                    <div class='col-sm-8'>
                        <input  type='email' name='email' class='form-control' autocomplete='off'>
                    </div>
                </div>
                <!-- End Email -->
                <!-- Start FullName -->
                <div class='form-group form-group-lg'>
                    <label class='col-sm-2 control-label'>Full Name</label>
                    <div class='col-sm-8'>
                        <input  type='text' name='fullname' class='form-control' autocomplete='off'>
                    </div>
                <!-- End FullName -->
                <!-- Start Submit -->
                </div>
                <div class='form-group form-group-lg'>
                    <div class='col-sm-offset-2 col-sm-10'>
                        <input type='submit' name='Add member' value='Add Member' class='btn btn-success btn-lg'>
                    </div>
                </div>
                <!-- End Submit -->
            </form>
        </div>
<?php }
    else if($page == 'Insert'){ // Insert Members Page
        // Get variables from the form
        if($_SERVER['REQUEST_METHOD']=='POST'){
            echo "<h1 class='text-center'>Insert Member</h1>";
            $user       = $_POST['username'];
            $id         = $_SESSION['UserID'];
            $pass       = $_POST['password'];
            $mail       = $_POST['email'];
            $fname      = $_POST['fullname'];
            $hashPass   = sha1($_POST['password']);
            // Password Trick 
            $formErrors;
            if(empty($user)){
                $formErrors[]='Username Can\'t be Empty';
            }
            if(empty($mail)){
                $formErrors[]='Email Can\'t be Empty';
            }
            if(empty($fname)){
                $formErrors[]='Full Name Can\'t be Empty';
            }
            if(empty($pass)){
                $formErrors[]='Password Can\'t be Empty';
            }
            //Check if the username is taken
                $count = checkItems("UserName","users",$user);
                if($count>0)
                {
                    $formErrors[]="This Username is Already Exist";
                }
            // Check if there is no errors
            if(empty($formErrors)){
                // Insert Items Database
                $stmt = $con->prepare("INSERT INTO users (Username, Password, Email, FullName,RegStatus,Date) VALUES (:user, :pass, :mail, :fullname,1,now())");
                $stmt->execute(array(
                    'user'      => $user,
                    'pass'      => $hashPass,
                    'mail'      => $mail,
                    'fullname'  => $fname
                ));
                // Insert Success
                $msg = "Member Added Successfully";
                redirectToIndex(3,$msg,"success","Members.php?page=Manage");
            } 
            // if there an error 
            else{
                $error='';
                foreach($formErrors as $errors){
                    $error.=$errors.'<br>'; 
                }   
                redirectToIndex(4,$error,'danger',"Members.php?page=Add");
            }   
        }
        else {
            redirectToIndex(3,"You Can't Enter This Page Directly","danger",'back');
        }
}
    elseif($page == 'Edit'){// Edit Page
        // Check if the id is exist and numeric
        $userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // Get The Data From Databse
        $stmt = $con->prepare("SELECT * FROM users WHERE UserID=? LIMIT 1");
            $stmt->execute(array($userid));
            $row= $stmt->fetch(); 
            $count = $stmt->rowCount();
            // Check if this user is exist
            if($count> 0)
            {
    ?>
    <h1 class='text-center'>Edit Member</h1>
    <div class='container'>
        <form class='form-horizontal' action='?page=Update' method='POST'>
            <!-- Start Username -->
            <input type='hidden' name='UserID' value='<?php echo $userid?>'>
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label'>Username</label>
                <div class='col-sm-8'>
                    <input  type='text' name='username' class='form-control' value='<?php echo $row['UserName'];?>' autocomplete='off'>
                </div>
            </div>
            <!-- End Username -->
            <!-- Start Password  -->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label'>Password</label>
                <div class='col-sm-8'>
                    <input type='hidden' name='oldpassword' value='<?php echo $row['Password'];?>' class='form-control'>
                    <input type='password' name='password' class='form-control' placeholder="Leave Blank if You Don't Want to Change it">
                </div>
            </div>
            <!-- End Password -->
            <!-- Start Email -->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label'>Email</label>
                <div class='col-sm-8'>
                    <input  type='email' name='email' class='form-control' value='<?php echo $row['Email'];?>' autocomplete='off'>
                </div>
            </div>
            <!-- End Email -->
            <!-- Start FullName -->
            <div class='form-group form-group-lg'>
                <label class='col-sm-2 control-label'>Full Name</label>
                <div class='col-sm-8'>
                    <input  type='text' name='fullname' class='form-control' value='<?php echo $row['FullName'];?>' autocomplete='off'>
                </div>
            <!-- End FullName -->
            <!-- Start Submit -->
            </div>
            <div class='form-group form-group-lg'>
                <div class='col-sm-offset-2 col-sm-10'>
                    <input type='submit' name='Save' value='Save' class='btn btn-success btn-lg'>
                </div>
            </div>
            <!-- End Submit -->
        </form>
    </div>
<?php }
    else {
        $errormsg = "There is No Such ID";
        redirectToIndex(3,$errormsg,'danger');
}
    }
elseif($page == 'Update'){ // Update Page
    // Get variables from the form
    if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "<h1 class='text-center'>Update Member</h1>";
        $id     = $_POST['UserID'];
        $user   = $_POST['username'];
        $mail   = $_POST['email'];
        $fname  = $_POST['fullname'];
        $pass = '';
        // Updata Member Trick
        $stmt2=$con->prepare("SELECT UserName FROM users WHERE UserName=? AND UserID!=?");
        $stmt2->execute(array($user,$id));
        $count = $stmt2->rowCount();
        // Password Trick 
        $formErrors;
        $pass = empty($_POST['password'])?$_POST['oldpassword'] : sha1($_POST['password']);
        if(empty($user)){
            $formErrors[]='Username Can\'t be Empty';
        }
        if(empty($mail)){
            $formErrors[]='Email Can\'t be Empty';
        }
        if(empty($fname)){
            $formErrors[]='Full Name Can\'t be Empty';
        }
        if($id == 1 && $_SESSION['UserID']!=$id){
            $formErrors[]='You Can\'t Edit This User';
        }
        if($count==1){
            $formErrors[]='This Username Already Exist';
        }
        // Check if there is no errors
        if(empty($formErrors)){
            // Update Database
            // For Admin Username 
            $stmt=$con->prepare("UPDATE users SET UserName=?, Email= ?, Password=?, FullName=? WHERE UserID= ?");
            $stmt->execute(array($user,$mail,$pass,$fname,$id));
            $msg = "Profile Updated Successfully";
            redirectToIndex(3,$msg,"success","back");
        } 
        // if there an error 
        else{
            $error='';
            foreach($formErrors as $errors){
                $error.=$errors.'<br>'; 
            }   
            redirectToIndex(4,$error,'danger',"Members.php?page=Edit&id=$id");
        }   
    }
}
elseif($page == 'Delete')  
{// Delete Page
    echo "<h1 class='text-center'>Delete Member</h1>";
    echo "<div class='container'>";
    // Check if the id is exist and numeric
    $userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    // Get The User Info From database
    $count = checkItems("UserID", "users" , $userid);
        // Check if the user Exist
        if($count > 0)
        {
            $stmt = $con->prepare("DELETE FROM users WHERE UserID=?");
            $stmt->execute(array($userid));
            redirectToIndex(3,"User Deleted Successfully","success","Members.php");
        }
        else {
            redirectToIndex(3,"This UserName isn't Exist","danger");
            
        }
}
elseif($page == 'Activate'){ // Activate Page
    echo "<h1 class='text-center'>Activate Member</h1>";
    echo "<div class='container'>";
    // Check if the id is exist and numeric
    $userid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    // Get The User Info From database
    $count = checkItems("UserID", "users" , $userid);
        // Check if the user Exist
        if($count > 0)
        {
            $stmt = $con->prepare("UPDATE users SET RegStatus=1 WHERE UserID=?");
            $stmt->execute(array($userid));
            redirectToIndex(3,"User Activated Successfully","success");
        }
        else {
            redirectToIndex(3,"This UserName isn't Exist","danger");
            
        }

}
include $tpl . "footer.php";
}
    else {
    $error = "You Are Not Authozried to See this Page";
    redirectToIndex(3,$error,"danger");
    exit();
}
ob_end_flush();
?>