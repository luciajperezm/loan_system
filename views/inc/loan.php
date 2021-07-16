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
</script>