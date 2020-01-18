/**
 *     ___ _    __   ____            _
 *    /   | |  / /  / __ \___  _____(_)____ ____
 *   / /| | | / /  / / / / _ \/ ___/ / __ `/ __ \
 *  / ___ | |/ /  / /_/ /  __(__  ) / /_/ / / / /
 * /_/  |_|___/  /_____/\___/____/_/\__, /_/ /_/
 *                                 /____/
 * ------------ By Anselmo Velame ---------------
 *
 * Sistma Administrativo
 * Images Colors
 *
 */
;(function($)
{
    /**
     * Peview Image
     * @param int id
     * @param int width
     */
    preview_image = function(arq,prev,width)
    {
        $('#'+prev).html("");
        var total_file=document.getElementById(arq).files.length;
        for(var i=0;i<total_file;i++)
        {
            $('#'+prev).append('<img src="'+URL.createObjectURL(event.target.files[i])+'" width="'+width+'">');
        }
    };


    /**
     * Date: 06/06/2019
     *
     * @param int id
     * @param string url
     * @param int sta
     * @param int cover
     * @param string token
     */
    statusColor = function(id, url, sta, cover, token)
    {
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN':token},
            dataType: "json",
            url: url,
            data: {_method:'put', 'active':sta},
            success: function(data){
                if(data.success == true){
                    if ( typeof data.alert !== "undefined" && data.alert ) {
                        $.modal.alert(data.alert);
                    };
                    $("#btns-"+id).html(data.html);
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                ajaxFormError(xhr);
            }
        });
    };

    /**
     * Remove image color.
     * @param int id
     * @param string url
     */

    deleteColor = function(id, url)
    {

        $.modal.confirm(tableProduct.txtConfirm+' '+name+'?', function() {
            $.ajax({
                type: 'DELETE',
                dataType: "json",
                url: url,
                headers: {'X-CSRF-TOKEN': tableProduct.token},
                success: function (data) {
                    if (data.success == true) {
                        if ( typeof data.alert !== "undefined" && data.alert ) {
                            $.modal.alert(data.alert);
                        };
                        if (data.reload == true) {
                            tableAjaxReload();
                        } else {
                            $("#img-colors-" + id).remove();
                        }
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function (xhr) {
                    ajaxFormError(xhr);
                }
            });
        }, function(){
            $.modal.alert(tableProduct.txtCancel);
        });


    };



    $("body").on("click","#btn-colors",function(e){
        $(this).parents("#form-colors").ajaxForm(opc_colors);
    });
    var opc_colors = {
        beforeSend: function() {
            setBtn(1,tableProduct.txtLoader,false,'loader disbeled','submit-colors','btn-colors');
        },
        success: function(data) {
            if (data.success == true) {
                if (data.ac == 'create') {
                    $('input[name="img[code]"]').val(data.code);
                    $('input[name="img[color]"]').val('');
                    $('input[name="img[html]"]').val('');
                    $('#barvadiv' ).attr('style', 'margin-top:2px;width:100px;height:100px;');
                    $("#uploadCanvas").val('');

                    // change radio cover
                    var idpro = $("#cover_id").val();

                    $("#load_cover_"+idpro).html('<label for="img_cover_'+idpro+'_1" class="button green-active">'+
                        '<input type="radio" name="img[cover]" id="img_cover_'+idpro+'_1" value="1">'+
                        tableProduct.txtYes+
                        '</label>'+
                        '<label for="img_cover_'+idpro+'_2" class="button red-active" >'+
                        '<input type="radio" name="img[cover]" id="img_cover_'+idpro+'_2" value="0" checked>'+
                        tableProduct.txtNot+
                        '</label>');

                    // reset group clors
                    $(".color").removeAttr('data-selected');
                    $("#group-colors-"+idpro).html('<span class="groups"></span>');

                    var order = $('input[name="img[order]"]').val(),
                        sum_order = parseFloat(order)+1;
                    $('input[name="img[order]"]').val(sum_order);

                    $('input[name="pos[order]"]').val('1');

                    var count_colors = $("#count_colors").html(),
                        total_colors = parseFloat(count_colors)+1;
                    $("#count_colors").html(total_colors);

                    // ability tab #tab-positions
                    nextTabs('new-product','show-positions', true);
                    $("#insert_color").html('<input name="pos[image_color_id]" type="hidden" value="'+data.id+'">'+
                        '<input name="pos[name]" type="hidden" value="'+data.name+'">'+
                        '<input name="pos[color]" type="hidden" value="'+data.color+'">'+
                        '<input name="pos[code]" type="hidden" value="'+data.code+'">');

                    setBtn(1,tableProduct.txtNext,true,'icon-forward','submit-colors','btn-colors');
                    tableAjaxReload();
                };

                if (data.ac == 'add') {
                    var count_colors = $("#count_colors").html(),
                        total_colors = parseFloat(count_colors)+1;
                    $("#count_colors").html(total_colors);

                    $("#gallery-colors-"+data.product_id).prepend(data.html);
                    fechaModal();
                }

                if (data.ac == 'update') {
                    $("#img-colors-"+data.id).html(data.html);
                    fechaModal();
                }

                msgNotifica(true, data.message, true, false);
            } else {
                msgNotifica(false, data.message, true, false);
                setBtn(1,tableProduct.txtSave,true,'icon-tick','submit-colors','btn-colors');
            }
        },
        error: function(xhr)
        {
            ajaxFormError(xhr);
            setBtn(1,tableProduct.txtSave,true,'icon-tick','submit-colors','btn-colors');
        }
    };

})(jQuery);