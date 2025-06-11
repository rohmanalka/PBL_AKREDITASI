<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - Sistem Akreditasi</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('gplanding/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('gplanding/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Load jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Then load Bootstrap JS -->
    <script src="{{ asset('gplanding/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Load jQuery Validation Plugin -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
    <!-- SweetAlert untuk notifikasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('gplanding/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gplanding/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('gplanding/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('gplanding/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('gplanding/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('gplanding/assets/css/main.css') }}" rel="stylesheet">

    <script src="https://kit.fontawesome.com/349ee9c857.js" crossorigin="anonymous"></script>

    <!-- =======================================================
  * Template Name: Gp
  * Template URL: https://bootstrapmade.com/gp-free-multipurpose-html-bootstrap-template/
  * Updated: Aug 15 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page" data-locale="{{ app()->getLocale() }}">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center me-auto me-lg-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">{{ __('landingpg.judulhead') }}</h1>
                <span></span>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">{{ __('landingpg.home') }}<br></a></li>
                    <li><a href="#about">{{ __('landingpg.about') }}</a></li>
                    <li><a href="#services">{{ __('landingpg.visi') }}</a></li>
                    <li><a href="#team">{{ __('landingpg.team') }}</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <div class="d-flex align-items-center">
                <!-- Switch bahasa tanpa gambar -->
                <div class="form-check form-switch mb-0 me-3">
                    <input class="form-check-input" type="checkbox" id="languageToggle" onchange="toggleLanguage()" />
                    <label class="form-check-label text-white" for="languageToggle" style="cursor:pointer;"
                        id="language-label">ID</label>
                </div>

                <!-- Tombol Masuk -->
                <button onclick="modalAction('{{ url('login') }}')" class="btn-getstarted"
                    style="background-color: transparent">
                    {{ __('landingpg.login') }}
                </button>
            </div>
        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <img src="{{ asset('gplanding/assets/img/landingpage-bg.png') }}" alt="" data-aos="fade-in">
            <div class="container">
                <div class="row justify-content-center text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-xl-6 col-lg-8">
                        <h2>{{ __('landingpg.judullanding') }}</h2>
                        <p>{{ __('landingpg.prodi') }}</p>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->
        <!-- Modal Container -->
        <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" data-width="75%">
        </div>

        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container section-title" data-aos="fade-up">
                <h2>{{ __('landingpg.about') }}</h2>
                <p>{{ __('landingpg.profil') }}</p>
            </div><!-- End Section Title -->
            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">
                    <div class="col-lg-6 order-1 order-lg-2">
                        <img src="{{ asset('gplanding/assets/img/profilti-bg.png') }}" class="img-fluid"
                            alt="">
                    </div>
                    <div class="col-lg-6 order-2 order-lg-1 content">
                        <p class="fst-italic">
                            {{ __('landingpg.profile') }}
                        </p>
                        <ul>
                            <li><i class="bi bi-clock"></i> <span>{{ __('landingpg.profile_prodi') }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Services Section -->
        <section id="services" class="services section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>{{ __('landingpg.about') }}</h2>
                <p>{{ __('landingpg.vismis') }}</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="fa-solid fa-bullseye"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>{{ __('landingpg.sasaran') }}</h3>
                            </a>
                            <p style="text-align: justify;"> 
                                1. Meningkatnya akses relevansi, kuantitas, dan kualitas Pendidikan Program Studi D4 - SIB. <br>
                                2. Meningkatnya relevansi dan kualitas kegiatan pembelajaran di Program Studi D4 - SIB. <br>
                                3. Meningkatnya kualitas hasil kegiatan kemahasiswaan D4 - SIB dan inisiasi pembinaan karier untuk pembekalan lulusan.<br>
                                4. Meningkatnya relevansi, kuantitas, kualitas, dan kemanfaatan hasil penelitian seluruh sivitas akademika.<br>
                                5. Meningkatnya relevansi, kuantitas, kualitas, dan kemanfaatan hasil pengabdian kepada masyarakat untuk kesejahteraan masyarakat.<br>
                            </p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-broadcast"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>{{ __('landingpg.visi') }}</h3>
                            </a>
                            <p style="text-align: justify;">
                                Menjadi Program Studi Unggul dalam Bidang Sistem Informasi Bisnis di Tingkat Nasional dan
                                Internasional.
                            </p>
                        </div>
                    </div><!-- End Service Item -->

                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item position-relative">
                            <div class="icon">
                                <i class="bi bi-easel"></i>
                            </div>
                            <a href="service-details.html" class="stretched-link">
                                <h3>{{ __('landingpg.misi') }}</h3>
                            </a>
                            <p style="text-align: justify;">
                                1. Melaksanakan pendidikan vokasi yang inovatif berdasarkan pada sistem pendidikan
                                terapan dengan memanfaatkan kemajuan teknologi, sehingga mampu menghasilkan lulusan yang
                                memiliki kompetensi di bidang sistem informasi bisnis dan siap bersaing di tingkat
                                nasional dan global. <br>
                                2. Melaksanakan penelitian terapan berbasis produk dan jasa bidang Sistem Informasi
                                Bisnis.<br>
                                3. Melaksanakan pengabdian masyarakat dengan menggunakan kemajuan Sistem Informasi
                                Bisnis untuk meningkatkan kesejahteraan.<br>
                                4. Mewujudkan kerja sama yang saling menguntungkan dengan berbagai pihak baik di dalam
                                maupun di luar negeri pada bidang Sistem Informasi Bisnis
                            </p>
                        </div>
                    </div><!-- End Service Item -->
                </div>
            </div>
        </section><!-- /Services Section -->

        <!-- Team Section -->
        <section id="team" class="team section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>{{ __('landingpg.team') }}</h2>
                <p>{{ __('landingpg.we') }}</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="100">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('gplanding/assets/img/team/team-1.jpg') }}" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Muhammad Rohman Al Kautsar</h4>
                                <span>2341760055</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="200">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('gplanding/assets/img/team/puput.jpg') }}" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Aprilia Putri Anggraini</h4>
                                <span>2341760043</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="300">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('gplanding/assets/img/team/erika.jpg') }}" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Erika Atthacarya Putri Cahyani</h4>
                                <span>2341760158</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up"
                        data-aos-delay="400">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('gplanding/assets/img/team/malik.jpg') }}" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Malik Adzano Aryasatya D</h4>
                                <span>2341760161</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->

                    <div class="col-lg-3 col-md-6 d-flex align-items-stretch mx-auto" data-aos="fade-up"
                        data-aos-delay="400">
                        <div class="team-member">
                            <div class="member-img">
                                <img src="{{ asset('gplanding/assets/img/team/lia.png') }}" class="img-fluid"
                                    alt="">
                                <div class="social">
                                    <a href=""><i class="bi bi-instagram"></i></a>
                                    <a href=""><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                            <div class="member-info">
                                <h4>Rahmalia Mutia Farda</h4>
                                <span>2341760130</span>
                            </div>
                        </div>
                    </div><!-- End Team Member -->
                </div>
            </div>
        </section><!-- /Team Section -->

    </main>

    <footer id="footer" class="footer dark-background">
        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4 col-md-6 footer-about">
                        <a href="index.html" class="logo d-flex align-items-center">
                            <span class="sitename">{{ __('landingpg.judulhead') }}</span>
                        </a>
                        <div class="footer-contact pt-3">
                            <p>JTI POLINEMA</p>
                            <p>{{ __('landingpg.prodi') }}</p>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 footer-links">
                        <h4>{{ __('landingpg.link') }}</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#hero"> {{ __('landingpg.home') }}</a>
                            </li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#about">
                                    {{ __('landingpg.about') }}</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#team"> {{ __('landingpg.team') }}</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-3 footer-links">
                        <h4>{{ __('landingpg.informasi') }}</h4>
                        <ul>
                            <p><strong>{{ __('landingpg.alamat') }}:</strong> <span> Jl. Soekarno Hatta No.9</span></p>
                            <p><strong>{{ __('landingpg.kontak') }}:</strong> <span>(0341) 404424</span></p>
                        </ul>
                    </div>

                    <div class="col-lg-2 col-md-3 footer-links">
                        <h4>{{ __('landingpg.follow') }}</h4>
                        <div class="social-links d-flex mt-2">
                            <a href=""><i class="bi bi-instagram"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="copyright">
            <div class="container text-center">
                <p>© <span>Copyright</span> <strong class="px-1 sitename">PBL AKREDITASI KEL 2</strong></p>
                <div class="credits">
                    <!-- All the links in the footer should remain intact. -->
                    <!-- You can delete the links only if you've purchased the pro version. -->
                    <!-- Licensing information: https://bootstrapmade.com/license/ -->
                    <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a> Distributed by <a
                        href="https://themewagon.com">ThemeWagon</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('gplanding/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('gplanding/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('gplanding/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('gplanding/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('gplanding/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('gplanding/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('gplanding/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('gplanding/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('gplanding/assets/js/main.js') }}"></script>

    <script>
        function modalAction(url = '') {
            $('#myModal').load(url, function() {
                $('#myModal').modal('show');
            });
        }

        function toggleLanguage() {
            const checkbox = document.getElementById('languageToggle');
            const label = document.getElementById('language-label');

            // Tentukan bahasa berdasarkan status checkbox
            let locale = checkbox.checked ? 'en' : 'id';

            // Ubah label
            label.textContent = locale.toUpperCase();

            // Redirect ke route ganti bahasa
            window.location.href = `/lang/${locale}`;
        }

        // Set label awal sesuai session yang sudah disimpan di server
        document.addEventListener('DOMContentLoaded', function() {
            const checkbox = document.getElementById('languageToggle');
            const label = document.getElementById('language-label');

            // Ambil bahasa dari halaman, misal lewat data attribute di elemen body atau dari server (misal blade)
            // Contoh jika menggunakan blade: <body data-locale="{{ app()->getLocale() }}">
            const currentLocale = document.body.getAttribute('data-locale') || 'id';

            // Set checkbox dan label sesuai bahasa saat ini
            checkbox.checked = (currentLocale === 'en');
            label.textContent = currentLocale.toUpperCase();
        });
    </script>
</body>

</html>
