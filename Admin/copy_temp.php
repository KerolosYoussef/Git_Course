<?php 
/* 
=============================================================
== 
== 
=============================================================
*/
    ob_start();
    $pagetitle='';
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
        }
        else if($page == 'Add'){ // Add Page
        }
        else if($page == 'Insert'){ // Insert Page
        }
        elseif($page == 'Edit'){// Edit Page
        }
        elseif($page == 'Update'){ // Update Page
        }
        elseif($page == 'Delete')  {// Delete Page
        }
        elseif($page == 'Activate'){ // Activate Page
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