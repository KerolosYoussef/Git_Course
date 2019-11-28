<?php 
    function language($string){
        $langs = array(
            "Admin-Home"        => "الرئيسية",
            "Admin-Categories"  => 'الفئات',
            "Admin-EditProfile" => 'تعديل الملف الشخصي',
            "Admin-Settings"    => 'الاعدادات',
            "Admin-Logout"      => 'تسجيل الخروج'
        );
        return $langs[$string];
    }