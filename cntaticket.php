<?php
$pagina = "ticket";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM ticket order by folio_ti";
$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);

$message = "";



?>

<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->


    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header bg-blue text-light">
                <h1 class="card-title mx-auto">Consulta de Tickets de Servicio</h1>
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
                            <div class="table-responsive">
                                <table name="tablaV" id="tablaV" class="table table-sm table-striped table-bordered table-condensed text-nowrap w-auto mx-auto" style="width:100%">
                                    <thead class="text-center bg-blue">
                                        <tr>
                                            <th>Folio</th>
                                            <th>Cliente</th>
                                            <th>Fecha Inicio</th>
                                            <th>Fecha Fin</th>
                                            <th>Descripción/Servicio</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $registro) {
                                        ?>
                                            <tr>
                                                <td><?php echo $registro['folio_ti'] ?></td>
                                                <td><?php echo $registro['cliente_ti'] ?></td>
                                                <td><?php echo $registro['apertura_ti'] ?></td>
                                                <td><?php echo $registro['clausura_ti'] ?></td>
                                                <td><?php echo $registro['descripcion_ti'] ?></td>
                                                <td><?php echo $registro['estado_ti'] ?></td>
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
                                        <input type="text" class="form-control" name="folio" id="folio" autocomplete="off" placeholder="Folio">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="inicio" class="col-form-label">Inicio:</label>
                                        <input type="text" class="form-control" name="inicio" id="inicio" autocomplete="off" placeholder="Inicio">
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="fin" class="col-form-label">Fin:</label>
                                        <input type="text" class="form-control" name="fin" id="fin" autocomplete="off" placeholder="Fin">
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
                                        <input type="text" class="form-control" name="descripcion" id="descripcion" autocomplete="off" placeholder="Descripción del Servicio">
                                    </div>
                                </div>

                                

                                <div class="offset-sm-9 col-sm-3">
                                    <div class="form-group input-group-sm">
                                        <label for="costo" class="col-form-label">Costo:</label>
                                        <input type="text" class="form-control" name="costo" id="costo" autocomplete="off" placeholder="Costo">
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
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaticket.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>