<?php 
/* 
=============================================================
== Items Page
=============================================================
*/
    ob_start();
    $pagetitle='Items';
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
            // Fetch The Data From Database
            $stmt = $con->prepare("SELECT 
                                    items.*,categories.Name AS Categorie, users.UserName as Username FROM items
                                    INNER JOIN categories ON categories.ID = items.Cat_ID
                                    INNER JOIN users ON users.UserID = items.Member_ID");
            $stmt->execute();
            $items= $stmt->fetchAll();
            $count = countItem('*','items');
            ?>
            <h1 class='text-center'>Manage Items</h1>
            <div class='container'>
            <?php 
            if($count>0){
                    ?>
                    <div class='table-responsive'>
                        <table class='text-center main-table table table-bordered'>
                            <tr>
                                <td>#ID</td>
                                <td>Name</td>
                                <td>Description</td>
                                <td>Price [EGP]</td>
                                <td>Added Date</td>
                                <td>Made In</td>
                                <td>Status</td>
                                <td>Categorie</td>
                                <td>Member</td>
                                <td>Control</td>
                            </tr>
                            <?php
                            foreach($items as $item)
                            { 
                            echo "<tr class='items'>";
                                echo "<td>" . $item['Item_ID'] . "</td>";
                                echo "<td>" . $item['Name'] . "</td>";
                                echo "<td>" . $item['Description'] . "</td>";
                                echo "<td>" . $item['Price'] . "</td>";
                                echo "<td>" . $item['Add_Date']."</td>";
                                echo "<td>" . $item['Country_Made']."</td>";
                                echo "<td>"; 
                                    if($item['Status']==1){
                                        echo "New";
                                    } elseif($item['Status']==2){
                                        echo "Like New";
                                    } elseif($item['Status']==3){
                                        echo "Used";
                                    } else if($item['Status']==4){
                                        echo "Very Old";
                                    }
                                echo "</td>";
                                echo "<td>" . $item['Categorie']."</td>";
                                echo "<td>" . $item['Username']."</td>";
                                echo "<td>";
                                echo "<a href='items.php?page=Edit&id=". $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>
                                <a href='items.php?page=Delete&id=".$item['Item_ID']."' class='btn btn-danger confirm'><i class='fa fa-trash'></i>Delete</a>";
                                if($item['Approve_Status']==0){
                                echo "<a href='items.php?page=Approve&id=".$item['Item_ID']."' class='btn btn-info activate'><i class='fa fa-check'></i>Activate</a>";}
                                echo "<a href='comments.php?id=". $item['Item_ID'] . "' class='btn btn-primary'><i class='fa fa-comment'></i>Comments</a>";
                                
                            }
                            ?></table>
                            </div>
                            <?php
            } else {
                ?> 
                    <div class='alert alert-info'>You Don't Have Any Item</div>
                <?php
            }
            ?>
            <a href='items.php?page=Add' class='btn btn-primary'><i class='fa fa-plus'></i> Add New Item</a>
            </div>
        <?php
        }
        else if($page == 'Add'){ // Add Page?>
            <h1 class='text-center'>Add New Item</h1>
            <div class='container addPage'>
                <form class='form-horizontal' action="?page=Insert" method="POST">
                    <!-- Start Name -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Name</label>
                        <div class='col-sm-8'>
                            <input required type='text' name='name' class='form-control' placeholder='Enter Item Name' autocomplete='off'>
                        </div>
                    </div>
                    <!-- End Name -->
                    <!-- Start Description -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Description</label>
                        <div class='col-sm-8'>
                            <input required type='text' name='description' class='form-control' placeholder='Description of Item' autocomplete='off'> 
                        </div>
                    </div>
                    <!-- End Description -->
                    <!-- Start Price -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Price</label>
                        <div class='col-sm-8'>
                            <input required type='text' name='price' class='form-control' placeholder='Enter Price' autocomplete='off'> 
                        </div>
                    </div>
                    <!-- End Price -->
                    <!-- Start MadeIn -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Made In</label>
                        <div class='col-sm-8'>
                            <input required type='text' name='country_made' class='form-control' placeholder='Country of Made' autocomplete='off'> 
                        </div>
                    </div>
                    <!-- End MadeIn -->
                    <!-- Start Status -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Status</label>
                        <div class='col-sm-8'>
                            <select class='form-control' name='Status'>
                                <option value="0">...</option>
                                <option value="1">New</option>
                                <option value="2">Like New</option>
                                <option value="3">Used</option>
                                <option value="4">Very Old</option>
                            </select>
                        </div>
                    </div>
                    <!-- End Status -->
                    <!-- Start Member -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Member</label>
                        <div class='col-sm-8'>
                            <select class='form-control' name='user'>
                                <option value="0">...</option>
                                <?php 
                                    $stmt2=$con->prepare("SELECT * FROM users WHERE GroupID=0");
                                    $stmt2->execute();
                                    $users = $stmt2->fetchAll();
                                    foreach($users as $user){
                                        echo "<option style='font-size:18px;' value='".$user['UserID']."'>".$user['UserName']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Member -->
                    <!-- Start Categorie -->
                    <div class='form-group form-group-lg'>
                        <label class='col-sm-2 control-label'>Categorie</label>
                        <div class='col-sm-8'>
                            <select class='form-control' name='cate'>
                                <option value="0">...</option>
                                <?php 
                                    $stmt3=$con->prepare("SELECT * FROM categories");
                                    $stmt3->execute();
                                    $cate = $stmt3->fetchAll();
                                    foreach($cate as $cat){
                                        echo "<option style='font-size:18px;' value='".$cat['ID']."'>".$cat['Name']."</option>";
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <!-- End Categorie -->
                    <!-- Start Submit -->
                    <div class='form-group form-group-lg'>
                        <div class='col-sm-offset-2 col-sm-1'>
                            <input type='submit' class='btn btn-success btn-lg' name='submit' value='Add'>
                        </div>
                    </div>
                    <!-- End Submit -->
                </form>
            </div>
<?php   }
        else if($page == 'Insert'){ // Insert Page
            // Check if the user open the page from the form or not
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo "<h1 class='text-center'>Add Item</h1>";
                // Get The Data From The Form
                $name           = $_POST['name'];
                $description    = $_POST['description'];
                $price          = $_POST['price'];
                $made           = $_POST['country_made'];
                $status         = $_POST['Status'];
                $member         = $_POST['user'];
                $categorie      = $_POST['cate'];
                $formErrors;
                // Checking for Errors
                if(empty($name)){
                    $formErrors[]="Name Cant't Be Empty";
                }
                if(empty($description)){
                    $formErrors[]="Description Can't Be Empty";
                }
                if(empty($price)){
                    $formErrors[]="Price Can't Be Empty";
                }
                if(empty($made)){
                    $formErrors[]="Made Country Can't be Empty";
                }
                if($member==0){
                    $formErrors[]="Members Can't Be Empty";
                }
                if($status==0){
                    $formErrors[]="Status Can't Be Empty";
                }
                if($categorie==0){
                    $formErrors[]="Categorie Can't Be Empty";
                }
                // Check if there is no errors
                if(empty($formErrors)){
                    $add=$con->prepare("INSERT INTO items 
                                        (Name, Description, Price, Country_Made, Status, Add_Date, Cat_ID, Member_ID) VALUES
                                        (:name, :desc, :price, :made, :status, NOW(), :catid, :memberid)");
                    $add->execute(array(
                        "name"      => $name,
                        "desc"      => $description,
                        "price"     => $price,
                        "made"      => $made,
                        "status"    => $status,
                        ":catid"    => $categorie,
                        ":memberid" => $member
                    ));
                    $msg = 'Item Added Successfully';
                    redirectToIndex(3,$msg,"success",'items.php');
                }
                else {
                    $msg = '';
                    foreach($formErrors as $error){
                        $msg .= $error .'<br>';
                    }
                    redirectToIndex(5,$msg,"danger",'back');
                }
            }
            else {
                $msg='You Are not Autrhorized too see this page';
                redirectToIndex(3,$msg,'danger');
            }
        }
        elseif($page == 'Edit'){// Edit Page
            $itemid =  isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;
            $stmt8 = $con->prepare("SELECT * FROM items WHERE Item_ID=? LIMIT 1");
            $stmt8->execute(array($itemid));
            $item= $stmt8->fetch();
            $count= $stmt8->rowCount();
            if($count>0){
                ?>
                <h1 class='text-center'>Edit Item</h1>
                <div class='container'>
                    <form class='form-horizontal' action="?page=Update" method='POST'>
                        <!-- Start Name -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Name</label>
                            <div class='col-sm-8'>
                                <input hidden type="text" name='itemid' value='<?php echo $itemid; ?>'>
                                <input type="text" name='name' class='form-control' value='<?php echo $item['Name'];?>' placeholder='Enter Item Name'>
                            </div>
                        </div>
                        <!-- End Name -->
                        <!-- Start Description -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Description</label>
                            <div class='col-sm-8'>
                                <input type="text" name='Description' class='form-control' value='<?php echo $item['Description'];?>' placeholder='Description of Item'>
                            </div>
                        </div>
                        <!-- End Description -->
                        <!-- Start Price -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Price</label>
                            <div class='col-sm-8'>
                                <input type="text" name='Price' class='form-control' value='<?php echo $item['Price'];?>' placeholder='Enter Price'>
                            </div>
                        </div>
                        <!-- End Price -->
                        <!-- Start MadeIn -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Made In</label>
                            <div class='col-sm-8'>
                                <input type='text' name='country_made' class='form-control' value='<?php echo $item['Country_Made']?>' placeholder='Country of Made' autocomplete='off'> 
                            </div>
                        </div>
                        <!-- End MadeIn -->
                        <!-- Start Status -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Status</label>
                            <div class='col-sm-8'>
                                <select class='form-control' name='Status'>
                                    <option <?php if($item['Status']==1){echo "Selected";} ?> value="1">New</option>
                                    <option <?php if($item['Status']==2){echo "Selected";} ?> value="2">Like New</option>
                                    <option <?php if($item['Status']==3){echo "Selected";} ?> value="3">Used</option>
                                    <option <?php if($item['Status']==4){echo "Selected";} ?> value="4">Very Old</option>
                                    
                                </select>
                            </div>
                        </div>
                        <!-- End Status -->
                        <!-- Start Member -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Member</label>
                            <div class='col-sm-8'>
                                <select class='form-control' name='user'>
                                    <?php 
                                        $stmt2=$con->prepare("SELECT * FROM users WHERE GroupID=0");
                                        $stmt2->execute();
                                        $users = $stmt2->fetchAll();
                                        foreach($users as $user){
                                            echo "<option style='font-size:18px;' value='".$user['UserID']."'";
                                            if($item['Member_ID']==$user['UserID']) echo "Selected";
                                            echo ">".$user['UserName']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Member -->
                        <!-- Start Categorie -->
                        <div class='form-group form-group-lg'>
                            <label class='col-sm-2 control-label'>Categorie</label>
                            <div class='col-sm-8'>
                                <select class='form-control' name='cate'>
                                    <?php 
                                        $stmt3=$con->prepare("SELECT * FROM categories");
                                        $stmt3->execute();
                                        $cate = $stmt3->fetchAll();
                                        foreach($cate as $cat){
                                            echo "<option style='font-size:18px;' value='".$cat['ID']."'";
                                            if($item['Cat_ID']==$cat['ID']){ echo "Selected";}
                                            echo ">".$cat['Name']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- End Categorie -->
                        <!-- Start Submit -->
                        <div class='form-group form-group-lg'>
                            <div class='col-sm-offset-2 col-sm-1'>
                                <input type='submit' class='btn btn-success btn-lg' name='submit' value='Add'>
                            </div>
                        </div>
                        <!-- End Submit -->
                    </form>
                </div>
                <?php 
            }
            else {
                $msg = 'There is No Such ID';
                redirectToIndex(3 ,$msg , 'danger');
            }
        }
        elseif($page == 'Update'){ // Update Page
            if($_SERVER['REQUEST_METHOD']=='POST'){
                echo "<h1 class='text-center'>Update Item</h1>";
                echo "<div class='container'>";
                    $id             = $_POST['itemid'];
                    $name           = $_POST['name'];
                    $description    = $_POST['Description'];
                    $price          = $_POST['Price'];
                    $made           = $_POST['country_made'];
                    $status         = $_POST['Status'];
                    $member         = $_POST['user'];
                    $categorie      = $_POST['cate'];
                    $formErrors;
                    // Checking for Errors
                    if(empty($name)){
                        $formErrors[]="Name Cant't Be Empty";
                    }
                    if(empty($description)){
                        $formErrors[]="Description Can't Be Empty";
                    }
                    if(empty($price)){
                        $formErrors[]="Price Can't Be Empty";
                    }
                    if(empty($made)){
                        $formErrors[]="Made Country Can't be Empty";
                    }
                    if($member==0){
                        $formErrors[]="Members Can't Be Empty";
                    }
                    if($status==0){
                        $formErrors[]="Status Can't Be Empty";
                    }
                    if($categorie==0){
                        $formErrors[]="Categorie Can't Be Empty";
                    }
                // Updata The Data in the database
                if(empty($formErrors)){
                    $stmt4=$con->prepare("UPDATE items SET
                                        Name=?, Description=?, Price=?, Country_Made=?, Status=?, Cat_ID=?, Member_ID=?
                                        WHERE Item_ID=?");
                    $stmt4->execute(array($name,$description,$price,$made,$status,$categorie,$member,$id));
                    $msg = 'Item Updated Successfully';
                    redirectToIndex(3,$msg,'success',"?page=Manage");
                } else {
                    $msg = '';
                    foreach($formErrors as $error){
                        $msg .= $error . '<br>';
                    }
                    redirectToIndex(5,$msg ,"danger",'back');
                }
            }
            else {
                $msg = 'You Are Not Authorized To Visit This Page';
                redirectToIndex(3, $msg, 'danger'); 
            }
        }
        elseif($page == 'Delete')  {// Delete Page
            echo "<h1 class='text-center'>Delete Item</h1>";
            echo "<div class='container'>";
                $itemid =(isset($_GET['id']) && is_numeric($_GET['id']))? intval($_GET['id']) : 0;
                $count = checkItems("Item_ID",'items',$itemid);
                if($count > 0){
                    $stmt= $con->prepare("DELETE FROM items WHERE Item_ID=?");
                    $stmt->execute(array($itemid));
                    $msg = 'Item Deleted Successfully';
                    redirectToIndex(3,$msg,"success",'?page=Manage');
                } else {
                    $msg = 'This Item doesn\'t Exist';
                    redirectToIndex(3,$msg,"danger",'?page=Manage');
                }
            echo "</div>";
        }
        elseif($page == 'Approve'){ // Activate item
            // Get id
            $itemid = (isset($_GET['id']) && is_numeric($_GET['id']))? intval($_GET['id']): 0;
            // check if user exist
            $count = checkItems("Item_ID",'items',$itemid);
            if($count > 0){
                echo "<h1 class='text-center'>Approve Item</h1>";
                echo "<div class='container'>";
                    $stmt = $con->prepare("UPDATE items SET Approve_Status=1 WHERE Item_ID=?");
                    $stmt->execute(array($itemid));
                    $msg = 'Item Approved Successfully';
                    redirectToIndex(3,$msg,'success','back');
                echo "</div>";
            } else {
                $msg = 'This item isn\'t exist';
                redirectToIndex(3,$msg,'danger','back');
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