<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Putusan;

class PutusanTable extends DataTableComponent
{
    protected $model = Putusan::class;
    protected $listeners = ['refreshPutusanTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['putusans.id']);
    }

    public function columns(): array
    {
        return [
            Column::make("Tanggal", "tanggal_putusan")
                ->format(function ($row) {
                    return \Carbon\Carbon::parse($row)->format('d-m-Y');
                })
                ->searchable()
                ->sortable(),
            Column::make("No Putusan Pengadilan", "no_putusan")
                ->searchable()
                ->sortable(),
            Column::make("Pengadilan", "pengadilan")
                ->searchable()
                ->sortable(),
            Column::make("Penuntut Umum", "penuntut")
                ->searchable()
                ->sortable(),
            Column::make("Terpidana", "terpidana")
                ->searchable()
                ->sortable(),
            Column::make('Amar Putusan')
                ->label(function ($row, Column $column) {
                    return view('action.detail-penyitaan', ['row' => $row]);
                }),
            Column::make('Aksi')
                ->label(function ($row, Column $column) {
                    return view('action.putusan', ['data' => $row]);
                }),
        ];
    }
}
