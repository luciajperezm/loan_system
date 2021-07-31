<?php

if($ajaxRequest){
    require_once "../models/productModel.php";
}else{
    require_once "./models/productModel.php";
}

class productController extends productModel
{
    /*--- ADD PRODUCT CONTROLLER ---*/
    public function add_product_controller()
    {
        $code = mainModel::clean_input($_POST['product_code_reg']);
        $name = mainModel::clean_input($_POST['product_name_reg']);
        $stock = mainModel::clean_input($_POST['product_stock_reg']);
        $status = mainModel::clean_input($_POST['product_status_reg']);
        $detail = mainModel::clean_input($_POST['product_detail_reg']);

        /*- Checking for empty fields -*/
        if($code == "" || $name == "" || $stock == "" || $status == ""){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Some input fields are empty",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- Checking for data integrity -*/
        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $code)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Code number is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}", $name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The (Product Name) input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if(mainModel::verify_input_data("[0-9]{1,9}", $stock)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The stock input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($detail != ""){
            if(mainModel::verify_input_data("[a-zA-Z0-9- ]{1,45}", $detail)){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "The Detail input is not valid",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if($status != "Available" && $status != "Unavailable"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Status input is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*- Is the product already registered? -*/
        $check_product = mainModel::execute_simple_queries("SELECT item_id FROM item WHERE item_codigo='$code'");
        if($check_product->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This Product is already registered",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $check_name = mainModel::execute_simple_queries("SELECT item_nombre FROM item WHERE item_nombre='$name'");
        if($check_name->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This Product is already registered",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        $data_product_reg = [
            "Code" => $code,
            "Name" => $name,
            "Stock" => $stock,
            "Status" => $status,
            "Detail" => $detail
        ];

        $add_product = productModel::add_product_model($data_product_reg);

        if($add_product->rowCount() == 1){
            $alert = [
                "Alert" => "clean",
                "Title" => "Great News",
                "Text" => "This product was successfully registered",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't register this product",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

    /*--- PAGINATION PRODUCT CONTROLLER ---*/
    public function pagination_product_controller($page, $n_results, $privilege, $url, $search)
    {
        $page = mainModel::clean_input($page);
        $n_results = mainModel::clean_input($n_results);
        $privilege = mainModel::clean_input($privilege);

        $url = mainModel::clean_input($url);
        $url = SERVER_URL.$url."/";

        $search = mainModel::clean_input($search);

        $table = "";

        $page = (isset($page) && $page > 0) ? (int) $page : 1;
        $init = ($page > 0) ? (($page * $n_results) - $n_results) : 0;

        if(isset($search) && $search != ""){
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM item WHERE item_nombre LIKE '%$search%' OR item_codigo LIKE '%$search%'  ORDER BY item_nombre ASC LIMIT $init, $n_results";
        }else{
            $query = "SELECT SQL_CALC_FOUND_ROWS * FROM item ORDER BY item_nombre ASC LIMIT $init, $n_results";
        }

        $connection = mainModel::connect();

        $data = $connection->query($query);
        $data = $data->fetchAll();

        /* NUmber of registered data */
        $total = $connection->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();

        $N_pages = ceil($total / $n_results);

        $table.='<table class="table table-sm">
        <thead>
        <tr class="t-row">
            <th>#</th>
            <th class="text-center">Code</th>
        <th class="text-center">Name</th>
        <th class="text-center">Stock</th>
        <th class="text-center">detail</th>
        <th class="text-center">Status</th>';

        if($privilege == 1 || $privilege == 2){
            $table.='<th class="text-center ">Update</th>';
        }
        if($privilege == 1){
            $table.='<th class="text-center ">Delete</th>';
        }

        $table.=' </tr></thead><tbody class="table__body">';

        if($total >= 1 && $page <= $N_pages){
            $counter = $init + 1;
            $reg_init = $init + 1;
            foreach($data as $rows) {
                $table.='<tr>
        <td class="text-center ">'.$counter.'</td>
        <td class="text-center ">'.$rows['item_codigo'].'</td>
        <td class="text-center ">'.$rows['item_nombre'].'</td>
        <td class="text-center ">'.$rows['item_stock'].'</td>
        <td class="text-center ">
            <button type="button" class="btn btn-info" data-toggle="popover" data-trigger="hover" title="'.$rows['item_nombre']
                    .'" data-content="'.$rows['item_detalle'].'">
                <i class="fas fa-info-circle"></i>
            </button>
        </td>';
                if($rows['item_estado'] == "Available"){ $table.='<td class="text-center "><span class="badge badge-primary">'
                    .$rows['item_estado'].'</span></td>';}else { $table.='<td class="text-center "><span class="badge badge-danger">'.$rows['item_estado'].'</span></td>';}

                if($privilege == 1 || $privilege == 2){
                    $table.='<td class="text-center ">
            <a href="'.SERVER_URL.'product-update/'.mainModel::encryption($rows['item_id']).'/" class="btn 
btn-success">
                <i class="fas fa-sync-alt"></i>
            </a>
        </td>';
                }

                if($privilege == 1){
                    $table.='<td class="text-center ">
            <form class="Ajax_Form form-table" action="'.SERVER_URL.'ajax/productAjax.php" method="post" data-form="delete"
autocomplete="off"> 
<input type="hidden" name="product_id_del" value="'.mainModel::encryption($rows['item_id']).'">
                <button type="submit" class="btn btn-warning">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>
        </td>';
                }

                $table.='</tr>';
                $counter++;
            }
            $reg_final = $counter - 1;
        }else {
            if($total >= 1){
                $table.='<tr><td colspan="9" class="text-center"><a href="'.$url.'" class="btn btn-raised btn-success btn-sm">CLick here to reload list</a></td></tr>';
            }else {
                $table.='<tr><td colspan="9" class="text-center">There are no products registered in the system</td></tr>';
            }
        }
        $table.='</tbody></table>';

        if($total >= 1 && $page <= $N_pages){
            $table.='<p class="text-right">'.$total.' product(s)</p>';
            $table.=mainModel::pagination($page, $N_pages, $url, 7);
        }

        return $table;
    }

    /*--- DELETE PRODUCT CONTROLLER ---*/
    public function delete_product_controller(){

        /*Receiving id from product*/
        $id = mainModel::decryption($_POST['product_id_del']);
        $id = mainModel::clean_input($id);

        /*testing product in data base*/
        $check_product_db = mainModel::execute_simple_queries("SELECT item_id FROM item WHERE item_id = '$id'");
        if($check_product_db->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "This product doesn't exist",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*checking if a loan was made with the selected product*/
        $check_product_loan = mainModel::execute_simple_queries("SELECT item_id FROM detalle WHERE item_id = '$id' LIMIT 1");
        if($check_product_loan->rowCount() > 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "A transaction was made with this product and cannot be delete, you may change its status to Unavailable",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }


        /*checking user privilege*/
        session_start(['name' => 'LOAN']);
        if($_SESSION['privilege_loan'] != 1){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "You are not allowed to do this",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        /*deleting product*/
        $delete_product = productModel::delete_product_model($id);
        if($delete_product->rowCount() == 1){
            $alert = [
                "Alert" => "reload",
                "Title" => "Product deleted",
                "Text" => "The product was successfully deleted",
                "Type" => "success"
            ];
        }else {
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't delete this product",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);
    }

    /*--- DATA PRODUCT CONTROLLER ---*/
    public function data_product_controller($type, $id){
        //getting variables ready
        $type = mainModel::clean_input($type);
        $id = mainModel::decryption($id);
        $id = mainModel::clean_input($id);

        return productModel::data_product_model($type, $id);
    }

    /*--- UPDATE PRODUCT CONTROLLER ---*/
    public function update_product_controller()
    {
        //receive id
        $id = mainModel::decryption($_POST['product_id_up']);
        $id = mainModel::clean_input($id);

        //make sure product exists in bd
        $check_product = mainModel::execute_simple_queries("SELECT * FROM item WHERE item_id='$id'");
        if($check_product->rowCount() <= 0){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't find this product",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }else {
            $fields = $check_product->fetch();
        }

        $code = mainModel::clean_input($_POST['product_code_up']);
        $name = mainModel::clean_input($_POST['product_name_up']);
        $stock = mainModel::clean_input($_POST['product_stock_up']);
        $status = mainModel::clean_input($_POST['product_status_up']);
        $detail = mainModel::clean_input($_POST['product_detail_up']);


        if(isset($_POST['product_status_up'])){
            $status = mainModel::clean_input($_POST['product_status_up']);
        }else {
            $status = $fields['product_status'];
        }

        /*- Checking for empty fields -*/
        if($code == "" || $name == "" || $stock == "" || $status == ""){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "Some input fields are empty",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        //product code input
        if(mainModel::verify_input_data("[a-zA-Z0-9-]{1,45}", $code)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The code is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        //product name input
        if(mainModel::verify_input_data("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}", $name)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Name is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        //product stock input
        if(mainModel::verify_input_data("[0-9]{1,9}", $stock)){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Code is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        if($detail != ""){
            if(mainModel::verify_input_data("[a-zA-záéíóúÁÉÍÓÚñÑ0-9 ]{1,140}", $detail)){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "The Detail message is not valid",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        if($status != "Available" && $status != "Unavailable"){
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "The Status is not valid",
                "Type" => "error"
            ];
            echo json_encode($alert);
            exit();
        }

        //checking if code is already in the system
        if($code != $fields['item_codigo']){
            $check_code = mainModel::execute_simple_queries("SELECT item_codigo FROM item WHERE item_codigo='$code'");
            if($check_code->rowCount()>0){
                $alert = [
                    "Alert" => "simple",
                    "Title" => "Something went wrong",
                    "Text" => "This Code is already registered",
                    "Type" => "error"
                ];
                echo json_encode($alert);
                exit();
            }
        }

        /* Preparing data to send it to model */
        $data_product_up = [
            "Code" => $code,
            "Name" => $name,
            "Stock" => $stock,
            "Status" => $status,
            "Detail" => $detail,
            "ID" => $id
        ];
        if(productModel::update_product_model($data_product_up)){
            $alert = [
                "Alert" => "reload",
                "Title" => "Done!",
                "Text" => "This product was successfully updated",
                "Type" => "success"
            ];
        }else{
            $alert = [
                "Alert" => "simple",
                "Title" => "Something went wrong",
                "Text" => "We couldn't update this product",
                "Type" => "error"
            ];
        }
        echo json_encode($alert);

    }

}