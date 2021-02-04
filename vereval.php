<?php $pagina = "evaluacion";
include_once "templates/header.php";
include_once "templates/barra.php";
include_once "templates/navegacion.php";
include_once 'bd/conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

if (isset($_GET['id_alumno'])) {

    $id_alumno = $_GET['id_alumno'];
    $alumno = "";
    $id_nivel = "";
    $nivel = "";
    $agrupador = "";
    $id_etapa = "";

    $cntavinculo = "SELECT alumno.id_alumno, alumno.nombre 
    FROM alumno where id_alumno='$id_alumno'";
    $resvinculo = $conexion->prepare($cntavinculo);
    $resvinculo->execute();
    $datavinculo = $resvinculo->fetchAll(PDO::FETCH_ASSOC);
    if ($resvinculo->rowCount() >= 1) {
        foreach ($datavinculo as $dtvin) {

            $alumno = $dtvin['nombre'];
        }
    }

    //BUSCAR EL NIVEL Y LOS OBJETIVOS DEL ALUMNO EN LA TABLA EVALUACION DATOSEVAL


    $consulta = "SELECT datoseval.id_alumno,datoseval.id_instructor,
                datoseval.id_nivel,datoseval.id_etapa ,nivel.nivel,nivel.agrupador 
                FROM datoseval join nivel on datoseval.id_nivel =nivel.ID_NIVEL where datoseval.id_alumno='" . $id_alumno . "'";
    $resdatoseval = $conexion->prepare($consulta);
    $resdatoseval->execute();
    $datadatoseval = $resdatoseval->fetchAll(PDO::FETCH_ASSOC);
    if ($resdatoseval->rowCount() >= 1) {
        foreach ($datadatoseval as $dteval) {
            $id_alumno = $dteval['id_alumno'];
            $id_nivel = $dteval['id_nivel'];
            $nivel = $dteval['nivel'];
            $agrupador = $dteval['agrupador'];
            $id_etapa = $dteval['id_etapa'];
        }
    }

    //BUSCAR DE CUANTOS NIVELES ESTA CONFORMADO EL PROGRAMA DEL ALUMNO ACTUAL EN BASE
    // AL NIVEL DE DATOS EVAL

    $consulta = "SELECT * from nivel where agrupador='" . $agrupador . "' order by id_nivel";
    $resnivel = $conexion->prepare($consulta);
    $resnivel->execute();
    $datanivel = $resnivel->fetchAll(PDO::FETCH_ASSOC);

    if ($resnivel->rowCount() >= 1) {
        $nniveles = $resnivel->rowCount();
    } else {
        $nniveles = 0;
    }
} else {
    echo '<script type="text/javascript">';
    echo 'window.location.href="cntaalumno.php";';
    echo '</script>';
}
//BUSCAR AL ALUMNO POR MEDIO DE LA TABLA VINCULACION



?>





<div class="content-wrapper">


    <section class="content">
        <div class="card">
            <div class="card-header bg-gradient-blue">
                <div class="row justify-content-center">
                    <h4 class="card-title text-center"><span>ALUMNO: </span>
                        <bold><?php echo $alumno ?></bold>
                    </h4>
                </div>
            </div>
            <div class="card-body">
                <!-- TARJETA DE EVALUACION -->
                <div class="card color-palette-box">
                    <!--ENCABEZADO NOMBRE DEL ALUMNO Y NIVEL -->
                    <div class="card-header ">
                        <div class="row justify-content-between ">
                            <h3 class="card-title text-primary font-weight-bold">
                                <i class="fas fa-medal"></i>
                                EVALUACIÓN
                            </h3>
                            <h3 class="card-title text-primary font-weight-bold">
                                NIVEL ACTUAL: <span class="text-danger"> <?php echo $nivel . '/' . $id_etapa ?></span>
                            </h3>
                        </div>
                    </div>
                    <!--FIN DE ENCABEZADO -->

                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-lg-10">
                                <!-- CODIGO PARA DIBUJAR LA TARJETA NIVEL-->
                                <?php
                                //codigo para dibujar las tarjetas de los niveles
                                foreach ($datanivel as $dtnivel) {
                                    $nactual = $dtnivel['ID_NIVEL'];

                                    $sqletapa = "SELECT * FROM etapa where id_nivel='" . $nactual . "'";
                                    $resetapa = $conexion->prepare($sqletapa);
                                    $resetapa->execute();
                                    $dataetapa = $resetapa->fetchAll(PDO::FETCH_ASSOC);
                                    $niv = preg_replace('/[^0-9]/', '', $dtnivel['NCORTO']);




                                    $sqltotal = "SELECT * FROM evalgeneral where id_alumno='" . $id_alumno . "' and id_nivel='" . $nactual . "' and valor='1'";
                                    $restotal = $conexion->prepare($sqltotal);
                                    $restotal->execute();
                                    $totalpasados = $restotal->rowCount();

                                    $sqltot = "SELECT * FROM objetivo where id_nivel='" . $nactual . "'";
                                    $restot = $conexion->prepare($sqltot);
                                    $restot->execute();
                                    $totaletapa = $restot->rowCount();





                                    if ($niv <> 0) {
                                        $proporcion = round(($totalpasados / $totaletapa) * 100, 0);
                                        $textocolor = "";
                                        $bgcolor = "";
                                        switch ($niv) {
                                            case 1:
                                                $textocolor = "text-danger";
                                                $bgcolor = "bg-gradient-danger";
                                                break;
                                            case 2:
                                                $textocolor = "text-orange";
                                                $bgcolor = "bg-gradient-orange";
                                                break;
                                            case 3:
                                                $textocolor = "text-success";
                                                $bgcolor = "bg-gradient-success";
                                                break;
                                            case 4;
                                                $textocolor = "text-primary";
                                                $bgcolor = "bg-gradient-primary";
                                            default:

                                                break;
                                        }
                                ?>
                                        <div class="card shadow mb-4 ">
                                            <!-- TITULO DE TARJETA DE NIVEL Y CODIGO PARA DESPLEGAR -->
                                            <a href="#<?php echo $dtnivel['NCORTO']; ?>" class="d-block card-header py-3 <?php echo $bgcolor; ?> " data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                                <h5 class="m-0 font-weight-bold text-light "><?php echo $dtnivel['NIVEL']; ?></h5>
                                            </a>
                                            <!-- CONTENIDO DE LA TARJETA DE NIVEL -->
                                            <div class="<?php echo ($id_nivel == $nactual) ? 'collapsed' : 'collapse'; ?>" id="<?php echo $dtnivel['NCORTO']; ?>">

                                                <div class="card-body">
                                                    <?php

                                                    //empieza el if de contar las etapas
                                                    if ($resetapa->rowCount() >= 1) {
                                                        //si tiene etapas dibuja la progress bar

                                                    ?>
                                                        <!-- BARRA DE PROGRESO DEL NIVEL -->
                                                        <div class="progress rounded  progress-bar-striped  " style="height: 30px;">
                                                            <div class="progress-bar <?php echo $bgcolor; ?> " role="progressbar" aria-valuenow="<?php echo $proporcion; ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $proporcion . '%'; ?>">
                                                                <span class="center"><?php echo $proporcion . '% COMPLETADO'; ?></span>
                                                            </div>
                                                        </div>
                                                        <!-- FIN DE LA BARRA DE PROGRESO -->
                                                        <?php
                                                        foreach ($dataetapa as $dtetaoa) {
                                                            //CODIGO PARA BUSCAR LOS OBJETIVOS
                                                            $eactual = $dtetaoa['id_etapa'];


                                                        ?>
                                                            <!-- TITULO Y ENCABEZADO DE LA TARJETA DE ETAPA -->
                                                            <a href="#<?php echo $dtnivel['NCORTO'] . str_replace(' ', '', $dtetaoa['nom_etapa']); ?>" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="collapseCardExample">
                                                                <h6 class="m-0 font-weight-bold <?php echo $textocolor; ?>"><?php echo 'ETAPA ' . $dtetaoa['id_etapa']; ?></h6>
                                                            </a>

                                                            <!-- CONTENIDO DE LA TARJETA DE ETAPA -->
                                                            <div class="<?php echo (($id_nivel == $nactual) && ($id_etapa == $eactual)) ? 'collapsed' : 'collapse'; ?>" id="<?php echo $dtnivel['NCORTO'] . str_replace(' ', '', $dtetaoa['nom_etapa']); ?>">
                                                                <!-- INICIA LA TABLA DE OBJETIVOS DE LA ETAPA -->
                                                                <?php
                                                                $sqlobj = "SELECT * FROM evalgeneral where id_alumno='" . $id_alumno . "' and id_nivel='" . $nactual . "' and id_etapa='" . $eactual . "'";
                                                                $resobj = $conexion->prepare($sqlobj);
                                                                $resobj->execute();
                                                                $dataobj = $resobj->fetchAll(PDO::FETCH_ASSOC);
                                                                if ($resobj->rowCount() >= 1) {
                                                                ?>
                                                                    <div class="table-responsive table-striped table-bordered">
                                                                        <table class="table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class="text-center"><strong>OBJETIVO</strong></th>
                                                                                    <th class="text-center" style="width:10%"><strong>ESTADO</strong></th>
                                                                                </tr>
                                                                            </thead>

                                                                            <tbody>
                                                                                <?php
                                                                                foreach ($dataobj as $dtobj) {
                                                                                ?>

                                                                                    <tr>
                                                                                        <th style="color:#858796"><?php echo $dtobj['desc_objetivo']; ?></th>
                                                                                        <?php
                                                                                        if ($dtobj['valor'] == 1) {
                                                                                        ?>
                                                                                            <th class="text-center"><i class="fas fa-swimmer text-success"></i></th>
                                                                                        <?php
                                                                                        } else if ($dtobj['activo'] == 1) {
                                                                                        ?>
                                                                                            <th class="text-center"><i class="fas fa-swimmer text-warning"></i></th>
                                                                                        <?php
                                                                                        } else {
                                                                                        ?>
                                                                                            <th class="text-center"><i class="fas fa-swimmer text-grey"></i></th>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                    </tr>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>

                                                                <?php

                                                                }
                                                                ?>
                                                            </div>
                                                    <?php
                                                        }   // termina el foreach de las etapas
                                                    } // termina el if de contar las etapas
                                                    ?>
                                                    <!-- TERMINA LA TABLA -->
                                                </div>
                                            </div>
                                        </div>
                                        <!-- TERMINALA TARJETA -->
                                <?php

                                    }
                                    //termina codigo de dibujar las tarjetas de niveles foreach
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>


        </div><!-- /.container-fluid -->
    </section>
</div>

<?php require_once('templates/footer.php') ?>