<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-dark btn-tog">
            <i class="fas fa-bars" style="font-size: 16px;"></i>
        </button>
        <div>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item nav__icon">
                    <a class="nav-link " href="<?php echo SERVER_URL."user-update/".$ins_logout->encryption
                        ($_SESSION['id_loan'])."/";?>"><i
                          class="fas fa-user-cog icon
"></i>Update User</a>
                </li>
                <li class="nav-item nav__icon">
                    <a class="nav-link btn-exit-system" href="javascript:void(0)"><i class="fas fa-power-off icon
"></i>Sign
                      Out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
