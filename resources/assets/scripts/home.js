/*
 * Handling of 'other actions' menu
 */

var otherActions = $('#otherActions'),
	current = false;

// Other actions
$('.list .button-group a:nth-child(2)').menuTooltip('Carregando...', {

	classes: ['with-mid-padding'],
	ajax: 'ajax-demo/tooltip-content.html',

	onShow: function(target)
	{
		// Remove auto-hide class
		target.parent().removeClass('show-on-parent-hover');
	},

	onRemove: function(target)
	{
		// Restore auto-hide class
		target.parent().addClass('show-on-parent-hover');
	}
});

// Delete button
$('.list .button-group a:last-child').data('confirm-options', {

	onShow: function()
	{
		// Remove auto-hide class
		$(this).parent().removeClass('show-on-parent-hover');
	},

	onConfirm: function()
	{
		// Remove element
		$(this).closest('li').fadeAndRemove();

		// Prevent default link behavior
		return false;
	},

	onRemove: function()
	{
		// Restore auto-hide class
		$(this).parent().addClass('show-on-parent-hover');
	}

});

// Demo modal
function openModal()
{
	$.modal({
		content: '<p>This is an example of modal window. You can open several at the same time (click links below!), move them and resize them.</p>'+
				  '<p>The plugin provides several other functions to control them, try below:</p>'+
				  '<ul class="simple-list with-icon">'+
				  '    <li><a href="javascript:void(0)" onclick="openModal()">Open new blocking modal</a></li>'+
				  '    <li><a href="javascript:void(0)" onclick="$.modal.alert(\'This is a non-blocking modal, you can switch between me and the other modal\', { blocker: false })">Open non-blocking modal</a></li>'+
				  '    <li><a href="javascript:void(0)" onclick="$(this).getModalWindow().setModalTitle(\'\')">Remove title</a></li>'+
				  '    <li><a href="javascript:void(0)" onclick="$(this).getModalWindow().setModalTitle(\'New title\')">Change title</a></li>'+
				  '    <li><a href="javascript:void(0)" onclick="$(this).getModalWindow().loadModalContent(\'ajax-demo/auto-setup.html\')">Load Ajax content</a></li>'+
				  '</ul>',
		title: 'Example modal window',
		width: 300,
		scrolling: false,
		actions: {
			'Close' : {
				color: 'red',
				click: function(win) { win.closeModal(); }
			},
			'Center' : {
				color: 'green',
				click: function(win) { win.centerModal(true); }
			},
			'Refresh' : {
				color: 'blue',
				click: function(win) { win.closeModal(); }
			},
			'Abort' : {
				color: 'orange',
				click: function(win) { win.closeModal(); }
			}
		},
		buttons: {
			'Close': {
				classes:	'huge blue-gradient glossy full-width',
				click:		function(win) { win.closeModal(); }
			}
		},
		buttonsLowPadding: true
	});
};

// Demo alert
function openAlert()
{
	$.modal.alert('This is an alert message', {
		buttons: {
			'Thanks, captain obvious': {
				classes:	'huge blue-gradient glossy full-width',
				click:		function(win) { win.closeModal(); }
			}
		}
	});
};

// Demo prompt
function openPrompt()
{
	var cancelled = false;

	$.modal.prompt('Please enter a value between 5 and 10:', function(value)
	{
		value = parseInt(value);
		if (isNaN(value) || value < 5 || value > 10)
		{
			$(this).getModalContentBlock().message('Please enter a correct value', { append: false, classes: ['red-gradient'] });
			return false;
		}

		$.modal.alert('Value: <strong>'+value+'</strong>');

	}, function()
	{
		if (!cancelled)
		{
			$.modal.alert('Oh, come on....');
			cancelled = true;
			return false;
		}
	});
};

// Demo confirm
function openConfirm()
{
	$.modal.confirm('Challenge accepted?', function()
	{
		$.modal.alert('Me gusta!');

	}, function()
	{
		$.modal.alert('Meh.');
	});
};

/*
 * Navegação da agenda
 * Este exemplo mostra como controlar remotamente uma agenda. Na maioria das vezes, os controles embutidos
 * Usar cabeçalho funciona bem
 */

	// Dias da semana
var daysName = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sabado', 'Domingo'],

	// Nome display
	agendaDay = $('#agenda-day'),

	// Agenda scrolling
	agenda = $('#agenda').scrollAgenda({
		first: 2,
		onRangeChange: function(start, end)
		{
			if (start != end)
			{
				agendaDay.text(daysName[start].substr(0, 3)+' - '+daysName[end].substr(0, 3));
			}
			else
			{
				agendaDay.text(daysName[start]);
			}
		}
	});

// Remote controls
$('#agenda-previous').click(function(event)
{
	event.preventDefault();
	agenda.scrollAgendaToPrevious();
});
$('#agenda-today').click(function(event)
{
	event.preventDefault();
	agenda.scrollAgendaFirstColumn(2);
});
$('#agenda-next').click(function(event)
{
	event.preventDefault();
	agenda.scrollAgendaToNext();
});

// Demo loading modal
function openLoadingModal()
{
	var timeout;

	$.modal({
		contentAlign: 'center',
		width: 240,
		title: 'Loading',
		content: '<div style="line-height: 25px; padding: 0 0 10px"><span id="modal-status">Contacting server...</span><br><span id="modal-progress">0%</span></div>',
		buttons: {},
		scrolling: false,
		actions: {
			'Cancel': {
				color:	'red',
				click:	function(win) { win.closeModal(); }
			}
		},
		onOpen: function()
		{
				// Progress bar
			var progress = $('#modal-progress').progress(100, {
					size: 200,
					style: 'large',
					barClasses: ['anthracite-gradient', 'glossy'],
					stripes: true,
					darkStripes: false,
					showValue: false
				}),

				// Loading state
				loaded = 0,

				// Window
				win = $(this),

				// Status text
				status = $('#modal-status'),

				// Function to simulate loading
				simulateLoading = function()
				{
					++loaded;
					progress.setProgressValue(loaded+'%', true);
					if (loaded === 100)
					{
						progress.hideProgressStripes().changeProgressBarColor('green-gradient');
						status.text('Done!');
						/*win.getModalContentBlock().message('Content loaded!', {
							classes: ['green-gradient', 'align-center'],
							arrow: 'bottom'
						});*/
						setTimeout(function() { win.closeModal(); }, 1500);
					}
					else
					{
						if (loaded === 1)
						{
							status.text('Loading data...');
							progress.changeProgressBarColor('blue-gradient');
						}
						else if (loaded === 25)
						{
							status.text('Loading assets (1/3)...');
						}
						else if (loaded === 45)
						{
							status.text('Loading assets (2/3)...');
						}
						else if (loaded === 85)
						{
							status.text('Loading assets (3/3)...');
						}
						else if (loaded === 92)
						{
							status.text('Initializing...');
						}
						timeout = setTimeout(simulateLoading, 50);
					}
				};

			// Start
			timeout = setTimeout(simulateLoading, 2000);
		},
		onClose: function()
		{
			// Stop simulated loading if needed
			clearTimeout(timeout);
		}
	});
};



/*
 * Google Charts
 * This script is dedicated to building and refreshing the demo chart
 * Remove if not needed
 */

/*
var chartInit = false,
	drawVisitorsChart = function()
	{
		// Create our data table.
		var data = new google.visualization.DataTable();
		var raw_data = [['Produtos', 50, 73, 104, 129, 146, 176, 139, 149, 218, 194, 96, 53],
						['Cadastros', 82, 77, 98, 94, 105, 81, 104, 104, 92, 83, 107, 91],
						['Contatos', 50, 39, 39, 41, 47, 49, 59, 59, 52, 64, 59, 51],
						['Pedidos', 45, 35, 35, 39, 53, 76, 56, 59, 48, 40, 48, 21]];

		var months = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];

		data.addColumn('string', 'Month');
		for (var i = 0; i < raw_data.length; ++i)
		{
			data.addColumn('number', raw_data[i][0]);
		}

		data.addRows(months.length);

		for (var j = 0; j < months.length; ++j)
		{
			data.setValue(j, 0, months[j]);
		}
		for (var i = 0; i < raw_data.length; ++i)
		{
			for (var j = 1; j < raw_data[i].length; ++j)
			{
				data.setValue(j-1, i+1, raw_data[i][j]);
			}
		}

		// Crie e desenhe a visualização.
		// Saiba mais sobre a configuração do LineChart: http://code.google.com/apis/chart/interactive/docs/gallery/linechart.html
		var div = $('#demo-chart'),
			divWidth = div.width();
		new google.visualization.LineChart(div.get(0)).draw(data, {
			title: 'Número de visitantes únicos',
			width: divWidth,
			height: $.template.mediaQuery.is('mobile') ? 180 : 265,
			legend: 'right',
			yAxis: {title: '(thousands)'},
			backgroundColor: ($.template.ie7 || $.template.ie8) ? '#494C50' : 'transparent',	// IE8 E menor não suportam transparência
			legendTextStyle: { color: 'white' },
			titleTextStyle: { color: 'white' },
			hAxis: {
				textStyle: { color: 'white' }
			},
			vAxis: {
				textStyle: { color: 'white' },
				baselineColor: '#666666'
			},
			chartArea: {
				top: 35,
				left: 30,
				width: divWidth-40
			},
			legend: 'bottom'
		});

		// Mensagem somente quando redimensionar
		if (chartInit)
		{
			notify('Gráfico redimensionado', 'O evento de mudança de largura foi acionado.', {
				icon: "{{url('assets/backend/img/demo/icon.png')}}"
			});
		}

		// Ready
		chartInit = true;
	};

// Load the Visualization API and the piechart package.
google.load('visualization', '1', {
	'packages': ['corechart']
});

// Set a callback to run when the Google Visualization API is loaded.
google.setOnLoadCallback(drawVisitorsChart);

// Watch for block resizing
$('#demo-chart').widthchange(drawVisitorsChart);

// Respond.js hook (media query polyfill)
$(document).on('respond-ready', drawVisitorsChart);

*/