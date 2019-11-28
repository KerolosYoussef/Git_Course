<?php 
    function language($string){
        $langs = array(
            // navbar Links
            "Admin-Home"        => "Home",
            "Admin-Categories"  => "Categories",
            "Admin-Items"       => "Items",
            "Admin-Members"     => "Members",
            "Admin-Comments"     => "Comments",
            "Admin-Statistics"  => "Statistics",
            "Admin-Logs"        => "Logs",
            'Admin-EditProfile' => 'Edit Profile',
            "Admin-Settings"    => 'Settings',
            "Admin-Logout"      => 'Log Out'
        );
        return $langs[$string];
    }