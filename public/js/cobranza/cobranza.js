$(function () {
    $('#reservationdate').datetimepicker({
        format: 'L',
        locale: 'es',
        maxDate: moment(),
    });
})

$(document).on('click', '.savecuentaxcobrar', function(){
    var fecha = $('#reservationdate .datetimepicker-input').val()
    var idi = parseFloat($('#idcuentaxcob').val())
    var monto = parseFloat($('#monto_pagar').val())
    
    $('#formulariopagar').removeClass('d-none')
    $('#cont_cobranza').removeClass('d-none')
    $('#secobrotxt').addClass('d-none')
    var clas = 'error'

    if(idi>0)
    {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        if($.trim(fecha) != '' && fecha.length)
        {
            rta = validar_monto()
            if(rta['estado'])
            {
                var canttd = parseInt($('#tabla_cobros tbody tr td.fechai').length)
                canttd = canttd > 0 ? canttd : 0
                canttd++
                var html = ''

                var $post = {};
                $post._token = $('meta[name="csrf-token"]').attr('content');
                $post._fecha = datetoing(fecha);
                $post._monto = monto;
                $.ajax({
                    type: "POST",
                    data: $post,
                    url: '/cuentasxcobrarinscripciones/'+idi+'/savecobroinscripcion',
                    success: function (response) {                            
                        if(response.estado == 1)
                        {
                            clas = 'success'
                            html = '<tr><td class="fechai">'+response.data.fecha_ingreso+'</td><td>'+monto+'</td></tr>';
                            if(canttd == 1)
                            {
                                $('#tabla_cobros tbody').html(html)
                            }
                            else
                            {
                                $('#tabla_cobros tbody').append(html)
                            }

                            if(response.data.cobranzaestados_id == 4)
                            {
                                $('#formulariopagar').addClass('d-none')
                                $('#secobrotxt').removeClass('d-none')
                                $('#tr_'+idi+' td.btncobranza').html('<button tipo="b" type="button" class="btn btn-sm btn-info vercuentaxcobrar" data-toggle="modal" data-target="#pagarcuentas"><i class="fas fa-eye"></i> Ver</button>')
                            }

                            $('#monto_pagar').attr({'max':response.data.monto_pendiente})
                            $('#elmax').html(response.data.monto_pendiente)
                            $('#monto_pagar').val('')
                            $('#reservationdate .datetimepicker-input').val('')

                            $('#tr_'+idi+' td.estadocobros').html(response.data.estadocobros)
                            $('#tr_'+idi+' td.mcobrado').html(response.data.monto_cobrado)
                            $('#tr_'+idi+' td.mpendiente').html(response.data.monto_pendiente)                                
                        }
                        Toast.fire({
                            icon: clas,
                            title: response.mensaje
                        })
                    }
                });
            }
            else
            {
                Toast.fire({
                    icon: 'error',
                    title: rta.mensaje
                })
                $('#monto_pagar').focus()
            }
        }
        else
        {
            Toast.fire({
                icon: 'error',
                title: 'Agregar Fecha ingreso'
            })
            $('#reservationdate input').focus()
        }
    }
})

$(document).on('click', '.vercuentaxcobrar', function(){
    var tis = $(this)
    var pad = tis.parents('tr')
    var idi = parseInt(pad.attr('cuentasxcobrarinscripcionid'))
    var nomb = pad.find('.nombrecompleto').html()
    var tipo = tis.attr('tipo')
    var titulomodal = 'Cobrar'
    if(tipo == 'a')
    {
        $('#formulariopagar').removeClass('d-none')
        $('#cont_cobranza').removeClass('d-none')
        $('#secobrotxt').addClass('d-none')
    }
    else
    {
        $('#cont_cobranza').addClass('d-none')
        $('#secobrotxt').addClass('d-none')
        titulomodal = "Ver"
    }
    $('#titulomodal').html(titulomodal)
    $('#elnombrecomp').html(nomb)
    if(idi >0)
    {
        $('#idcuentaxcob').val(idi)
        var $post = {};
        $post._token = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            type: "POST",
            data: $post,
            url: '/cuentasxcobrarinscripciones/'+idi+'/vercuentaxcobrar',
            success: function (response) {
                if(response.estado == 1)
                {
                    $('#monto_pagar').attr({'max':response.data.cue.monto_pendiente})
                    $('#elmax').html(response.data.cue.monto_pendiente)
                    $('#tabla_cobros tbody').html(response.data.html)
                }
            }
        });
    }
})

$(document).on('focusout','#monto_pagar', function() {
    var rta = validar_monto()
    console.log(rta)
    if(!rta['estado'])
    {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        
        Toast.fire({
            icon: 'error',
            title: rta['mensaje']
        })
    }
});

function validar_monto()
{
    var monto = parseFloat($('#monto_pagar').val())
    var max = parseFloat($('#elmax').html())
    var rta = []
    rta['estado']=0;
    rta['mensaje']='Monstos mayor a 0'
    if(monto >0 && max>0)
    {
        if(max >=monto)
        {
            rta['estado']=1;
            rta['mensaje']='Valores correctos'             
        }
        else
        {
            rta['mensaje'] = 'Corregir la cantidad debe se menor al Monto Pendiente'
        }
    }
    return rta
}

function datetoing(fec)
{
    var fec = fec.split("/");
    var fe_in = new Date(fec[2], fec[1] - 1, fec[0]);
    return moment(fe_in).format("YYYY-MM-DD");
}