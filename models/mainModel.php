<?php

/*--- THIS MODEL CONTAINS REUSABLE FUNCTIONS ---*/

if($ajaxRequest){
    require_once "../config/SERVER.php";
}else{
    require_once "./config/SERVER.php";
}

class mainModel {

    /*--- CONNECTION TO DATA BASE ---*/
    protected static function connect()
    {
        $connection = new PDO(DBM, USER, PASS);
        $connection->exec("SET CHARACTER UTF-8");
        return $connection;
    }

    /*--- EXECUTE SIMPLE QUERIES ---*/
    protected static function execute_simple_queries($query)
    {
        $sql = self::connect()->prepare($query);
        $sql->execute();
        return $sql;
    }

    /*--- ENCRYPTION ---*/
    public function encryption($string)
    {
        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    /*--- DECRYPTION ---*/
    protected static function decryption($string)
    {
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    /*--- GENERATE RANDOM CODES (L875-1) ---*/
    protected static function generate_random_code($letter, $length, $number)
    {
        for( $i = 1; $i <= $length; $i++){
            $random = rand(0,9);
            $letter.=$random;
        }
        return $letter."-".$number;
    }

    /*--- CLEAN INPUT FORMS TO AVOID SQL INJECTION ---*/
    protected static function clean_input($input)
    {
        $input=trim($input);
        $input=stripslashes($input);
        $input=str_ireplace("<script>", "", $input);
        $input=str_ireplace("</script>", "", $input);
        $input=str_ireplace("<script src", "", $input);
        $input=str_ireplace("<script type=", "", $input);
        $input=str_ireplace("SELECT * FROM", "", $input);
        $input=str_ireplace("DELETE FROM", "", $input);
        $input=str_ireplace("INSERT INTO", "", $input);
        $input=str_ireplace("DROP TABLE", "", $input);
        $input=str_ireplace("DROP DATABASE", "", $input);
        $input=str_ireplace("TRUNCATE TABLE", "", $input);
        $input=str_ireplace("SHOW TABLES", "", $input);
        $input=str_ireplace("SHOW DATABASES", "", $input);
        $input=str_ireplace("<?php", "", $input);
        $input=str_ireplace("?>", "", $input);
        $input=str_ireplace("--", "", $input);
        $input=str_ireplace(">", "", $input);
        $input=str_ireplace("<", "", $input);
        $input=str_ireplace("[", "", $input);
        $input=str_ireplace("]", "", $input);
        $input=str_ireplace("^", "", $input);
        $input=str_ireplace("==", "", $input);
        $input=str_ireplace(";", "", $input);
        $input=str_ireplace("::", "", $input);
        $input=stripslashes($input);
        $input=trim($input);
        return $input;
    }

    /*--- VERIFY INPUT DATA ---*/
    protected static function verify_input_data($filter, $input)
    {
        if(preg_match("/^".$filter."$/", $input)){
            return false;
        }else{
            return true;
        }
    }

    /*--- VERIFY INPUT DATES ---*/
    protected static function verify_input_dates($date)
    {
        $value=explode('-', $date);
        if(count($value)==3 && checkdate($value[1],$value[2],$value[0])){
            return false;
        }else{
            return true;
        }
    }
    
    /*--- PAGINATION WITH BOOTSTRAP BUTTONS ---*/
    protected static function pagination($page,$N_pages,$url,$buttons)
    {
        $table='<nav aria-label="Page navigation example"><ul class="pagination justify-content-center">';

        if($page == 1){
            $table.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-left"></i></a></li>';
        }else{
            $table.='
				<li class="page-item"><a class="page-link" href="'.$url.'1/"><i class="fas fa-angle-double-left"></i></a></li>
				<li class="page-item"><a class="page-link" href="'.$url.($page-1).'/">Previous</a></li>
				';
        }

        $ci = 0;
        for($i = $page; $i <= $N_pages; $i++){
            if($ci >= $buttons){
                break;
            }
            if($page == $i){
                $table.='<li class="page-item"><a class="page-link active" href="'.$url.$i.'/">'.$i.'</a></li>';
            }else{
                $table.='<li class="page-item"><a class="page-link" href="'.$url.$i.'/">'.$i.'</a></li>';
            }
            $ci++;
        }

        if($page == $N_pages){
            $table.='<li class="page-item disabled"><a class="page-link"><i class="fas fa-angle-double-right"></i></a></li>';
        }else{
            $table.='
				<li class="page-item"><a class="page-link" href="'.$url.($page+1).'/">Next</a></li>
				<li class="page-item"><a class="page-link" href="'.$url.$N_pages.'/"><i class="fas fa-angle-double-right"></i></a></li>
				';
        }

        $table.='</ul></nav>';
        return $table;
    }

}
