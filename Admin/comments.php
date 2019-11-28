<?php 
/* 
=============================================================
== Manage Comments Page 
== You Can |Edit||Delete|Approve
=============================================================
*/
ob_start();
$pagetitle='Comments';
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
        $item_Name = '';
        $Item_ID=(isset($_GET['id']) && is_numeric($_GET['id']))? "items.Item_ID= ".intval($_GET['id']):"1";
        $stmt = $con->prepare("SELECT comments.* ,items.Name AS Item_Name, users.UserName as Member_Name FROM comments
                            INNER JOIN items ON items.item_ID = comments.Item_ID
                            INNER JOIN users ON users.UserID = comments.user_ID WHERE $Item_ID");
        $stmt->execute(array($Item_ID));
        $comments= $stmt->fetchAll();
        $count = $stmt->rowCount();
        if(isset($_GET['id'])){
            foreach($comments as $comment)
            { 
                $item_Name = "[ ".$comment['Item_Name']." ]";
            }
        } else {
            $item_Name = '';
        }
        if($count>0){
        ?>
        <h1 class='text-center'>Manage  <?php echo $item_Name; ?> Comments</h1>
        <div class='container'>
            <div class='table-responsive'>
                <table class='text-center main-table table table-bordered'>
                    <tr>
                        <td>#ID</td>
                        <td>Comment</td>
                        <td>Item name</td>
                        <td>Member Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>
                    <?php
                    foreach($comments as $comment)
                    { 
                    echo "<tr>";
                        echo "<td>" . $comment['C_ID'] . "</td>";
                        echo "<td>" . $comment['Comment'] . "</td>";
                        echo "<td>" . $comment['Item_Name'] . "</td>";
                        echo "<td>" . $comment['Member_Name'] . "</td>";
                        echo "<td>" . $comment['Added_Date']."</td>";
                        echo "<td>";
                        echo "<a href='comments.php?page=Edit&id=". $comment['C_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                        <a href='comments.php?page=Delete&id=".$comment['C_ID']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i>Delete</a>";
                            if($comment['C_Status']==0){
                            echo "<a href='comments.php?page=Approve&id=".$comment['C_ID']."' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";
                    }
                        echo "</td>";
                        echo "</tr>";
                    }
                ?></table>
            </div>
        </div>
    <?php
    } else {
        echo "<h1 class='text-center'>Manage <?php echo $item_Name; ?> Comments</h1>";
        echo "<div class='container'>";
        $msg = 'There Is no Comments For This items';
        redirectToIndex(3,$msg ,"info","back");
    } 
    }
    elseif($page == 'Edit'){// Edit Page
        // Get The ID of the comment
        $commentID=(isset($_GET['id']) && is_numeric($_GET['id']))? intval($_GET['id']) : 0;
        // Get The Data From Database
        $stmt = $con->prepare("SELECT * FROM comments WHERE C_ID=?");
        $stmt->execute(array($commentID));
        $comment=$stmt->fetch();
        $count= $stmt->rowCount();
        if($count>0){?>
            <h1 class='text-center'>Edit Comment</h1>
            <div class='container'>
                <form class='form-horizontal' action="?page=Update" method="POST">
                    <!-- Start Comment -->
                        <input hidden type="text" name='C_ID' value="<?php echo $comment['C_ID'] ?>">
                        <div class='comment form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Comment</label>
                            <div class='col-sm-8'>
                                <textarea required class='form-control text-area' name="Comment" rows="3"><?php echo $comment['Comment'];?> </textarea>
                            </div>
                        </div>
                    <!-- End Comment -->
                    <!-- Start Save -->
                    <div class='form-group form-group-lg '>
                        <div class='col-sm-offset-2 col-sm-1'>
                            <input type="submit" value='Save' class='btn btn-primary btn-lg'>
                        </div>
                    </div>
                    <!-- End Save -->
                </form>
            </div>
        <?php
        } else {
            $msg = 'There is No Such ID';
            redirectToIndex(3,$msg,'danger','back');
        }
    
    }
elseif($page == 'Update'){ // Update Page
    // Get variables from the form
    if($_SERVER['REQUEST_METHOD']=='POST'){
        echo "<h1 class='text-center'>Update Comment</h1>";
        $commentID      = $_POST['C_ID'];
        $Comment        = $_POST['Comment'];
        $formErrors;
        if(empty($Comment)){
            $formErrors[]="Comment Mustn't Be Empty";
        }
        if(empty($formErrors)){
            // Update Database
            // For Admin Username 
            $stmt=$con->prepare("UPDATE comments SET Comment=? WHERE C_ID= ?");
            $stmt->execute(array($Comment,$commentID));
            $msg = "Comment Updated Successfully";
            redirectToIndex(3,$msg,"success","comments.php");
        } 
        // if there an error 
        else{
            $error='';
            foreach($formErrors as $errors){
                $error.=$errors.'<br>'; 
            }   
            redirectToIndex(4,$error,'danger',"comments.php?page=Edit&id=$commentID");
        }   
    }
}
elseif($page == 'Delete')  
{// Delete Page
    echo "<h1 class='text-center'>Delete Comment</h1>";
    echo "<div class='container'>";
    // Check if the id is exist and numeric
    $commentID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    // Get The User Info From database
    $count = checkItems("C_ID", "comments" , $commentID);
        // Check if the user Exist
        if($count > 0)
        {
            $stmt = $con->prepare("DELETE FROM comments WHERE C_ID=?");
            $stmt->execute(array($commentID));
            redirectToIndex(3,"User Deleted Successfully","success","comments.php");
        }
        else {
            redirectToIndex(3,"This UserName isn't Exist","danger");
            
        }
}
elseif($page == 'Approve'){ // Approve Page
    echo "<h1 class='text-center'>Approve Comment</h1>";
    echo "<div class='container'>";
    // Check if the id is exist and numeric
    $commentID = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
    // Get The User Info From database
    $count = checkItems("C_ID", "comments" , $commentID);
        // Check if the user Exist
        if($count > 0)
        {
            $stmt = $con->prepare("UPDATE comments SET C_Status=1 WHERE C_ID=?");
            $stmt->execute(array($commentID));
            redirectToIndex(3,"Comment Approved Successfully","success","back");
        }
        else {
            redirectToIndex(3,"This Comment isn't Exist","danger");
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