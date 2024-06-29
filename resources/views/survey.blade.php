@extends('layouts.front')
@section('title', 'Survey Kepuasan')
@push('headscripts')
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                        @if (session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        <h4 class="fw-bold text-center mt-3">Survey Kepuasan</h4>
                        <form class="px-4" method="POST" action="{{ route('survey.store') }}">
                            @csrf
                            <p class="fw-bold">Apakah Anda puas menggunakan aplikasi ini ?</p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kepuasan" value="4"
                                    id="SangatPuas" required />
                                <label class="form-check-label" for="SangatPuas">
                                    Sangat Memuaskan
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kepuasan" value="3"
                                    id="Puas" />
                                <label class="form-check-label" for="Puas">
                                    Memuaskan
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kepuasan" value="2"
                                    id="CukupPuas" />
                                <label class="form-check-label" for="CukupPuas">
                                    Cukup Memuaskan
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="kepuasan" value="1"
                                    id="KurangPuas" />
                                <label class="form-check-label" for="KurangPuas">
                                    Kurang Memuaskan
                                </label>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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

@endsection
