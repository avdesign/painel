<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccountTypeTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(ConfigSiteTableSeeder::class);
        $this->call(ConfigPagesTableSeeder::class);
        $this->call(ConfigModulesTableSeeder::class);
        $this->call(ConfigProfilesTableSeeder::class);
        $this->call(ConfigPermissionsTableSeeder::class);
        $this->call(ConfigKeywordsTableSeeder::class);
        $this->call(ConfigProductTableSeeder::class);
        $this->call(ConfigFreightsTableSeeder::class);
        $this->call(ConfigPercentTableSeeder::class);
        $this->call(ConfigProfileClientTableSeeder::class);
        $this->call(ConfigShippingTableSeeder::class);
        $this->call(ConfigBrandTableSeeder::class);
        $this->call(ConfigAdminTableSeeder::class);
        $this->call(ConfigUnitMeasureTableSeeder::class);
        $this->call(ConfigKitTableSeeder::class);        
        $this->call(ConfigSectionTableSeeder::class);
        $this->call(ConfigCategoryTableSeeder::class);
        $this->call(ConfigColorPositionTableSeeder::class);
        $this->call(ConfigColorGroupTableSeeder::class);
        $this->call(ConfigSubjectContactTableSeeder::class);
        $this->call(ConfigFormPaymentTableSeeder::class);
        $this->call(ConfigStatusPaymentTableSeeder::class);
        $this->call(ConfigBannerTableSeeder::class);
        $this->call(ConfigBoxTableSeeder::class);
        $this->call(ConfigSliderTableSeeder::class);
        //$this->call(ContentFormPaymentTableSeeder::class);
        $this->call(ContentDeliveryReturnTableSeeder::class);
        $this->call(ContentPrivacyPoliciesTableSeeder::class);
        $this->call(ContentTermsConditionsTableSeeder::class);
        $this->call(SocialShareTableSeeder::class);
        $this->call(StateTableSeeder::class);
        $this->call(PaymentCompanyTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(ContactTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
