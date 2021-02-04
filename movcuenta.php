<?php
$pagina = "cxp";

include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";


include_once 'bd/conexion.php';

$folio = (isset($_GET['folio'])) ? $_GET['folio'] : '';
$objeto = new conn();
$conexion = $objeto->connect();
$tokenid = md5($_SESSION['s_usuario']);

if ($folio != "") {

    $opcion = 2;
    $consulta = "SELECT * FROM w_movcuenta where id_mov='$folio'";

    $resultado = $conexion->prepare($consulta);
    $resultado->execute();


    $data = $resultado->fetchAll(PDO::FETCH_ASSOC);

    foreach ($data as $dt) {
        $folio = $dt['id_mov'];
        $tipo_mov = $dt['tipo_mov'];
        $fecha_mov = $dt['fecha_mov'];
        $fecha_reg = $dt['fecha_reg'];
        $id_cuenta = $dt['id_cuenta'];
        $cuenta = $dt['cuenta'];
        $concepto_mov = $dt['concepto_mov'];
        $monto_mov = $dt['monto_mov'];
        $metodo_mov = $dt['metodo_mov'];
        $ref_mov = $dt['ref_mov'];
        $folio_cxc = $dt['folio_cxc'];
    }





    $message = "";
} else {
    $folio = "";
    $tipo_mov = "";
    $fecha_mov = "";
    $fecha_reg = "";
    $id_cuenta = "";
    $cuenta = "";
    $concepto_mov = "";
    $monto_mov = "";
    $ref_mov = "";
    $folio_cxc = "";
    $metodo_mov = "";
    $opcion = 1;
}

$consultac = "SELECT * FROM w_cuenta WHERE tipo_cuenta='BANCO' ORDER BY id_cuenta";
$resultadoc = $conexion->prepare($consultac);
$resultadoc->execute();
$datac = $resultadoc->fetchAll(PDO::FETCH_ASSOC);

$consultacon = "SELECT * FROM w_partida order by id_partida";
$resultadocon = $conexion->prepare($consultacon);
$resultadocon->execute();
$datacon = $resultadocon->fetchAll(PDO::FETCH_ASSOC);



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
            <div class="card-header bg-gradient-blue text-light">
                <h1 class="card-title mx-auto">Transacciones de Cuenta</h1>
            </div>

            <div class="card-body">

                <div class="row">
                    <div class="col-lg-12">

                        <button id="btnNuevo" type="button" class="btn bg-gradient-blue btn-ms" data-toggle="modal"><i class="fas fa-plus-square text-light"></i><span class="text-light"> Nuevo</span></button>
                        <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" value="btnGuardar"><i class="far fa-save"></i> Guardar</button>

                    </div>
                </div>

                <br>


                <!-- Formulario Datos de Cliente -->
                <form id="formDatos" action="" method="POST">

                    <div class="content">

                        <div class="card card-widget" style="margin-bottom:0px;">

                            <div class="card-header bg-gradient-blue " style="margin:0px;padding:8px">
                                <h1 class="card-title ">Datos de Registro</h1>
                            </div>

                            <div class="card-body" style="margin:0px;padding:1px;">

                                <div class="row justify-content-sm-center mx-1">

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" name="tokenid" id="tokenid" value="<?php echo $tokenid; ?>">
                                            <input type="hidden" class="form-control" name="opcion" id="opcion" value="<?php echo $opcion; ?>">
                                            <input type="hidden" class="form-control" name="id_cuenta" id="id_cuenta" value="<?php echo $id_cuenta; ?>">
                                            <label for="cuenta" class="col-form-label">CUENTA:</label>

                                            <div class="input-group input-group-sm">

                                                <input type="text" class="form-control" name="cuenta" id="cuenta" value="<?php echo $cuenta; ?>" disabled>
                                                <span class="input-group-append">
                                                    <button id="bcuenta" type="button" class="btn btn-primary "><i class="fas fa-search"></i></button>

                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="fecha" class="col-form-label">Fecha:</label>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha_mov; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-2" hidden>
                                        <div class="form-group input-group-sm">
                                            <label for="fechareg" class="col-form-label">Fecha de Registro:</label>
                                            <input type="hidden" class="form-control" name="fechareg" id="fechareg" value="<?php echo date("Y-m-d H:i:s"); ?> " disabled>
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="referencia" class="col-form-label">Referencia:</label>
                                            <input type="text" class="form-control" name="referencia" id="referencia" value="<?php echo  $ref_mov; ?>">


                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="folior" class="col-form-label">Folio Mov.:</label>

                                            <input type="text" class="form-control" name="folior" id="folior" value="<?php echo $folio; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group input-group-sm">
                                            <label for="foliocxc" class="col-form-label">Ref Cxp:</label>

                                            <input type="text" class="form-control" name="foliocxc" id="foliocxc" value="<?php echo $folio_cxc; ?>">
                                        </div>
                                    </div>

                                </div>

                                <div class=" row justify-content-sm-center mx-1">
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <label for="concepto" class="col-form-label">Concepto:</label>
                                            <textarea rows="2" class="form-control" name="concepto" id="concepto"><?php echo $concepto_mov; ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row justify-content-sm-center mx-1">
                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">

                                            <label for="tipomov" class="col-form-label">Tipo de Movimiento:</label>
                                            <select class="form-control" name="tipomov" id="tipomov">
                                                <option id="nada" value="nada" disabled <?php echo $tipo_mov == '' ? 'selected' : '' ?>>Elije un tipo de Movimiento</option>
                                                <option id="inicial" value="inicial" <?php echo $tipo_mov == 'inicial' ? 'selected' : '' ?>>Saldo Inicial </option>
                                                <option id="ingreso" value="ingreso" <?php echo $tipo_mov == 'ingreso' ? 'selected' : '' ?>>Ingreso </option>
                                                <option id="gasto" value="gasto" <?php echo $tipo_mov == 'gasto' ? 'selected' : '' ?>>Gasto</option>

                                            </select>


                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="saldoini" class="col-form-label">Saldo Actual</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </div>

                                                <input type="text" class="form-control text-right" name="saldoini" id="saldoini" value="" disabled>
                                            </div>



                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm ">


                                            <label for="metodo" class="col-form-label">Médoto:</label>

                                            <select class="form-control" name="metodo" id="metodo">
                                            <option id="nmetodo" value="nmetodo" disabled <?php echo $metodo_mov == '' ? 'selected' : '' ?>>Elije un metodo</option>
                                                <option id="efectivo" value="efectivo" <?php echo $metodo_mov == 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                                                <option id="cheque" value="cheque" <?php echo $metodo_mov == 'cheque' ? 'selected' : '' ?>>Cheque</option>
                                                <option id="transferencia" value="transferencia" <?php echo $metodo_mov == 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                                                <option id="tarjeta de Debito" value="tarjeta de Debito" <?php echo $metodo_mov == 'tarjeta de debito' ? 'selected' : '' ?>>Tarjeta de Debito</option>
                                                <option id="Tarjeta de Credito" value="Tarjeta de Credito" <?php echo $metodo_mov == 'tarjeta de credito' ? 'selected' : '' ?>>Tarjeta de Credito</option>

                                            </select>


                                        </div>
                                    </div>

                                    <div class="col-lg-2 ">

                                        <label for="subtotal" class="col-form-label ">Monto de Operación:</label>

                                        <div class="input-group input-group-sm">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="fas fa-dollar-sign"></i>
                                                </span>
                                            </div>

                                            <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="<?php echo $monto_mov; ?>">
                                        </div>
                                    </div>

                                    <div class="col-lg-2">
                                        <div class="form-group input-group-sm">
                                            <label for="saldofin" class="col-form-label">Saldo Final</label>
                                            <div class="input-group input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">
                                                        <i class="fas fa-dollar-sign"></i>
                                                    </span>
                                                </div>

                                                <input type="text" class="form-control text-right" name="saldofin" id="saldofin" value="" disabled>
                                            </div>



                                        </div>
                                    </div>

                                </div>


                            </div>


                        </div>
                        <!-- Formulario Agrear Item -->


                    </div>


                </form>


                <!-- /.card-body -->

                <!-- /.card-footer-->
            </div>

        </div>

        <!-- /.card -->

    </section>


    <section>
        <div class="container">
            <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR CUENTA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto " style="padding:10px">
                            <table name="tablaC" id="tablaC" class="table table-sm table-striped text-nowrap table-bordered table-condensed " style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Nombre/Descripcion</th>
                                        <th>Saldo</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datac as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_cuenta'] ?></td>
                                            <td><?php echo $datc['nom_cuenta'] ?></td>
                                            <td><?php echo $datc['saldo_cuenta'] ?></td>


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
    </section>



    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalConcepto" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR PARTIDA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaCon" id="tablaCon" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Partida</th>
                                        <th>Seleccionar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    foreach ($datacon as $datc) {
                                    ?>
                                        <tr>
                                            <td><?php echo $datc['id_partida'] ?></td>
                                            <td><?php echo $datc['nom_partida'] ?></td>
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
    </section>

    <section>
        <div class="container">

            <!-- Default box -->
            <div class="modal fade" id="modalSubpartida" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-md" role="document">
                    <div class="modal-content w-auto">
                        <div class="modal-header bg-gradient-blue">
                            <h5 class="modal-title" id="exampleModalLabel">BUSCAR SUBPARTIDA</h5>

                        </div>
                        <br>
                        <div class="table-hover table-responsive w-auto" style="padding:15px">
                            <table name="tablaSub" id="tablaSub" class="table table-sm text-nowrap table-striped table-bordered table-condensed" style="width:100%">
                                <thead class="text-center">
                                    <tr>
                                        <th>Id</th>
                                        <th>Subartida</th>
                                        <th>Seleccionar</th>
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
    </section>




    <!-- /.content -->
</div>



<?php include_once 'templates/footer.php'; ?>
<script src="fjs/movcuenta.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>
<script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script language="JavaScript">