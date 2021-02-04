<?php $pagina = "evaluacion";
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
$message = "";

$fecha = date('Y-m-d');

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

  /*Insert nuevo Registro de Evaluación */
  $cntareg = "SELECT * FROM evalregistro where id_alumno='$id' and estado='0'";
  $resultadoreg = $conexion->prepare($cntareg);
  $resultadoreg->execute();

  if ($resultadoreg->rowCount() > 0) {
    $datares = $resultadoreg->fetchAll(PDO::FETCH_ASSOC);
    foreach ($datares as $dt) {
      $folio = $dt['folio'];
      $fecha = $dt['fecha'];
    }
  } else {
    $cntareg = "INSERT INTO evalregistro (id_alumno,fecha,nombre,id_nivel,nom_nivel,id_etapa,nom_etapa,id_instructor,instructor,estado) VALUES ('$id','$fecha','$nom_alumno','$id_nivel','$nom_nivel','$id_etapa','$nom_etapa','$id_instructor','$nom_instructor','0')";
    $resultadoreg = $conexion->prepare($cntareg);
    $resultadoreg->execute();

    $consultatmp = "SELECT folio FROM evalregistro WHERE id_alumno ='$id' ORDER BY folio";
    $resultadotmp = $conexion->prepare($consultatmp);
    $resultadotmp->execute();
    $datatmp = $resultadotmp->fetchAll(PDO::FETCH_ASSOC);
    foreach ($datatmp as $dt) {
      $folio = $dt['folio'];
    }
  }

  $cntaobj = "SELECT * FROM evalobjreg WHERE folio ='$folio' ORDER BY registro";
  $resobj = $conexion->prepare($cntaobj);
  $resobj->execute();
  $dataobj = $resobj->fetchAll(PDO::FETCH_ASSOC);


  $cntaact = "SELECT * FROM evalactreg WHERE folio ='$folio' ORDER BY reg_act";
  $resact = $conexion->prepare($cntaact);
  $resact->execute();
  $dataact = $resact->fetchAll(PDO::FETCH_ASSOC);



  /*
  $consulta2 = "SELECT id_etapa,nom_etapa FROM etapa WHERE id_nivel='" . $id_nivel . "' order by id_etapa";
  $resultado2 = $conexion->prepare($consulta2);
  $resultado2->execute();
  $data2 = $resultado2->fetchAll(PDO::FETCH_ASSOC);


  $consulta3 = "SELECT id_instructor,instructor FROM vlistas WHERE id_alumno='" . $id . "' and status=1 and estado=1 and id_act=0 group by id_alumno,id_instructor order by instructor";
  $resultado3 = $conexion->prepare($consulta3);
  $resultado3->execute();
  $data3 = $resultado3->fetchAll(PDO::FETCH_ASSOC);
*/



  $consulta4 = "SELECT * FROM evalgeneral where id_alumno='" . $id . "' and id_nivel='" . $id_nivel . "' and id_etapa='" . $id_etapa . "' and activo='1' limit 1";
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
                    <h5 class="modal-title" id="exampleModalLabel">Información del Alumno</h5>
                  </div>
                  <form id="formPersonas" action="" method="POST">
                    <div class="modal-body row justify-content-between" style="padding-bottom:0px">
                      <div class="col-sm-3">
                        <label for="folio" class="col-form-label">Folio:</label>
                        <input type="text" class="form-control" name="folio" id="folio" value="<?php echo $folio; ?>">
                      </div>
                      <div class="col-sm-3">
                        <label for="fecha" class="col-form-label">Fecha:</label>
                        <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $fecha; ?>">
                      </div>
                    </div>
                    <div class="modal-body row " style="padding-top:0px">

                      <div class="col-sm-12">
                        <label for="nombre" class="col-form-label">Nombre:</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo $nom_alumno; ?>" disabled>

                        <input type="hidden" class="form-control" name="id" id="id" value="<?php echo $id; ?>">
                      </div>

                      <div class="col-sm-4">

                        <label for="nivel" class="col-form-label">Nivel:</label>
                        <input type="text" class="form-control" name="nivel" id="nivel" value="<?php echo $nom_nivel; ?>" disabled>

                        <input type="hidden" class="form-control" name="id_nivel" id="id_nivel" value="<?php echo $id_nivel; ?>" disabled>
                      </div>
                      <div class="col-sm-4">

                        <label for="etapa" class="col-form-label">Etapa:</label>
                        <input type="text" class="form-control" name="etapa" id="etapa" value="<?php echo $nom_etapa; ?>" disabled>
                      </div>

                      <div class="col-sm-4">
                        <label for="instructor" class="col-form-label">Instructor:</label>
                        <input type="text" class="form-control" name="instructor" id="instructor" value="<?php echo $nom_instructor; ?>" disabled>

                      </div>

                      <div class="col-sm-12">
                        <div class="content" role="document">
                          <div class="content">
                            <br>

                            <div class="container">

                              <div class="row">
                                <div class="col-lg-12">
                                  <div class="card-header bg-gradient-blue">

                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                      <button id="btnAddObj" name="btnAddObj" type="button" class="btn bg-success btn-sm">
                                        <i class="fas fa-plus-square"></i>
                                      </button>
                                    </div>

                                    <h1 class="card-title "> Objetivos a Evaluar</h1>


                                  </div>
                                  <div class=" table-sm table-condensed table-responsive table-striped table-bordered">
                                    <table class="table" id="tablaObj">
                                      <thead>
                                        <tr>
                                          <th>REG</th>
                                          <th class="text-center"><strong>ID</strong></th>
                                          <th class="text-center"><strong>OBJETIVO</strong></th>
                                          <th>ACCIONES</th>
                                        </tr>
                                      </thead>

                                      <tbody id="tbody">
                                        <?php
                                        foreach ($dataobj as $dtobj) {

                                        ?>
                                          <tr>
                                            <td><?php echo $dtobj['registro'] ?></td>
                                            <td><?php echo $dtobj['id_objetivo'] ?></td>
                                            <td><?php echo $dtobj['descripcion'] ?></td>
                                            <td></td>
                                          </tr>
                                        <?php
                                        }
                                        ?>
                                      </tbody>
                                    </table>
                                  </div>
                                </div>
                                <div class="col-lg-12">
                                  <div class="card-header bg-gradient-blue">

                                    <div class="card-tools" style="margin:0px;padding:0px;">

                                      <button id="btnAddActividad" name="btnAddActividad" type="button" class="btn bg-success btn-sm">
                                        <i class="fas fa-plus-square"></i>
                                      </button>
                                    </div>

                                    <h1 class="card-title ">Actividades</h1>


                                  </div>

                                </div>
                                <div class="table-sm table-condensed mx-auto" style="width:98%;">
                                  <table class="table" id="tablaActividad">
                                    <thead>
                                      <tr>
                                        <th class="text-center"><strong>ID</strong></th>
                                        <th class="text-center"><strong>DESCRIPCION</strong></th>
                                        <th></th>
                                      </tr>
                                    </thead>

                                    <tbody id="tbodyact">
                                      <?php
                                      foreach ($dataact as $dtact) {

                                      ?>
                                        <tr>
                                          <td><?php echo $dtact['reg_act'] ?></td>
                                          <td>
                                            <li><?php echo $dtact['actividad'] ?>
                                            </li>
                                          </td>
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

                  </form>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary" onclick="window.location.href='cntaalumno.php'"><i class="fas fa-backward"></i> Regresar</button>
                  <button type="button" id="btnGuardar" name="btnGuardar" class="btn btn-success" ><i class="fas fa-save"></i> Guardar</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>



  <section>
    <div class="container">

      <!-- Default box -->
      <div class="modal fade" id="modalObj" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content w-auto">
            <div class="modal-header bg-gradient-primary">
              <h5 class="modal-title" id="exampleModalLabel">Ojetivos a Evaluar</h5>

            </div>
            <br>
            <div class="table-hover responsive w-auto " style="padding:10px">
              <table name="tablabuscarobj" id="tablabuscarobj" class="table table-sm table-striped table-bordered table-condensed" style="width:100%">
                <thead class="text-center">
                  <tr>
                    <th>ID</th>
                    <th>OBJETIVO</th>
                    <th>SELECCIONAR</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  foreach ($data4 as $dtesp) {
                  ?>
                    <tr>
                      <td><?php echo $dtesp['id_objetivo'] ?></td>
                      <td><?php echo $dtesp['desc_objetivo'] ?></td>
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
        <!-- /.card-body -->

        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </div>
  </section>

  <section>
    <div class="modal fade" id="modalactividad" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog " role="document">
        <div class="modal-content">
          <div class="modal-header bg-gradient-primary">
            <h5 class="modal-title" id="exampleModalLabel">AGREGAR ACTIVIDAD</h5>

          </div>
          <div class="card card-widget" style="margin: 10px;">
            <form id="formotro" action="" method="POST">
              <div class="modal-body row">
                <div class="col-sm-12">
                  <div class="form-group input-group-sm">
                    <label for="actividad" class="col-form-label">Actividad:</label>
                    <textarea name="actividad" id="actividad" class="form-control" rows="4" placeholder="Descripción de la Actividad"></textarea>

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
            <button type="button" id="btnguardaractividad" name="btnguardaractividad" class="btn btn-success" value="btnguardaractividad"><i class="far fa-save"></i> Agregar</button>
          </div>
          </form>
        </div>
      </div>
    </div>
  </section>

</div>







<?php require_once('templates/footer.php') ?>
<script src="fjs/regevaluacion.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/sweetalert2/sweetalert2.all.min.js"></script>