<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Aplikasi BK</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  </head>
  <body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="/">Aplikasi BK</a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
        <i class="fas fa-bars"></i>
      </button>
      <!-- Navbar Search-->
      <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2my-md-0"></form>
      <!-- Navbar-->
      <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-userfa-fw"></i>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
            <li> <a class="dropdown-item" href="/logout">Logout</a> </li>
          </ul>
        </li>
      </ul>
    </nav>
    <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion"> 
          <div class="sb-sidenav-menu">
            <div class="nav">
              <div class="sb-sidenav-menu-heading">Menu</div>
              <?php

              if (Auth::user()->level == 'admin') {
                echo "<a class='nav-link' href='/admin'>";
              } elseif (Auth::user()->level == 'gurubk'){
                echo "<a class='nav-link' href='/guru'>";
              }
              ?>
              <!-- <a class="nav-link" href="index.html"> -->
                <div class="sb-nav-link-icon"><i class="fasfa-tachometer-alt"></i></div> 
                <?php
                  echo 'Dashboard ' . ucfirst(Auth::user()->level) . '';
                ?>
              </a>
              <div class="sb-sidenav-menu-heading">Data</div>
              <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-columns"></i>
                </div> Master <div class="sb-sidenav-collapse-arrow">
                  <i class="fas fa-angle-down"></i>
                </div>
              </a>
              <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                  <?php
                  if (Auth::user()->level == 'admin') {
                    echo "<a class='nav-link' href='/admin/petugas'>petugas</a>";
                    echo "<a class='nav-link' href='/admin/siswa'>Siswa</a>";
                  } elseif (Auth::user()->level == 'gurubk') {
                    echo "<a class='nav-link' href='/guru/siswa'>Siswa</a>";
                  }
                  ?>
                </nav>
              </div>
              <a class="nav-link collapse" href="#" data-bs-toggle="collapse" data-bs-target="#collapseKejadian" aria-expanded="false" aria-controls="collapseLayouts">
                <div class="sb-nav-link-icon">
                  <i class="fas fa-columns"></i>
                </div> Kejadian <div class="sb-sidenav-collapse-arrow">
                  <i class="fas fa-angle-down"></i>
                </div>
              </a>
              <div class="collapse" id="collapseKejadian" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                 <?php
                 if (Auth::user()->level =='admin') {
                  echo "<a class='nav-link' href='/admin/pelanggaran'>Pelanggaran</a>";
                  echo "<a class='nav-link' href='/admin/tanggapan'>Tanggapan</a>";
                 } elseif (Auth::user()->level == 'gurubk') {
                  echo "<a class='nav-link' href='/guru/pelanggaran'>Pelanggaran</a>";
                  echo "<a class='nav-link' href='/guru/tanggapan'>Tanggapan</a>";
                 }
                 ?>
                </nav>
              </div>
            </div>
          </div>
        </nav>
      </div>
      <div id="layoutSidenav_content">
        <main> 
          <div class="container-fluid px-4">

            <h2 class="mt-4">
            <?php
            if (Auth::user()->level == 'admin') {
              echo "selamat datang bang admin";
            } elseif (Auth::user()->level == 'gurubk') {
              echo "selamat datang pak/bu guru";
            }
            ?>
            </h2>
            <ol class=breadcrumb mb-4">
              <li class="breadcrumb-item active">Dashboard</li>
          </ol>
          
          @yield('content')
         </main>
        <footer class="py-4 bg-light mt-auto">
          <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
              <div class="text-muted"></div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/scripts.js') }}"></script>
  </body>
</html>