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
 * Inventary
 *
 */
;(function($)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableInventory = function()
    {
        var painel = Handlebars.compile($("#painel-"+tableInventary.id).html()),
            table = $("#"+tableInventary.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableInventary.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableInventary.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableInventary.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableInventary.tableStyled){
                    $("#"+tableInventary.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableInventary.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableInventary.color+" glossy");
                    tableInventary.tableStyled = true;
                }
            },
            columns:[
                { data: null, searchable:false, render: function ( data, type, row )
                    {
                        return data.image;
                    }
                },
                {data: 'code'},
                {data: 'kit_name'},
                {data: 'stock'},
                {data: 'amount'},
                {data: "updated_at", className:'align-center'},
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
            ],
            order: [[0, 'desc']]

        });

        $('#'+tableInventary.id).on('click', tableInventary.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
                row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableInventary.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableInventary.colorSel);
            }
        });
    }

})(jQuery);