<aside class="main-sidebar sidebar-light-primary elevation-3 ">
  <!-- Brand Logo -->

  <a href="inicio.php" class="brand-link">

    <img src="img/mundo.jpg" alt="Tecniem Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-bold">TECNIEM</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
      <div class="image">
        <img src="img/user.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $_SESSION['s_nombre']; ?></a>
        <input type="hidden" id="nameuser" name="nameuser" value="<?php echo $_SESSION['s_nombre']; ?>">
        <input type="hidden" id="fechasys" name="fechasys" value="<?php echo date('Y-m-d') ?>">
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item ">
          <a href="inicio.php" class="nav-link <?php echo ($pagina == 'home') ? "active" : ""; ?> ">
            <i class="nav-icon fas fa-home "></i>
            <p>
              Inicio
            </p>
          </a>
        </li>

        <li class="nav-item  has-treeview <?php echo ($pagina == 'ticket' ) ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link  <?php echo ($pagina == 'ticket' ) ? "active" : ""; ?>">
            <i class="nav-icon fas fa-tasks nav-icon"></i>
            <p>
              Operaciones
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>


          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cntaticket.php" class="nav-link <?php echo ($pagina == 'ticket') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-ticket-alt nav-icon"></i>
                <p>Tickets</p>
              </a>
            </li>

            
          </ul>

        </li>

        <li class="nav-item has-treeview <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp' || $pagina == 'subpartida') ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'proveedor' || $pagina == 'partida' || $pagina == 'cxp' || $pagina == 'subpartida') ? "active" : ""; ?>">
          <span class="fa-stack">
              <i class=" fas fa-dollar-sign "></i>
              <i class=" fas fa-arrow-down "></i>
            </span>
            <p>
              Egresos
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntapartida.php" class="nav-link <?php echo ($pagina == 'partida') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Partidas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntapartida.php" class="nav-link <?php echo ($pagina == 'subpartida') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-list-alt nav-icon"></i>
                <p>Subpartidas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntaproveedor.php" class="nav-link <?php echo ($pagina == 'proveedor') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-people-carry nav-icon"></i>
                <p>Proveedores</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntacxp.php" class="nav-link <?php echo ($pagina == 'cxp') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-file-invoice-dollar nav-icon"></i>
                <p>Cuentas por Pagar</p>
              </a>
            </li>


          </ul>
        </li>

        <li class="nav-item has-treeview <?php echo ($pagina == 'proyectos'  ) ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'proyectos' ) ? "active" : ""; ?>">
          <span class="fa-stack">
              <i class="nav-icon fas fa-laptop-code "></i>
            </span>
            <p>
              SISTEMAS
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntaproyecto.php" class="nav-link <?php echo ($pagina == 'proyectos') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-project-diagram nav-icon"></i>
                <p>Proyectos</p>
              </a>
            </li>

       

         

          </ul>
        </li>

        <li class="nav-item has-treeview <?php echo ($pagina == 'cuentas' || $pagina == 'caja' ) ? "menu-open" : ""; ?>">


          <a href="#" class="nav-link <?php echo ($pagina == 'cuentas' || $pagina == 'caja') ? "active" : ""; ?>">
          <span class="fa-stack">
              <i class="nav-icon fas fa-dollar-sign "></i>
            </span>
            <p>
              Control
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="cntacuenta.php" class="nav-link <?php echo ($pagina == 'cuentas') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-money-check-alt nav-icon"></i>
                <p>Cuentas</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="cntacaja.php" class="nav-link <?php echo ($pagina == 'caja') ? "active seleccionado" : ""; ?>  ">
                <i class="fas fa-cash-register nav-icon"></i>
                <p>Caja</p>
              </a>
            </li>

         

          </ul>
        </li>


        <?php if ($_SESSION['s_rol'] == '3') {
        ?>
          <li class="nav-item has-treeview <?php echo ($pagina == 'resumencxp' ) ? "menu-open" : ""; ?>">


            <a href="#" class="nav-link <?php echo ($pagina == 'resumencxp' ) ? "active" : ""; ?>">
              <span class="fa-stack">
                <i class="fas fa-chart-line nav-icon"></i>

              </span>
              <p>
                Reportes
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="resumencxp.php" class="nav-link <?php echo ($pagina == 'resumencxp') ? "active seleccionado" : ""; ?>  ">
                  <i class="fas fa-file-invoice nav-icon"></i>
                  <p>Resumen Egresos</p>
                </a>
              </li>


            </ul>
          </li>
        <?php
        }
        ?>




        <?php if ($_SESSION['s_rol'] == '2') {
        ?>
          <hr class="sidebar-divider">
          <li class="nav-item">
            <a href="cntausuarios.php" class="nav-link <?php echo ($pagina == 'usuarios') ? "active" : ""; ?> ">
              <i class="fas fa-user-shield"></i>
              <p>Usuarios</p>
            </a>
          </li>
        <?php
        }
        ?>

        <hr class="sidebar-divider">
        <li class="nav-item">
          <a class="nav-link" href="bd/logout.php">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <p>Salir</p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
<!-- Main Sidebar Container -->