<?php

namespace App\Http\Livewire\Admin\Page;

use App\Models\Page;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Rules\{Rule, RuleActions};
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\{Button, Column, Exportable, Footer, Header, PowerGrid, PowerGridComponent, PowerGridEloquent};

final class Table extends PowerGridComponent
{
    use ActionButton;

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
                ->route('admin.pages.create', ['_return' => $this->returnUrl()])
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
    * @return Builder<Page>
    */
    public function datasource(): Builder
    {
        return Page::query();
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
            ->addColumn('status', function(Page $model) {
                return $model->statusText;
            })
            ->addColumn('created_at_formatted', function (Page $model) {
                return Carbon::parse($model->created_at)->format('d.m.Y H:i');
            })
            ->addColumn('updated_at_formatted', function (Page $model) {
                return Carbon::parse($model->updated_at)->format('d.m.Y H:i');
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
                ->title('Alias')
                ->field('alias')
                ->searchable(),
            Column::add()
                ->title('Show')
                ->field('status'),
            Column::add()
                ->title('Created at')
                ->field('created_at_formatted', 'created_at'),
            Column::add()
                ->title('Updated at')
                ->field('updated_at_formatted', 'updated_at'),
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
               ->route('admin.pages.edit', ['page' => 'id', '_return' => $this->returnUrl()]),

           Button::make('delete', '<i class="fas fa-trash"></i>')
               ->class('btn btn-delete-row')
               ->target('_self')
               ->method('delete')
               ->tooltip(__('Delete'))
               ->route('admin.pages.destroy', ['page' => 'id', '_return' => $this->returnUrl()]),
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
        return route('admin.pages.index', ['page' => $this->page]);
    }
}
