<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Penyitaan;
use Illuminate\Database\Eloquent\Builder;

class PenyitaanTable extends DataTableComponent
{
    protected $model = Penyitaan::class;
    protected $listeners = ['refreshPenyitaanTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['penyitaans.id']);
    }

    public function builder(): Builder
    {
        return Penyitaan::query()->with('putusan');
    }

    public function columns(): array
    {
        return [
            Column::make("Tanggal", "tanggal_penyitaan")
                ->format(function ($row) {
                    return \Carbon\Carbon::parse($row)->format('d-m-Y');
                })
                ->searchable()
                ->sortable(),
            Column::make("No Penetapan Penyitaan", "no_penyitaan")
                ->searchable()
                ->sortable(),
            Column::make("Tanggal Register", "tanggal_register")
                ->format(function ($row) {
                    if ($row != NULL) {
                        return \Carbon\Carbon::parse($row)->format('d-m-Y');
                    } else {
                        return "-";
                    }
                })
                ->searchable()
                ->sortable(),
            Column::make("No Register", "no_register")
                ->searchable()
                ->sortable(),
            Column::make("Pengadilan", "pengadilan")
                ->searchable()
                ->sortable(),
            Column::make("Penyidik", "penyidik")
                ->searchable()
                ->sortable(),
            Column::make("Penuntut Umum", "penuntut")
                ->searchable()
                ->sortable(),
            Column::make("Terdakwa", "tersangka")
                ->searchable()
                ->sortable(),
            Column::make('Barang Bukti')
                ->label(function ($row, Column $column) {
                    return view('action.detail-penyitaan', ['row' => $row]);
                }),
            Column::make('Aksi')
                ->label(function ($row, Column $column) {
                    return view('action.penyitaan', ['data' => $row]);
                }),
        ];
    }
}
