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
 * Products
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array 
     */
    $.fn.loadTableProducts = function()
    {  
        var painel = Handlebars.compile($("#painel-"+tableProduct.id).html()),
        table = $("#"+tableProduct.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableProduct.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableProduct.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableProduct.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableProduct.tableStyled){
                    $("#"+tableProduct.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableProduct.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableProduct.color+" glossy");
                    tableProduct.tableStyled = true;
                }
            },
            columns:[
                { data: null, searchable:false, render: function ( data, type, row ) 
                    {
                        return data.image;
                    } 
                },
                {data: "visits.0", className:'align-center'},
                {data: 'new', className:'align-center'},
                {data: 'offer.0', className:'align-center'},
                {data: 'active', className:'align-center'},
                {data: 'featured', className:'align-center'},
                {data: 'trend', className:'align-center'},
                {data: 'black_friday', className:'align-center'},
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''},
            ],
            order: [[0, 'desc']]

        });
 /*
        $('#'+tableProduct.id).on('click', tableProduct.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
            row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('row-drop');
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('row-drop');
            }
        });


 */
        $('#'+tableProduct.id).on('click', tableProduct.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
            row = table.row(tr);
            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableProduct.colorSel);
            } else {
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableProduct.colorSel);
            }
        });

        tableAjaxReload = function()
        {
            table.ajax.reload();
        }





        /**
         * Form dos fields dos produtos.
         * View: backend.products.modal.forms.product
         * @param string id - form
         * @param string ac - optional (criar ou editar).
         */
        formProduct = function(id, ac)
        {
            var form  = $('#form-'+id),
                url   = form.attr('action');
            $.ajax({
                beforeSend: function(){
                    setBtn(2,tableProduct.txtLoader,false,'loader','submit-product','btn-product');
                },                
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                success: function(data){
                    if(data.success == true){
                        setBtn(2,tableProduct.txtNext,true,'icon-forward','submit-product','btn-product');     
                        if (ac == 'create') {

                            $('input[name="prod[name]"]').val('');
                            $('input[name="img[code]"]').val(data.code);
                            $('input[name="img[order]"]').val('1');

                            var count_product = $("#count_product").html(),
                                total_product = parseFloat(count_product)+1;
                                $("#count_product").html(total_product);
                            var count_section = $("#count-section-"+data.product.section_id).html(),
                                total_section = parseFloat(count_section)+1;
                                $("#count-section-"+data.product.section_id).html(total_section);
                            var count_category = $("#count-category-"+data.product.category_id).html(),
                                total_category = parseFloat(count_category)+1;
                                $("#count-category-"+data.product.category_id).html(total_category);

                            // adiciona o field obrigatório no form-colors
                            $("#insert_product").html('<input name="img[product_id]" type="hidden" value="'+data.product.id+'">'+
                                                      '<input name="img[product_name]" type="hidden" value="'+data.product.name+'">'+
                                                      '<input name="img[brand]" type="hidden" value="'+data.product.brand+'">'+
                                                      '<input name="img[section]" type="hidden" value="'+data.product.section+'">'+
                                                      '<input name="img[category]" type="hidden" value="'+data.product.category+'">'+
                                                      '<input name="img[kit_name]" type="hidden" value="'+data.product.kit_name+'">');
                            // habilita a tab #tab-colors
                            nextTabs('new-product','show-colors', true);
                        } else {
                            if (data.refresh == true){

                                // faz o load dento da div
                                $( "#info-product-"+data.id ).load( data.redirect, function() {
                                    fechaModal();
                                });
                            } else  {
                                if (data.change == true) {
                                    var count_section_current = $("#count-section-"+data.current.section_id).html(),
                                        total_section_current = parseFloat(count_section_current)-1;
                                        $("#count-section-"+data.current.section_id).html(total_section_current);
                                    var count_category_current = $("#count-category-"+data.current.category_id).html(),
                                        total_category_current = parseFloat(count_category_current)-1;
                                        $("#count-category-"+data.current.category_id).html(total_category_current);

                                    var count_section_update = $("#count-section-"+data.update.section_id).html(),
                                        total_section_update = parseFloat(count_section_update)+1;
                                        $("#count-section-"+data.update.section_id).html(total_section_update);
                                    var count_category_update = $("#count-category-"+data.update.category_id).html(),
                                        total_category_update = parseFloat(count_category_update)+1;
                                        $("#count-category-"+data.update.category_id).html(total_category_update);

                                };
                                // Se alterou a section ou category faz um reload na table
                                table.ajax.reload();
                                fechaModal();
                            }

                            table.ajax.reload();
                            fechaModal();
                        }

                        msgNotifica(true, data.message, true, false);

                    } else {
                        setBtn(2,tableProduct.txtNext,true,'icon-forward','submit-product','btn-product');
                        msgNotifica(false, data.message, true, false);
                    }
                },
                error: function(xhr){
                    setBtn(2,tableProduct.txtNext,true,'icon-forward','submit-product','btn-product');
                    ajaxFormError(xhr);
                }          
            });

            return false;
        };

        get_prices = function(url, profiles)
        {
            var percent = $("#price_card_percent_1").val()/100;
            var card = $("input[name='price[1][price_card]']").val();
            var descont = percent*card;
            var cash = card-descont;
            var value = new Number(cash);
            var total = value.toFixed(2);
            $("input[name='price[1][price_cash]']").val(total);
            if (profiles == 1) {                
                $.ajax({
                    beforeSend: function(){
                        $("#load_prices").html('<span class="loader"></span>');
                    },
                    type: 'POST',
                    dataType: "html",
                    url: url,
                    data: {card:card, cash:total, _token:tableProduct.token},
                    success: function(data){
                        $("#load_prices").html(data);
                    },
                    error: function(xhr){
                        $("#load_prices").html('');
                        ajaxFormError(xhr);
                    }          
                });
            };
        }

        /**
         * Habilitar valor oferta.
         * View: produtos.modal.forms.produto
         * @param int opc - (1 ou 0)
         */
        get_offers = function(url, opc, profiles)
        {
            
            if (opc == 1) {
                var percent = $("#price_card_percent_1").val();
                $("#offer_percent_1").val(percent);
                $("#normal_offer").show();
            } else {
                $("#normal_offer").hide();
            };

            if (profiles == 1) {
                $.ajax({
                    beforeSend: function(){
                        $("#get_offers").html('<span class="loader"></span>');
                    },
                    type: 'POST',
                    dataType: "html",
                    url: url,
                    data: {opc:opc, _token:tableProduct.token},
                    success: function(data){
                        $("#get_offers").html(data);                       
                    },
                    error: function(xhr){
                        $("#get_offers").html('');
                        ajaxFormError(xhr);
                    }          
                });
            };
        }


        /**
         * Update status fields.
         * (new,offer,status,fatured,black_friday,trend)
         *
         * @param string field 
         * @param int id - product.
         * @param is status - (1,0)
         * @param string token 
         */
        statusFields = function(field, id, url, sta, token)
        {
            var btn = $("#"+field+"-"+id),
                button = $(this),
                status;
            (sta == 1 ? status = 0 : status = 1);
            $.ajax({
                type: 'POST',
                headers: {'X-CSRF-TOKEN':token},
                dataType: "json",
                url: url,
                data: {_method:'put', field:field, status:status},
                beforeSend: function() {
                    btn.html('<span class="loader"></span>');
                },
                success: function(data){
                    if(data.success == true){
                        btn.html(data.click);
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
         * Delete Product
         * @param string url, string name
        */
        deleteProduct = function(url, name)
        {
            $.modal.confirm(tableProduct.txtConfirm+' '+name+'?', function(){
                $.ajax({
                    type: 'DELETE',
                    dataType: "json",
                    headers: {'X-CSRF-TOKEN':tableProduct.token},
                    url: url,
                    success: function(data){
                        if(data.success == true){
                            var count_colors = $("#count_colors").html(),
                                total_colors = parseFloat(count_colors)-data.product.total_colors;
                                $("#count_colors").html(total_colors);
                            var count_product = $("#count_product").html(),
                                total_product = parseFloat(count_product)-1;
                                $("#count_product").html(total_product);
                            var count_section = $("#count-section-"+data.product.section_id).html(),
                                total_section = parseFloat(count_section)-1;
                                $("#count-section-"+data.product.section_id).html(total_section);
                            var count_category = $("#count-category-"+data.product.category_id).html(),
                                total_category = parseFloat(count_category)-1;
                                $("#count-category-"+data.product.category_id).html(total_category);

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

            }, function(){
                $.modal.alert(tableProduct.txtCancel);
            });
        };

        /**
         * Calculate Cash.
         * View: products.modal.forms.product
         * @param int id  config_prices
         * @param string opc - (price, offer, update)
         */
        calculateCash = function(id, opc)
        {
            if (opc == 'offer') {
                var percent    = $("input[name='price["+id+"][offer_percent]']").val()/100;
                var price_card = $("input[name='price["+id+"][offer_card]']").val();
                var descont    = percent*price_card;
                var price_cash = price_card-descont;
                var value      = new Number(price_cash);
                var total      = value.toFixed(2);
                $("input[name='price["+id+"][offer_cash]']").val(total);
            };

            if (opc == 'price') {

                var percent = $("#price_card_percent_"+id).val()/100,
                    card    = $("input[name='price["+id+"][price_card]']").val(),
                    descont = percent*card,
                    cash    = card-descont,
                    value   = new Number(cash),
                    total   = value.toFixed(2);
                $("input[name='price["+id+"][price_cash]']").val(total);

                var ids   = $("#ids_prices").val();
                var array = ids.split(",");

                $.each( array, function( i, v ) {
                    var sum,
                        price  = $("#price_card_"+id).val(),
                        spcard = $("input[name='price["+v+"][price_card_percent]']").val(),
                        spcash = $("input[name='price["+v+"][price_cash_percent]']").val();


                    var pcard = spcard.replace("+", "").replace("-", ""),
                        percent_card = pcard/100,
                        percentage_card = percent_card*price;

                    if (spcard >= 0) {
                        var price_card = +price+percentage_card;
                    } else {
                        var price_card = price-percentage_card;
                    }

                    var value_card = new Number(price_card),
                        total_card = value_card.toFixed(2);

                    var pcash = spcash.replace("+", "").replace("-", ""),
                        percent_cash = pcash/100,
                        percentage_cash = percent_cash*price;

                    if (spcash >= 0) {
                        var price_cash = +price+percentage_cash;
                    } else {
                        var price_cash = price-percentage_cash;
                    }

                    var value_cash = new Number(price_cash),
                        total_cash = value_cash.toFixed(2);

                    $("#price_card_"+v).val(total_card);
                    $("#price_cash_"+v).val(total_cash);
                });
            };
        }
        

        /**
         * Habilitar os fields do frete do produto.
         * View: products.modal.forms.freight
         * @param int opc - (1 ou 0)
         */
        setFreight = function(opc)
        {
            if (opc == 1) {
                $("#fields_freight").show();
                $("#freight").val(1);
            } else {
                $("#freight").val(0);
                $("#fields_freight").hide();
            }
        };

        /**
         * Habilitar os fields do valor da oferta.
         * View: produtos.modal.forms.produto
         * @param int opc - (1 ou 0)
         */
        setOffer = function(opc)
        {
            if (opc == 1) {
                $("#values_offers").show();
            } 
            if (opc == 0) {
                $("#values_offers").hide();
            }
        }




        /**
         * Ability kit module new product.
         * @param int kit
         * @param int idcat
         * @param string url
         */
        setKit = function(ac, kit, url)
        {
            if (kit == 1) {
               $("#kits").show(); 
            } else {
               $("#kits").hide(); 
            }
            $("#grid_kit").val(kit);
            $( ".grid_colors" ).children( ".select-value" ).text("Selecione Uma");
            $( "#box-grids-colors" ).html( '' );

        }


        /**
         * Ability stock module new product.
         * @param int stock
         * @param int idcat
         * @param string url
         */
        setStock = function(ac, stock, url)
        {

            $("#grid_stock").val(stock);
            $( ".grid_colors" ).children( ".select-value" ).text("Selecione Uma");
            $( "#box-grids-colors" ).html( '' );
        };


    }

})(jQuery);