<h2>Loans</h2>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad dolore doloremque error explicabo fuga in ipsa
    labore laborum libero minima molestiae</p>
<div class="buttons">
    <button
        class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>reservation-new/">New Loan</a></button>
    <button class="btn btn__cta"><i class="fas fa-calendar ic"></i><a href="<?php echo SERVER_URL;?>reservation-reservation/">Reservations</a></button>
    <button class="btn btn__cta"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>reservation-list/">Payed Loans</a></button>
    <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>reservation-search/">Search Loans</a></button>
</div>
<?php require_once "./controllers/loanController.php";
$ins_loan = new loanController();
echo $ins_loan->pagination_loan_controller($page[1], 15, $_SESSION['privilege_loan'], $page[0], "Loan", "", "");