@extends('layouts.front')
@section('title', 'Main Menu')
@push('headscripts')
    <!-- Custom CSS for Modern Look -->
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

        .main-content {
            flex: 1;
            text-align: center;
            padding: 20px;
            margin-top: 60px;
            background: #f0f5f9;
            border-radius: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .main-content h2 {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .icon-card {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            flex: 1 1 calc(50% - 20px);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s ease-in-out;
        }

        .icon-card:hover {
            transform: translateY(-10px);
        }

        .icon-card .icon {
            font-size: 40px;
            color: #ff1493;
            margin-bottom: 10px;
        }

        .icon-card .title {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        .footer {
            /* position: fixed; */
            bottom: 0;
            width: 100%;
            text-align: center;
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
            right: 20px;
            z-index: 1000;
            transition: all 0.3s ease-in-out;
        }

        .whatsapp-btn:hover {
            background-color: #128c7e;
            transform: scale(1.1);
        }

        @media (max-width: 768px) {
            .icon-card {
                flex: 1 1 100%;
                margin: 10px 0;
            }

            .main-content {
                padding: 10px;
                margin-top: 80px;
            }
        }

        /* Cloud Decoration */
        .cloud {
            position: absolute;
            background: white;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .cloud:before,
        .cloud:after {
            content: '';
            position: absolute;
            background: white;
            width: 100%;
            height: 100%;
            border-radius: 50%;
        }

        .cloud:before {
            top: -50%;
            left: 50%;
            width: 75%;
            height: 75%;
        }

        .cloud:after {
            top: -25%;
            left: -25%;
            width: 50%;
            height: 50%;
        }

        .cloud1 {
            width: 100px;
            height: 60px;
            position: absolute;
            top: 120px;
            right: 20px;
        }

        .cloud2 {
            width: 80px;
            height: 48px;
            top: 80px;
            left: 30px;
        }
    </style>
@endpush

@section('content')
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <!-- <div class="icon"><i class="bi bi-arrow-left"></i></div> -->
        <h1>SI-PERBASI</h1>
        <div class="icon"><img src="{{ asset('assets/img/logo-bg.png') }}" alt="App Icon" width="48"></div>
    </header>
    <!-- End Header -->

    <main id="main" class="main-content">
        <h2 style="color: #ff69b4; font-family: 'Arial', sans-serif;">Hallo, Selamat Datang<br>Silahkan Pilih Layanan Kami
        </h2>


        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="{{ url('/barangbukti') }}">
                        <div class="icon-card">
                            <div class="icon"><i class="bx bx-fingerprint"></i></div>
                            <h4 class="title" style="color: #ff8da1;">Daftar Barang Bukti</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="{{ url('/barangsita') }}">
                        <div class="icon-card">
                            <div class="icon"><i class="bx bx-package"></i></div>
                            <h4 class="title" style="color: #ff8da1;">Daftar Barang Rampasan Negara</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="{{ url('/lelang') }}">
                        <div class="icon-card">
                            <div class="icon"><i class="bx bx-bell"></i></div>
                            <h4 class="title" style="color: #ff8da1;">Pengumuman Lelang</h4>
                        </div>
                    </a>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="{{ url('/survey') }}">
                        <div class="icon-card">
                            <div class="icon"><i class="bx bx-bar-chart"></i></div>
                            <h4 class="title" style="color: #ff8da1;">Survey Kepuasan</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </main>
    <!-- End #main -->

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="container">
            <div class="copyright">
                &copy; Copyright <strong><span>Kejaksaan Negri Banjarnegara</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>
    <!-- End Footer -->

    <!-- WhatsApp Button -->
    <a href="https://wa.me/{{ $wa }}" class="whatsapp-btn" target="_blank">
        <i class="bi bi-whatsapp"></i>
    </a>
@endsection
