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
 * Contacts
 *
 */
;(function($, undefined)
{
    /**
     * Init table
     * @var array 
     */
    $.fn.loadTableContacts = function()
    {  
        var painel = Handlebars.compile($("#painel-"+tableContact.id).html()),
        table = $("#"+tableContact.id).DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: tableContact.url,
                type: "POST",
                dataType: "json",
                headers: {'X-CSRF-TOKEN': tableContact.token}
            },
            sScrollX: true,
            sScrollXInner: "100%",
            buttons: ['reset'],
            sPaginationType: "full_numbers",
            iDisplayLength: tableContact.limit,
            sDom: 'CB<"clear"><"dataTables_header"lfr>t<"dataTables_footer"ip>',
            fnDrawCallback: function( oSettings ){
                if (!tableContact.tableStyled){
                    $("#"+tableContact.id).closest(".dataTables_wrapper").find(".dataTables_length select").addClass("select "+tableContact.color+" glossy").styleSelect();
                    $("#btn-reset").addClass(tableContact.color+" glossy");
                    tableContact.tableStyled = true;
                }
            },
            columns:[
                {data: 'created_at'},
                {data: 'name'},
                {data: 'subject'},
                {data: 'message'},
                {data: 'client', className:'align-center'},
                {data: 'send', className:'align-center'},
                {data:null, className:'details-control', orderable:false, searchable:false, defaultContent: ''}
            ],
            order: [[0, 'desc']]

        });
        $('#'+tableContact.id).on('click', tableContact.openDetails, function() {
            if (event.target !== this){
                return;
            }
            var tr = $(this).closest('tr'),
            row = table.row(tr);
            if (row.child.isShown()) {
                // Esta row já está aberta - fechá-la
                row.child.hide();
                tr.removeClass('shown');
                tr.children().removeClass(tableContact.colorSel);
            } else {
                // Abrir esta row
                row.child(painel(row.data())).show();
                tr.addClass('shown');
                tr.children().addClass(tableContact.colorSel);
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
         *
         * @param opc
         */
        openResponse = function(opc,id)
        {
            if (opc == 1) {
                $("#response-email-"+id).show();
            } else {
                $("#response-email-"+id).hide();
            }
        };

        /**
         *
         * @param id
         */
        responseMail = function(id, loader, txt)
        {
            var form  = $('#'+id),
                url   = form.attr('action');
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    setBtn(4,loader,false,'loader','btn-response',false,'silver');
                },
                success: function(data){
                    if (data.success == true) {
                        refreshContact(data.id,data.refresh);
                    } else {
                        setBtn(4,' '+txt,true,'icon-paper-plane','btn-response',false,'blue');
                    }
                    msgNotifica(data.success, data.message, true, false);
                },
                error: function(xhr){
                    setBtn(4,' '+txt,true,'icon-paper-plane','btn-response',false,'blue');
                    ajaxFormError(xhr);
                }
            });
        };

        /**
         *
         * @param id
         * @param url
         */
        refreshContact = function (id, url) {
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
         * @param status
         */
        statusMail = function (id, status) {
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: base+"/contacts/"+id+"/status",
                data: {'status':status},
                headers: {'X-CSRF-TOKEN':tableContact.token},
                success: function(data){
                    if (status == 1) {
                        $("#icon-star-"+id).addClass('orange');
                        $("#icon-flag-"+id).removeClass('red');
                    } else {
                        $("#icon-star-"+id).removeClass('orange');
                        $("#icon-flag-"+id).addClass('red');
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
        spamContact = function (id) {
            $.ajax({
                type: 'POST',
                dataType: "json",
                url: base+"/contacts/"+id+"/spam",
                headers: {'X-CSRF-TOKEN':tableContact.token},
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