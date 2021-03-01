<?php
$pagina = "proyectos";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";




include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

$consulta = "SELECT * FROM w_proyecto order by id_proyecto";
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
                <h1 class="card-title mx-auto">Proyectos</h1>
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
                                            <th>Id</th>
                                            <th>Proyecto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($data as $dat) {
                                        ?>
                                            <tr>
                                                <td><?php echo $dat['id_proyecto'] ?></td>
                                                <td><?php echo $dat['nom_proyecto'] ?></td>

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
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title" id="exampleModalLabel">NUEVO PROYECTO</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formDatos" action="" method="POST">
                            <div class="modal-body row">


                                <div class="col-sm-12">
                                    <div class="form-group input-group-sm">
                                        <label for="nombre" class="col-form-label">Proyecto:</label>
                                        <input type="text" class="form-control" name="nombre" id="nombre" autocomplete="off" placeholder="Proyecto">
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
        <div class="modal fade" id="modalBitacora" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg " role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title" id="exampleModalLabel">Bitacora de Proyecto</h5>

                    </div>
                    <div class="card card-widget" style="margin: 10px;">
                        <form id="formBitacora" action="" method="POST">
                            <div class="modal-body ">

                                <div class="row justify-content-between">
                                    <div class="col-sm-4 ">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" autocomplete="off" placeholder="Fecha" >
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group input-group-sm">
                                            <label for="tipo" class="col-form-label">Tipo:</label>
                                            <select class="form-control" name="tipo" id="tipo">
                                                <option id="requerimiento" value="requerimiento">Requerimiento</option>
                                                <option id="entrega" value="entrega">Entrega</option>
                                                <option id="reporte" value="reporte">Reporte</option>
                                                <option id="duda" value="duda">Duda</option>
                                                

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">


                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="titulo" class="col-form-label">Titulo:</label>
                                            <input type="text" class="form-control" name="titulo" id="titulo" autocomplete="off" placeholder="Titulo">
                                        </div>
                                    </div>


                                    <div class="col-sm-12">
                                        <div class="form-group input-group-sm">
                                            <label for="descripcion" class="col-form-label">Descripción:</label>
                                            <textarea name="descripcion" id="descripcion" class="form-control" rows="10" placeholder="Descripción"></textarea>
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
                        <button type="button" id="btnGuardarBit" name="btnGuardarBit" class="btn btn-success" value="btnGuardarBit"><i class="far fa-save"></i> Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>


<?php include_once 'templates/footer.php'; ?>
<script src="fjs/cntaproyecto.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>