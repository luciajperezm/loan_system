<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Lorem Ipsum</h3>
    </div>
    <div class="user__profile">
        <div class="side1">
            <i class="fas fa-user-circle fa-3x"></i>
        </div>
        <div class="side2">
            <span class="user__profile-name"><?php echo $_SESSION['name_loan']." ".$_SESSION['last_name_loan'];?></span><br>
            <span class="user__profile-job"><?php echo $_SESSION['username_loan']; ?></span>
        </div>
    </div>
    <ul class="list-unstyled components">
        <li>
            <a href="<?php echo SERVER_URL;?>home/"><i class="fas fa-home icon"></i>Dashboard</a>
        </li>
       <li>
            <a href="#productSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-boxes icon"></i>Products</a>
            <ul class="collapse list-unstyled" id="productSubmenu">
                <li>
                    <a href="<?php echo SERVER_URL;?>product-new/"><i class="fas fa-plus icon"></i>New Product</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>product-list/"><i class="fas fa-list icon"></i>List of Products</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>product-search/"><i class="fas fa-search icon"></i>Search
                      Product</a>
                </li>
            </ul>
       </li>
       <li>
            <a href="#customerSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-user-friends icon"></i>Customers</a>
            <ul class="collapse list-unstyled" id="customerSubmenu">
                <li>
                    <a href="<?php echo SERVER_URL;?>customer-new/"><i class="fas fa-plus icon"></i>New Customer</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>customer-list/"><i class="fas fa-list icon"></i>List of
                      Customers</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>customer-search/"><i class="fas fa-search icon"></i>Search
                      Customer</a>
                </li>
            </ul>
       </li>
       <li>
            <a href="#reservation_submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i
                    class="fas
            fa-hand-holding-usd icon"></i>Loans</a>
            <ul class="collapse list-unstyled" id="reservation_submenu">
                <li>
                    <a href="<?php echo SERVER_URL;?>reservation-new/"><i class="fas fa-plus icon"></i>New Loan</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>reservation-reservation/"><i class="fas fa-calendar
                    icon"></i>Reservations</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>reservation-pending/"><i class="fas fa-business-time
                    icon"></i>Loans</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>reservation-list/"><i class="fas fa-list icon"></i>Finished</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>reservation-search/"><i class="fas fa-search icon"></i>Search
                      loan by date</a>
                </li>
            </ul>
        </li>
       <?php if($_SESSION['privilege_loan'] == 1){ ?>
       <li>
            <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fas fa-id-card-alt icon"></i>Users</a>
            <ul class="collapse list-unstyled" id="userSubmenu">
                <li>
                    <a href="<?php echo SERVER_URL;?>user-new/"><i class="fas fa-plus icon"></i>New User</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>user-list/"><i class="fas fa-list icon"></i>List of Users</a>
                </li>
                <li>
                    <a href="<?php echo SERVER_URL;?>user-search/"><i class="fas fa-search icon"></i>Search User</a>
                </li>
            </ul>
       </li>
        <?php } ?>
        <li>
            <a href="<?php echo SERVER_URL;?>company/"><i class="fas fa-store icon"></i>Company</a>
        </li>
    </ul>
</nav>