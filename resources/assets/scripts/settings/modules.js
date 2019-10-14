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
 * Modules
 */


;(function($)
{   
    $.fn.loadTableProfile = function()
    {
        var template = Handlebars.compile($("#"+avdTable.id+"-template").html()),
            table = $('#'+avdTable.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: avdTable.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': avdTable.token}
            },
            scrollX: true,
            sScrollXInner: "100%",
            sPaginationType: "full_numbers",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: avdTable.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!avdTable.tableStyled){
                    $("#"+avdTable.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+avdTable.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(avdTable.color+" glossy");
                    avdTable.tableStyled = true;
                }
            },
            columns: [
                {data: 'name'},
                {data: 'type'},
                {data: 'order', className: 'align-center'},
                {data: 'label'},
                {
                    data: 'actions', 
                    className: 'align-right',
                    orderable: false,
                    searchable: false,
                    defaultContent: ''
                },
                {
                    className: 'details-control',
                    orderable: false,
                    searchable: false,
                    data: null,
                    defaultContent: ''
                }
            ],
            order: [[0, 'asc']]
        });

        /**
         * Adicionar ouvinte de eventos para abrir e fechar detalhes.
         * @var avdTable.id(id)td.details-control
        */
        $('#'+avdTable.id).on('click', avdTable.openDetails, function(event) {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
                row = table.row(tr),
                divId = avdTable.id+'-'+row.data().id;

            if (row.child.isShown()) {
                // Esta row já esta aberta - fechar
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(avdTable.colorSel);
            } else {
                // abre esta row
                row.child(template(row.data())).show();
                ajaxTable(divId, row.data());
                tr.addClass('shown');
                tr.children().addClass(avdTable.colorSel);
            }
        });

        /**
         * Carregar detalhes com ajax.
         * @param divId (id)
         * @param url (data.details_url)
        */
        ajaxTable = function(divId, url) 
        {
            $.ajax({
                url: url.details_url,
                type: "POST",
                dataType: "html",
                headers: {'X-CSRF-TOKEN': avdTable.token},
                beforeSend: function() {
                },
                success: function(data){
                    $("#"+divId).html(data);
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }

        /**
         * create or update
         * @param ac (opcional)
        */
        formModule = function(ac)
        {
            var form = $('#form-'+avdTable.id),
                url  = form.attr('action'),
                txt;
            (ac == 'create' ? txt = avdTable.txtSave : txt = avdTable.txtUpdate);
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,avdTable.txtLoader,false,'loader','btn-modal',false,'silver');
                },
                success: function(data){
                    if(data.success == true){
                        table.ajax.reload();
                        msgNotifica(true, data.message, true, false);
                        fechaModal();
                    } else {
                        setBtn(4,txt,true,'icon-outbox','btn-modal',false,'blue');
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    setBtn(4,txt,true,'icon-outbox','btn-modal',false,'blue');
                    ajaxFormError(xhr);
                }
            });
        };

        /**
         * delete
         * @param string url, string name
        */
        deleteModule = function(url, name)
        {
            $.modal.confirm(avdTable.txtConfirm+' '+name+'?', function(){
                $.ajax({
                    type: 'post',
                    dataType: "json",
                    data: {_method:'delete', _token :avdTable.token },
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
                        msgNotifica(false, avdTable.txtError, true, false);
                    }
                });

            }, function(){
                $.modal.alert(avdTable.txtCancel);
            });
        };


    };

})(jQuery);