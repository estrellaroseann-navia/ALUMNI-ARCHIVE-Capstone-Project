@extends('mainsite.layouts.app')
@section('content')
      <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.webp);">
      <div class="container position-relative">
        <h1>Contact</h1>
      </div>
    </div><!-- End Page Title -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <div class="mb-5">
        <iframe style="width: 100%; height: 400px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen=""></iframe>
      </div><!-- End Google Maps -->

      <div class="container" data-aos="fade">

        <div class="row gy-5 gx-lg-5">

          <div class="col-lg-4">

            <div class="info">
              <h3>Get in touch</h3>
              <p>Et id eius voluptates atque nihil voluptatem enim in tempore minima sit ad mollitia commodi minus.</p>

              <div class="info-item d-flex">
                <i class="flex-shrink-0 bi bi-geo-alt"></i>
                <div>
                  <h4>Location:</h4>
                  <p>A108 Adam Street, New York, NY 535022</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="flex-shrink-0 bi bi-envelope"></i>
                <div>
                  <h4>Email:</h4>
                  <p>info@example.com</p>
                </div>
              </div><!-- End Info Item -->

              <div class="info-item d-flex">
                <i class="flex-shrink-0 bi bi-phone"></i>
                <div>
                  <h4>Call:</h4>
                  <p>+1 5589 55488 55</p>
                </div>
              </div><!-- End Info Item -->

            </div>

          </div>

          <div class="col-lg-8">
          <form action="{{ route('send.message') }}" method="post" id="messageForm" class="php-email-form">
            @csrf
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
                <div class="loading" style="display: none;">Loading...</div>
                <div id="successMessage" class="alert alert-success" style="display: none;"></div>
                <div id="errorMessage" class="alert alert-danger" style="display: none;"></div>
            </div>
            <div class="text-center">
                <button type="submit">Send Message</button>
            </div>
            </form>

          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).on('submit', '#messageForm', function(e) {
        e.preventDefault(); // Prevent default form submission

// Hide previous messages
        $('#successMessage, #errorMessage').hide();
        $('.loading').fadeIn(); // Show loading

        $.ajax({
            url: '{{ route('send.message') }}', // Laravel route
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                     $('#successMessage').html(response.message).fadeIn(); // Show the success message
                    setTimeout(function() {
                        $('#successMessage').fadeOut(); // Fade out the message after a delay
                    }, 3000);; // Show success message
                    $('#messageForm')[0].reset(); // Clear form fields

                } else {
                    $('#errorMessage').html(response.message).fadeIn(); // Show error message
                }
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    let errors = xhr.responseJSON.errors;
                    let errorMessages = Object.values(errors)
                        .map(err => err.join('<br>')) // Format errors
                        .join('<br>');
                    $('#errorMessage').html(errorMessages).fadeIn();
                } else {
                    $('#errorMessage').html('An unexpected error occurred. Please try again.').fadeIn();
                }
            },
            complete: function() {
                $('.loading').fadeOut(); // Hide loading message
            }
        });
    });
  </script>

@endsection
