<x-Base-Layout>
    <!-- Hero section -->
    <section id="page-header" class="about-header">
        <h2>#Let's_Login</h2>
        <p>Start shopping</p>
      </section>
      <section id="form-details">
        <form id="loginForm" action="">
          @csrf
          
          {{-- <span>LEAVE A MESSAGE</span> --}}
          <h2>Login</h2>
          <span class="text-danger error-msg fs-6 ps-2" id="email-error"></span>
          <input type="text" name="email" id="email" placeholder="E-mail" />
          <span class="text-danger error-msg fs-6 ps-2" id="password-error"></span>
          <input type="password" name="password" id="password" placeholder="Password" />
          <p>You don't have an account? <span><a class="h6" href="{{ route('signup.create') }}">Signup Now</a></span></p>
          <button type="submit" id="login-btn" class="normal submit-btn">Login</button>
        </form>
        <div class="people">
          <div>
            <img
              src="{{ asset('images/people/1.png') }}
          "
              alt=""
            />
            <p>
              <span>John Doe</span> Senior Marketing Manager <br />
              Phone: + 000 123 000 77 88 <br />Email: contact@example.com
            </p>
          </div>
          <div>
            <img
              src="{{ asset('images/people/2.png') }}
          "
              alt=""
            />
            <p>
              <span>John Doe</span> Senior Marketing Manager <br />
              Phone: + 000 123 000 77 88 <br />Email: contact@example.com
            </p>
          </div>
          <div>
            <img
              src="{{ asset('images/people/3.png') }}
          "
              alt=""
            />
            <p>
              <span>John Doe</span> Senior Marketing Manager <br />
              Phone: + 000 123 000 77 88 <br />Email: contact@example.com
            </p>
          </div>
        </div>
      </section>
      @push('scripts')
        <script>
            $(document).ready(function(){
              $('#loginForm').submit(function(e){
                e.preventDefault();
                $('#login-btn').html('Processing...')
                $('.error-msg').html('');
                let formData = $(this).serialize();

                $.ajax({
                  url: "{{ route('authenticate') }}",
                  method: 'POST',
                  data: formData,
                  success: function(response){
                    if('redirect' in response){
                      $('.error-msg').html('');
                      window.location.href = response.redirect;
                    } else if ('error' in response){
                      $('#email-error').html(response.error);
                    }
                    $('#login-btn').html('Login')
                  },
                  error: function(xhr){
                    $('#login-btn').html('Login')
                    let errors = xhr.responseJSON.errors;
                    if(errors && typeof errors === 'string'){
                      $('#email-error').html(errors);
                    }
                    $.each(errors, function(field,error){
                      $('#' + field + '-error').html(error);
                    });
                  }
                });
              });
            });
        </script>
      @endpush
</x-Base-Layout> 