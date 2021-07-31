<header class="hero">
    <h2 class="welcome">Welcome <?php echo $_SESSION['name_loan'];?>!</h2><br><br><br><br><br>
    <div class="hero-footer">
        <div class="date">Today is <?php echo date("m-d-Y") ?></div>
    </div>
</header><br><br>
<div class="home-cont">
    <div class="full-box tile-container">
        <?php
        require_once "./controllers/customerController.php";
        $ins_customer = new customerController();
        $reg_customers = $ins_customer->data_customer_controller("Count",0)
        ?>
        <a href="<?php echo SERVER_URL; ?>customer-new/" class="tile">
            <div class="tile-tittle">Customers</div>
            <div class="tile-icon">
              <i class="fas fa-users fa-fw"></i>
              <p><?php echo $reg_customers->rowCount();?> Registered</p>
            </div>
        </a>
        <?php
        require_once "./controllers/loanController.php";
        $ins_loan = new loanController();
        $reg_loans = $ins_loan->data_loan_controller("Count_Loan",0);
        $reg_reservation = $ins_loan->data_loan_controller("Count_Reservation",0);
        $reg_finished = $ins_loan->data_loan_controller("Count_Finished",0);
        ?>
        <a href="<?php echo SERVER_URL; ?>reservation-reservation/" class="tile">
            <div class="tile-tittle">Reservations</div>
            <div class="tile-icon">
                <i class="far fa-calendar-alt fa-fw"></i>
                <p><?php echo $reg_reservation->rowCount();?> Registered</p>
            </div>
        </a>
        <a href="<?php echo SERVER_URL; ?>reservation-pending/" class="tile">
            <div class="tile-tittle">Active Leases</div>
            <div class="tile-icon">
                <i class="fas fa-hand-holding-usd fa-fw"></i>
                <p><?php echo $reg_loans->rowCount();?> Registered</p>
            </div>
        </a>
        <a href="<?php echo SERVER_URL; ?>reservation-list/" class="tile">
            <div class="tile-tittle">Payed Leases</div>
            <div class="tile-icon">
                <i class="fas fa-clipboard-list fa-fw"></i>
                <p><?php echo $reg_finished->rowCount();?> Registered</p>
            </div>
        </a>
    </div>
</div>
