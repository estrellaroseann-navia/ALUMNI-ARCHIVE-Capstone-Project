@extends('mainsite.layouts.app')
@section('content')
  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

      <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
            @foreach ($content as $item)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img src="{{ asset('storage/'. $item->src) }}" alt="">
                    <div class="carousel-container">
                        <h2>{{ $item->title }}</h2>
                        <p>{{ $item->description }}</p>
                    </div>
                </div><!-- End Carousel Item -->
            @endforeach



        <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
          <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
        </a>

        <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
          <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
        </a>

        <ol class="carousel-indicators"></ol>

      </div>

    </section><!-- /Hero Section -->



    <!-- Services 2 Section -->
    <section id="services-2" class="services-2 section dark-background">
      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h1>Milestones</h1>
      </div><!-- End Section Title -->

      <div class="services-carousel-wrap">
        <div class="container">
          <div class="swiper init-swiper">
            <script type="application/json" class="swiper-config">
              {
                "loop": true,
                "speed": 600,
                "autoplay": {
                  "delay": 5000
                },
                "slidesPerView": "auto",
                "pagination": {
                  "el": ".swiper-pagination",
                  "type": "bullets",
                  "clickable": true
                },
                "navigation": {
                  "nextEl": ".js-custom-next",
                  "prevEl": ".js-custom-prev"
                },
                "breakpoints": {
                  "320": {
                    "slidesPerView": 1,
                    "spaceBetween": 40
                  },
                  "1200": {
                    "slidesPerView": 3,
                    "spaceBetween": 40
                  }
                }
              }
            </script>
            <button class="navigation-prev js-custom-prev">
              <i class="bi bi-arrow-left-short"></i>
            </button>
            <button class="navigation-next js-custom-next">
              <i class="bi bi-arrow-right-short"></i>
            </button>
            <div class="swiper-wrapper">
                @foreach ($milestone as $item)
                    <div class="swiper-slide">
                        <div class="service-item">
                        <div class="service-item-contents">
                            <a href="#">
                            <h2 class="service-item-title">{{ $item->description }}</h2>
                              <a href="{{ $item->link }}"><span class="service-item-category">See More</span></a>
                            </a>
                        </div>
                        <img src="{{ asset('storage/'. $item->src) }}" alt="Image" class="img-fluid">
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>
      </div>
    </section><!-- /Services 2 Section -->



    <!-- Recent Posts Section -->
    <section id="recent-posts" class="recent-posts section">

      <!-- Section Title -->
      <div class="container section-title" >
        <h2>Recent Announcements</h2>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">
                @foreach ($announcement as $item )
                    <div class="col-xl-4 col-md-6" >
                        <div class="post-item position-relative h-100"  data-aos-delay="300">

                            <div class="overflow-hidden post-img position-relative">
                                <img src="{{ asset('storage/'. $item->src) }}" class="img-fluid" alt="">
                                <span class="post-date">{{ $item->created_at->format('M d') }}</span>
                            </div>

                            <div class="post-content d-flex flex-column">
                                 <h3 class="post-title">{{ $item->description }}</h3>
                                <a href="blog-details.html" class="readmore stretched-link"><span>See More</span><i
                                    class="bi bi-arrow-right"></i></a>

                            </div>

                        </div>
                    </div><!-- End post item -->
                @endforeach



        </div>

      </div>

    </section><!-- /Recent Posts Section -->

  </main>
@endsection
