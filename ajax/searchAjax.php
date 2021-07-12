<?php
    session_start(['name' => 'LOAN']);
    require_once "../config/APP.php";
    
    if(isset($_POST['search_init']) || isset($_POST['delete_search']) || isset($_POST['search_init_loan']) || isset($_POST['search_final_loan'])){
        $data_url = [
            "user"=>"user-search",
            "customer"=>"customer-search",
            "product"=>"product-search",
            "loan"=>"reservation-search"
        ];



        if(isset($_POST['module'])){
            $module = $_POST['module'];
            if(!isset($data_url[$module])){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "We couldn't search this data",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't search this data",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($module == "loan"){
            $date_init = "date_init".$module;
            $date_final = "date_final".$module;

            /* initialize search */
            if(isset($_POST['search_init_loan']) || isset($_POST['search_final_loan'])){

                if($_POST['search_init_loan'] == "" || $_POST['search_final_loan'] == ""){
                    $alert = [
                        "Alert" => "simple",
                        "Title" => "Something went wrong",
                        "Text" => "Some input fields are empty",
                        "Type" => "error"
                    ];
                    echo json_encode($alert);
                    exit();
                }

                $_SESSION[$date_init] = $_POST['search_init_loan'];
                $_SESSION[$date_final] = $_POST['search_final_loan'];
            }

            if(isset($_POST['delete_search'])){
                unset($_SESSION[$date_init]);
                unset($_SESSION[$date_final]);
            }

        }else {
            $name_var = "search_".$module;

            //initialize search
            if(isset($_POST['search_init'])){
                if($_POST['search_init'] == ""){
                    $alert = [
                        "Alert" => "simple",
                        "Title" => "Something went wrong",
                        "Text" => "The search input field is empty",
                        "Type" => "error"
                    ];
                    echo json_encode($alert);
                    exit();
                }
                $_SESSION[$name_var] = $_POST['search_init'];
            }

            //delete search
            if(isset($_POST['delete_search'])){
               unset($_SESSION[$name_var]);
            }
        }

        $url = $data_url[$module];
        // redirect user
        $alert = [
            "Alert"=>"redirect",
            "URL"=> SERVER_URL.$url."/"
        ];
        echo json_encode($alert);

    }else{
        session_unset();
        session_destroy();
        header("Location: ".SERVER_URL."login/");
        exit();
    }