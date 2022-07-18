$(document).on('click','.eliminar', function() {
    var tis = $(this)
    var pad = tis.parents('tr')
    var arbitroid = pad.attr('arbitroid')
    var precio = parseFloat(pad.find('td.tdprecio').html())    
    precio = precio > 0 ? precio : 0
    let _token   = $('meta[name="csrf-token"]').attr('content')
    var $post = {};
    $post._token = _token;

    if(precio && arbitroid)
    {
        Swal.fire({
            title: '¿Esta seguro de ELIMINAR?',
            text: "No podrás revertir esto.!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, Eliminar!'
        }).then((result) => {

            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    data: $post,
                    url: '/arbitros/'+arbitroid+'/updatearbitro',
                    success: function (response) {
                        if(response.estado == 1)
                        {
                            Swal.fire(
                                'Elimino!',
                                'El socio fue eliminado.',
                                'success'
                            )
                            window.location.reload();
                        }
                    }
                });
            }
        })
    }
    
});

$(document).on('click','.verarbitro', function() {
    var tis = $(this)
    var pad = tis.parents('tr')
    var arbitroid = pad.attr('arbitroid')
    
    var nomb = pad.find('td.tdnombres').html()
    var apel = pad.find('td.tdapellidos').html()
    $('#nombrecompleto').html(nomb+', '+apel)
    var precio = parseFloat(pad.find('td.tdprecio').html())    
    
    precio = precio > 0 ? precio : 0
    
    if(precio > 0)
    {
        $('#precio').val(precio)
    }
    
    $('#precio').val(precio)    
    $('#arbitro_id').val(arbitroid)
});

$(document).on('click','.editararbitro', function() {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });
    let _token   = $('meta[name="csrf-token"]').attr('content');
    var precio = $('#precio').val();
    var arbitroid = parseInt($('#arbitro_id').val())

    arbitroid = arbitroid > 0 ? arbitroid : 0
    precio = precio > 0 ? precio : 0
    
    if(arbitroid > 0 && precio>0)
    {   
        var $post = {};
        $post.precio = precio;
        $post.estado = 1;
        $post._token = _token;
        
        $.ajax({
            type: "POST",
            data: $post,
            url: '/arbitros/'+arbitroid+'/updatearbitro',
            success: function (response) {
                if(response.estado == 1)
                {
                    $('#editar_arbitro').modal('hide')
                    $('#tr_'+arbitroid).find('td.tdprecio').html(precio)
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
            title: "Ingresar Precio"
        })
    }
});

