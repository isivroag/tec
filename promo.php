.p<?php $pagina = "promocion";
    include_once "templates/header.php";
    include_once "templates/barra.php";
    include_once "templates/navegacion.php";


    include_once 'bd/conexion.php';
    $objeto = new conn();
    $conexion = $objeto->connect();


    $id = "";
    $id_nivel = "";
    $nom_nivel = "";
    $nom_alumno = "";
    $id_etapa = "";
    $nom_etapa = "";
    $id_instructor = "";
    $nom_instructor = "";

    if (!empty($_GET['id'])) {

        $id = $_GET['id'];


        $consulta1 = "SELECT * from vdatosevaluacion where id_alumno='" . $id . "' order by id_alumno";

        $resultado1 = $conexion->prepare($consulta1);
        $resultado1->execute();
        $data = $resultado1->fetchAll(PDO::FETCH_ASSOC);
        if ($resultado1->rowCount() >= 1) {
            foreach ($data as $dtvin) {

                $nom_alumno = $dtvin['nombre'];
                $id_nivel = $dtvin['id_nivel'];
                $nom_nivel = $dtvin['ncorto'];
                $id_etapa = $dtvin['id_etapa'];
                $nom_etapa = $dtvin['nom_etapa'];
                $id_instructor = $dtvin['id_instructor'];
                $nom_instructor = $dtvin['nominstructor'];
            }
        }

        $consulta2 = "SELECT id_etapa,nom_etapa FROM etapa WHERE id_nivel='" . $id_nivel . "' order by id_etapa";
        $resultado2 = $conexion->prepare($consulta2);
        $resultado2->execute();
        $data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);


        $consulta3 = "SELECT id_instructor,instructor FROM vlistas WHERE id_alumno='" . $id . "' and status=1 and estado=1 and id_act=0 group by id_alumno,id_instructor order by instructor";
        $resultado3 = $conexion->prepare($consulta3);
        $resultado3->execute();
        $data3 = $resultado3->fetchAll(PDO::FETCH_ASSOC);




        $consulta4 = "SELECT * FROM evalgeneral where id_alumno='" . $id . "' and id_nivel='" . $id_nivel . "' and id_etapa='" . $id_etapa . "'";
        $resultado4 = $conexion->prepare($consulta4);
        $resultado4->execute();
        $data4 = $resultado4->fetchAll(PDO::FETCH_ASSOC);
    } else {
        echo "<script> window.location='cntaalumno.php'; </script>";
    }

    ?>
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="css/estilo.css">

<div class="content-wrapper">
    <section class="content">
        <div class="card">
            <div class="card-header bg-gradient-blue text-light">
                <h4 class="card-title text-center">Información de Evaluación</h4>

            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="" id="modalCRUD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="container" role="document">
                                <div class="modal-content">
                                    <div class="modal-header bg-gradient-primary">
                                        <h5 class="modal-title" id="exampleModalLabel">INFORMACION DEL ALUMNO</h5>
                                    </div>
                                    <form id="formPersonas" action="" method="POST">
                                        <div class="modal-body row">
                                            <div class="col-sm-12">
                                                <label for="nombre" class="col-form-label">Nombre:</label>
                                                <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nom_alumno; ?>" disabled>

                                                <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id; ?>">
                                                <input type="hidden" class="form-control" name="fecha" id="fecha" value="<?php echo date('Y-m-d');; ?>">
                                            </div>

                                            <div class="col-sm-4">

                                                <label for="nivel" class="col-form-label">Nivel:</label>
                                                <input type="text" class="form-control" name="nivel" id="nivel" value="<?php echo $nom_nivel; ?>">

                                                <input type="hidden" class="form-control" name="id_nivel" id="id_nivel" value="<?php echo $id_nivel; ?>">
                                            </div>
                                            <div class="col-sm-4">

                                                <label for="etapa" class="col-form-label">Etapa:</label>

                                                <select class="form-control" name="etapa" id="etapa">

                                                    <?php
                                                    if ($resultado3->rowCount() >= 1) {
                                                        foreach ($data2 as $dtdat) {

                                                    ?>

                                                            <option value="<?php echo $dtdat['id_etapa']; ?>" <?php if ($dtdat['id_etapa'] == $id_etapa) { ?> selected <?php } ?>><?php echo $dtdat['nom_etapa']; ?></option>

                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>


                                            </div>
                                            <div class="col-sm-4">
                                                <label for="instructor" class="col-form-label">Instructor:</label>
                                                <select class="form-control" name="instructor" id="instructor">

                                                    <?php
                                                    if ($resultado3->rowCount() >= 1) {
                                                        foreach ($data3 as $dtdat) {

                                                    ?>

                                                            <option value="<?php echo $dtdat['id_instructor']; ?>" <?php if ($dtdat['id_instructor'] == $id_instructor) { ?> selected <?php } ?>><?php echo $dtdat['instructor']; ?></option>

                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-sm-12">
                                                <div class="content" role="document">
                                                    <div class="content">
                                                        <br>

                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="table-responsive table-striped table-bordered table-sm table-condensed">
                                                                        <table class="table" id="tablaobjetivos">
                                                                            <thead>
                                                                                <tr class="bg-gradient-blue">
                                                                                    <th class="text-center"><strong>ID</strong></th>
                                                                                    <th class="text-center"><strong>OBJETIVO</strong></th>
                                                                                    <th class="text-center" style="width:10%"><strong>ESTADO</strong></th>
                                                                                    <th class="text-center"><strong>VALOR</strong></th>
                                                                                    <th class="text-center" style="width:20%"><strong>ACCIONES</strong></th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody id="tbody">
                                                                                <tr>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                    <th class="text-center"></th>
                                                                                    <th></th>
                                                                                    <th></th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                    </form>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="window.location.href='cntaalumno.php'"><i class="fas fa-backward"></i> Regresar</button>
                                    <button type="button" class="btn btn-success" onclick="window.location.href='cntaalumno.php'"><i class="fas fa-save"></i> Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>





<?php require_once('templates/footer.php') ?>
<script src="fjs/promo.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>