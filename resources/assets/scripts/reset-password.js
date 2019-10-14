

$(document).ready(function()
{
    /*
     * JS login effect
     * Este script permitirá efeitos para a página de login
*/
    // Elements
    var doc = $('html').addClass('js-login'),
        container = $('#container'),
        formWrapper = $('#form-wrapper'),
        formBlock = $('#form-block'),
        formViewport = $('#form-viewport'),
        forms = formViewport.children('form'),

        // Doors
        topDoor = $('<div id="top-door" class="form-door"><div></div></div>').appendTo(formViewport),
        botDoor = $('<div id="bot-door" class="form-door"><div></div></div>').appendTo(formViewport),
        doors = topDoor.add(botDoor),

        // Switch
        formSwitch = $('<div id="form-switch"><span class="button-group"></span></div>').appendTo(formBlock).children(),

        // Current form
        hash = (document.location.hash.length > 1) ? document.location.hash.substring(1) : false,

        // If layout is centered
        centered,

        // Store current form
        currentForm,

        // Animation interval
        animInt,

        // Work vars
        maxHeight = false,
        blocHeight;

    /******* EDITAR ESTA SECÇÃO *******/

    /*
     * AJAX login
     * Essas funções irão processar o processo de login através do AJAX
     */
    $('#form-login').submit(function(event)
    {
        // Values
        var login = $.trim($('#login').val()),
            pass = $.trim($('#pass').val()),
            dataForm = $(this).serialize(),
            url = $(this).attr('action');

        // Check inputs
        if (login.length === 0){
            // Display message
            displayError('Por favor, preencha seu login');
            return false;
        } else if (pass.length === 0){
            // Remova a mensagem de login vazia se exibida
            formBlock.clearMessages('Por favor, preencha seu login');
              // Display message
          displayError('Preencha sua senha');
            return false;
        } else {
            // Remove previous messages
            formBlock.clearMessages();

            // Show progress
            displayLoading('Verificando credenciais...');

            // Pare o comportamento normal
            event.preventDefault();

            $.ajax(url, {
                data: dataForm,
                method: 'POST',
                success: function(data){
                    if (data.logged == true){
                        setTimeout(function() {
                            document.location.href = data.redirect
                        }, 2000);
                    } else {
                        formBlock.clearMessages();
                        displayError(data.message);
                    }
                },
                error: function(){
                    formBlock.clearMessages();
                    displayError('Erro ao contactar ao servidor!');
                }
            });
        }
    });

    $('#form-reset-password').submit(function(event)
    {
        // Values
        var mail = $.trim($('#mail').val()),
            password = $.trim($('#password').val()),
            password_confirm = $.trim($('#password_confirm').val()),
            dataForm = $(this).serialize(),
            url = $(this).attr('action');
        // Remove previous messages
        formWrapper.clearMessages();

        if (password.length === 0)
        {
            displayError('Por favor, digite sua senha');
            return false;
        }
        else if (mail.length === 0)
        {
            displayError('Por favor, digite seu email');
            return false;
        }
        else if (!/^[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?$/.test(mail))
        {
            displayError('Por favor, digite um email val\u00eddo');
            return false;
        }
        else if (password_confirm.length === 0)
        {
            displayError('Digite a confirma\u00e7\u00e3o da senha');
            return false;
        }
        else if (password_confirm != password)
        {
            displayError('As senha n\u00e3o s\u00e3o iguais');
            return false;
        }
        else
        {
           // Remove previous messages
            formBlock.clearMessages();

            // Pare o comportamento normal
            event.preventDefault();

            $.ajax(url, {
                data: dataForm,
                type: 'POST',
                dataType: "json",
                success: function(data){
                    if (data.success == true){
                        displayLoading(data.message);
                        setTimeout(function() {
                            document.location.href = data.redirect
                        }, 5000);
                    } else {
                        formBlock.clearMessages();
                        displayError(data.message);
                    }
                },
                error: function(xhr){
                    formBlock.clearMessages();
                    if (xhr.status == 422) {    
                        var obj = $.parseJSON(xhr.responseText), msgs = '';
                        $.each( obj, function( key, value ) {
                             displayError(value);
                        });
                       
                    } else {
                        displayError('Hove um erro no servidor, tente mais tarde');
                    }                   
                                  
                }
            });
        }
    });


    /*
     * Actions form
     */

    forms.each(function(i)
    {
        var form = $(this),
            height = form.outerHeight(),
            active = (hash === false && i === 0) || (hash === this.id),
            color = this.className.match(/[a-z]+-gradient/) ? ' '+(/([a-z]+)-gradient/.exec(this.className)[1])+'-active' : '';

        // Store size
        form.data('height', height);

        // Min-height for mobile layout
        if (maxHeight === false || height > maxHeight)
        {
            maxHeight = height;
        }

        // Button in the switch
        form.data('button', $('<a href="#'+this.id+'" class="button anthracite-gradient'+color+(active ? ' active' : '')+'">'+this.title+'</a>')
                            .appendTo(formSwitch)
                            .data('form', form));

        // If active
        if (active)
        {
            // Store
            currentForm = form;

            // Height of viewport
            formViewport.height(height);
        }
        else
        {
            // Hide for now
            form.hide();
        }
    });

    // Main bloc height (without form height)
    blocHeight = formBlock.height()-currentForm.data('height');

    // Handle resizing (mostly for debugging)
    function handleLoginResize()
    {
        // Detect mode
        centered = (container.css('position') === 'absolute');

        // Set min-height for mobile layout
        if (!centered)
        {
            formWrapper.css('min-height', (blocHeight+maxHeight+20)+'px');
            container.css('margin-top', '');
        }
        else
        {
            formWrapper.css('min-height', '');
            if (parseInt(container.css('margin-top'), 10) === 0)
            {
                centerForm(currentForm, false);
            }
        }
    };

    // Register and first call
    $(window).bind('normalized-resize', handleLoginResize);
    handleLoginResize();

    // Switch behavior
    formSwitch.on('click', 'a', function(event)
    {
        var link = $(this),
            form = link.data('form'),
            previousForm = currentForm;

        event.preventDefault();
        if (link.hasClass('active'))
        {
            return;
        }

        // Refresh forms sizes
        forms.each(function(i)
        {
            var form = $(this),
                hidden = form.is(':hidden'),
                height = form.show().outerHeight();

            // Store size
            form.data('height', height);

            // If not active
            if (hidden)
            {
                // Hide for now
                form.hide();
            }
        });

        // Clear messages
        formWrapper.clearMessages();

        if (animInt)
        {
            clearTimeout(animInt);
        }

        formViewport.stop(true);
        currentForm.data('button').removeClass('active');
        link.addClass('active');
        currentForm = form;

        if (doc.hasClass('csstransitions'))
        {
            doors.removeClass('door-closed').addClass('door-down');
            animInt = setTimeout(function()
            {
                doors.addClass('door-closed');
                animInt = setTimeout(function()
                {
                    previousForm.hide();
                    form.show();
                    centerForm(form, true);
                    formViewport.animate({
                        height: form.data('height')+'px'
                    }, function()
                    {
                        doors.removeClass('door-closed');
                        animInt = setTimeout(function()
                        {
                            doors.removeClass('door-down');
                        }, 300);
                    });
                }, 300);
            }, 300);
        }
        else
        {
            // Close doors
            topDoor.animate({ top: '0%' }, 300);
            botDoor.animate({ top: '50%' }, 300, function()
            {
                previousForm.hide();
                form.show();
                centerForm(form, true);
                formViewport.animate({
                    height: form.data('height')+'px'
                }, {
                    /* IE7 é um pouco bugado, devemos forçar o redesenho */
                    step: function(now, fx)
                    {
                        topDoor.hide().show();
                        botDoor.hide().show();
                        formSwitch.hide().show();
                    },

                    complete: function()
                    {
                        topDoor.animate({ top: '-50%' }, 300);
                        botDoor.animate({ top: '105%' }, 300);
                        formSwitch.hide().show();
                    }
                });
            });
        }
    });

    // Iniciar Ajuste vertical
    centerForm(currentForm, false);

    /*
     * Center function
     * @param jQuery Forma o elemento de formulário cuja altura será usada
     * @param boolean Animar se deseja ou não animar a mudança de posição
     * @param string|element|array em jQuery selector, DOM element Ou conjunto de DOM elements que devem ser ignorados
     * @return void
     */
    function centerForm(form, animate, ignore)
    {
        // If layout is centered
        if (centered)
        {
            var siblings = formWrapper.siblings().not('.closing'),
                finalSize = blocHeight+form.data('height');

            // Ignored elements
            if (ignore)
            {
                siblings = siblings.not(ignore);
            }

            // Get other elements height
            siblings.each(function(i)
            {
                finalSize += $(this).outerHeight(true);
            });

            // Setup
            container[animate ? 'animate' : 'css']({ marginTop: -Math.round(finalSize/2)+'px' });
        }
    };

    /**
     *  Exibir mensagens de erro
     * @param string message O erro para exibir
     */
    function displayError(message)
    {
        // Show message
        var message = formWrapper.message(message, {
            append: false,
            arrow: 'bottom',
            classes: ['red-gradient'],
            animate: false 
        });

        centerForm(currentForm, true, 'fast');
        message.bind('endfade', function(event)
        {
            centerForm(currentForm, true, message.get(0));

        }).hide().slideDown('fast');
    };

    /**
     * Exibir mensagens de carregamento
     * @param string message A mensagem a ser exibida
     */
    function displayLoading(message)
    {
        var message = formWrapper.message('<strong>'+message+'</strong>', {
            append: false,
            arrow: 'bottom',
            classes: ['blue-gradient', 'align-center'],
            stripes: true,
            darkStripes: false,
            closable: false,
            animate: false
        });

        centerForm(currentForm, true, 'fast');
        message.bind('endfade', function(event)
        {
            centerForm(currentForm, true, message.get(0));
        }).hide().slideDown('fast');
    };

});