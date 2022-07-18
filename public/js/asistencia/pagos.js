$(function () {
    var arbit = parseInt($('#arbitro').val())
    if(arbit >0)
        $('#precioArbitro').val($('.precios_'+arbit).val())
})

$(document).on('change','#arbitro', function() {
    var arbit = parseInt($(this).val())
    
    if(arbit >0)
    {
        $('#precioArbitro').val($('.precios_'+arbit).val())
        var canth = parseFloat($('#cantidahora_').val())
        var preci = parseFloat($('#precioArbitro').val())

        if(preci>0 && canth>0)          
            $('#precioTotal').val(canth*preci)
    }
});

$(document).on('change','#cancha', function() {
    var cancha = parseInt($(this).val())
    console.log(cancha)
    if(cancha >0)
    {
        $('#precioCancha').val($('.precioscancha_'+cancha).val())
        var canth = parseFloat($('#cantidahora_').val())
        var preci = parseFloat($('#precioCancha').val())

        if(preci>0 && canth>0)          
            $('#precioTotalc').val(canth*preci)
    }
});

$(document).on('focusout','#cantidahora_', function() {
    var canth = parseFloat($(this).val())
    var preci = parseFloat($('#precioArbitro').val())
    var precic = parseFloat($('#precioCancha').val())
    if(canth >0)
    {
        if(preci>0)
            $('#precioTotal').val(canth*preci)
        
        if(precic>0)
            $('#precioTotalc').val(canth*precic)
    }
});