   <!-- Navbar -->
   <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
       <div class="container">
           <a href="dashboard.php" class="navbar-brand">
               <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
               <span class="brand-text font-weight-light">Antrian</span>
           </a>

           <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
           </button>

           <div class="collapse navbar-collapse order-3" id="navbarCollapse">
               <!-- Left navbar links -->
               <ul class="navbar-nav">
               <li class="nav-item">
                       <a href="check_out.php" class="nav-link">Check Out</a>
                   </li>
                   <li class="nav-item">
                       <a href="riwayat_pemesanan.php" class="nav-link">Cek List Riwayat</a>
                   </li>
               </ul>
           </div>

           <!-- Right navbar links -->
           <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
               <li class="nav-item dropdown">
                   <a class="nav-link" href="logout_pengguna.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')">
                       <i class="fas fa-sign-out-alt"></i> Keluar
                   </a>
               </li>
           </ul>

       </div>
   </nav>
   <!-- /.navbar -->