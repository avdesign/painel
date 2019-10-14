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
 * Accounts
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableAccounts = function() {
        var painel = Handlebars.compile($("#painel-" + tableAccount.id).html()),
            table = $("#" + tableAccount.id).DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: tableAccount.url_accounts,
                    type: "POST",
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN': tableAccount.token}
                },
                sScrollX: true,
                sScrollXInner: "100%",
                buttons: ['reset'],
                sPaginationType: "full_numbers",
                iDisplayLength: tableAccount.limit,
                sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
                fnDrawCallback: function (oSettings) {
                    if (!tableAccount.tableStyled) {
                        $("#" + tableAccount.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select " + tableAccount.color + " glossy").styleSelect();
                        $("#btn-reset").addClass(tableAccount.color + " glossy");
                        tableAccount.tableStyled = true;
                    }
                },
                columns:[
                    {data: 'id', className:'align-center'},
                    {data: 'profile_id'},
                    {data: 'first_name'},
                    {data: 'visits', className:'align-center'},
                    {data: 'admin'},
                    {data: 'active', className:'align-center'},
                    {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
                ],
                order: [[0, 'desc']]

        });
        $('#' + tableAccount.id).on('click', tableAccount.openDetails, function () {
            if (event.target !== this) {
                return;
            }
            var tr = $(this).closest('tr'),
                row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableAccount.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableAccount.colorSel);
            }
        });

        /**
         * Search
         */
        $(".dataTables_filter input")
            .unbind()
            .bind("input", function(e) {
                if(this.value.length >= 3 || e.keyCode == 13) {
                    table.search(this.value).draw();
                }
                if(this.value == "") {
                    table.search("").draw();
                }
                return;
            });





        /**
         * Forms create and update
         * @param ac
         */
        formAccount = function(ac)
        {
            var form = $('#form-'+tableAccount.id),
                url  = form.attr('action'),
                txt;
            (ac == 'create' ? txt = tableAccount.txtSave : txt = tableAccount.txtUpdate);
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
         *  Delete Account
         * @param url
         * @param name
         */
        deleteAccount = function(id, url, name)
        {
            var note = $("#note_"+id).val();
            if (note <= 0) {
                $.modal.alert(tableAccount.txtAtert);
            } else {

                $.modal.confirm(tableAccount.txtConfirm+' '+name+'?', function(){

                    $.ajax({
                        type: 'DELETE',
                        dataType: "json",
                        headers: {'X-CSRF-TOKEN':tableAccount.token},
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
                            msgNotifica(false, tableAccount.txtError, true, false);
                        }
                    });

                }, function(){
                    $.modal.alert(tableAccount.txtCancel);
                });

            }



        };


    }
})(jQuery);


