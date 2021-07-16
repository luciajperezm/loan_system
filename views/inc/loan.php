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



}//84
</script>