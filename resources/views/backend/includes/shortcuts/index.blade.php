<!-- Side tabs shortcuts -->
<ul id="shortcuts" role="complementary" class="children-tooltip tooltip-right">
	<li class="current"><a href="home" class="shortcut-dashboard" title="Home">Home</a></li>
	<li><a href="contacts" class="shortcut-messages" title="Mensagens">Contatos</a></li>
	<li><a href="accounts" class="shortcut-contacts" title="Clientes">Clientes</a></li>
	<li><a href="orders" class="shortcut-agenda" title="Pedidos">Pedidos</a></li>
	<!--
	<li><a href="agenda.html" class="shortcut-medias" title="Agenda">Agenda</a></li>
	-->
	<li><a href="wishlist" class="shortcut-stats" title="Lista de Desejos">Lista de Desejos</a></li>
	@can('model-admins-view')
		<li><a href="admins" class="shortcut-users" title="Usuários">Usuários</a></li>
	@endcan
	@can('config-view')
		<li><a href="config/system" class="shortcut-settings" title="Configurações">Configurações</a></li>
	@endcan
</ul>

