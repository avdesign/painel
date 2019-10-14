@isset($product)
    <script type="text/javascript">
    // new color
    $( ".grid_colors" ).change(function() {
        var id,
            opc   = $(this).val(),
            url   = "{{route('load-grids')}}",
            kit   = $("#kit_id").val(),
            stock = $("#sto_id").val(),
            idpro = $('input[name="img[product_id]"]').val();
        if (opc == 'brand') {
            id  = $("#bra_id" ).val();
        } else if (opc == 'section') {
            id = $("#sec_id").val();
        } else if (opc == 'category') {
            id = $("#cat_id").val();
        }

        $("#loader-grids").show();
        $( "#box-grids-colors").html("");

        $.get( url, { opc: opc, stock: stock, kit: kit, id: id, idpro: idpro } )
            .done(function( data ) {
                $("#loader-grids").hide();
                $( "#box-grids-colors" ).html( data );
            });
    });
    </script>
@else
    <script type="text/javascript">
        // new product
        $( ".grid_colors" ).change(function() {
            var id,
                opc   = $(this).val(),
                url   = "{{route('load-grids')}}",
                kit   = $('input[name="kit"]' ).val(),
                stock = $('input[name="stock"]' ).val(),
                idpro = $('input[name="img[product_id]"]').val();
            if (opc == 'brand') {
                id  = $( "#brand_id option:selected").val();
            } else if (opc == 'section') {
                id = $('input[name="prod[section_id]"]').val();
            } else if (opc == 'category') {
                id = $('input[name="prod[category_id]"]').val();
            }

            if (id) {
                $("#loader-grids").show();
                $("#box-grids-colors").html("");

                $.get( url, { opc: opc, stock: stock, kit: kit, id: id, idpro: idpro } )
                    .done(function( data ) {
                        $("#loader-grids").hide();
                        $( "#box-grids-colors" ).html( data );
                    });
            }

        });
    </script>
@endisset
