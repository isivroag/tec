<?php
$pagina = "evaluacion";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';

$id = (isset($_GET['id'])) ? $_GET['id'] : '';

$objeto = new conn();
$conexion = $objeto->connect();


$cntalumno = "SELECT * FROM vdatosevaluacion where id_alumno='$id'";
$resalumno = $conexion->prepare($cntalumno);
$resalumno->execute();
$dataalum = $resalumno->fetchAll(PDO::FETCH_ASSOC);

foreach ($dataalum as $dtalumn) {
    $alumno = $dtalumn['nombre'];
    $nivel = $dtalumn['ncorto'];
    $etapa = $dtalumn['nom_etapa'];
}


$consulta = "SELECT * FROM evalregistro where id_alumno='$id'order by fecha";
$resultado = $conexion->prepare($consulta);
$resultado->execute();


$data2 = $resultado->fetchAll(PDO::FETCH_ASSOC);

?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->




    <!-- Main content -->
    <div class="card">
        <div class="card-header bg-gradient-blue text-light">
            <h1 class="card-title mx-auto">Historial de Evaluaciones</h1>
        </div>

        <div class="card-body">

            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                        <div class="card bg-gradient-blue">
                            <div class="time-label">
                                <div class="row justify-content-center" style="height:50px">
                                    <div class="col-lg-6">
                                        <span class=' font-weight-bolder'>ALUMNO: </span><br><span class=' font-weight-bold '><?php echo $alumno ?></span>
                                    </div>
                                    <div class="col-lg-2">

                                        <span class=' font-weight-bolder'>NIVEL: </span><br><span class=' font-weight-bold '><?php echo $nivel ?></span>

                                    </div>
                                    <div class="col-lg-2">
                                        <span class=' font-weight-bolder'>ETAPA: </span> <br> <span class=' font-weight-bold '><?php echo $etapa ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        foreach ($data2 as $dt2) {

                            $folio = $dt2['folio'];

                            echo "<div class='time-label'>";

                            echo "</div>";
                            echo "<div>";
                            echo "<i class='fas fa-list bg-blue'></i>";
                            echo "<div class='timeline-item'>";
                            echo "<div class='timeline-header bg-gray-light  border border-primary'>";
                            echo "<span class='text-blue font-weight-bolder'>Fecha: </span><span class=' font-weight-bold '>" . $dt2['fecha'] . "</span><br>";

                            echo "</div>";
                            echo "<div class='timeline-body  border border-primary '>";
                            echo "<span class='text-blue font-weight-bolder'>INSTRUCTOR: </span><span class='font-weight-bold '>" . $dt2['instructor'] . " </span>";
                            echo "<div>";
                            echo "<span class='text-blue font-weight-bolder'>OBJETIVOS: </span>";

                            $cntaobj = "SELECT * FROM evalobjreg WHERE folio ='$folio' ORDER BY registro";
                            $resobj = $conexion->prepare($cntaobj);
                            $resobj->execute();
                            $dataobj = $resobj->fetchAll(PDO::FETCH_ASSOC);


                            foreach ($dataobj as $objetivos) {
                                echo "<li>" . $objetivos['descripcion'] . "</li>";
                            }
                            echo "</div>";

                            echo "<div>";
                            echo "<span class='text-blue font-weight-bolder'>ACTIVIDADES: </span>";

                            $cntaact = "SELECT * FROM evalactreg WHERE folio ='$folio' ORDER BY reg_act";
                            $resact = $conexion->prepare($cntaact);
                            $resact->execute();
                            $dataact = $resact->fetchAll(PDO::FETCH_ASSOC);


                            foreach ($dataact as $actividades) {
                                echo "<li>" . $actividades['actividad'] . "</li>";
                            }
                            echo "</div>";
                            echo "<div class='text-blue font-weight-bolder'>";
                            if ($dt2['estado'] == 1) {
                                $estado = "Evaluación Completa";
                            } else {
                                $estado = "Evaluación Incompleta";
                            }
                            echo "<span class='text-blue font-weight-bolder'>ESTADO: </span><span class='font-weight-bold text-dark'>" . $estado . " </span>";
                            echo "</div>";

                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }

                        ?>
                        <div>
                            <i class="fas fa-clock bg-info"></i>
                        </div>
                    </div>



                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.timeline -->

    </section>
    <!-- /.content -->
</div>

<?php include_once 'templates/footer.php'; ?>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>