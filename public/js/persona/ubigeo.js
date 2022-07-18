$(function() {
    var iddocu = parseInt($('#tipo_documentos_id').val())
    if(iddocu >0)
    {
        var cantdigitos = parseInt($('.digitos_'+iddocu).val());
        if(cantdigitos>0)
        {
            $('#numero_documento').attr({'maxlength':cantdigitos})
        }                    
    }
    /*$('#departamentos_id').prepend('<option value="">SELECCIONE DEPARTAMENTO</option>');
    $('#provincias_id').prepend('<option value="">SELECCIONE PROVINCIA</option>');
    $('#distritos_id').prepend('<option value="">SELECCIONE DISTRITO</option>');*/
});
$(document).on('change','#tipo_documentos_id', function() {
    var iddocu = parseInt($(this).val())
    if(iddocu >0)
    {
        var cantdigitos = parseInt($('.digitos_'+iddocu).val());
        if(cantdigitos>0)
        {
            $('#numero_documento').attr({'maxlength':cantdigitos})
        }                    
    }
});
$(document).on('change','#departamentos_id', function() {
    var depaid = $(this).val()
    $('#provincias_id').empty();
    $('#distritos_id').empty();
    if($.trim(depaid) != '')
    {
        $('#provincias_id').html('<option value="">SELECCIONE PROVINCIA</option>');
        $('#distritos_id').html('<option value="">SELECCIONE DISTRITO</option>');
        
        $.ajax({
            type: "GET",
            url: '/personas/'+depaid+'/obtenerprovincia',
            success: function (response) {
                for (var i=0; i<response.rta.length; i++)
                {
                    $('#provincias_id').append('<option value="'+response.rta[i].id+'">'+response.rta[i].provincias+'</option>');
                }
            }
        });
    }
});
$(document).on('change','#provincias_id', function() {
    var depaid = $(this).val()
    $('#distritos_id').empty();
    if($.trim(depaid) != '')
    {
        $('#distritos_id').html('<option value="">SELECCIONE DISTRITO</option>');
        
        $.ajax({
            type: "GET",
            url: '/personas/'+depaid+'/obtenerdistrito',
            success: function (response) {
                for (var i=0; i<response.rta.length; i++)
                {
                    $('#distritos_id').append('<option value="'+response.rta[i].id+'">'+response.rta[i].distritos+'</option>');
                }
            }
        });
    }
});