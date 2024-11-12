<?php

namespace App\Exports;

use App\Models\BarangBukti;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Carbon\Carbon;

class BarbukExport implements FromCollection, WithHeadings, WithMapping, WithCustomStartCell
{
    protected $startDate;
    protected $endDate;
    private $rowNumber = 0;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = Carbon::parse($startDate)->startOfDay();
        $this->endDate = Carbon::parse($endDate)->endOfDay();
    }
    /**
     * Fetch data with date range filtering
     */
    public function collection()
    {
        return BarangBukti::where('ekonomis_tinggi', 1)->whereBetween('tanggal_register', [$this->startDate, $this->endDate])->get();
    }

    /**
     * Define the headings
     */
    public function headings(): array
    {
        return [
            'NO',
            'SATKER',
            'NO. TGL REGISTER BENDA SITAAN / BARANG BUKTI',
            'NAMA TERSANGKA / TERDAKWA',
            'JENIS BARANG SITAAN/BUKTI',
            'JUMLAH SATUAN',
            'TEMPAT PENYIMPANAN',
            'KONDISI',
            'KETERANGAN',
        ];
    }

    /**
     * Map data to the export format
     */
    public function map($barang): array
    {
        $this->rowNumber++;
        $tgl_register = \Carbon\Carbon::parse($barang->penyitaan->tanggal_register)->format('d-m-Y');
        return [
            $this->rowNumber,
            "KEJAKSAAN NEGERI BANJARNEGARA",
            "{$barang->penyitaan->no_register} - {$tgl_register}",
            $barang->penyitaan->tersangka,
            $barang->nama_barang,
            $barang->satuan,
            "Gudang BB Kejaksaan Negeri Banjarnegara",
            $barang->kondisi,
            $barang->ket_sidang,
        ];
    }

    /**
     * Define starting cell if you want to start from a specific cell
     */
    public function startCell(): string
    {
        return 'A1';
    }
}
