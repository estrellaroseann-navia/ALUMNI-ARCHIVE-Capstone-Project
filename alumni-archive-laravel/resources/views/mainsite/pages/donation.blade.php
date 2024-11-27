@extends('mainsite.layouts.app')
@section('content')
  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade"
      style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Donation</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="content">
        <div class="container">
            @foreach ($content as $item)
                <div class="row">
                    <div class="mb-4 col-lg-6 mb-lg-0">
                        <img src="{{ asset('storage/'. $item->src) }}" alt="Image " class="img-fluid img-overlap" data-aos="zoom-out">
                        </div>
                        <div class="ml-auto col-lg-5" data-aos="fade-up" data-aos-delay="100">
                        <h2 class="mb-4 text-white content-title">
                            {{ $item->content }}
                        </h2>
                    </div>
                </div>
            @endforeach

        </div>
      </div>
    </section><!-- /About Section -->





  </main>
@endsection
