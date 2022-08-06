<?php

namespace App\Http\Livewire\Admin\Menu;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class Table extends PowerGridComponent
{
    use ActionButton;

    public ?Menu $parent;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): array
    {
        //$this->showCheckBox();
        return [
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Header
    |--------------------------------------------------------------------------
    |
    */
    public function header(): array
    {
        return [
            Button::add('create')
                ->route('admin.menus.create',
                    ['parent_id' => $this->parent->id ?? null, '_return' => $this->returnUrl()])
                ->caption(__('Create'))
                ->target('_self')
                ->class('btn btn-success')
        ];
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return Builder<Menu>
    */
    public function datasource(): Builder
    {
        return Menu::query()
            ->where('parent_id', $this->parent->id ?? null)
            ->orderBy('sort');
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('children', function(Menu $model) {
                $indexRoute = route("admin.menus.index", ['parent_id' => $model->id]);
                return '<a href="' . $indexRoute . '">' . __('Sub-items (:count)', ['count' => $model->children()->count()]) . '</a>';
            });
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->searchable(),
            Column::add()
                ->title('Title')
                ->field('title')
                ->searchable(),
            Column::add()
                ->title('Url')
                ->field('url')
                ->searchable(),
            Column::add()
                ->title('Status')
                ->field('status'),
            Column::add()
                ->title('Children')
                ->field('children'),
        ];
    }

     /**
     * PowerGrid Page Action Buttons.
     *
     * @return array<int, Button>
     */
    public function actions(): array
    {
       return [
           Button::make('edit', '<i class="fas fa-edit"></i>')
               ->class('btn')
               ->target('_self')
               ->tooltip(__('Edit'))
               ->route('admin.menus.edit', ['menu' => 'id', '_return' => $this->returnUrl()]),

           Button::make('delete', '<i class="fas fa-trash"></i>')
               ->class('btn btn-delete-row')
               ->target('_self')
               ->method('delete')
               ->tooltip(__('Delete'))
               ->route('admin.menus.destroy', ['menu' => 'id', '_return' => $this->returnUrl()]),
       ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid Page Action Rules.
     *
     * @return array<int, RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($page) => $page->id === 1)
                ->hide(),
        ];
    }
    */

    /**
     * @return string
     */
    protected function returnUrl(): string
    {
        return route('admin.menus.index', ['page' => $this->page, 'parent_id' => $this->parent->id ?? null]);
    }
}
