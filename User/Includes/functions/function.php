<?php
/*
    ** Get Categories Function v2.0
    ** Function to get Categories from database
*/
function getCat(){
    global $con;
    $getcat = $con->prepare("SELECT * FROM categories ORDER BY ID ASC");
    $getcat->execute();
    $cat = $getcat->fetchAll();
    return $cat;
}
/*
    ** Get Categories Function v2.0
    ** Function to get Categories from database
*/
function getItems($id){
    global $con;
    $getitem = $con->prepare("SELECT * FROM items WHERE Cat_ID=? AND Approve_Status=1 ORDER BY Item_ID DESC ");
    $getitem->execute(array($id));
    $item = $getitem->fetchAll();
    return $item;
}

// Redirect Function v1.0
// Title Function that echo the title in the page in case the page has $pagetitle variable 
// and echo default title in other pages
    function getTitle(){
        global $pagetitle;
        if(isset($pagetitle))
        {
            echo $pagetitle;
        }
        else {
            echo 'Default';
        }
    }

/* Function To Redirect Into Index Page v2.0 [This Function has parameters]
    ** $seconds = The number of seconds that the page will start to redirect 
    ** $msg = The MSG That Will show while redirecting
    ** $msgclass = The Message Class [danger , success , info]
    ** $url = The url of redirection
*/
    function redirectToIndex($seconds=3,$Msg,$msgclass='info',$url=null){
        if($url == null){
            $url = 'index.php';
        }
        elseif($url == 'back') {
            if(empty($_SERVER['HTTP_REFER'])){
                $url = $_SERVER['HTTP_REFERER'];
            } else {
                $url = 'index.php';
            }
        }
            echo "<div class='alert alert-$msgclass'>";
            echo "<p class='danger'>".$Msg . "<br> You Will Be Redirected To The Previous Page"."</p>";
            echo "</div>";
            header("Refresh:$seconds;$url");
            exit();
    }
/*
    ** Function To Check the item is exist in Database or not v1.0
    ** This Function Accept Parameters
    ** $select = The item that function will check in database [$user , $item, $category]
    ** $table = The Table That The function will check into [users , items  ]
    ** $value  = The value of the select in the table  
*/
    function checkItems($select, $table , $value){
        global $con;
        $check=$con->prepare("SELECT $select FROM $table WHERE $select =?");
        $check->execute(array($value));
        $count=$check->rowCount();
        return $count;
    }

/*
    ** Count Items Function v2.0
    ** Function To Count the items table with database [Function Accept Parameters]
    ** $table = The Table that i will get info from [users,items,category]
    ** $items = The Item that i will count [Members , Items, etc ]
    ** $where = Add Condition to database
*/
function countItem($items,$table,$where = 1){
    global $con;
    $counter=$con->prepare("SELECT COUNT($items) FROM $table WHERE $where");
    $counter->execute();
    return $counter->fetchColumn();
}

/*
    ** Get Latest Record Function v2.0
    ** Function to get Last n items from database
    ** $item = The Item That u will choose from database
    ** $table = The Table u will choose from
    ** $order = The Order of the latest item
    ** $where = Condition(optional)
*/
    function getLatest($item,$table,$order,$limit=5,$where=1){
        global $con;
        $getstmt = $con->prepare("SELECT $item FROM $table WHERE $where ORDER BY $order DESC LIMIT $limit ");
        $getstmt->execute();
        $rows = $getstmt->fetchAll();
        return $rows;
    }
?>