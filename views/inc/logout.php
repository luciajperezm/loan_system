<script>






    let btn_logout = document.querySelector(".btn-exit-system");
    btn_logout.addEventListener('click', function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to exit the system",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#333',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, exit!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.value) {
                let url = '<?php echo SERVER_URL; ?>ajax/loginAjax.php';
                let token = '<?php echo $ins_logout->encryption($_SESSION['token_loan']); ?>'
                let username = '<?php echo $ins_logout->encryption($_SESSION['username_loan']); ?>'

                let data = new FormData();

                data.append("token", token);
                data.append("username", username);

                fetch(url, {
                    method : 'POST',
                    body: data
                })
                    .then(answer => answer.json())
                    .then(answer => {
                        return ajax_alerts(answer);
                });
            }
        });
    })
</script>
