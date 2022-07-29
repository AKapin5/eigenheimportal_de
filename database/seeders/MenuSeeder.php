<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanUp();
        echo 'Seeding menu items..' . PHP_EOL;
        $menuItems = $this->getMenuItems();
        foreach ($menuItems as $menuItem) {
            $model = new Menu();
            $model->url = $menuItem['url'];
            foreach (supportedLocales() as $locale) {
                $model->setTranslation('title', $locale, $menuItem['title']);
            }
            $model->assignNewSort();
            $model->save();
            echo $model->id . PHP_EOL;
        }
        echo 'FINISHED.' . PHP_EOL;
    }

    public function getMenuItems()
    {
        return [
            [
                'title' => 'Referenzen',
                'url' => '/objects',
            ],
            [
                'title' => 'Gewerbe',
                'url' => '/objects/gewerbe',
            ],
            [
                'title' => 'Wohnobjecte',
                'url' => '/objects/eigentumswohnung',
            ],
            [
                'title' => 'Blog',
                'url' => '/blog',
            ],
            [
                'title' => 'Kontact',
                'url' => '/contact',
            ],
        ];
    }

    /**
     * @return void
     */
    protected function cleanUp()
    {
        Schema::disableForeignKeyConstraints();
        Menu::truncate();
        Schema::enableForeignKeyConstraints();
    }
}
