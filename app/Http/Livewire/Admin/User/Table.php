<?php

namespace App\Http\Livewire\Admin\User;

use App\Models\User;
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
                ->route('admin.users.create', ['_return' => $this->returnUrl()])
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
    * @return Builder<User>
    */
    public function datasource(): Builder
    {
        return User::query();
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
            ->addColumn('status', function(User $model) {
                return $model->statusText;
            })
            ->addColumn('roles', function(User $model) {
                return $model->roles()->pluck('name')->implode(', ');
            })
            ->addColumn('created_at_formatted', function (User $model) {
                return Carbon::parse($model->created_at)->format('d.m.Y H:i');
            })
            ->addColumn('updated_at_formatted', function (User $model) {
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
                ->title('Name')
                ->field('name')
                ->searchable(),
            Column::add()
                ->title('Email')
                ->field('email')
                ->searchable(),
            Column::add()
                ->title('Roles')
                ->field('roles'),
            Column::add()
                ->title('Status')
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
               ->route('admin.users.edit', ['user' => 'id', '_return' => $this->returnUrl()]),

           Button::make('delete', '<i class="fas fa-trash"></i>')
               ->class('btn btn-delete-row')
               ->target('_self')
               ->method('delete')
               ->tooltip(__('Delete'))
               ->route('admin.users.destroy', ['user' => 'id', '_return' => $this->returnUrl()]),
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
        return route('admin.users.index', ['page' => $this->page]);
    }
}
