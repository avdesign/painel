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
 * Kits
 */


;(function($)
{   
    $.fn.loadTableKits = function()
    {
        var table = $('#'+avdTable.id).DataTable({
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
                {data: 'order', className: 'align-center'},
                {data: 'name'},
                {data: 'active', className: 'align-center'},
                {
                    data: 'actions', 
                    className: 'align-right',
                    orderable: false,
                    searchable: false,
                    defaultContent: ''
                }
            ],
            order: [[0, 'asc']]
        });

        /**
         * create or update
         * @param ac (opcional)
        */
        formKit = function(ac)
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
         * delete
         * @param string url, string name
        */
        deleteKit = function(url, name)
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