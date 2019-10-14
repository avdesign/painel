;(function($, undefined) { 
   
    var bar = $('.progress-bar');
    var percent = $('.progress-text');
    var retorno = $('#message');       
    $('#uploadimage').ajaxForm({
        beforeSend: function() {
            $('#image_preview').css("display", "block");
            $('#submit').hide(); 
            $("#retorno").empty();
            $('#loading').show();
            retorno.empty();
            var percentVal = '0%';
            bar.width(percentVal)
            percent.html(percentVal);
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar.width(percentVal)
            percent.html(percentVal);
            //console.log(percentVal, position, total);
        },
        success: function(response) {
            $('#img-'+response.id).hide();
            var percentVal = '100%';
            bar.width(percentVal)
            percent.html(percentVal);
            if(response.success == true){
                if (response.ac == 'alterar') {
                    $("#box-form").load(base+response.url_retorno);
                } else {
                    (response.status == 1 ? cor = 'green-gradient' : cor = 'red-gradient');
                    $('#loading').hide();
                    $('#image_preview').html("");
                    $(".gallery").append('<li id="img-'+response.id+'">'+
                        '<img src="'+base+'/'+response.src+'" class="framed">'+
                        '<div class="controls">'+
                            '<span id="btns-'+response.id+'" class="button-group compact children-tooltip">'+
                                "<button onclick=\"statusImg('"+response.idm+"', '"+response.tipo+"', '"+response.id+"', '"+response.status+"', '"+response.token+"')\" class=\"button icon-tick "+cor+"\" title=\"Alterar Status\"></button>"+
                                "<button onclick=\"alterarImg('"+response.tipo+"', '"+response.id+"')\" class=\"button\" title=\"Alterar Imagem\">Editar</button>"+
                                "<button onclick=\"excluirImg('"+response.idm+"', '"+response.tipo+"', '"+response.id+"', '"+response.token+"')\" class=\"button icon-trash red-gradient\" title=\"Excluir Imagem\"></button>"+
                            '</span>'+
                        '</div>'+
                    '</li>');
                };
            } else {
                $('#loading').hide();
                msgNotifica(false, response.message, true, false);
            }
        },
        complete: function(xhr) {
            retorno.html(xhr.responseText);
        },
        error: function(xhr){
            $('#submit').show();
            $('#loading').hide();
            msgNotifica(false, xhr.responseText, true, false);
        }
    }); 
})(jQuery); 