<script>
function  search_customer(){
    let input_customer = document.querySelector('#input_customer').value;

    input_customer = input_customer.trim();

    if(input_customer != ""){
        let data = new FormData();
        data.append("search_customer", input_customer);
        fetch("<?php echo SERVER_URL; ?>ajax/loanAjax.php",{
            method: 'POST',
            body: data
        })
            .then(answer => answer.text())
            .then(answer => {
                let table_customers = document.querySelector('#table_customers');
                table_customers.innerHTML = answer;
            });
    }else {
        Swal.fire({
            title: 'Something went wrong!',
            text: 'You have to introduce the DNI, Name or Last name of the customer',
            type: 'error',
            confirmButtonColor: '#333',
            cancelButtonColor: '#d33',
        });
    }
}

function add_customer(id){
    $('#ModalCustomer').modal('hide');
    Swal.fire({
        title: 'Are you sure?',
        text: 'This customer will be added to the transaction',
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#333',
        cancelButtonColor: '#d33',
        confirmButtonText: 'I\'m Sure',
    }).then((result) => {
        if(result.value){
            let data = new FormData();
            data.append("id_add_customer", id);
            fetch("<?php echo SERVER_URL; ?>ajax/loanAjax.php",{
                method: 'POST',
                body: data
            })
                .then(answer => answer.json())
                .then(answer => {
                    return ajax_alerts(answer);
                });
        }else {
            $('#ModalCustomer').modal('show');
        }
    });
}

function search_product(){
    let input_product = document.querySelector('#input_item').value;

    input_product = input_product.trim();

    if(input_product != ""){
        let data = new FormData();
        data.append("search_product", input_product);

        fetch("<?php echo SERVER_URL; ?>ajax/loanAjax.php",{
            method: 'POST',
            body: data
        })
            .then(answer => answer.text())
            .then(answer => {
                let table_products = document.querySelector('#tabla_items');
                table_products.innerHTML = answer;
            });
    }else {
        Swal.fire({
            title: 'Something went wrong!',
            text: 'You have to introduce the Code or Name of the product',
            type: 'error',
            confirmButtonColor: '#333',
            cancelButtonColor: '#d33',
        });
    }
}

function modal_add_products(id){
    $('#ModalItem').modal('hide');
    $('#ModalAddProduct').modal('show');
    document.querySelector('#id_add_product').setAttribute("value", id);
}

function modal_search_product(){
    $('#ModalAddProduct').modal('hide');
    $('#ModalItem').modal('show');
}
</script>