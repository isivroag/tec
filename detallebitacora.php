<?php
$pagina = "detallebit";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';

$id = (isset($_GET['id'])) ? $_GET['id'] : '';

$objeto = new conn();
$conexion = $objeto->connect();


$cnta = "SELECT * FROM w_bitacora where id_proyecto='$id'";
$resultado = $conexion->prepare($cnta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);



$cntap = "SELECT * FROM w_proyecto where id_proyecto='$id'";
$resultadop = $conexion->prepare($cntap);
$resultadop->execute();
$datap = $resultadop->fetchAll(PDO::FETCH_ASSOC);

foreach ($datap as $registrop) {
    $proyecto = $registrop['nom_proyecto'];
}


?>


<div class="content-wrapper">
    <!-- Content Header (Page header) -->




    <!-- Main content -->
    <div class="card">
        <div class="card-header bg-gradient-blue text-light">
            <h1 class="card-title mx-auto">Bitacora de Proyecto</h1>
        </div>

        <div class="card-body">

            <!-- Timelime example  -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <div class="timeline">
                        <div class="card bg-gradient-blue">
                            <div class="time-label">
                                <div class="row justify-content-center" style="height:35px">
                                    <div class="col-lg-1 d-flex">
                                        <h3 class=' font-weight-bolder'>Proyecto: </h3>
                                    </div>
                                    <div class="col-lg-2">
                                        <h3 class=' font-weight-bold '> <?php echo $proyecto ?></h3>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <?php
                        foreach ($data as $rtegistro) {
                            $id_bit = $rtegistro['id_bit'];
                            $fecha = $rtegistro['fecha_bit'];
                            $tipo = $rtegistro['tipo_bit'];
                            $titulo = $rtegistro['titulo_bit'];
                            $descripcion = $rtegistro['descripcion_bit'];

                            $array = preg_split("/\r\n|\n|\r/", $descripcion);






                            echo "<div class='time-label'></div>";
                            echo "<div>";

                            echo "<i class='fas fa-list bg-blue'></i>";
                            echo "<div class='timeline-item'>";

                            echo "<div class='timeline-header bg-gray-light  border border-primary'>";
                            echo "<span class='text-blue font-weight-bolder'>Fecha: </span><span class=' font-weight-bold '>" . $fecha . "</span><br>";
                            echo "<span class='text-blue font-weight-bolder'>Titulo: </span><span class='font-weight-bold text-dark'>" . $titulo . " </span><br>";
                            echo "<span class='text-blue font-weight-bolder'>Tipo: </span><span class='font-weight-bold '>" . $tipo . " </span><br>";
                            echo "</div>";
                            echo "<div class='timeline-body  border border-primary '>";


                            echo "<span class='text-blue font-weight-bolder'>DETALLES:</span><br>";
                            echo "<ul>";
                            foreach ($array as $linea) {
                                echo "<li>";
                                echo "</span><span class='font-weight-bold text-dark'>" . $linea . " </span> <br>";
                                echo "</li>";
                            }
                            echo "</ul>";
                            echo "</div>";
                            echo "</div>";
                            echo "</div>";
                        }

                        ?>
                        <div>
                            <i class="fas fa-clock bg-primary"></i>
                        </div>
                    </div>

                </div>
            </div>
            <!-- /.col -->
        </div>
    </div>
    <!-- /.timeline -->


    <!-- /.content -->
</div>

<?php include_once 'templates/footer.php'; ?>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>