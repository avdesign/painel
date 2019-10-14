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
 * Categories
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array 
     */
    $.fn.loadTableCategories = function()
    {  
        var painel = Handlebars.compile($("#painel-"+tableCategory.id).html()),
        table = $("#"+tableCategory.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableCategory.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableCategory.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableCategory.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableCategory.tableStyled){
                    $("#"+tableCategory.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableCategory.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableCategory.color+" glossy");
                    tableCategory.tableStyled = true;
                }
            },
            columns:[
                {data: 'order', className:'align-center'},
                {data: 'name'},
                {data: 'section'},
                {data: 'visits', className:'align-center'},
                {data: 'description'},
                {data: 'active', className:'align-center'},
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
            ],
            order: [[0, 'asc']]

        });
        $('#'+tableCategory.id).on('click', tableCategory.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
            row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableCategory.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableCategory.colorSel);
            }
        });

        /**
         * create  e update
         * @param ac (opcional)
        */
        formCategory = function(ac)
        {
            var form = $('#form-'+tableCategory.id),
                url  = form.attr('action'),
                txt;
            (ac == 'create' ? txt = tableCategory.txtSave : txt = tableCategory.txtUpdate);

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
                        if (ac == 'create') {
                            var count_category = $("#count_category").text(),
                                total_category = parseFloat(count_category)+1;
                            $("#count_category").text(total_category);
                        };
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
         * Delete Category
         * @param string url, string name
        */
        deleteCategory = function(url, name)
        {
            $.modal.confirm(tableCategory.txtConfirm+' '+name+'?', function(){
                
                $.ajax({
                    type: 'DELETE',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableCategory.token},
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            var count_category = $("#count_category").text(),
                                total_category = parseFloat(count_category)-1;                     
                            $("#count_category").text(total_category);

                            var count_colors = $("#count_colors").html(),
                                total_colors = parseFloat(count_colors)-data.deleted.total_colors;
                                $("#count_colors").html(total_colors);
                            var count_product = $("#count_product").html(),
                                total_product = parseFloat(count_product)-data.deleted.total_products;
                                $("#count_product").html(total_product);

                            table.ajax.reload();                
                            msgNotifica(true, data.message, true, false);
                        } else {
                            msgNotifica(false, data.message, true, false);
                        }
                    },
                    error: function(data){
                        ajaxFormError(xhr);
                    }
                });

            }, function(){
                $.modal.alert(tableCategory.txtCancel);
            });
        };



        /**
         * Verifica o type da grid
         * @param type
         */
        typeGrideCategory = function (type) {
            if (type === 'unit') {
                $("#grid-name").show();
                $("#grid-unit").show();
                $("#grid-kit").hide();
            }
            if (type === 'kit') {
                $("#grid-name").show();
                $("#grid-kit").show();
                $("#grid-unit").hide();
            }
        }

        /**
         * Adiciona um campo input para und
         */
        plusUndCategory = function () {
            $("#plus-unit").append('<span class="puls_grid input margin-right">'+
                    '<input type="text" name="label[]" value="" size="4" class="input-unstyled">'+
                    '<button onclick="removeGridCategory(this,\'.puls_grid\');" class="remove-unit button red-gradient icon-minus" title="'+tableCategory.texDelete+'"></button>'+
                '</span>');
        }

        /**
         * Adicionar input kit
         */
        plusKitCategory = function(){
            $("#plus-kit").append('<p class="puls_grid button-height inline-small-label">'+
                    '<span class="input">'+
                        '<input type="text" name="qty[]" class="amount input-unstyled input-sep" placeholder="'+tableCategory.texQty+'" value="0" maxlength="3" style="width: 30px;">'+
                        '<input type="text" name="des[]" class="input-unstyled" placeholder="'+tableCategory.txtDesc+'" value="" style="width: 80px;">'+
                        '<button onclick="removeGridCategory(this,\'.puls_grid\')" class="remove button red-gradient icon-minus" title="'+tableCategory.texDelete+'"></button>'+
                    '</span>' +
                '</p>');
            sumGridsCategory();
        }

        /**
         * Remover input Unit
         */
        removeGridCategory = function(_this, id) {
            $(_this).parents(id).remove();
        }

        /**
         * Somar total das grades
         */
        sumGridsCategory = function () {
            var inputs = document.getElementsByClassName( 'amount' ),
                amount  = [].map.call(inputs, function( input ) {
                    return parseInt(input.value);
                }).reduce(function(a, b) {
                    return a + b;
                });

            $("#total-grids").text(amount);
        }


        /**
         *  Form grids
         */
        formGridCategory = function(id, ac, ele, load, loading, btn)
        {

            var form = $('#form-'+ele),
                url  = form.attr('action');
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,loading,false,'loader','btn-modal',false,'silver');
                },
                success: function(data){
                    if(data.success == true){
                        $( "#load-grids-"+id ).load( load, function() {
                            msgNotifica(true, data.message, true, false);
                        });
                    } else {
                        setBtn(4,btn,true,'icon-outbox','btn-modal',false,'blue');
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    setBtn(4,btn,true,'icon-outbox','btn-modal',false,'blue');
                    ajaxFormError(xhr);
                }
            });
        }


        /**
         * Delete Grid
         * @param int id
         * @param string name 
         * @param string url
         * @param string token
        */
        deleteGridCategory = function(id, name, url, token)
        {
            $.modal.confirm(tableCategory.txtRemove+' '+name+'?', function(){
                $.ajax({
                    type: 'DELETE',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':token},
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            $("#grid_"+id).hide();
                            msgNotifica(true, data.message, true, false);
                        } else {
                            msgNotifica(false, data.message, true, false);
                        }
                    },
                    error: function(xhr){
                        ajaxFormError(xhr);
                    }
                });

            }, function(){
                $.modal.alert(tableCategory.txtCancel);
            });
        };


        /**
         * Peview Image
         * @param int id
         * @param int width 
        */
        preview_image = function(id, width)
        {
            $('#image_preview_'+id).html("");
            var total_file=document.getElementById("upload_file").files.length;
            for(var i=0;i<total_file;i++)
            {
                $('#image_preview_'+id).append('<img src="'+URL.createObjectURL(event.target.files[i])+'" width="'+width+'">');
            }
            $("#btn-upload-submit").show();
        };


        /**
         * Status Image
         * @param int id
         * @param string url
         * @param string token
        */
        statusImage = function(id, url, token)
        {
            $.ajax({
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN':token},
                url: url,
                data: {_method:'put'},
                beforeSend: function() {
                    $("#status-"+id).attr('class', 'button disabled');
                },
                success: function(data){
                    if(data.success == true){
                        $("#status-"+id).attr('class', data.class);
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
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
        deleteImage = function(id, url, token)
        {
            $.ajax({
                type: 'POST',
                dataType: "json",
                headers: {'X-CSRF-TOKEN':token},
                url: url,
                data: {_method:'delete'},
                success: function(data){
                    if(data.success == true){
                        $("#img-"+id).remove();
                        msgNotifica(true, data.message, true, false);
                    } else {
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    ajaxFormError(xhr);
                }
            });
        } 

        /**
         * Ajax Form
        */
        $("body").on("click","#btn-upload",function(e){
            $(this).parents("#form-image").ajaxForm(options);
        });

        var options = { 
            beforeSend: function() {
                setBtn(4,'Aguarde',false,'loader','btn-upload',false,'silver');
            },
            success: function(data) {
                if (data.success == true) {
                    setBtn(1,ac,true,'icon-cloud-upload','btn-upload');
                    if (data.ac == 'create') {
                        $("#gallery-"+data.idm).prepend(
                            '<li id="img-'+data.id+'">'+
                                '<img src="'+data.path+'" class="framed">'+
                                '<div class="controls">'+
                                    '<span id="btns-'+data.id+'" class="button-group compact children-tooltip">'+
                                        "<button id=\"status-"+data.id+"\" onclick=\""+data.url_status+"\" class=\""+data.class+"\" title=\""+data.btn.status+"\"></button>"+
                                        "<button id=\"edit-"+data.id+"\" onclick=\""+data.url_edit+"\" class=\"button\" title=\""+data.btn.edit+"\">"+data.btn.edit+"</button>"+
                                        "<button id=\"delete-"+data.id+"\" onclick=\""+data.url_delete+"\" class=\"button icon-trash red-gradient\" title=\""+data.btn.delete+"\"></button>"+
                                    '</span>'+
                                '</div>'+
                            '</li>');
                    }
                    if (data.ac == 'update') {
                        $("#img-"+data.id).html(
                                '<img src="'+data.path+'" class="framed">'+
                                '<div class="controls">'+
                                    '<span id="btns-'+data.id+'" class="button-group compact children-tooltip">'+
                                        "<button id=\"status-"+data.id+"\" onclick=\""+data.url_status+"\" class=\""+data.class+"\" title=\""+data.btn.status+"\"></button>"+
                                        "<button id=\"edit-"+data.id+"\" onclick=\""+data.url_edit+"\" class=\"button\" title=\""+data.btn.edit+"\">"+data.btn.edit+"</button>"+
                                        "<button id=\"delete-"+data.id+"\" onclick=\""+data.url_delete+"\" class=\"button icon-trash red-gradient\" title=\""+data.btn.delete+"\"></button>"+
                                    '</span>'+
                                '</div>');
                    }
                    fechaModal();
                    msgNotifica(true, data.message, true, false);
                } else {
                    msgNotifica(false, data.message, true, false);
                }
            },
            complete: function(data) {
                setBtn(4,'Upload',true,'icon-cloud-upload','btn-upload',false,'blue');
            },
            error: function(xhr) {
                ajaxFormError(xhr);
                setBtn(4,'Upload',true,'icon-cloud-upload','btn-upload',false,'blue');
            }
        };



    }

})(jQuery);