const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css');
*/


/*
 |--------------------------------------------------------------------------
 | Images Design
 |--------------------------------------------------------------------------
 */
mix.copyDirectory('resources/assets/img', 'public/img');
mix.copyDirectory('resources/assets/img', 'public/backend/img');


mix.copyDirectory('resources/assets/css/Entypo', 'public/backend/css/Entypo');
mix.copyDirectory('resources/assets/css/font-awesome', 'public/backend/css/font-awesome');
mix.copyDirectory('resources/assets/js/libs/ckeditor','public/backend/js/libs/ckeditor');

/*
 |--------------------------------------------------------------------------
 | libs css/js
 |--------------------------------------------------------------------------
 */



mix.copy('resources/assets/js/libs/modernizr.custom.js','public/backend/js/libs/modernizr.custom.js');
// Painel
mix.copy('resources/assets/js/libs/jquery/jquery-3.2.1.min.js','public/backend/js/libs/jquery/jquery.min.js');
// Aviso para atualizar a versão
mix.copy('resources/assets/js/version.js','public/backend/js/version.js');

//formData - upload de arquivos
mix.scripts('resources/assets/js/libs/formData/jquery.form.js', 'public/backend/js/libs/formData/jquery.form.min.js');
mix.scripts('resources/assets/js/libs/Mask/jquery.maskedinput.js', 'public/backend/js/libs/Mask/jquery.maskedinput.min.js');

/*
 |--------------------------------------------------------------------------
 | Login pages stylesheet styles
 |--------------------------------------------------------------------------
 | min-width.css  2x.css, 480.css, 768.css, 992.css, 1200.css
 |
 */
mix.styles([
    'resources/assets/css/reset.css',
    'resources/assets/css/style.css',
    'resources/assets/css/colors.css',
    'resources/assets/css/print.css',
    'resources/assets/css/min-width.css',
    'resources/assets/css/styles/form.css',
    'resources/assets/css/styles/switches.css',
    'resources/assets/css/login.css'
], 'public/backend/css/login.min.css');


mix.scripts([
    'resources/assets/js/setup.js',
    'resources/assets/js/avd.input.js',
    'resources/assets/js/avd.message.js',
    'resources/assets/js/avd.notify.js',
    'resources/assets/js/avd.tooltip.js',
    'resources/assets/scripts/login.js',
    'resources/assets/js/avd.navigable.js',
], 'public/backend/js/login.min.js');

/*
 |--------------------------------------------------------------------------
 | Painel pages stylesheet styles
 |--------------------------------------------------------------------------
 | min-width.css  2x.css, 480.css, 768.css, 992.css, 1200.css
 |
 */
mix.styles([
    'resources/assets/css/reset.css',
    'resources/assets/css/style.css',
    'resources/assets/css/colors.css',
    'resources/assets/css/print.css',
    'resources/assets/css/min-width.css',
    'resources/assets/css/styles/form.css',
    'resources/assets/css/styles/switches.css',
    'resources/assets/css/styles/agenda.css',
    'resources/assets/css/styles/dashboard.css',
    'resources/assets/css/styles/modal.css',
    'resources/assets/css/styles/progress-slider.css',
    'resources/assets/css/styles/files.css',
    'resources/assets/css/styles/table.css',
    'resources/assets/css/styles/avd.colorpicker.css'
], 'public/backend/css/painel.min.css');

// Configuração das cores das tabelas (DataTable)
mix.styles('resources/assets/css/tables/anthracite-gradient.css', 'public/backend/css/tables/anthracite-gradient.css');
mix.styles('resources/assets/css/tables/blue-gradient.css', 'public/backend/css/tables/blue-gradient.css');
mix.styles('resources/assets/css/tables/green-gradient.css', 'public/backend/css/tables/green-gradient.css');
mix.styles('resources/assets/css/tables/grey-gradient.css', 'public/backend/css/tables/grey-gradient.css');
mix.styles('resources/assets/css/tables/orange-gradient.css', 'public/backend/css/tables/orange-gradient.css');
mix.styles('resources/assets/css/tables/red-gradient.css', 'public/backend/css/tables/red-gradient.css');



mix.scripts([
    'resources/assets/js/setup.js',
    'resources/assets/js/avd.functions.js',
    'resources/assets/js/avd.input.js',
    'resources/assets/js/avd.message.js',
    'resources/assets/js/avd.modal.js',
    'resources/assets/js/avd.navigable.js',
    'resources/assets/js/avd.notify.js',
    'resources/assets/js/avd.scroll.js',
    'resources/assets/js/avd.accordions.js',
    'resources/assets/js/avd.progress-slider.js',
    'resources/assets/js/avd.tooltip.js',
    'resources/assets/js/avd.confirm.js',
    'resources/assets/js/avd.agenda.js',
    'resources/assets/js/avd.content-panel.js',
    'resources/assets/js/avd.tabs.js',
    'resources/assets/js/avd.colorpicker.js',
], 'public/backend/js/painel.min.js');

// Script para selecionar a cor em
mix.scripts('resources/assets/js/avd.hexa.js','public/backend/js/avd.hexa.min.js');

mix.scripts([
    'resources/assets/js/libs/tinycon.min.js',
    'resources/assets/js/libs/jquery.ba-hashchange.js',
    'resources/assets/js/libs/Handlebars/handlebars.js',
    'resources/assets/js/libs/DataTables/jquery.dataTables.js',
    'resources/assets/js/libs/DataTables/ext/dataTables.buttons.js',
    'resources/assets/js/libs/DataTables/ext/buttons.colVis.js',
    'resources/assets/js/libs/DataTables/ext/buttons.server-side.js',
], 'public/backend/js/libs/libs.min.js');

// Editor Accounts
mix.scripts('resources/assets/scripts/accounts/accounts.js', 'public/backend/scripts/accounts/accounts.min.js');
mix.scripts('resources/assets/scripts/accounts/address.js', 'public/backend/scripts/accounts/address.min.js');
mix.scripts('resources/assets/scripts/accounts/excludeds.js', 'public/backend/scripts/accounts/excludeds.min.js');
mix.scripts('resources/assets/scripts/accounts/notes.js', 'public/backend/scripts/accounts/notes.min.js');


// Editor Admin
mix.scripts('resources/assets/scripts/admins/admins.js', 'public/backend/scripts/admins/admins.min.js');
mix.scripts('resources/assets/scripts/admins/admins-excluded.js', 'public/backend/scripts/admins/admins-excluded.min.js');
mix.scripts('resources/assets/scripts/admins/myprofile.js', 'public/backend/scripts/admins/myprofile.min.js');

mix.scripts('resources/assets/scripts/contacts/contacts.js', 'public/backend/scripts/contacts/contacts.min.js');
mix.scripts('resources/assets/scripts/contacts/spams.js', 'public/backend/scripts/contacts/spams.min.js');

// Configuração do sistema
mix.scripts('resources/assets/scripts/settings/colors-group.js', 'public/backend/scripts/settings/colors-group.min.js');
mix.scripts('resources/assets/scripts/settings/colors-positions.js', 'public/backend/scripts/settings/colors-positions.min.js');
mix.scripts('resources/assets/scripts/settings/customers-perfil.js', 'public/backend/scripts/settings/customers-perfil.min.js');
mix.scripts('resources/assets/scripts/settings/forms-payments.js', 'public/backend/scripts/settings/forms-payments.min.js');
mix.scripts('resources/assets/scripts/settings/keywords.js', 'public/backend/scripts/settings/keywords.min.js');
mix.scripts('resources/assets/scripts/settings/kits.js', 'public/backend/scripts/settings/kits.min.js');
mix.scripts('resources/assets/scripts/settings/modules.js', 'public/backend/scripts/settings/modules.min.js');
mix.scripts('resources/assets/scripts/settings/percents.js', 'public/backend/scripts/settings/percents.min.js');
mix.scripts('resources/assets/scripts/settings/permissions.js', 'public/backend/scripts/settings/permissions.min.js');
mix.scripts('resources/assets/scripts/settings/profiles.js', 'public/backend/scripts/settings/profiles.min.js');
mix.scripts('resources/assets/scripts/settings/shippings.js', 'public/backend/scripts/settings/shippings.min.js');
mix.scripts('resources/assets/scripts/settings/status-payments.js', 'public/backend/scripts/settings/status-payments.min.js');
mix.scripts('resources/assets/scripts/settings/subjects.js', 'public/backend/scripts/settings/subjects.min.js');
mix.scripts('resources/assets/scripts/settings/template.js', 'public/backend/scripts/settings/template.min.js');
mix.scripts('resources/assets/scripts/settings/unit-measures.js', 'public/backend/scripts/settings/unit-measures.min.js');




mix.scripts('resources/assets/scripts/banners.js', 'public/backend/scripts/banners.min.js');
mix.scripts('resources/assets/scripts/brands.js', 'public/backend/scripts/brands.min.js');
mix.scripts('resources/assets/scripts/categories.js', 'public/backend/scripts/categories.min.js');
mix.scripts('resources/assets/scripts/content-site.js', 'public/backend/scripts/content-site.min.js');

mix.scripts('resources/assets/scripts/orders/orders.js', 'public/backend/scripts/orders/orders.min.js');
mix.scripts('resources/assets/scripts/orders/excludeds.js', 'public/backend/scripts/orders/excludeds.min.js');
mix.scripts('resources/assets/scripts/orders/items.js', 'public/backend/scripts/orders/items.min.js');
mix.scripts('resources/assets/scripts/orders/notes.js', 'public/backend/scripts/orders/notes.min.js');
mix.scripts('resources/assets/scripts/orders/shippings.js', 'public/backend/scripts/orders/shippings.min.js');

mix.scripts('resources/assets/scripts/products/products.js', 'public/backend/scripts/products/products.min.js');
mix.scripts('resources/assets/scripts/products/colors.js', 'public/backend/scripts/products/colors.min.js');
mix.scripts('resources/assets/scripts/products/positions.js', 'public/backend/scripts/products/positions.min.js');
mix.scripts('resources/assets/scripts/products/grids.js', 'public/backend/scripts/products/grids.min.js');
mix.scripts('resources/assets/scripts/products/catalog.js', 'public/backend/scripts/products/catalog.min.js');
mix.scripts('resources/assets/scripts/products/stock.js', 'public/backend/scripts/products/stock.min.js');

mix.scripts('resources/assets/scripts/reports/inventory.js', 'public/backend/scripts/reports/inventory.min.js');

mix.scripts('resources/assets/scripts/sections.js', 'public/backend/scripts/sections.min.js');
mix.scripts('resources/assets/scripts/sliders.js', 'public/backend/scripts/sliders.min.js');
mix.scripts('resources/assets/scripts/wishlist.js', 'public/backend/scripts/wishlist.min.js');


mix.scripts('resources/assets/scripts/gateways/pagseguro.js', 'public/backend/scripts/gateways/pagseguro.min.js');




/*
 |--------------------------------------------------------------------------
 | Error pages stylesheet styles
 |--------------------------------------------------------------------------
 | min-width.css  2x.css, 480.css, 768.css, 992.css, 1200.css
 |
 */
mix.styles([
    'resources/assets/css/reset.css',
    'resources/assets/css/style.css',
    'resources/assets/css/colors.css',
    'resources/assets/css/error.css',
], 'public/backend/css/error.min.css');

mix.scripts([
    'resources/assets/js/libs/jquery/jquery-3.2.1.min.js',
    'resources/assets/js/setup.js',
], 'public/backend/js/error.min.js');





if (mix.inProduction()) {
    mix.version();
}
