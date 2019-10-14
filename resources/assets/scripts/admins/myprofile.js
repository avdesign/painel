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
 * My Profile
 *
 */
;(function($, undefined)
{  

    /**
     * update
     * @param id loader txt
    */
    formMyProfile = function(id, loader, txt)
    {
        var form = $('#form-'+id),
            url  = form.attr('action');
        $.ajax({
            type: 'POST',
            dataType: "json",
            url: url,
            data: form.serialize(),
            beforeSend: function() {
                setBtn(4,loader,false,'loader','btn-modal',false,'silver');
            },
            success: function(data){
                if(data.success == true){
                    setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                    msgNotifica(true, data.message, true, false);
                    fechaModal();
                } else {
                    setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                    msgNotifica(false, data.message, true, false);
                }
            },
            error: function(xhr){
                setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                ajaxFormError(xhr);
            }
        });
    };


    /**
     * Peview Image
     * @param int id
     * @param int width
     */
    preview_image = function (id, width) {
        $('#image_preview_' + id).html("");
        var total_file = document.getElementById("upload_file").files.length;
        for (var i = 0; i < total_file; i++) {
            $('#image_preview_' + id).append('<img src="' + URL.createObjectURL(event.target.files[i]) + '" width="' + width + '">');
        }
        $("#btn-upload-submit").show();
    };



    /**
     * Ajax Form
     */
    $("body").on("click", "#btn-upload", function (e) {
        $(this).parents("#form-image").ajaxForm(options);
    });

    var options = {
        beforeSend: function () {
            setBtn(4, 'Aguarde', false, 'loader', 'btn-upload', false, 'silver');
        },
        success: function (data) {
            if (data.success == true) {
                setBtn(1, ac, true, 'icon-cloud-upload', 'btn-upload');
                if (data.ac == 'create') {
                    $("#gallery-" + data.idm).prepend(
                        '<li id="img-' + data.id + '">' +
                        '<img src="' + data.path + '" class="framed">' +
                        '<div class="controls">' +
                        '<span id="btns-' + data.id + '" class="button-group compact children-tooltip">' +
                        "<button id=\"status-" + data.id + "\" onclick=\"" + data.url_status + "\" class=\"" + data.class + "\" title=\"" + data.btn.status + "\"></button>" +
                        "<button id=\"edit-" + data.id + "\" onclick=\"" + data.url_edit + "\" class=\"button\" title=\"" + data.btn.edit + "\">" + data.btn.edit + "</button>" +
                        "<button id=\"delete-" + data.id + "\" onclick=\"" + data.url_delete + "\" class=\"button icon-trash red-gradient\" title=\"" + data.btn.delete + "\"></button>" +
                        '</span>' +
                        '</div>' +
                        '</li>');
                }
                if (data.ac == 'update') {
                    $("#img-" + data.id).html(
                        '<img src="' + data.path + '" class="framed">' +
                        '<div class="controls">' +
                        '<span id="btns-' + data.id + '" class="button-group compact children-tooltip">' +
                        "<button id=\"status-" + data.id + "\" onclick=\"" + data.url_status + "\" class=\"" + data.class + "\" title=\"" + data.btn.status + "\"></button>" +
                        "<button id=\"edit-" + data.id + "\" onclick=\"" + data.url_edit + "\" class=\"button\" title=\"" + data.btn.edit + "\">" + data.btn.edit + "</button>" +
                        "<button id=\"delete-" + data.id + "\" onclick=\"" + data.url_delete + "\" class=\"button icon-trash red-gradient\" title=\"" + data.btn.delete + "\"></button>" +
                        '</span>' +
                        '</div>');
                }
                if(data.auth === true) {
                    $("#avatar").attr('src', data.path);
                }

                $("#btn-add-image-admin").hide();
                $("#btn-add-photo-admin").hide();
                $("#btn-upd-photo-admin").show();

                fechaModal();
                msgNotifica(true, data.message, true, false);
            } else {
                msgNotifica(false, data.message, true, false);
            }
        },
        complete: function (data) {
            setBtn(4, 'Upload', true, 'icon-cloud-upload', 'btn-upload', false, 'blue');
        },
        error: function (xhr) {
            ajaxFormError(xhr);
            setBtn(4, 'Upload', true, 'icon-cloud-upload', 'btn-upload', false, 'blue');
        }
    };




})(jQuery);