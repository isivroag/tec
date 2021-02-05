$(document).ready(function() {
    var id, opcion;
    opcion = 4;

    tablaVis = $("#tablaV").DataTable({
        columnDefs: [{
            targets: -1,
            data: null,
            defaultContent: "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button><button class='btn btn-sm bg-success btnCerrar' data-toggle='tooltip' data-placement='top' title='Cerrar'><i class=' text-light fas fa-check-circle'></i></button><button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-ban'></i></button></div>",
        }, { className: "hide_column", "targets": [5] }],

        //Para cambiar el lenguaje a español
        language: {
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
            sProcessing: "Procesando...",
        },
    });
    $('[data-toggle="tooltip"]').tooltip();

    $("#btnNuevo").click(function() {
        //window.location.href = "prospecto.php";
        $("#formDatos").trigger("reset");

        $(".modal-header").css("background-color", "#28a745");
        $(".modal-header").css("color", "white");
        $("#modalCRUD").modal("show");
        id = null;
        opcion = 1; //alta
        var today = new Date();
        var date = today.getFullYear() + "-" + (today.getMonth() + 1) + "-" + today.getDate();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        var dateTime = date + " " + time;
        $("#inicio").val(dateTime);
        $("#fin").val(dateTime);
        $("#costo").val(0);
        $('#estado').removeClass('bg-success');
        $('#estado').removeClass('bg-primary');
        $('#estado').removeClass('bg-danger');

    });

    var fila; //capturar la fila para editar o borrar el registro

    //botón EDITAR
    $(document).on("click", ".btnEditar", function() {
        fila = $(this).closest("tr");
        folio = parseInt(fila.find("td:eq(0)").text());

        //window.location.href = "actprospecto.php?id=" + id;
        inicio = fila.find("td:eq(2)").text();
        fin = fila.find("td:eq(3)").text();
        cliente = fila.find("td:eq(1)").text();
        descripcion = fila.find("td:eq(4)").text();
        costo = fila.find("td:eq(5)").text();
        estado = fila.find("td:eq(6)").text();

        $("#cliente").val(cliente);
        $("#inicio").val(inicio);
        $("#fin").val(fin);
        $("#folio").val(folio);
        $("#costo").val(costo);
        $("#descripcion").val(descripcion);
        $("#estado").val(estado);
        console.log(estado);

        /**/
        $('#estado').removeClass('bg-success');
        $('#estado').removeClass('bg-primary');
        $('#estado').removeClass('bg-danger');

        /* if ($.trim(estado) == 'Abierto') {
             $('#estado').addClass('bg-success');
         } else {
             $('#estado').addClass('bg-primary');
         }*/

        switch ($.trim(estado)) {
            case 'Abierto':
                $('#estado').addClass('bg-success');
                break;

            case 'Cerrado':
                $('#estado').addClass('bg-primary');
                break;
            case 'Cancelado':
                $('#estado').addClass('bg-danger');
                break;
            default:
                $('#estado').removeClass('bg-success');
                $('#estado').removeClass('bg-primary');
                $('#estado').removeClass('bg-danger');
        }

        opcion = 2; //editar

        $(".modal-header").css("background-color", "#007bff");
        $(".modal-header").css("color", "white");
        $(".modal-title").text("Editar Partida");
        $("#modalCRUD").modal("show");
    });

    //botón BORRAR
    $(document).on("click", ".btnBorrar", function() {
        fila = $(this);

        id = parseInt($(this).closest("tr").find("td:eq(0)").text());
        opcion = 3; //borrar

        //agregar codigo de sweatalert2
        var respuesta = confirm(
            "¿Está seguro de eliminar el registro: " + id + "?"
        );

        console.log(id);
        console.log(opcion);
        if (respuesta) {
            $.ajax({
                url: "bd/crudpartida.php",
                type: "POST",
                dataType: "json",
                data: { id: id, opcion: opcion },

                success: function(data) {
                    console.log(fila);

                    tablaVis.row(fila.parents("tr")).remove().draw();
                },
            });
        }
    });


    $("#formDatos").submit(function(e) {
        e.preventDefault();
        opcion = 1;
        var inicio = $("#inicio").val();
        var fin = $("#fin").val();
        var cliente = $("#cliente").val();
        var descripcion = $("#descripcion").val();
        var costo = $("#costo").val();
        var usuario = $("#nameuser").val();


        if (cliente.length == 0) {
            Swal.fire({
                title: 'Datos Faltantes',
                text: "Debe ingresar todos los datos del Cliente",
                icon: 'warning',
            })
            return false;
        } else {
            $.ajax({
                url: "bd/crudticket.php",
                type: "POST",
                dataType: "json",
                data: { inicio: inicio, fin: fin, cliente: cliente, descripcion: descripcion, costo: costo, usuario: usuario, opcion: opcion },
                success: function(data) {


                    //tablaPersonas.ajax.reload(null, false);


                    tfolio = data[0].folio_ti;
                    tcliente = data[0].cliente_ti;
                    tinicio = data[0].apertura_ti;
                    tfin = data[0].clausura_ti;
                    tdescripcion = data[0].descripcion_ti;
                    tcosto = data[0].costo_ti;
                    testado = data[0].estado_ti;
                    if (testado == 1) {
                        testado = "<span class='bg-success'> Abierto </span>";
                    } else if (testado == 2) {
                        testado = "<span class='bg-primary'> Cerrado </span>";
                    } else {
                        testado = "<span class='bg-danger'> Cancelado </span>";
                    }

                    if (opcion == 1) {
                        tablaVis.row.add([tfolio, tcliente, tinicio, tfin, tdescripcion, testado]).draw();
                    } else {
                        tablaVis.row(fila).data([tfolio, tcliente, tinicio, tfin, tdescripcion, testado]).draw();
                    }
                }
            });
            $("#modalCRUD").modal("hide");
        }
    });

});