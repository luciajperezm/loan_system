<?php

class viewsModel {

    /*--- GET VIEWS MODEL ---*/
    protected static function get_views_model($views)
    {
        $whiteList = ["home", "company", "customer-list", "customer-new", "customer-search", "customer-update", "product-list", "product-new", "product-search", "product-update", "reservation-list", "reservation-pending", "reservation-new", "reservation-reservation", "reservation-search", "reservation-update", "user-list", "user-new", "user-search", "user-update"];
        if(in_array($views, $whiteList)){
            if(is_file("./views/content/".$views."-view.php")){
                $content = "./views/content/".$views."-view.php";
            }else{
                $content = "404";
            }
        }elseif ($views == "login" || $views == "index"){
            $content = "login";
        }else {
            $content = "404";
        }
        return $content;
    }

}
