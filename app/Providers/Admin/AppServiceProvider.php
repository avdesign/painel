<?php

namespace AVDPainel\Providers\Admin;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (env('APP_ENV') === 'production') {
            $this->app['request']->server->set('HTTPS', true);
        }

        $models = array(
            'Admin',
            'AdminAccess',
            'AdminPermission',
            'Brand',
            'Catalog',
            'Category',
            'ConfigAdmin',
            'ConfigBanner',
            'ConfigBrand',
            'ConfigCategory',
            'ConfigColorGroup',
            'ConfigColorPosition',
            'ConfigFormPayment',
            'ConfigFreight',
            'ConfigKeyword',
            'ConfigKit',
            'ConfigModule',
            'ConfigPage',
            'ConfigPercent',
            'ConfigPermission',
            'ConfigProduct',
            'ConfigProfile',
            'ConfigProfileClient',
            'ConfigSection',
            'ConfigShipping',
            'ConfigSite',
            'ConfigSlider',
            'ConfigStatusPayment',
            'ConfigSubjectContact',
            'ConfigSystem',
            'ConfigTemplate',
            'Contact',
            'ContactSpam',
            'ConfigUnitMeasure',
            'ContentContract',
            'ContentDelivery',
            'ContentDeliveryReturn',
            'ContentFaq',
            'ContentFormPayment',
            'ContentPrivacyPolicy',
            'ContentTermsConditions',
            'GridBrand',
            'GridCategory',
            'GridProduct',
            'GridSection',
            'GroupColor',
            'ImageAdmin',
            'ImageCategory',
            'ImageColor',
            'ImageBanner',
            'ImageBrand',
            'ImagePosition',
            'ImageSection',
            'ImageSlider',
            'Inventory',
            'Order',
            'OrderItem',
            'OrderNote',
            'OrderShipping',
            'PaymentBillet',
            'Product',
            'ProductCost',
            'ProductPrice',
            'Section',
            'State',
            'Stock',
            'User',
            'UserAddress',
            'UserNote',
            'Wishlist'
        );

        foreach ($models as $model) {
            $this->app->bind("AVDPainel\Interfaces\Admin\\{$model}Interface", "AVDPainel\Repositories\Admin\\{$model}Repository");
        }


        /**
         * Services
         */
        $services = array(
            'PagSeguro'
        );

        foreach ($services as $service) {
            $this->app->bind("AVDPainel\Services\Admin\\{$service}ServicesInterface", "AVDPainel\Services\Admin\\{$service}Services");
        }


    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
