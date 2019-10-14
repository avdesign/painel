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
 * Brands
 *
 */
;(function($, undefined)
{
        /**
         * Peview Image
         * @param int id
         * @param int width 
        */
        preview_image = function(id, width)
        {
            $('#image_preview_'+id).html("");
            var total_file=document.getElementById("upload_file").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#image_preview_'+id).append('<img src="'+URL.createObjectURL(event.target.files[i])+'" width="'+width+'">');
            }
            $("#btn-upload-submit").show();
        };



        /**
         * Status Image
         * @param int id
         * @param string url
         * @param string token
        */
        statusImage = function(id, url, token)
        {
            $.ajax({
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN':token},
                url: url,
                data: {_method:'put'},
                beforeSend: function() {
                    $("#status-"+id).attr('class', 'button disabled');
                },
                success: function(data){
                    if(data.success == true){
                        $("#status-"+id).attr('class', data.class);
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }

        /**
         * Remove Image
         * @param int id
         * @param string url
         * @param string token
        */
        deleteImage = function(id, url, token)
        {
            $.ajax({
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN':token},
                url: url,
                data: {_method:'delete'},
                success: function(data){
                    if(data.success == true){
                        $("#img-"+id).remove();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }

    /**
     *  Alterar ordem dos banners
     * @param id
     * @param url
     * @param token
     */
        updateBannerOrder = function(id, url, token)
        {
            var order = $("#input-order-"+id).val();
            if (order.length == 1) {
                order = '0'+order;
            }
            $.ajax({
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN':token},
                url: url,
                data: {_method:'PUT', id:id, order:order},
                success: function(data){
                    if(data.success == true){
                        $("#order-"+id).text('Ordem ('+order+')');
                        $("#order-"+id).removeTooltip();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }



    /**
         * Ajax Form
        */
        $("body").on("click","#btn-upload",function(e){
            $(this).parents("#form-image").ajaxForm(options);
        });

        var options = { 
            beforeSend: function() {
                setBtn(4,'Aguarde',false,'loader','btn-upload',false,'silver');
            },
            success: function(data) {
                if (data.success == true) {
                    setBtn(1,ac,true,'icon-cloud-upload','btn-upload');
                    if (data.ac == 'create') {
                        $("#gallery-"+data.idm).prepend(
                            '<li class="square" id="img-'+data.id+'">'+
                                '<img src="'+data.path+'" class="framed">'+
                                '<div class="controls">'+
                                    '<span id="btns-'+data.id+'" class="button-group compact children-tooltip">'+
                                        "<button id=\"status-"+data.id+"\" onclick=\""+data.url_status+"\" class=\""+data.class+"\" title=\""+data.btn.status+"\"></button>"+
                                        "<button id=\"order-"+data.id+"\" onclick=\""+data.url_order+"\" class=\"button\" title=\""+data.btn.order+"\">"+data.btn.order+ "("+data.order+")</button>"+
                                        "<button id=\"edit-"+data.id+"\" onclick=\""+data.url_edit+"\" class=\"button\" title=\""+data.btn.edit+"\">"+data.btn.edit+"</button>"+
                                        "<button id=\"delete-"+data.id+"\" onclick=\""+data.url_delete+"\" class=\"button icon-trash red-gradient\" title=\""+data.btn.delete+"\"></button>"+
                                    '</span>'+
                                '</div>'+
                            '</li>'+ data.script);

                    }
                    if (data.ac == 'update') {
                        $("#img-"+data.id).html(
                                '<img src="'+data.path+'" class="framed">'+
                                '<div class="controls">'+
                                    '<span id="btns-'+data.id+'" class="button-group compact children-tooltip">'+
                                        "<button id=\"status-"+data.id+"\" onclick=\""+data.url_status+"\" class=\""+data.class+"\" title=\""+data.btn.status+"\"></button>"+
                                        "<button id=\"order-"+data.id+"\" onclick=\""+data.url_order+"\" class=\"button\" title=\""+data.btn.order+"\">"+data.btn.order+ "("+data.order+")</button>"+
                                        "<button id=\"edit-"+data.id+"\" onclick=\""+data.url_edit+"\" class=\"button\" title=\""+data.btn.edit+"\">"+data.btn.edit+"</button>"+
                                        "<button id=\"delete-"+data.id+"\" onclick=\""+data.url_delete+"\" class=\"button icon-trash red-gradient\" title=\""+data.btn.delete+"\"></button>"+
                                    '</span>'+
                                '</div>'+ data.script);
                    }

                    fechaModal();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            complete: function(data) {
                setBtn(4,'Upload',true,'icon-cloud-upload','btn-upload',false,'blue');
            },
            error: function(xhr) {
                ajaxFormError(xhr);
                setBtn(4,'Upload',true,'icon-cloud-upload','btn-upload',false,'blue');
            }
        };      


})(jQuery);