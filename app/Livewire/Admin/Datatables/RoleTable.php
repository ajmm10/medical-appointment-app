<?php

namespace App\Livewire\Admin\Datatables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Spatie\Permission\Models\Role;

class RoleTable extends DataTableComponent
{
    protected $model = Role::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('id');
        $this->setPerPage(10);
        $this->setPerPageAccepted([10, 25, 50]);
        $this->setSearchPlaceholder('Buscar');
        $this->setQueryStringDisabled();
        $this->setSortingPillsDisabled();
        $this->setFilterPillsDisabled();
        $this->setSecondaryHeaderDisabled();
        $this->setTableWrapperAttributes([
            'class' => 'overflow-hidden rounded-lg border border-slate-200 bg-white',
            'default' => false,
        ]);
        $this->setToolBarAttributes([
            'class' => 'mb-4 flex flex-col gap-3 px-0 sm:flex-row sm:items-center sm:justify-between',
            'default-styling' => false,
        ]);
        $this->setColumnSelectButtonAttributes([
            'class' => 'inline-flex items-center justify-center rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50',
            'default-styling' => false,
            'default-colors' => false,
        ]);
        $this->setPerPageFieldAttributes([
            'class' => 'w-24 rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200',
            'default-styling' => false,
            'default-colors' => false,
        ]);
        $this->setTableAttributes([
            'class' => 'min-w-full',
            'default' => false,
        ]);
        $this->setTheadAttributes([
            'class' => 'bg-slate-50',
            'default' => false,
        ]);
        $this->setThAttributes(function (): array {
            return [
                'class' => 'px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-500',
            ];
        });
        $this->setTdAttributes(function (): array {
            return [
                'class' => 'px-6 py-4 text-sm text-slate-800',
            ];
        });
        $this->setSearchFieldAttributes([
            'class' => 'w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm text-slate-700 focus:border-indigo-300 focus:ring focus:ring-indigo-200',
            'default' => false,
            'default-styling' => false,
            'default-colors' => false,
        ]);
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id')
                ->sortable(),
            Column::make('Nombre', 'name')
                ->sortable(),
            Column::make('Proteccion', 'is_system')
                ->label(function ($row) {
                    return view('admin.roles.protection-badge', ['role' => $row]);
                })
                ->sortable(),
            Column::make('Fecha', 'created_at')
                ->format(fn ($value) => $value->format('Y-m-d H:i:s'))
                ->sortable(),
            Column::make('Acciones')
                ->label(function ($row) {
                    return view('admin.roles.actions', ['role' => $row]);
                }),
        ];
    }
}
