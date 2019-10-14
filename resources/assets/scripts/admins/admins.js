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
 * Admins
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableAdmins = function() {
        var painel = Handlebars.compile($("#painel-" + tableAdmin.id).html()),
            table = $("#" + tableAdmin.id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: tableAdmin.url_admins,
                    type: "POST",
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': tableAdmin.token}
                },
                sScrollX: true,
                sScrollXInner: "100%",
                buttons: ['reset'],
                sPaginationType: "full_numbers",
                iDisplayLength: tableAdmin.limit,
                sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
                fnDrawCallback: function (oSettings) {
                    if (!tableAdmin.tableStyled) {
                        $("#" + tableAdmin.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select " + tableAdmin.color + " glossy").styleSelect();
                        $("#btn-reset").addClass(tableAdmin.color + " glossy");
                        tableAdmin.tableStyled = true;
                    }
                },
                columns:[
                    {data: 'name', className:'align-left'},
                    {data: 'profile', className:'align-right'},
                    {data: 'active', className:'align-center'},
                    {data: 'phone', className:'align-right'},
                    {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
                ],
                order: [[0, 'asc']]

        });
        $('#' + tableAdmin.id).on('click', tableAdmin.openDetails, function () {
            if (event.target !== this) {
                return;
            }
            var tr = $(this).closest('tr'),
                row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableAdmin.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableAdmin.colorSel);
            }
        });


        /**
         * Forms create and update
         * @param ac
         */
        formAdmin = function(ac)
        {
            var form = $('#form-'+tableAdmin.id),
                url  = form.attr('action'),
                txt;
            (ac == 'create' ? txt = tableAdmin.txtSave : txt = tableAdmin.txtUpdate);
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,'Aguarde',false,'loader','btn-modal',false,'silver');
                },
                success: function(data){
                    if(data.success == true){
                        setBtn(4,txt,true,'icon-publish','btn-modal',false,'blue');
                        table.ajax.reload();
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
         *  Delete Admin
         * @param url
         * @param name
         */
        deleteAdmin = function(url, name)
        {
            $.modal.confirm(tableAdmin.txtConfirm+' '+name+'?', function(){
                $.ajax({
                    type: 'DELETE',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableAdmin.token},
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            table.ajax.reload();
                            msgNotifica(true, data.message, true, false);
                        } else {
                            msgNotifica(false, data.message, true, false);
                        }
                    },
                    error: function(data){
                        msgNotifica(false, tableAdmin.txtError, true, false);
                    }
                });

            }, function(){
                $.modal.alert(tableAdmin.txtCancel);
            });
        };

        /**
         * Access Admins (txt)
         * @param ac
         * @param id
         * @param name
         * @param path
         * @param date
         */
        adminAccessTxt = function(ac, id, name, path, date)
        {
            if (ac == 'delete-all' || ac == 'delete') {
                if (ac == 'delete-all') {
                    var content = filesAccess.txtConfirmAll+name;
                    setBtn(4,filesAccess.txtLoader,false,'loader','del-all-'+id,false,'silver');
                }
                else {
                    var content = filesAccess.txtConfirm+date+' de '+name;
                }
                $.modal.confirm(content, function(){
                    $.ajax({
                        type: 'POST',
                        dataType: 'json',
                        data: { ac:ac, user:name, path:path, _token:filesAccess.token },
                        url: filesAccess.url,
                        success: function( data ){
                            if (data.success == true) {
                                if (ac == 'delete') {
                                    $("#"+date+"_"+id).hide();
                                    $("#return_"+id).html('');
                                    $("#info_"+id).show();
                                } else {
                                    $("#del-all-"+id).hide();
                                    $("#return_"+id).hide();
                                    $("#files_"+id).hide();
                                }
                            } else {

                                if (ac == 'delete-all') {
                                    setBtn(4,filesAccess.txtDelete,true,'icon-trash ','del-all-'+id,false,'red');
                                };
                            }

                            msgNotifica(data.success, data.message, true, false);
                        },
                        error: function( response ){
                            msgNotifica(false, filesAccess.txtError, true, false);
                            if (ac == 'delete-all') {
                                setBtn(4,filesAccess.txtDelete,true,'icon-trash ','btn-modal',false,'red');
                            };
                        }
                    });

                }, function()
                {
                    $.modal.alert(filesAccess.txtCancel);
                    setBtn(4,filesAccess.txtDelete,true,'icon-trash ','del-all-'+id,false,'red');
                });
            }
            else {
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    data: { ac:ac, user:name, path:path, _token:filesAccess.token },
                    url: filesAccess.url,
                    success: function(data){
                        $("#return_"+id).html(data);
                        $("#info_"+id).hide();
                    },
                    error: function(xhr){
                        ajaxFormError(xhr);
                    }
                });
            }
        };


        /**
         * Permissions
         * @param idmod
         * @param url
         */
        openPermissions = function(idmod, url){
            $.ajax({
                url: url,
                dataType: "html",
                beforeSend: function() {
                    $("#loader-"+idmod).show();
                },
                success: function(data){
                    $("#loader-"+idmod).hide();
                    $("#permisions-"+idmod).html(data);

                },
                error: function(xhr){
                    $("#loader-"+idmod).hide();
                    ajaxFormError(xhr);
                }
            });
        }



        $.fn.changePermission = function(id, url)
        {
            var ac,
                val = $("#check_"+id).val();
            if (val == 1) {
                $("#check_"+id).val(0);
                ac = 'remove';
            } else {
                $("#check_"+id).val(1);
                ac = 'insert';
            }

            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN': tableAdmin.token},
                data: { _method:'put', ac:ac, id:id },
                url: url,
                dataType: 'json',
                success: function( data ){
                    if (data.success == true) {
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function( data ){
                    msgNotifica(false, 'Houve um erro no servidor', true, false);
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
         * Status Image
         * @param int id
         * @param string url
         * @param string token
         */
        statusImage = function (id, url, token) {
            $.ajax({
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN': token},
                url: url,
                data: {_method: 'put'},
                beforeSend: function () {
                    $("#status-" + id).attr('class', 'button disabled');
                },
                success: function (data) {
                    if (data.success == true) {
                        $("#status-" + id).attr('class', data.class);
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function (xhr) {
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
        deleteImage = function (id, url, token) {
            $.ajax({
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN': token},
                url: url,
                data: {_method: 'delete'},
                success: function (data) {
                    if (data.success == true) {
                        $("#btn-add-image-admin").show();
                        $("#img-" + id).remove();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function (xhr) {
                    ajaxFormError(xhr);
                }
            });
        }

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

    }

})(jQuery);


