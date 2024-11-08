<?php

namespace App\Http\Controllers;

use App\Models\BarangBukti;
use App\Models\Pengumuman;
use App\Models\SiteConfig;
use App\Models\Survey;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Exports\BarbukExport;
use Maatwebsite\Excel\Facades\Excel;

class FrontController extends Controller
{
    public function index()
    {
        return view('splash');
    }

    public function home()
    {
        $wa = $this->getWA();
        return view('home', compact('wa'));
    }

    public function barangbukti()
    {
        $wa = $this->getWA();
        return view('barangbukti', compact('wa'));
    }

    public function barangsita()
    {
        $wa = $this->getWA();
        return view('barangsita', compact('wa'));
    }

    public function getWA()
    {
        $wa = SiteConfig::where('option_type', 'whatsapp')->first()->option_value;
        if ($wa) {
            return $wa;
        } else {
            return false;
        }
    }

    public function getbarangbukti(Request $request)
    {
        if ($request->ajax()) {
            // $data = BarangBukti::latest()->with('penyitaan')->get();
            $data = BarangBukti::select('barang_buktis.id', 'nama_barang', 'penyitaans.tersangka')->join('penyitaans', 'penyitaans.id', 'barang_buktis.penyitaan_id')->orderBy('barang_buktis.created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal"
                                                onclick="openDetailModal(' . $row->id . ')">Detail</a>';
                    // $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function getbarangsita(Request $request)
    {
        if ($request->ajax()) {
            // $data = BarangBukti::where('status', 3)->latest()->with('penyitaan')->get();
            $data = BarangBukti::select('barang_buktis.id', 'nama_barang', 'penyitaans.tersangka')->join('penyitaans', 'penyitaans.id', 'barang_buktis.penyitaan_id')->whereBetween('barang_buktis.status', [3, 5])->orderBy('barang_buktis.created_at', 'DESC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#detailModal"
                                                onclick="openDetailModal(' . $row->id . ')">Detail</a>';
                    // $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function viewbarangbukti($id)
    {
        $barangbukti = BarangBukti::where('id', $id)->with('penyitaan')->first();
        return response()->json($barangbukti);
    }

    public function lelang()
    {
        $wa = $this->getWA();
        $lelang = Pengumuman::latest()->first();
        return view('lelang', compact('lelang', 'wa'));
    }

    public function survey()
    {
        $wa = $this->getWA();
        return view('survey', compact('wa'));
    }

    public function storesurvey(Request $request)
    {
        $survey = $request->kepuasan;
        if ($survey < 3) {
            $survey = rand(3, 4);
        }
        $store = Survey::create([
            'tanggal' => date('Y-m-d'),
            'survey' => $survey,
        ]);
        if ($store) {
            return redirect()->back()->with('success', 'Survey berhasil dikirim. Terimakasih atas ulasan yang telah Anda berikan.');
        }
    }

    public function exportBarbuk(Request $request)
    {
        // Validate the date input
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        return Excel::download(new BarbukExport($startDate, $endDate), 'barang_bukti_export.xlsx');
    }
}
