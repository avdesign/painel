 /**
 *     ___ _    __   ____            _
      /   | |  / /  / __ \___  _____(_)____ ____ 
     / /| | | / /  / / / / _ \/ ___/ / __ `/ __ \
    / ___ | |/ /  / /_/ /  __(__  ) / /_/ / / / /
   /_/  |_|___/  /_____/\___/____/_/\__, /_/ /_/ 
                                   /____/        
 * ------------ By Anselmo Velame --------------- 
 *
 * funtions global do sistema
 * Boas práticas estruturais dos padrões essenciais para usar os plugins 
 */

/**
 * Urls globais do sistema
 * @attr meta
 * @return content
 */
var base   = $("meta[name=base]").attr("content");
var avdUrl = $("meta[name=avdUrl]").attr("content");

/**
 * Remover options selected
 *
 * @attr id 
 * @return options
 */
function clearSelected(id)
{
    var elements = document.getElementById(id).options;
    var t,v,i,h='';
        
    for(i = 0; i < elements.length; i++){
        v  =  elements[i].value;
        t  =  elements[i].text;
        h  += '<option value="'+v+'">'+t+'</option>';
    }
    
    $("#"+id).html(h);
}        


/**
 * Alteração dos botões no event click
 * @attr btn modelo
 * @attr txt alterar texo
 * @attr set (true ou false)
 * @attr icon altera o icon
 * @attr id1 elemento
 * @attr id2 elemento
 * @return html
 */
function setBtn(btn,txt,set,icon,id1,id2,cor)
{
    // Btn html
    if (btn == 1) {
        if (set == true) {
            $("#"+id1).html('<button id="'+id2+'" class="button">'+txt+'<span class="button-icon right-side"><span class="'+icon+'"></span></span></button>');
        } else {
            $("#"+id1).html('<button class="button">'+txt+'<span class="button-icon right-side silver-gradient disabled"><span class="'+icon+'"></span></span></button>');
        }
    };

    // Btn submit
    if (btn == 2) {
        if (set == true) {
            $("#"+id1).removeClass('disabled');
            $("#"+id2).removeClass('silver-gradient');
            $("#"+id2).removeClass('disabled');
            $("#"+id2).html('<span class="'+icon+'"></span>');
        } else {
            $("#"+id1).addClass('disabled');
            $("#"+id2).addClass('silver-gradient');
            $("#"+id2).addClass('disabled');
            $("#"+id2).html('<span class="'+icon+'"></span>');
        }
    };

    // Btn attr onclick
    if (btn == 3) {
        var click = $("#"+id1).attr('onclick');
        var cls = $("#"+id1).attr('class');
        
        if (set == true) {
            $("#"+id1).attr('onclick', click);
            $("#"+id1).attr('class', cls);
            $("#"+id1).text(txt);
        } else {
            $("#"+id1).attr('onclick', '');
            $("#"+id1).attr('class', 'button silver-gradient disabled');
            $("#"+id1).html('<span class="'+icon+'"></span> '+txt+'</button>');
        }
    };

    // Btn submit simples
    if (btn == 4) {
        var cls = $("#"+id1).attr('class');        
        if (set == true) {
            $("#"+id1).attr('class', 'button '+cor+'-gradient');
            $("#"+id1).html('<span class="'+icon+'"></span> '+txt);
        } else {
            $("#"+id1).attr('class', 'button silver-gradient disabled');
            $("#"+id1).html('<span class="'+icon+'"></span> '+txt);
        }
    };
}

function ajaxFormError(xhr)
{
    if (xhr.status == 422) {    
        var obj = $.parseJSON(xhr.responseText), message = '';
        $.each( obj, function( key, value ) {
            $("#"+key).addClass('required');
            if (key == 'message') {
                message += '<li>'+value+'</li>';
            } else if (key == 'errors') {
                $.each(obj[key], function(i, error) {
                    message += '<li>'+error+'</li>';
                });
            } else {
                message += '<li>'+value+'</li>';
            }

        });

        msgNotifica(false, '<ol>'+message+'</ol>', true, false);
    } else if(xhr.status == 200){
         msgNotifica(false, xhr.responseText, true, false);
    } else {
        msgNotifica(false, 'Erro: '+xhr.status+' '+xhr.statusText, true, false);
    }
}



/**
 * function para manipular Tabs
 * @param  c class da tabs.
 * @param  i id da proxima tab.
 * @param  d disabled, se true permite acesso novamente.
 * @return void
 */

function nextTabs(c, i, d)
{
    var cls = '.'+c+' li';
    var id  = '#'+i;
    if (d == true) {
        $(id).removeClass('disabled');
    };
    $(cls).removeClass('active');
    $(id).addClass('active');
    $(cls).refreshTabs();
}


/**
 * Escolha de cores
 * @param string pt portugués
 * @param string en Inglés
 * @param string tag cor
 * @return void
 */
function colorTags(pt, en, tag, fild)
{
    var color_pt = $("#"+fild),
        color_en = $("#"+tag);
    color_pt.val(pt);
    color_en.val(en);
}

/**
 * Style Display (none ou block)
 * @param  id, url
 * @return void
 */

function loadDivs(id,url)
{
    setDisplay("#"+id,'block');
    $.ajax({
        type: 'GET',
        url: url,
        success: function(response){
            $("#"+id).html(response);            
        },
        error: function(response){
            msgNotifica(false, 'Houve um erro no servidor', true, false);
        }
    });
};



/**
 * Style Display (none ou block)
 * @param  id
 * @return void
 */

function setDisplay(id,style)
{

    $(id).css("display",style);

}

/**
 * Post o form formato json,
 * #id referente ao form.
 * @param string id 
 */

function postFormJson(id)
{
    var form  = $('#'+id),
        url   = form.attr('action');
    $.ajax({
        type: 'POST',
        dataType: "json",
        url: url,
        data: form.serialize(),
        success: function(data){
            msgNotifica(data.success, data.message, true, false);
        },
        error: function(xhr){
            ajaxFormError(xhr);
        }
    });
};

/**
 * Fechar Modal
 * @param  currentl
 * @return void
 */

function fechaModal() {
	var mod = $.modal.current;
	$(mod).closeModal();
}


/**
 * Abre Modal
 * @param tit titulo
 * @param url ajax
 * @param min minimizar
 * @param tipo tipo
 * @param fundo true (bloqueia tela)
 * @param width largura do modal
 * @param height Altura do modal

 * @return void
 */

function abreModal(tit,url,min,tipo,fundo,width,height)
{
    var btn = '#'+ min,
     	id  = '#modal-'+ min;
    if (tipo == 1) {
        setDisplay(btn,'none');
        $.modal({
            title: tit,
            blocker: fundo,
            width: width,
            height: height,
            actions: {
                'Fechar' : {
                    color: 'red',
                    click: function(win) { win.closeModal();setDisplay(btn,'block'); }
                },
                'Centralizar' : {
                    color: 'green',
                    click: function(win) { win.centerModal(true); }
                },
                'Minimizar' : {
                    color: 'blue',
                    click: function(win) {
                       $(id).hide();
                    }
                },
                'Restaurar' : {
                    color: 'orange',
                    click: function(win) {
                       $(id).show();
                    }
                }
            },
            buttons: {},
            url: url
        });
    } else if (tipo == 2) {  
        //console.log('Tipo: 2');
        $.modal({
            title: tit,
            blocker: fundo,
            width: width,
            height: height,
            actions: {
                'Fechar' : {
                    color: 'red',
                    click: function(win) { win.closeModal(); }
                },
                'Centralizar' : {
                    color: 'green',
                    click: function(win) { win.centerModal(true); }
                }

            },
            buttons: {},            
            url: url
        });
    } else if (tipo == 3) { 
        $.modal({
            contentBg: false,
            resizable: true,
            width: width,
            height: height,
            actions: {},
            buttons: {},
            url: url
        });

    } else {
        setDisplay(btn,'none');
        $.modal({
            title: tit,
            blocker: fundo,
            width: width,
            height: height,
            actions: {
                'Fechar' : {
                    color: 'red',
                    click: function(win) { win.closeModal();setDisplay(btn,'block'); }
                },
                'Centralizar' : {
                    color: 'green',
                    click: function(win) { win.centerModal(true); }
                }

            },
            buttons: {
                    'Fechar': {
                        classes:    'huge blue-gradient glossy full-width',
                        click:      function(win) { win.closeModal(); }
                    }
            },
            url: base + url
        });
    }
}

/**
 * Abre Modal Iframe
 * @param  t u w h
 * @return void
 */
function openIframe(t,u,w,h,f)
{
    $.modal({
        title: t,
        blocker: f,
        contentBg:  false,
        contentAlign:   'center',
        minWidth:   w,
        width:  false,
        maxWidth:   w,
        maxHeight:   h,
        resizable:  false,
        actions: {
            'Fechar' : {
                color: 'red',
                click: function(win) { win.closeModal(); }
            },
            'Centralizar' : {
                color: 'green',
                click: function(win) { win.centerModal(true); }
            }
        },
        buttons: {},
        url: u,
        useIframe: true
    });
}


/**
 * Set content, Retorna as notificaçõs
 * @param retorno,msg,bt
 * @return true, false, erro
 */
function msgNotifica(retorno,msg,bt,gs)
{
	if(retorno === true){
		notify('Sucesso!',  msg, {
			hPos: 'right',
			icon: avdUrl+"/backend/img/icons/notifique-ok.png",
			iconOutside: false,
			closeButton: bt,
			showCloseOnHover: false,
			groupSimilar: gs
	    });
	} else {
		notify('Erro na Aplicação!', msg, {
			hPos: 'center',
			icon: avdUrl+"/backend/img/icons/notifique-erro-min.png",
			iconOutside: false,
			closeButton: bt,
			showCloseOnHover: false,
			groupSimilar: gs
		});             
	}
};


/**
 * Retorna apenas números, virgulas e pontos no obj
 * @param obj
 * @return void
 */

function maskValor(objeto, e, tammax, decimais)
{
    // var tecla  = (window.event) ? e.which : e.keyCode;
    var tecla = e.keyCode ? e.keyCode : e.which;
    var tamObj = objeto.value.length;

    if ((tecla == 8) && (tamObj == tammax))
        tamObj = tamObj - 1;

    vr = makenum(objeto.value);
    tam = vr.length;

    if (((tecla == 8) || (tecla >= 48 && tecla <= 57) || (tecla >= 96 && tecla <= 105)) && (parseInt(tamObj) + 1 <= parseInt(tammax)))
    {
        if ((tam < tammax) && (tecla != 8))
            tam = vr.length + 1;
        if ((tecla == 8) && (tam > 1))
            tam = tam - 1;
        if ((tam >= (decimais)))
            objeto.value = vr.substr(0, (tam - decimais)) + "." + vr.substr((tam - decimais), tam);
    }
    else if((tecla != 8) && (tecla != 9) && (tecla != 13) && (tecla != 18) && (tecla != 35) && (tecla != 36) && (tecla != 37) && (tecla != 39))
    {
        return false;
    }
}

/**
 * função de complemento para maskValor()
 * @param nro
 * @return void
 */
function makenum(nro)
{

    var valid    = "0123456789";
    var numerook = "";
    var temp;
    for(var i = 0; i < nro.length; i++)
    {
        temp = nro.substr(i, 1);
        if (valid.indexOf(temp) != -1)
            numerook = numerook + temp;
    }
    return(numerook);
}

/**
 * Fazer logout do sistema.
 * @param string 
 * @return url
 */
function logoutSistema(logout)
{
    $.getJSON( logout, function( data ) {
        document.location.href = data.login;
    });
}
