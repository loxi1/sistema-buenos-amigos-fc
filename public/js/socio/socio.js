$(document).on('click','.versocio', function() {
    var tis = $(this)
    var pad = tis.parents('tr')
    var socioid = pad.attr('socioid')
    
    var nomb = pad.find('td.tdnombres').html()
    var apel = pad.find('td.tdapellidos').html()
    $('#nombreCompleto').val(nomb+', '+apel)
    var precio = 0
    var idti = parseInt(pad.find('td.tdtiposocio').attr('tipsocio'))
    
    idti = idti > 0 ? idti : 0
    
    if(idti > 0)
    {
        if($('.precio_'+idti).length)
        {
            precio = $('.precio_'+idti).val()
        }
    }
    $('#precio').val(precio)
    $('select[name=tiposocios_id]').val(idti)
    $('#socio_id').val(socioid)
});

$(document).on('click','.editarsocio', function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var idtipo = $('select[name=tiposocios_id]').val();
    var socioid = parseInt($('#socio_id').val())
    socioid = socioid > 0 ? socioid : 0
    idtipo = idtipo > 0 ? idtipo : 0
    console.log(socioid)
    if(socioid > 0 && idtipo>0)
    {   
        var $post = {};
        $post.socioid = socioid;
        $post._token = _token;
        
        var txtipo = $( "select[name=tiposocios_id] option:selected" ).text();
        var precio = $('.precio_'+idtipo).val()
        $('#tr_'+socioid).find('td.tdtiposocio').attr({'tdtiposocio':idtipo})
        $('#tr_'+socioid).find('td.tdtiposocio').html(txtipo)
        $('#tr_'+socioid).find('td.tdprecio').html(precio)
        var envia = socioid+'~'+$('select[name=tiposocios_id]').val()
        $.ajax({
            type: "POST",
            data: $post,
            url: '/socios/'+socioid+'/updatesocio',
            success: function (response) {
                if(response.estado == 1)
                {
                    $('#editar_socio').modal('hide')
                    Toast.fire({
                        icon: 'success',
                        title: response.mensaje
                    })
                }
            }
        });
    }
    else{
        Toast.fire({
            icon: 'error',
            title: "Seleccionar Tipo de Socio"
        })
    }
});

$(document).on('change','#edit_socio select', function() {
    var id = parseInt($(this).val())
    id = id > 0 ? id : 0
    var precio = ''
    if(id > 0)
    {
        precio = $('.precio_'+id).val()
    }
    $('#precio').val(precio)
});