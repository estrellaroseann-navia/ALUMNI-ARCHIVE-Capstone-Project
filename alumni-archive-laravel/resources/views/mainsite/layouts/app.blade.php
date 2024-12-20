<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Alumni Archive</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('') }}/img/favicon.png" rel="icon">
  <link href="{{ asset('') }}/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap"
    rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
  <link href="{{ asset('vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

  <!-- Main CSS File -->
  <link rel="stylesheet" href="{{ asset('css/mainsite/main.css') }}">

</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center position-relative">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

      <a href="index.html" class="logo d-flex align-items-center">
        <h1 class="sitename">Alumni Archive</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
            <li><a href="{{ route('home.page') }}" class="{{ request()->routeIs('home.page') ? 'active' : '' }}">Home</a></li>
            <li><a href="{{ route('about.page') }}" class="{{ request()->routeIs('about.page') ? 'active' : '' }}">About Us</a></li>
            <li><a href="{{ route('donation.page') }}" class="{{ request()->routeIs('donation.page') ? 'active' : '' }}">Donation</a></li>
            <li><a href="{{ route('survey.page') }}" class="{{ request()->routeIs('survey.page') ? 'active' : '' }}">Take a Tracking Survey</a></li>
            <li><a href="{{ route('contact.page') }}" class="{{ request()->routeIs('contact.page') ? 'active' : '' }}">Contact</a></li>


    @auth('student')
    <li> <!-- Check if the 'student' guard is authenticated -->
        <div class="ms-auto dropdown">
            <a
                href="#"
                class="d-flex align-items-center text-decoration-none dropdown-toggle"
                id="profileDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">
                <span class="me-2" id="navbarUserName">{{ auth('student')->user()->profile->first_name }}</span> <!-- Show the student's first name -->
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="{{ url('/profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </div>
    </li>
    @endauth



        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
       @guest('student')
    <!-- Content to be shown when the student is not logged in -->
        <a class="btn btn-warning active " href="{{ route('login') }}">Login</a>
        @endguest
    </div>
  </header>

  @yield('content')


  <footer id="footer" class="footer dark-background">



    <div class="text-center copyright">
      <div
        class="container d-flex flex-column flex-lg-row justify-content-center justify-content-lg-between align-items-center">

        <div class="d-flex flex-column align-items-center align-items-lg-start">
          <div>
            © Copyright <strong><span>Thesis nyo haha</span></strong>. All Rights Reserved
          </div>
        </div>

        <div class="order-first mb-3 social-links order-lg-last mb-lg-0">
          <a href=""><i class="bi bi-twitter-x"></i></a>
          <a href=""><i class="bi bi-facebook"></i></a>
          <a href=""><i class="bi bi-instagram"></i></a>
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
  <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  {{-- <script src="{{ asset('vendor/php-email-form/validate.js') }}"></script> --}}
  <script src="{{ asset('vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('vendor/glightbox/js/glightbox.min.js') }}"></script>

  <!-- Main JS File -->
   <script src="{{ asset('js/mainsite/main.js') }}"></script>
</body>

</html>
