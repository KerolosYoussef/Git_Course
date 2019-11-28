<?php 
    /*
        Categories => [Manege, Edit, Update, Add, Insert, Delete, Stats ]
    */
    $page = '';
    if(isset($_GET['page']))
    {
        $page = $_GET['page'];
    } else {
        $page = 'Manage';
    }
    //if the page in the main page 
    if($page == 'Manage'){
        echo 'Welcome to Manage Page';
    }
    elseif($page == 'Edit'){
        echo 'Welcome to Edit Page';
    }
    elseif($page == 'Update'){
        echo 'Welcome to Update Page';
    }
    elseif($page == 'Add'){
        echo 'Welcome to ADD Page';
    }
    elseif($page == 'Inser'){
        echo 'Welcome to Insert Page';
    }
    elseif($page == 'Delete'){
        echo 'Welcome to Delete Page';
    }
    elseif($page == 'Stats'){
        echo 'Welcome to Stats Page';
    }
    else {
        echo 'Error , This page isn\'nt exsit';
    }
