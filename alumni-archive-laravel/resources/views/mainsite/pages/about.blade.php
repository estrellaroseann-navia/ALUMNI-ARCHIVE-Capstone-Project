@extends('mainsite.layouts.app')
@section('content')
 <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
      style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>About</h1>
        <p>Esse dolorum voluptatum ullam est sint nemo et est ipsa porro placeat quibusdam quia assumenda numquam
          molestias.</p>
      </div>
    </div><!-- End Page Title -->

    <!-- About 3 Section -->
    <section id="about-3" class="about-3 section">
        @foreach ($content as $item )
             <div class="container">
        <div class="row gy-4 justify-content-between align-items-center">
          <div class="col-lg-6 order-lg-2 position-relative" data-aos="zoom-out">
            <img src="{{ asset('storage/'. $item->mission_img) }}" alt="Image" class="img-fluid">
          </div>
          <div class="col-lg-5 order-lg-1" data-aos="fade-up" data-aos-delay="100">
            <h2 class="mb-4 content-title">Mission</h2>
            <p class="mb-4">
             {{ $item->mission_text}}
            </p>
          </div>
        </div>
      </div>
      <div class="container">
        <div class="row gy-4 justify-content-between align-items-center">
          <div class="col-lg-6 order-lg-1 position-relative" data-aos="zoom-out">
            <img src="{{ asset('storage/'. $item->vision_img) }}" alt="Image" class="img-fluid">
          </div>
          <br>
          <br>
          <br>
          <br>
          <hr>

          <div class="col-lg-5 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <h2 class="mb-4 content-title">Vision</h2>
            <p class="mb-4">
              {{$item->vision_text}}
            </p>
          </div>
        </div>
      </div>
        @endforeach

    </section><!-- /About 3 Section -->
  </main>
@endsection
