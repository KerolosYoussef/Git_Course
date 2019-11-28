<?php 
/* 
=============================================================
== Categories Page
== You Can Add | Edit | Delete Categorie
=============================================================
*/
    ob_start();
    $pagetitle='Categories';
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
            // Get The Data from Database
            $orderBy = 'Name';
            $sort = "ASC";
            $orderByArr = array("Name","Ordering");
            $sortArr = array("ASC","DESC");
            if(isset($_GET['sort']) && in_array($_GET['sort'],$sortArr)){
                $sort = $_GET['sort'];
            }
            if(isset($_GET['sortBy']) && in_array($_GET['sortBy'],$orderByArr)){
                $orderBy = $_GET['sortBy'];
            }
            $stmt2 = $con->prepare("SELECT * FROM categories ORDER BY $orderBy $sort");
            $stmt2->execute();
            $categories=$stmt2->fetchAll(); 
            $count = countItem('*','categories');
            ?>
            <h1 class='text-center'>Manage Categories</h1>
            <div class='container categories'>
            <?php 
            if($count > 0){
                 // Start The HTML Page ?>
            
                <div class='panel panel-default'>
                    <div class='panel-heading'>
                        <span class='heading'><i class=" manage fas fa-tasks"></i>Manage Categories</span>
                        <div class='view pull-right'>
                            <i class='fa fa-eye'></i>View:[
                            <span class='active' data-view="full">Full</span> |
                            <span>Classic</span>]
                        </div>
                    </div>
                    <div class='panel-body'>
                        
                        <?php foreach($categories as $values){
                            echo "<div class='cat'>";
                                echo "<div class='hidden-btns'>";
                                    echo "<a href='?page=Edit&id=".$values['ID']."' class='btn btn-primary btn-sm'><i class='fa fa-edit'></i>Edit</a>";
                                    echo "<a href='?page=Delete&id=".$values['ID'] ."' class='btn btn-danger btn-sm confirm'><i class='fa fa-trash'></i>Delete</a>";
                                echo "</div>";
                                echo "<h3>" . $values['Name'] . "</h3>";
                                echo "<div class='show-hide'>";
                                    echo "<p>";
                                        if(empty($values['Description'])){ // Check if The Categorie Description is empty
                                            echo "This Categorie Has no Description";
                                        }else {
                                            echo $values['Description'];
                                        }
                                    echo"</p>";
                                    echo "<span>";
                                        if($values['Visibility'] == 0){
                                            echo "<span class='not-visible'><i class='fas fa-eye-slash'></i>Hidden</span>";
                                        }
                                        else {
                                            echo "<span class='visible'><i class='fas fa-eye'></i>Shown</span>";
                                        }
                                    echo "</span>";
                                    echo "<span>";
                                        if($values['Allow_Comment']==0){
                                            echo "<span class='comment-disabled'><i class='fas fa-minus-circle'></i>Comments are Disabled</span>";
                                        } else {
                                            echo "<span class='comment-enabled'><i class='fas fa-check'></i>Comments are Enabled</span>";
                                        }
                                    echo "</span>";
                                    echo "<span>";
                                    if($values['Allow_Ads']==0){
                                        echo "<span class='comment-disabled'><i class='fas fa-minus-circle'></i>Ads are Disabled</span>";
                                    } else {
                                        echo "<span class='comment-enabled'><i class='fas fa-check'></i>Ads are Enabled</span>";
                                    }
                                echo "</span>";
                                    echo "<hr>";
                                echo "</div>";
                            echo "</div>";
                        } ?>
                    </div>
                </div>
            <?php } else {
                ?>
                        <div class='alert alert-info'>You Don't Have Any Categorie</div>
            <?php }
            ?>
                <a href='categories.php?page=Add' class='btn btn-primary'><i class='fa fa-plus'></i> Add New Categorie</a>
                <?php 
                    echo "<div class='pull-right sorting'>";
                        echo "<h4 class='orderBy'>Order By</h4>";
                        echo "<select id='sortselect' name='srt' class='selectpicker'>";
                        foreach($orderByArr as $orderByValue){
                                echo "<option value='$orderByValue'>$orderByValue</option>";
                        }
                        echo "</select>";
                        echo "<select id='orderselect' name='order' class='selectpicker'>";
                        foreach($sortArr as $sortArrValue){
                            echo "<option value='$sortArrValue'>$sortArrValue</option>";
                        }
                        echo "</select>";
                        echo "<input id='send' class='btn btn-primary  btn-md' type=submit value='Submit'>";
                    echo "</div>";
                ?>
            </div>
            <?php 
            
        }
        else if($page == 'Add'){ // Add Page?>
            <h1 class='text-center'>Add New Categorie</h1>
            <div class='container'>
                <form class='form-horizontal' action="?page=Insert" method="POST">
                    <!-- Start Name -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Name</label>
                        <div class='col-sm-8'>
                            <input required type='text' name='name' class='form-control' autocomplete='off' placeholder="Enter Categorie Name">
                        </div>
                    </div>
                    <!-- End Name -->
                    <!-- Start Description -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Description</label>
                        <div class='col-sm-8'>
                            <input type='text' name='description' class='form-control' autocomplete='off' placeholder="Enter Description of the categorie">
                        </div>
                    </div>
                    <!-- End Description -->
                    <!-- Start Ordering -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Ordering</label>
                        <div class='col-sm-8'>
                            <input  type='text' name='ordering' class='form-control' autocomplete="off" placeholder="Enter Categorie Ordering">
                        </div>
                    </div>
                    <!-- End Ordering -->
                    <!-- Start Visiblity -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Visible</label>
                        <div class='col-sm-8'>
                            <div>
                                <input id='vis-yes' type='radio' name='visiblity' value='1' checked>
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id='vis-no' type='radio' name='visiblity' value='0'>
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Visiblity -->
                    <!-- Start Comment -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Allow Comment</label>
                        <div class='col-sm-8'>
                            <div>
                                <input id='com-yes' type='radio' name='Comment' value='1' checked>
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id='com-no' type='radio' name='Comment' value='0'>
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Comment -->
                    <!-- Start Ads -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Allow Ads</label>
                        <div class='col-sm-8'>
                            <div>
                                <input id='ads-yes' type='radio' name='ads' value='1' checked>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id='ads-no' type='radio' name='ads' value='0'>
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Ads -->
                    <!-- Start Submit -->
                        <div class='form-group form-group-lg'>
                            <div class='col-sm-offset-2 col-sm-1'>
                                <input type='submit' name='Add Categorie' value='Add Categorie' class='btn btn-success btn-lg'>
                            </div>
                        </div>
                    <!-- End Submit -->
                    
                </form>
            </div>

        <?php }
        else if($page == 'Insert'){ // Insert Page
            if($_SERVER['REQUEST_METHOD']=="POST"){
                echo "<h1 class='text-center'>Insert Categorie</h1>";
                // Get The info from the form
                $name           = $_POST['name'];
                $description    = $_POST['description'];
                $ordering       = $_POST['ordering'];
                $visible        = $_POST['visiblity'];
                $comment        = $_POST['Comment'];
                $ads            = $_POST['ads'];
                $formErrors     =array();
                // Check Form Errors
                if(empty($name)){
                    $formErrors[]="Name Mustn't be Empty";
                }
                // Check if the item is exist
                $count = checkItems("Name","categories", $name);
                if($count>0){
                    $formErrors[]="This Item Already Exist";
                }
                if(empty($formErrors)){
                    // Add Info to DataBase
                    $stmt=$con->prepare("INSERT INTO categories 
                    (Name, Description, Ordering, Visibility, Allow_Comment, Allow_Ads) VALUES
                    (:name, :desc, :order, :visible, :comment, :ads)");
                    $stmt->execute(array(
                        "name"      => $name,
                        "desc"      => $description,
                        "order"     => $ordering,
                        "visible"   => $visible,
                        "comment"   => $comment,
                        "ads"       => $ads
                    ));
                    $Msg = 'Categorie Added Successfully';
                    redirectToIndex(3,$Msg,'success',"back");
                }
                else {
                    $Msg = '';
                    foreach($formErrors as $error){
                        $Msg .= $error."<br>";
                    }
                    redirectToIndex(3,$Msg,'danger',"back");
                }
            }
            else {
                $Msg = "You Are Not Authorized to see This Page";
                redirectToIndex(3,$Msg,'danger',$url=null);
            }
        }
        elseif($page == 'Edit'){// Edit Page
        // Check if the id is exist and numeric
        $catid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
        // Get The Data From Databse
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID=? LIMIT 1");
            $stmt->execute(array($catid));
            $row= $stmt->fetch(); 
            $count = $stmt->rowCount();
            // Check if this user is exist
        if($count> 0)
        {
            ?>
        <h1 class='text-center'>Edit Categorie</h1>
            <div class='container'>
                <form class='form-horizontal' action="?page=Update" method="POST">
                    <!-- Start Name -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Name</label>
                        <div class='col-sm-8'>
                            <input type='text' hidden name='catID' value='<?php echo $catid; ?>'>
                            <input required type='text' name='name' class='form-control' value='<?php echo $row['Name']?>' autocomplete='off' placeholder="Enter Categorie Name">
                        </div>
                    </div>
                    <!-- End Name -->
                    <!-- Start Description -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Description</label>
                        <div class='col-sm-8'>
                            <input type='text' name='description' class='form-control'  value='<?php echo $row['Description']?>' autocomplete='off' placeholder="Enter Description of the categorie">
                        </div>
                    </div>
                    <!-- End Description -->
                    <!-- Start Ordering -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Ordering</label>
                        <div class='col-sm-8'>
                            <input  type='text' name='ordering' class='form-control'  value='<?php echo $row['Ordering']?>' autocomplete="off" placeholder="Enter Categorie Ordering">
                        </div>
                    </div>
                    <!-- End Ordering -->
                    <!-- Start Visiblity -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Visible</label>
                        <div class='col-sm-8'>
                            <div>
                                <input id='vis-yes' type='radio' name='visiblity' value='1' <?php if($row['Visibility']==1) echo "Checked" ?>>
                                <label for="vis-yes">Yes</label>
                            </div>
                            <div>
                                <input id='vis-no' type='radio' name='visiblity' value='0' <?php if($row['Visibility']==0) echo "Checked" ?>>
                                <label for="vis-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Visiblity -->
                    <!-- Start Comment -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Allow Comment</label>
                        <div class='col-sm-8'>
                            <div>
                                <input id='com-yes' type='radio' name='Comment' value='1' <?php if($row['Allow_Comment']==1) echo "Checked" ?>>
                                <label for="com-yes">Yes</label>
                            </div>
                            <div>
                                <input id='com-no' type='radio' name='Comment' value='0' <?php if($row['Allow_Comment']==0) echo "Checked" ?>>
                                <label for="com-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Comment -->
                    <!-- Start Ads -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Allow Ads</label>
                        <div class='col-sm-8'>
                            <div>
                                <input id='ads-yes' type='radio' name='ads' value='1' <?php if($row['Allow_Ads']==1) echo "Checked" ?>>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id='ads-no' type='radio' name='ads' value='0' <?php if($row['Allow_Ads']==0) echo "Checked" ?>>
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!-- End Ads -->
                    <!-- Start Submit -->
                        <div class='form-group form-group-lg'>
                            <div class='col-sm-offset-2 col-sm-1'>
                                <input type='submit' name='Add Categorie' value='Save' class='btn btn-success btn-lg'>
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
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo "<h1 class='text-center'>Update Categorie</h1>";
                $cateid         = $_POST['catID'];
                $name           = $_POST['name'];
                $description    = $_POST['description'];
                $ordering       = $_POST['ordering'];
                $visible        = $_POST['visiblity'];
                $comment        = $_POST['Comment'];
                $ads            = $_POST['ads'];
                $formErrors;
                if(empty($name)){
                    $formErrors[]='Username Can\'t be Empty';
                }
                $count = checkItems("Name","categories",$name);
                if($count>0)
                {
                    $formErrors[]="This Username is Already Exist";
                }
                // Check if there is no errors
                if(empty($formErrors)){
                    // Update Database
                    // For Admin Username 
                    $stmt=$con->prepare("UPDATE categories SET Name=?, Description=?, Ordering=?, Visibility=?, Allow_Comment=?, Allow_Ads=? WHERE ID= ?");
                    $stmt->execute(array($name,$description,$ordering,$visible,$comment,$ads,$cateid));
                    $msg = "Categorie Updated Successfully";
                    redirectToIndex(3,$msg,"success","categories.php?page=Manage");
                } 
                // if there an error 
                else{
                    $error='';
                    foreach($formErrors as $errors){
                        $error.=$errors.'<br>'; 
                    }   
                    redirectToIndex(4,$error,'danger',"categories.php?page=Edit&id=$cateid");
                }   
            }
        }
        elseif($page == 'Delete')  
        {// Delete Page
            echo "<h1 class='text-center'>Delete Categorie</h1>";
            echo "<div class='container'>";
            // Check if the id is exist and numeric
            $cateid = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            // Get The User Info From database
            $count = checkItems("ID", "categories" , $cateid);
                // Check if the user Exist
                if($count > 0)
                {
                    $stmt = $con->prepare("DELETE FROM categories WHERE ID=?");
                    $stmt->execute(array($cateid));
                    redirectToIndex(3,"Categorie Deleted Successfully","success","Categories.php");
                }
                else {
                    redirectToIndex(3,"This Categorie isn't Exist","danger");
                    
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