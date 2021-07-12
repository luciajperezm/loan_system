<?php

    /*--- The entire application gets executed in this file ---*/
    require_once "./config/APP.php";
    require_once "./controllers/viewsController.php";

    /*--- getting the template ---*/
    $template = new viewsController();
    $template->get_template_controller();