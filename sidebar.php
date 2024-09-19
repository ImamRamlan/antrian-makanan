<?php
$currentPage = basename($_SERVER['PHP_SELF']); // Mendapatkan nama file halaman saat ini
?>
<aside class="main-sidebar sidebar-dark-lime elevation-4">
  <a href="index.php" class="brand-link text-center">
    <span class="brand-text font-weight-light"><i class="fas fa-shopping-cart"></i> Antrian <strong>Makanan</strong> </span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="https://th.bing.com/th/id/OIP.7d0_Ub6VvuDSzPPVxyid3QAAAA?rs=1&pid=ImgDetMain" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['role']; ?> - <?php echo $_SESSION['nama']; ?></a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">MAIN NAVIGASI</li>
        <li class="nav-item">
          <a href="halaman_utama.php" class="nav-link <?php echo ($currentPage == 'halaman_utama.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-home"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a href="data_karyawan.php" class="nav-link <?php echo ($currentPage == 'data_karyawan.php' || $currentPage == 'tambah_pegawai.php' || $currentPage == 'edit_pegawai.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-tag"></i>
            Data Karyawan
          </a>
        </li>

        <li class="nav-item">
          <a href="data_pelanggan.php" class="nav-link <?php echo ($currentPage == 'data_pelanggan.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user"></i>
            Data Pelanggan
          </a>
        </li>
        <li class="nav-item">
          <a href="makanan_minuman.php" class="nav-link <?php echo ($currentPage == 'makanan_minuman.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-shapes"></i>
            Data Makanan Minuman
          </a>
        </li>
        <li class="nav-item">
          <a href="data_pesan.php" class="nav-link <?php echo ($currentPage == 'data_pesan.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-shopping-cart"></i>
            Data Pesan
          </a>
        </li>

        <li class="nav-header">LAINNYA</li>
        <li class="nav-item">
          <a href="data_detail.php" class="nav-link <?php echo ($currentPage == 'data_detail.php') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-store-slash "></i>
            Riwayat Pemesanan
          </a>
        </li>
        <li class="nav-item">
          <a href="logout.php" class="nav-link" data-toggle="modal" data-target="#logoutModal">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            Keluar
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>
<!-- ... (unchanged code) ... -->

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <a class="btn btn-primary" href="logout_admin.php">Logout</a>
      </div>
    </div>
  </div>
</div>