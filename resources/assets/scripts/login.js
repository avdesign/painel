

$(document).ready(function()
{
    /*
     * JS login effect
     * Este script permitir� efeitos para a p�gina de login
*/
    // Elements
    var doc = $('html').addClass('js-login'),
        container = $('#container'),
        formBlock = $('#form-block'),

    // If layout is centered
        centered;

    /******* EDITAR ESTA SEÇÃO *******/

    /*
     * AJAX login
     * Essas funções irão processar o processo de login atravs do AJAX
     */
    $('#form-login').submit(function(event){

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

    /*******  FINAL DA SE��O DE EDITAR *******/

    // Handle resizing (principalmente para depura��o)
    function handleLoginResize(){
        // Modo de detec��o
        centered = (container.css('position') === 'absolute');
        // Defina altura m�nima para layout m�vel
        if (!centered){
            container.css('margin-top', '');
        } else {
            if (parseInt(container.css('margin-top'), 10) === 0)
            {
                centerForm(false);
            }
        }
    };

    // Registro e primeira liga��o
    $(window).on('normalized-resize', handleLoginResize);
    handleLoginResize();

    /*
     * Fun��o central
     * @param boolean animate se deseja ou n�o animar a mudan�a de posi��o
     * @param string|element|array any jQuery selector, DOM element Ou conjunto de elementos DOM que devem ser ignorados
     * @return void
     */
    function centerForm(animate, ignore){
        // Se o layout estiver centrado
        if (centered){
            var siblings = formBlock.siblings(),
                finalSize = formBlock.outerHeight();
            // Ignored elements
            if (ignore){
                siblings = siblings.not(ignore);
            }
            // Get outros elementos de altura
            siblings.each(function(i){
                finalSize += $(this).outerHeight(true);
            });
            // Setup
            container[animate ? 'animate' : 'css']({ marginTop: -Math.round(finalSize/2)+'px' });
        }
    };

    // Ajuste vertical inicial
    centerForm(false);

    /**
     * Fun��o para exibir mensagens de erro
     * @param string message erro para exibir
     */
    function displayError(message){
        // Show message
        var message = formBlock.message(message, {
            append: false,
            arrow: 'bottom',
            classes: ['red-gradient'],
            animate: false	// N�s faremos anima��o mais tarde, precisamos conhecer primeiro a altura da mensagem
        });

        // Centraliza��o vertical (onde precisamos da altura da mensagem)
        centerForm(true, 'fast');

        // Observe o encerramento e mostre com efeito
        message.on('endfade', function(event)
        {
            // Isso ser� chamado uma vez que a mensagem desapareceu e seja removida
            centerForm(true, message.get(0));

        }).hide().slideDown('fast');
    }

    /**
     * Fun��o para exibir as mensagens de carregamento
     * @param string message A mensagem a ser exibida
     */
    function displayLoading(message){
        // Show message
        var message = formBlock.message('<strong>'+message+'</strong>', {
            append: false,
            arrow: 'bottom',
            classes: ['blue-gradient', 'align-center'],
            stripes: true,
            darkStripes: false,
            closable: false,
            animate: false	// N�s faremos anima��o mais tarde, precisamos conhecer primeiro a altura da mensagem
        });
        // Centraliza��o vertical (onde precisamos da altura da mensagem)
        centerForm(true, 'fast');
        // Observe o encerramento e mostre com efeito
        message.on('endfade', function(event){
            // Isso ser� chamado uma vez que a mensagem desapareceu e seja removida
            centerForm(true, message.get(0));

        }).hide().slideDown('fast');
    }
});