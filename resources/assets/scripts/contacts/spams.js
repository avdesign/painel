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
 * Spams
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array 
     */
    $.fn.loadTableSpams = function()
    {  
        var painel = Handlebars.compile($("#painel-"+tableSpam.id).html()),
        table = $("#"+tableSpam.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableSpam.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableSpam.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableSpam.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableSpam.tableStyled){
                    $("#"+tableSpam.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableSpam.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableSpam.color+" glossy");
                    tableSpam.tableStyled = true;
                }
            },
            columns:[
                {data: 'created_at'},
                {data: 'name'},
                {data: 'email'},
                {data: 'message'},
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
            ],
            order: [[0, 'desc']]

        });
        $('#'+tableSpam.id).on('click', tableSpam.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
            row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableSpam.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableSpam.colorSel);
            }
        });

        /**
         *
         * @param id
         * @param url
         */
        refreshSpam = function (id, url) {
            $.ajax({
                url: url,
                success: function(response){
                    $("#load-contact-"+id).html(response);
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }

        /**
         *
         * @param id
         */
        deleteSpam = function (id) {
            $.ajax({
                type: 'DELETE',
                dataType: "json",
                url: base+"/spams/"+id,
                data: {'status':status},
                headers: {'X-CSRF-TOKEN':tableSpam.token},
                success: function(data){
                    if (data.success == true) {
                        table.ajax.reload();
                    }
                    msgNotifica(data.success, data.message, true, false);
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }

        /**
         *
         * @param id
         */
        changeSpam = function (id) {
            $.ajax({
                type: 'PUT',
                dataType: "json",
                url: base+"/spams/"+id,
                headers: {'X-CSRF-TOKEN':tableSpam.token},
                success: function(data){
                    if (data.success == true) {
                        table.ajax.reload();
                    }
                    msgNotifica(data.success, data.message, true, false);
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        }





    }

})(jQuery);