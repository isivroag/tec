<?php
$pagina = "grupo";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";



include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();


$id = "";
$id_alumno = "";
$nombre = "";
$dataeval = "";
$ncorto = "";
$nom_etapa = "";


if (!empty($_GET['id'])) {

    $id = $_GET['id'];


    $consulta1 = "SELECT wvlistas.id_grupo,wvlistas.id_alumno,vdatosevaluacion.nombre,vdatosevaluacion.dataeval,vdatosevaluacion.ncorto,vdatosevaluacion.nom_etapa
        FROM wvlistas JOIN vdatosevaluacion ON wvlistas.id_alumno = vdatosevaluacion.id_alumno where wvlistas.id_grupo='" . $id . "' order by wvlistas.id_alumno";

    $resultado1 = $conexion->prepare($consulta1);
    $resultado1->execute();
    $data = $resultado1->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "<script> window.location='cntagpo.php'; </script>";
}

?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">




<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-blue ">
                <h1 class="card-title mx-auto">Información de Grupo</h1>
            </div>

            <div class="card-body">


                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-gradient-blue">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Estado</th>
                                        <th>Nivel</th>
                                        <th>Etapa</th>
                                        <th>Info</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    foreach ($data as $dat) {
                                    ?>
                                        <tr>
                                            <td><?php echo $dat['id_alumno'] ?></td>
                                            <td><?php echo $dat['nombre'] ?></td>
                                            <td><?php echo $dat['dataeval'] ?></td>
                                            <td><?php echo $dat['ncorto'] ?></td>
                                            <td><?php echo $dat['nom_etapa'] ?></td>
                                            <td></td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>







<?php require_once('templates/footer.php') ?>
<script src="fjs/viewgrupo.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>