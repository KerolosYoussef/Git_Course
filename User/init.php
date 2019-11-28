<?php
   // Connection to Database
   include "../Admin/Connect.php";
   // Routes 
   $libraries  = "Includes/libraries"; // Libraries Directory
   $tpl        = "Includes/templates/"; // Templates Directory
   $langs      = "Includes/languages/"; // Languages Directory
   $css        = "Design/CSS/"; // Css Directory
   $js         = "Design/JS/"; // Js Directory
   $function   = "Includes/functions/"; // Functions Directory
   // Including the important files 
   include $function . 'function.php';
   include $langs."English.php";
   include $tpl . "header.php";
   include $tpl . "navbar.php";