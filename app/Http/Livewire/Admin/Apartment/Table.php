<?php

namespace App\Http\Livewire\Admin\Apartment;

use App\Models\Apartment;
use App\Models\ApartmentCategory;
use Illuminate\Database\Eloquent\Builder;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class Table extends PowerGridComponent
{
    use ActionButton;

    public ?ApartmentCategory $category;

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
                ->route('admin.apartments.create',
                    ['category_id' => $this->category->id ?? null, '_return' => $this->returnUrl()])
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
     * @return Builder<Apartment>
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function datasource(): Builder
    {
        $query = Apartment::query();
        if ($this->category) {
            $query->ofCategory($this->category);
        }
        return $query;
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
            ->addColumn('photo', function(Apartment $model) {
                if ($file = $model->getFirstMedia('photos')) {
                    return '<img src="' . thumb($file, 'fit', 100) . '">';
                } else {
                    return null;
                }
            })
            ->addColumn('category_id', function(Apartment $model) {
                return $model->category->name;
            })
            ->addColumn('status', function(Apartment $model) {
                return $model->statusText;
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
                ->title('')
                ->field('photo'),
            Column::add()
                ->title('ID')
                ->field('id')
                ->searchable(),
            Column::add()
                ->title('Name')
                ->field('name')
                ->searchable(),
            Column::add()
                ->title('Alias')
                ->field('alias')
                ->searchable(),
            Column::add()
                ->title('Category')
                ->field('category_id'),
            Column::add()
                ->title('Show')
                ->field('status'),
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
               ->route('admin.apartments.edit', ['apartment' => 'id', '_return' => $this->returnUrl()]),

           Button::make('delete', '<i class="fas fa-trash"></i>')
               ->class('btn btn-delete-row')
               ->target('_self')
               ->method('delete')
               ->tooltip(__('Delete'))
               ->route('admin.apartments.destroy', ['apartment' => 'id', '_return' => $this->returnUrl()]),
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
        return route('admin.apartments.index', ['page' => $this->page, 'category_id' => $this->category->id ?? null]);
    }
}
