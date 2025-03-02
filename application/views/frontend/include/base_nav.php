<nav class="navbar navbar-expand-lg navbar-light bg-primary text text-white">
    <div class="container">
        <a class="navbar-brand text-white"   href="<?php echo base_url() ?>">
            <h3><i  style="color: white;"class="fas fa-bus"></i> <b style="color: white;">Next Fleet Dynamics</b></h3>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url() ?>"><i class="fas fa-home"></i>&nbsp;Home</a>
                </li>
                
                <?php if ($this->session->userdata('username')) { ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi, <?php echo $this->session->userdata('nama_lengkap'); ?>
                        </a>    
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="<?php echo base_url() ?>profile/profilesaya/<?php echo $this->session->userdata('kd_pelanggan') ?>">
                                <i class="fas fa-id-card"></i> My Profile
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url() ?>profile/tiketsaya/<?php echo $this->session->userdata('kd_pelanggan') ?>">
                                <i class="fas fa-ticket-alt"></i> My Ticket
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url() ?>login/logout">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </li>
                <?php } else { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() ?>login/Daftar">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url() ?>login">Login</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>