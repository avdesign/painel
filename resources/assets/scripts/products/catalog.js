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
 * Colors
 *
 */
;(function($)
{
    /**
     * Init table
     * @var array 
     */
    $.fn.loadTableCatalog = function()
    {  
        var table = $("#"+tableCatalog.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableCatalog.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableCatalog.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableCatalog.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableCatalog.tableStyled){
                    $("#"+tableCatalog.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableCatalog.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableCatalog.color+" glossy");
                    tableCatalog.tableStyled = true;
                }
            },
            columns:[
                { data: null, searchable:false, render: function ( data, type, row ) 
                    {
                        return data.image;
                    } 
                },
                {data: 'code'},
                {data: 'color'},
                {data: 'category'},
                {data: 'section'},
                {data: 'brand'},
                {data: 'visits', className:'align-center'},
                {data: "active", className:'align-center'},
                {
                    data: 'actions', 
                    className: 'align-right',
                    orderable: false,
                    searchable: false,
                    defaultContent: ''
                }
            ],
            order: [[0, 'desc']]

        });


        /**
         * Update Status.
         *
         * @param int id
         * @param string url
         * @param int sta
         * @param int cover
         * @param string token
         */
        statusCatalog = function(id, url, status, token)
        {
            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN':token},
                dataType: "json",
                url: url,
                data: {_method:'put', 'active':status},
                success: function(data){
                    if(data.success == true){
                        if ( typeof data.alert !== "undefined" && data.alert ) {
                            $.modal.alert(data.alert);
                        };
                        $("#status-"+id).html(data.html);
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        };



        /**
         * Peview Image
         * @param int id
         * @param int width 
        */
        preview_image = function(arq,prev,width)
        {
            $('#'+prev).html("");
            var total_file=document.getElementById(arq).files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#'+prev).append('<img src="'+URL.createObjectURL(event.target.files[i])+'" width="'+width+'">');
            }
        };



        /**
         * Excluir imagem cor.
         * @param int id
         */

        deleteColor = function(id, url)
        {
            $.ajax({
                type: 'DELETE',
                dataType: "json",
                url: url,
                headers: {'X-CSRF-TOKEN':tableCatalog.token},
                success: function(data){
                    if(data.success == true){
                        table.ajax.reload();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        };

        $("body").on("click","#btn-colors",function(e){
            $(this).parents("#form-colors").ajaxForm(opc_colors);
        });
        var opc_colors = { 
            beforeSend: function() {
                setBtn(1,'Aguarde',false,'loader disbeled','submit-colors','btn-colors');
            },
            success: function(data) {
                if (data.success == true) {
                    $("#img-"+data.id).attr('src', data.image);
                    $("#code-"+data.id).html(data.code);
                    $("#color-"+data.id).html(data.color);
                    fechaModal();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                    setBtn(1,'Salvar',true,'icon-tick','submit-colors','btn-colors');                    
                }
            },
            error: function(xhr)
            {
                ajaxFormError(xhr);
                setBtn(1,'Salvar',true,'icon-tick','submit-colors','btn-colors');
            }
        }; 

    }

})(jQuery);