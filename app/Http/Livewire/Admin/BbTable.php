<?php

namespace App\Http\Livewire\Admin;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\BarangBukti;
use Illuminate\Database\Eloquent\Builder;

class BbTable extends DataTableComponent
{
    protected $model = BarangBukti::class;

    protected $listeners = ['refreshBbTable' => '$refresh'];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setAdditionalSelects(['barang_buktis.id', 'barang_buktis.foto', 'barang_buktis.status', 'barang_buktis.tanggal_eksekusi', 'barang_buktis.putusan_id']);
    }

    public function builder(): Builder
    {
        return BarangBukti::query()->with('eksekusi');
    }

    public function columns(): array
    {
        return [
            Column::make("No Penyitaan", "penyitaan.no_penyitaan")
                ->sortable()
                ->searchable(),
            Column::make("No Putusan", "putusan.no_putusan")
                ->format(function ($row) {
                    return $row ?: '-';
                })
                ->sortable()
                ->searchable(),
            Column::make("Nama Barang", "nama_barang")
                ->sortable()
                ->searchable(),
            Column::make("Keterangan", "keterangan")
                ->sortable()
                ->searchable(),
            Column::make('Foto Barang')
                ->label(function ($row, Column $column) {
                    return view('action.foto', ['data' => $row]);
                }),
            Column::make('Amar Putusan')
                ->label(function ($row, Column $column) {
                    return view('action.amar-putusan', ['data' => $row]);
                }),
            Column::make('Aksi')
                ->label(function ($row, Column $column) {
                    return view('action.edit-delete', ['data' => $row]);
                }),
        ];
    }
}
