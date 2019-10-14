;(function($, undefined)
{
    /**
     * Init table
     * @var array
     */
    $.fn.loadTableAdminModules = function()
    {
        var dt = $('#'+tableAdminModules.id).DataTable( {
            processing: true,
            serverSide: true,
            sPaginationType: "full_numbers",
            sScrollX: true,
            sScrollXInner: "100%",
            lengthChange: false,
            info: false,
            ajax: {
                url: tableAdminModules.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableAdminModules.token}
            },
            columns:[
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''},
                {data: 'order', className: 'align-center'},
                {data: 'name'},
                {data: 'label'}
            ],
            order: [[1, 'asc']]

        } );

        // Array to track the ids of the details displayed rows
        var detailRows = [];

        $('#'+tableAdminModules.id+' tbody').on( 'click', 'tr td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = dt.row( tr );
            var idx = $.inArray( tr.attr('id'), detailRows );

            if ( row.child.isShown() ) {
                tr.removeClass( 'details' );
                row.child.hide();

                // Remove from the 'open' array
                detailRows.splice( idx, 1 );
            }
            else {
                tr.addClass( 'details' );
                row.child( htmlModules( row.data() ) ).show();

                // Add to the 'open' array
                if ( idx === -1 ) {
                    detailRows.push( tr.attr('id') );
                }
            }
        } );

        // On each draw, loop over the `detailRows` array and show any child rows
        dt.on( 'draw', function () {
            $.each( detailRows, function ( i, id ) {
                $('#'+tableAdminModules.id+' td.details-control').trigger( 'click' );
            } );
        } );



        /**
         *
         * @param data
         * @returns {string}
         */
        htmlModules = function ( data ) {

            return data.id;

        }





    }

})(jQuery);