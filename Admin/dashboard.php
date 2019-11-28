<?php 
$pagetitle = 'Dashboard';
session_start();
if(isset($_SESSION['Username'])){
    include 'init.php';
    ?>
        <h1 class='text-center'>DashBoard</h1>
        <div class='container dashboard-main text-center'>
            <div class='row'>
                <div class='col-md-3'>
                    <div class='stat stat1'>
                    <i class='fa fa-users user-icon'></i>
                    <div class='info'>
                        <p class='heading'>Total Members</p>
                        <span><a href='members.php'><?php echo countItem("UserName","users");  ?></a></span>
                    </div>
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class='stat stat2'>
                    <i class='fa fa-user-plus user-icon'></i>
                    <div class='info'>
                        <p class='heading'>Pending Members</p>
                            <span><a href='members.php?request=pending'><?php echo countItem("UserName","users","RegStatus=0");  ?></a></span>
                        </div>
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class='stat stat3'>
                    <i class='fa fa-tag user-icon'></i>
                    <div class='info'>
                        <p class='heading'>Total Items</p>
                            <span><a href='items.php'><?php echo countItem("Name","items");?></a></span>
                        </div>
                    </div>
                </div>
                <div class='col-md-3'>
                    <div class='stat stat4'>
                    <i class='fa fa-comments user-icon'></i>
                    <div class='info'>
                    <p class='heading'>Total Comments</p>
                        <span><a href='comments.php'><?php echo countItem("Comment","comments");?></a></span>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='container latest'>
            <div class='row'>
                <div class='col-sm-6'>
                    <div class='panel panel-default'>
                        <?php $latestRegiseredUsers = 4; ?> <!--Number of Lateset Users-->
                        <div class='panel-heading'>
                            <i class='fa fa-users'></i> Latest <?php echo $latestRegiseredUsers;?> Registered Users
                            <span class='toggle-info pull-right'>
                                <i class='dropdown-items fa fa-minus fa-lg'></i>
                            </span>
                        </div>
                        <div class='panel-body users-body'>
                            <ul class='list-unstyled latest-users'>
                                <?php    $lastitems = getLatest("*","users",'UserID',$latestRegiseredUsers); // Get Latest User
                                        $c = countItem('*','users');
                                        if($c>0){
                                            foreach($lastitems as $value){ // Last User Items
                                                echo "<li>";
                                                echo $value["UserName"];
                                                echo "<a href='Members.php?page=Edit&id=".$value['UserID']."'>";
                                                echo "<span class='btn btn-success pull-right'><i class='fa fa-edit'></i>Edit</span></a>";
                                                if($value["RegStatus"]==0){
                                                    echo "<a href='Members.php?page=Activate&id=".$value['UserID']."'<span class='btn btn-info pull-right'><i class='fa fa-check'></i>Activate</span></a></li>";
                                                }
                                            }
                                        } else {
                                            echo "<p><b>There is no Users</b></p>";
                                        }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class='col-sm-6'>
                    <div class='panel panel-default'>
                        <div class='panel-heading'>
                        <?php $latestRegiseredUsers = 4; ?> <!--Number of Lateset items-->
                        <span class='toggle-info pull-right'>
                                <i class='dropdown-items fa fa-minus fa-lg'></i>
                            </span>
                            <i class='fa fa-tag'></i> Latest <?php echo $latestRegiseredUsers; ?> Items
                        </div>
                        <div class='panel-body users-body'>
                            <ul class='list-unstyled latest-users'>
                                <?php    $lastitems = getLatest("*","items",'Item_ID',$latestRegiseredUsers); // Get Latest User
                                        $counter = countItem("*","Items");
                                        if($counter>0){
                                            foreach($lastitems as $value){ // Last User Items
                                                echo "<li>";
                                                echo $value["Name"];
                                                echo "<a href='Members.php?page=Edit&id=".$value['Item_ID']."'>";
                                                echo "<span class='btn btn-success pull-right'><i class='fa fa-edit'></i>Edit</span></a>";
                                                if($value["Approve_Status"]==0){
                                                    echo "<a href='Items.php?page=Approve&id=".$value['Item_ID']."'<span class='btn btn-info pull-right'><i class='fa fa-check'></i>Approve</span></a></li>";
                                                }
                                            }
                                        } else {
                                            echo "<p><b>There is no Items<b></p>";
                                        }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                
        </div>
        <!-- Start Latest Comments -->
        <div class='row'>
                <div class='col-sm-6'>
                    <div class='panel panel-default'>
                        <?php $latestRegiseredUsers = 4; ?> <!--Number of Lateset Comments-->
                        <div class='panel-heading'>
                            <i class='fa fa-comments'></i> Latest <?php echo $latestRegiseredUsers;?> Comments
                            <span class='toggle-info pull-right'>
                                <i class='dropdown-items fa fa-minus fa-lg'></i>
                            </span>
                        </div>
                        <div class='panel-body comment-body'>
                            <?php 
                                $stmt = $con->prepare("SELECT comments.*,users.UserName as Member_Name FROM comments
                                INNER JOIN users ON users.UserID = comments.user_ID ORDER BY C_ID DESC");
                                $stmt->execute();
                                $comments= $stmt->fetchAll();
                                $count = $stmt->rowCount();
                                if($count > 0){
                                    foreach($comments as $comment){
                                        echo "<div class='comment-box'>";
                                            echo "<div class='member_name'>";
                                                echo "<a href='Members.php?page=Edit&id=".$comment['user_ID']."'><span class='member-n'>".$comment['Member_Name']."</span></a>";
                                            echo "</div>";
                                            echo "<div class='member_Comment'>";
                                                echo "<p class='member-c'>".$comment['Comment']."</p>";
                                            echo "</div>";
                                        echo "</div>";
                                    }
                                } else {
                                    echo "<p><b>There is no Comments<b></p>";
                                }
                            ?>
                    </div>
                </div>
                <!-- End Latest Comments -->
                </div>
    <?php 
    
    include $tpl . "footer.php";
}
else {
    echo "You Are Not Authozried to See this Page";
    header('REFRESH: 5;Location:index.php');
    exit();
}