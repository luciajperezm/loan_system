const ajax_form = document.querySelectorAll(".Ajax_Form");

function send_ajax_form(e){
    e.preventDefault();

    let data = new FormData(this);
    let method = this.getAttribute("method");
    let action = this.getAttribute("action");
    let type = this.getAttribute("data-form");

    let header = new Headers();

    let config = {
        method: method,
        headers: header,
        mode: 'cors',
        cache: 'no-cache',
        body: data
    }

    let alert_text;

    if(type==="save"){
        alert_text="This Data will be stored in the system";
    }else if(type==="delete"){
        alert_text="This Data will be deleted from the system";
    }else if(type==="update"){
        alert_text="This Data will be updated in the system";
    }else if(type==="search"){
        alert_text="This Term will be deleted and you will have to write it again";
    }else if(type==="loans"){
        alert_text="This Data will be deleted from the Loan or Reservation";
    }else{
        alert_text="The request is being processed";
    }

    Swal.fire({
        title: 'Are you sure?',
        text: alert_text,
        type: 'question',
        showCancelButton: true,
        confirmButtonColor: '#333',
        cancelButtonColor: '#d33',
        confirmButtonText: 'I\'m Sure',
    }).then((result) => {
        if(result.value){
            fetch(action,config)
                .then(answer => answer.json())
                .then(answer => {
                    return ajax_alerts(answer);
                });
        }
    });
}

ajax_form.forEach(forms => {
    forms.addEventListener("submit", send_ajax_form);
});

function ajax_alerts(alert){
    if(alert.Alert==="simple"){
        Swal.fire({
            title: alert.Title,
            text: alert.Text,
            type: alert.Type,
            confirmButtonColor: '#333',
            cancelButtonColor: '#d33',
        });
    }else if(alert.Alert==="reload"){
        Swal.fire({
            title: alert.Title,
            text: alert.Text,
            type: alert.Type,
            confirmButtonColor: '#333',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if(result.value){
                location.reload();
            }
        });
    }else if(alert.Alert==="clean"){
        Swal.fire({
            title: alert.Title,
            text: alert.Text,
            type: alert.Type,
            confirmButtonColor: '#333',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if(result.value){
                document.querySelector(".Ajax_Form").reset();
            }
        });
    }else if(alert.Alert==="redirect"){
        window.location.href=alert.URL;
    }
}