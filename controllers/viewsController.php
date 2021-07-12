<?php

    require_once "./models/viewsModel.php";
    
    class viewsController extends viewsModel{
        
        /*--- GET TEMPLATE CONTROLLER ---*/
        public function get_template_controller()
        {
            return require_once "./views/template.php";
        }

        /*--- GET VIEWS CONTROLLER ---*/
        public function get_views_controller()
        {
            if(isset($_GET['views'])){
                $route = explode("/", $_GET['views']);
                $answer = viewsModel::get_views_model($route[0]);
            }else{
                $answer = "login";
            }
            return $answer;
        }

    }