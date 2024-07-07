@extends('layouts.front')
@section('title', 'Barang Bukti')
@push('headscripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css" rel="stylesheet">
    <style>
        /*QuickReset*/
        * {
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            position: relative;
            /* padding: 10px 0; */
            display: flex;
            flex-direction: column;
            min-height: 100dvh;
        }

        .header,
        .footer {
            background: #ff1493;
            color: #fff;
            text-align: center;
            padding: 10px 0;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            background: #ff1493;
        }

        .header .icon {
            font-size: 24px;
            color: #fff;
        }

        .header h1 {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }

        .whatsapp-btn {
            position: fixed;
            width: 60px;
            height: 60px;
            background-color: #25d366;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            font-size: 28px;
            line-height: 60px;
            box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.25);
            bottom: 20px;
            left: 20px;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        .whatsapp-btn i {
            margin-top: 20px;
        }

        .whatsapp-btn:hover {
            background-color: #128c7e;
            transform: scale(1.1);
        }

        #header .logo h1 {
            margin: 0;
            padding: 0;
        }

        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #e83e8c;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #d83277;
        }

        #main {
            flex: 1;
            padding-top: 60px;
        }

        .footer {
            /* position: fixed; */
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
@endpush
@section('content')
    <!-- ======= Header ======= -->
    <header id="header" class="fixed-top d-flex align-items-center" style="background-color: #FFB4C2;">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="logo">
                        <a href="{{ url('/home') }}" class="back-button"><i class="bi bi-arrow-left"></i> Kembali</a>
                    </div>
                </div>
                <div class="col-4 text-end">
                    <div class="icon"><img src="{{ asset('assets/img/logo-bg.png') }}" alt="App Icon" width="48">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header -->

    <main id="main">
        <!-- ======= About Section ======= -->
        <section id="about" class="about">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <h4 class="text-center">Barang Bukti</h4>
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered yajra-datatable">
                                <thead>
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Tersangka</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End About Section -->
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Kejaksaan Negeri Banjarnegara</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- WhatsApp Button -->
    <a href="https://wa.me/{{ $wa }}" class="whatsapp-btn" target="_blank"><i class="bi bi-whatsapp"></i></a>

    <!-- Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Tanggal Masuk Kejaksaan</th>
                                    <td><span id="tanggalMasuk"></span></td>
                                </tr>
                                <tr>
                                    <th>Nama Tersangka</th>
                                    <td><span id="namaTersangka"></span></td>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <td><span id="namaBarang"></span></td>
                                </tr>
                                <tr>
                                    <th>Keterangan</th>
                                    <td><span id="keterangan"></span></td>
                                </tr>
                                <tr>
                                    <th>Amar Putusan</th>
                                    <td><span id="amarPutusan"></span></td>
                                </tr>
                                <tr id="rowFoto1">
                                    <th colspan="2">Foto Barang</th>
                                </tr>
                                <tr id="rowFoto2">
                                    <td colspan="2"><img class="img-fluid" id="fotoBarang" /></td>
                                </tr>
                            </table>
                            <div id="eksekusi">
                                <hr>
                                <h5>Eksekusi</h5>
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Tanggal Eksekusi</th>
                                        <td><span id="tanggalEksekusi"></span></td>
                                    </tr>
                                    <tr>
                                        <th>Keterangan Eksekusi</th>
                                        <td><span id="keteranganEksekusi"></span></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="ambilBarang">
                                <hr>
                                <h5>Pengambilan Barang</h5>
                                <p>Untuk melakukan pengambilan barang silahkan persiapkan beberapa syarat berikut :</p>
                                <ol>
                                    <li>Identitas Asli & Fotocopy (KTP/SIM)</li>
                                    <li>Surat Kuasa Bermaterai (Apabila Diwakilkan)</li>
                                    <li>Dokumen kepemilikan barang (Apabila Ada)</li>
                                    <li>Formulir Pengambilan Barang Bukti (Unduh pada link dibawah ini)</li>
                                </ol>
                                <div class="text-center">
                                    <a class="btn btn-sm btn-primary" href="{{ url('/form-pengambilan-bb.pdf') }}">Unduh
                                        Form Pengambilan Barang Bukti</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footscripts')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script type="text/javascript">
        function openDetailModal(id) {
            $.get("/barangbukti" + '/' + id + '/get', function(data) {
                // console.log(data);
                $('#tanggalMasuk').html(data.penyitaan.tanggal_penyitaan);
                $('#namaBarang').html(data.nama_barang);
                $('#keterangan').html(data.keterangan);
                $('#namaTersangka').html(data.penyitaan.tersangka);
                if (data.status == 0) {
                    $('#ambilBarang').hide();
                    $('#amarPutusan').attr('class', 'badge bg-secondary');
                    $('#amarPutusan').html("-");
                } else if (data.status == 1) {
                    $('#ambilBarang').show();
                    $('#amarPutusan').attr('class', 'badge bg-primary text-white');
                    $('#amarPutusan').html('Dikembalikan kepada yang berhak');
                } else if (data.status == 2) {
                    $('#ambilBarang').hide();
                    $('#amarPutusan').attr('class', 'badge bg-danger');
                    $('#amarPutusan').html('Dimusnahkan');
                } else if (data.status == 3) {
                    $('#ambilBarang').hide();
                    $('#amarPutusan').attr('class', 'badge bg-success');
                    $('#amarPutusan').html('Dirampas untuk negara (Lelang)');
                }
                if (data.foto != null) {
                    $('#rowFoto1').show();
                    $('#rowFoto2').show();
                    $('#fotoBarang').show();
                    $('#fotoBarang').attr('src', '/storage/bb/' + data.foto);
                } else {
                    $('#rowFoto1').hide();
                    $('#rowFoto2').hide();
                    $('#fotoBarang').hide();
                }
                if (data.tanggal_eksekusi != null) {
                    $('#eksekusi').show();
                    if (data.status == 1) {
                        $('#ambilBarang').hide();
                    }
                    $('#tanggalEksekusi').html(data.tanggal_eksekusi);
                    $('#keteranganEksekusi').html(data.ket_eksekusi);
                } else {
                    if (data.status == 1) {
                        $('#ambilBarang').show();
                    }
                    $('#eksekusi').hide();
                }
            })
        }
    </script>
    <script type="text/javascript">
        $(function() {

            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('barangbukti.get') }}",
                columns: [{
                        data: 'nama_barang',
                        name: 'nama_barang'
                    },
                    {
                        data: 'penyitaan.tersangka',
                        name: 'tersangka'
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ]
            });

        });
    </script>
@endpush
