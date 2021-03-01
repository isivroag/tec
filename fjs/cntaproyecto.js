$(document).ready(function () {
  var id, opcion,proyecto
  opcion = 4

  tablaVis = $('#tablaV').DataTable({
    columnDefs: [
      {
        targets: -1,
        data: null,
        defaultContent:
          "<div class='text-center'><button class='btn btn-sm btn-primary  btnEditar' data-toggle='tooltip' data-placement='top' title='Editar'><i class='fas fa-edit'></i></button><button class='btn btn-sm bg-orange btnbitacora' data-toggle='tooltip' data-placement='top' title='Bitacora'><i class=' text-light fas fa-list'></i></button><button class='btn btn-sm btn-danger btnBorrar' data-toggle='tooltip' data-placement='top' title='Borrar'><i class='fas fa-trash-alt'></i></button></div>",
      },
    ],

    //Para cambiar el lenguaje a español
    language: {
      lengthMenu: 'Mostrar _MENU_ registros',
      zeroRecords: 'No se encontraron resultados',
      info:
        'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
      infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
      infoFiltered: '(filtrado de un total de _MAX_ registros)',
      sSearch: 'Buscar:',
      oPaginate: {
        sFirst: 'Primero',
        sLast: 'Último',
        sNext: 'Siguiente',
        sPrevious: 'Anterior',
      },
      sProcessing: 'Procesando...',
    },
  })
  $('[data-toggle="tooltip"]').tooltip()

  $('#btnNuevo').click(function () {
    //window.location.href = "prospecto.php";
    $('#formDatos').trigger('reset')
    $('.modal-header').css('background-color', '#28a745')
    $('.modal-header').css('color', 'white')

    $('#modalCRUD').modal('show')
    id = null
    opcion = 1 //alta
  })

  $(document).on('click', '.btnbitacora', function () {
    $('#formBitacora').trigger('reset')
    $('.modal-header').css('background-color', '#28a745')
    $('.modal-header').css('color', 'white')

    var fecha = new Date() //Fecha actual
    var mes = fecha.getMonth() + 1 //obteniendo mes
    var dia = fecha.getDate() //obteniendo dia
    var ano = fecha.getFullYear() //obteniendo año
    if (dia < 10) dia = '0' + dia //agrega cero si el menor de 10
    if (mes < 10) mes = '0' + mes //agrega cero si el menor de 10
    document.getElementById('fecha').value = ano + '-' + mes + '-' + dia
    fila = $(this).closest('tr')
    proyecto = parseInt(fila.find('td:eq(0)').text())


    $('#modalBitacora').modal('show')
  })
  var fila //capturar la fila para editar o borrar el registro

  //botón EDITAR
  $(document).on('click', '.btnEditar', function () {
    fila = $(this).closest('tr')
    id = parseInt(fila.find('td:eq(0)').text())

    //window.location.href = "actprospecto.php?id=" + id;
    nombre = fila.find('td:eq(1)').text()

    $('#nombre').val(nombre)

    opcion = 2 //editar

    $('.modal-header').css('background-color', '#007bff')
    $('.modal-header').css('color', 'white')
    $('.modal-title').text('Editar Partida')
    $('#modalCRUD').modal('show')
  })

  //botón BORRAR
  $(document).on('click', '.btnBorrar', function () {
    fila = $(this)

    id = parseInt($(this).closest('tr').find('td:eq(0)').text())
    opcion = 3 //borrar

    //agregar codigo de sweatalert2
    var respuesta = confirm('¿Está seguro de eliminar el registro: ' + id + '?')

    console.log(id)
    console.log(opcion)
    if (respuesta) {
      $.ajax({
        url: 'bd/crudproyecto.php',
        type: 'POST',
        dataType: 'json',
        data: { id: id, opcion: opcion },

        success: function (data) {
          tablaVis.row(fila.parents('tr')).remove().draw()
        },
      })
    }
  })

  $(document).on('click', '#btnGuardarBit', function () {
 
    opcion = 1
    fecha = $('#fecha').val()
    tipo = $('#tipo').val()
    titulo = $('#titulo').val()
    descripcion = $('#descripcion').val()
    console.log(proyecto);
    console.log(titulo);
    console.log(fecha);
    console.log(tipo);
    console.log(descripcion);
    
    $.ajax({
      url: 'bd/crudbitacora.php',
      type: 'POST',
      dataType: 'json',
      data: {
        proyecto: proyecto,
        titulo: titulo,
        fecha:fecha,
        tipo: tipo,
        descripcion: descripcion,
        id: id,
        opcion: opcion,
      },

      success: function (data) {
        console.log(data);
        $('#modalBitacora').modal('hide')
      },
    })
  });

  $('#formDatos').submit(function (e) {
    e.preventDefault()
    var nombre = $.trim($('#nombre').val())

    if (nombre.length == 0) {
      Swal.fire({
        title: 'Datos Faltantes',
        text: 'Debe ingresar todos los datos la Partida',
        icon: 'warning',
      })
      return false
    } else {
      $.ajax({
        url: 'bd/crudproyecto.php',
        type: 'POST',
        dataType: 'json',
        data: { nombre: nombre, id: id, opcion: opcion },
        success: function (data) {
          //tablaPersonas.ajax.reload(null, false);
          id = data[0].id_proyecto
          nombre = data[0].nom_proyecto

          if (opcion == 1) {
            tablaVis.row.add([id, nombre]).draw()
          } else {
            tablaVis.row(fila).data([id, nombre]).draw()
          }
        },
      })
      $('#modalCRUD').modal('hide')
    }
  })
})
