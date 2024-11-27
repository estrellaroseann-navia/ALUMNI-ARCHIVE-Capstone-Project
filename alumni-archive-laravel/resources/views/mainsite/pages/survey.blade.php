@extends('mainsite.layouts.app')
@section('content')
 <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Tracking Survey Form</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">


      <div class="container" data-aos="fade">

        <div class="row gy-5 gx-lg-5">



          <div class="col-lg-8">
            <form action="forms/contact.php" method="post" role="form" class="php-email-form">
              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required="">
                </div>
                <div class="mt-3 col-md-6 form-group mt-md-0">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required="">
                </div>
              </div>
              <div class="mt-3 form-group">
                <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" required="">
              </div>
              <div class="mt-3 form-group">
                <textarea class="form-control" name="message" placeholder="Message" required=""></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Your message has been sent. Thank you!</div>
              </div>
              <div class="text-center"><button type="submit">Send Message</button></div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->
  </main>
@endsection
