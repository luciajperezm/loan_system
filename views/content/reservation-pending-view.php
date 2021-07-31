<h2>Active Leases</h2>
<p>Here you can find the leases registered in the company. Be careful when updating or deleting this information</p>
<div class="buttons">
  <button class="btn btn__cta"><i class="fas fa-plus ic"></i><a href="<?php echo SERVER_URL;?>reservation-new/">New Lease</a></button>
  <button class="btn btn__cta"><i class="fas fa-business-time ic"></i><a href="<?php echo SERVER_URL;?>reservation-pending/">Active Leases</a></button>
  <button class="btn btn__cta"><i class="fas fa-calendar ic"></i><a href="<?php echo SERVER_URL;?>reservation-reservation/">Reservations</a></button>
  <button class="btn btn__cta"><i class="fas fa-search ic"></i><a href="<?php echo SERVER_URL;?>reservation-search/">Search Lease</a></button>
  <button class="btn btn__cta active"><i class="fas fa-list ic"></i><a href="<?php echo SERVER_URL;?>reservation-list/">Payed Leases</a></button>
</div>
<?php require_once "./controllers/loanController.php";
$ins_loan = new loanController();
echo $ins_loan->pagination_loan_controller($page[1], 15, $_SESSION['privilege_loan'], $page[0], "Loan", "", "");