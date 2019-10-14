/**
 *     ___ _    __   ____            _
 *    /   | |  / /  / __ \___  _____(_)____ ____
 *   / /| | | / /  / / / / _ \/ ___/ / __ `/ __ \
 *  / ___ | |/ /  / /_/ /  __(__  ) / /_/ / / / /
 * /_/  |_|___/  /_____/\___/____/_/\__, /_/ /_/
 *                                 /____/
 * ------------ By Anselmo Velame ---------------
 */
;(function($, undefined)
{
    /**
     * List users excluded.
     * @return json
     */
    $.fn.loadAdminsExcluded = function()
    {
        var painel = Handlebars.compile($("#painel-"+tableAdminExcluded.id).html()),
            table = $("#"+tableAdminExcluded.id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: tableAdminExcluded.url_excluded,
                    type: "POST",
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': tableAdminExcluded.token}
                },
                sScrollX: true,
                buttons: ['reset'],
                sPaginationType: "full_numbers",
                iDisplayLength: tableAdminExcluded.limit,
                sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
                fnDrawCallback: function( oSettings ){
                    if (!tableAdminExcluded.tableStyled){
                        $("#"+tableAdminExcluded.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableAdminExcluded.color+" glossy").styleSelect();
                        $("#btn-reset").addClass(tableAdminExcluded.color+" glossy");
                        tableAdminExcluded.tableStyled = true;
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
        $('#'+tableAdminExcluded.id).on('click', tableAdminExcluded.openDetails, function() {
            var tr = $(this).closest('tr'),
                row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableAdminExcluded.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableAdminExcluded.colorSel);
            }
        });

        /**
         * Reactivate users excluded.
         * @return boolean true or false
         */
        reactivateAdminExcluded = function(id, name)
        {
            $.modal.confirm(tableAdminExcluded.confirmReactivate + name, function()
            {
                $.ajax({
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': tableAdminExcluded.token},
                    dataType: "json",
                    data: {action:'reactivate', user:id},
                    url: tableAdminExcluded.url_reactivate,
                    beforeSend: function() {
                        setBtn(4,'Aguarde',false,'loader','btn-reactivate',false,'silver');
                    },
                    success: function(data){
                        if(data.success == true){
                            table.ajax.reload();
                            msgNotifica(true, data.message, true, false);
                        } else {
                            setBtn(4,tableAdminExcluded.txtReactivate,true,'icon-user','btn-reactivate',false,'blue');
                            msgNotifica(false, data.message, true, false);
                        }
                    },
                    error: function(xhr){
                        setBtn(4,tableAdminExcluded.txtReactivate,true,'icon-user','btn-reactivate',false,'blue');
                        msgNotifica(false, tableAdminExcluded.errorServer, true, false);
                    }
                });

            }, function()
            {
                $.modal.alert(tableAdminExcluded.cancelReactivate);
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
                data: {_method: 'delete', admin: id},
                success: function (data) {
                    if (data.success == true) {
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



    };

})(jQuery);