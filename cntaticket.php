<?php
$pagina = "ticket";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM ticket WHERE estado_ti<>0 ORDER BY folio_ti";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">
<style>
    .borderless td,
    .borderless th {
        border: none;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">

            <div id="div_carga">

                <img id="cargador" src="img/loader.gif" />
                <span class=" " id="textoc"><strong>Cargando...</strong></span>

            </div>
            <div class="card-header bg-blue text-light">
                <h1 class="card-title mx-auto">Tickets de Servicio</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">
                        <button id="btnNuevo" type="button" class="btn bg-blue btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                    </div>
                </div>
                <br>
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive ">
                                <table name="tablaV" id="tablaV" class="table table-sm table-bordered table-condensed table-hover text-nowrap w-auto mx-auto borderless" style="width:100%">
                                    <thead class="text-center bg-blue">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Descripción/Servicio</th>
                                            <th>Costo</th>
                                            <th>Estado</th>
                                            <th>Tareas</th>
                                            <th>Menú</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /.card-body -->

            <!-- /.card-footer-->
        </div>
        <!-- /.card -->

    </section>


    <section>
        <div class="modal fade" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title" id="exampleModalLabel">Alta de Ticket de Servicio</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="folio" class="col-form-label">Folio:</label>
                                        <input type="text" class="form-control" name="folio" id="folio" autocomplete="off" placeholder="Folio" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="inicio" class="col-form-label">Inicio:</label>
                                        <input type="text" class="form-control" name="inicio" id="inicio" autocomplete="off" placeholder="Inicio" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="fin" class="col-form-label">Fin:</label>
                                        <input type="text" class="form-control" name="fin" id="fin" autocomplete="off" placeholder="Fin" disabled>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="estado" class="col-form-label">Estado:</label>
                                        <input type="text" class="form-control" name="estado" id="estado" autocomplete="off" placeholder="Estado">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="cliente" class="col-form-label">Cliente:</label>
                                        <input type="text" class="form-control" name="cliente" id="cliente" autocomplete="off" placeholder="Cliente">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="descripcion" class="col-form-label">Descripción:</label>

                                        <textarea rows="3" class="form-control" name="descripcion" id="descripcion" placeholder="Descripción del Servicio"></textarea>
                                    </div>
                                </div>



                                <div class="offset-sm-9 col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="costo" class="col-form-label">Costo:</label>
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control text-right" name="costo" id="costo" autocomplete="off" placeholder="Costo">
                                        </div>



                                    </div>
                                </div>

                            </div>
                    </div>


                    <?php
                    if ($message != "") {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="badge "><?php echo ($message); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>

                        </div>

                    <?php
                    }
                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="submit" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade " id="modalTarea" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title" id="exampleModalLabel">Tareas de ticket</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formTareas" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-6">
                                    <div class="form-group input-group-sm">
                                        <input type="hidden" class="form-control" name="folio_ti" id="folio_ti" autocomplete="off" placeholder="folio_ti">
                                        <label for="tarea" class="col-form-label">Tarea:</label>
                                        <input type="text" class="form-control" name="tarea" id="tarea" autocomplete="off" placeholder="Tarea">
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="tareadesc" class="col-form-label">Descripción:</label>

                                        <textarea rows="3" class="form-control" name="tareadesc" id="tareadesc" placeholder="Descripción del Tarea"></textarea>
                                    </div>
                                </div>


                            </div>
                    </div>


                    <?php
                    if ($message != "") {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <span class="badge "><?php echo ($message); ?></span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>

                        </div>

                    <?php
                    }
                    ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="fas fa-ban"></i> Cancelar</button>
                        <button type="button" id="btnGuardarTar" name="btnGuardarTar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="modal fade" id="modalVerTar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title" id="exampleModalLabel">Listado de Tareas</h5>
                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                    <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive ">
                                <table name="tablaT" id="tablaT" class="table table-sm table-condensed table-bordered table-hover table-striped text-nowrap w-auto mx-auto borderless" style="width:100%">
                                    <thead class="text-center bg-blue">
                                        <tr>
                                            <th>ID</th>
                                            <th>Fecha</th>
                                            <th>Tarea</th>
                                            <th>Detalle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaticket.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/push/push.js"></script>