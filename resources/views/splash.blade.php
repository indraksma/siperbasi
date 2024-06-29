 @extends('layouts.front')
 @section('title', 'SIPERBASI')
 @push('headscripts')
     <style>
         h1,
         h2 {
             text-align: center;
             margin-bottom: 20px;
         }

         .logo {
             display: flex;
             align-items: center;
         }

         .logo img {
             height: 120px;
             margin-right: 10px;
         }
     </style>

     <script>
         setTimeout(function() {
             window.location.href = '/home';
         }, 5000);
     </script>
 @endpush
 @section('content')
     <!-- ======= Hero Section ======= -->
     <section id="hero">
         <div class="container">
             <div class="row justify-content-between">
                 <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                     <div data-aos="zoom-out">
                         <h1 style="text-align: center">SI <span>PERBASI</span></h1>
                         <h2>
                             SISTEM INFORMASI PELAYANAN PUBLIK PENGEMBALIAN BARANG
                             BUKTI/SITAAN
                         </h2>
                         <h2>KEJAKSAAN NEGERI BANJARNEGARA</h2>
                         <div class="text-center text-lg-start d-flex justify-content-center">
                             <img src="{{ asset('assets/img/logo-kejaksaan.png') }}" width="100" height="120"
                                 alt="Logo Kejaksaan" />
                             <img src="{{ asset('assets/img/logo-kabupaten.png') }}" width="100" height="120"
                                 alt="Logo Pemkab" />
                         </div>
                     </div>
                 </div>
                 <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                     <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid animated" alt="" />
                 </div>
             </div>
         </div>

         <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28" preserveAspectRatio="none">
             <defs>
                 <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18v44h-352z">
                 </path>
             </defs>
             <g class="wave1">
                 <use xlink:href="#wave-path" x="50" y="3" fill="rgba(255,255,255, .1)"></use>
             </g>
             <g class="wave2">
                 <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)"></use>
             </g>
             <g class="wave3">
                 <use xlink:href="#wave-path" x="50" y="9" fill="#fff"></use>
             </g>
         </svg>
     </section>
     <!-- End Hero -->

     <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
             class="bi bi-arrow-up-short"></i></a>
     <div id="preloader">
         <div class="fotter"><img src="{{ asset('assets/img/logo-kejaksaan.png') }}" width="58" height="63"
                 alt="" /><img src="{{ asset('assets/img/logo-kabupaten.png') }}" width="50" height="71"
                 alt="" /></div>
     </div>
 @endsection

 @push('footscripts')
     <!-- Vendor JS Files -->
     <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
     <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
     <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
     <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
     <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

     <!-- Template Main JS File -->
     <script src="{{ asset('assets/js/main.js') }}"></script>
 @endpush
