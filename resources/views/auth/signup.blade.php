<x-Base-Layout>
  {{-- @push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}">
  @endpush --}}
    <!-- Hero section -->
    <section id="page-header" class="about-header">
        <h2>#Let's_Go_Shopping</h2>
        <p>Create an account to procceed to shopping</p>
      </section>
      <section id="form-details">
        <form id="signupForm" >
          {{-- <span>LEAVE A MESSAGE</span> --}}
          @csrf
          <h2>SignUp</h2>
          <span class="error-msg text-danger fs-6 ps-2" id="first_name_error"></span>
          <input type="text" class="input-field" id="first_name" name="first_name" placeholder="First name" />
          <span class="error-msg text-danger fs-6 ps-2" id="last_name_error"></span>
          <input type="text" class="input-field" id="last_name" name="last_name" placeholder="Last name" />
          <span class="error-msg text-danger fs-6 ps-2" id="email_error"></span>
          <input type="text" class="input-field" id="email" name="email" placeholder="E-mail" />
          <span class="error-msg text-danger fs-6 ps-2" id="password_error"></span>
          <input type="password" class="input-field" id="password" name="password" placeholder="Password" />
          <span class="error-msg text-danger fs-6 ps-2" id="password-confirmation_error"></span>
          <input type="password" class="input-field" id="password_confirmation" name="password_confirmation" placeholder="Repeat Password" />
          <button type="submit" id="signup-btn" name="submit" class="normal">Signup</button>
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
          
          // This will allowing the page to load first before executing the scripts
           $(document).ready(function() {
            
            //This will handle the form submission
            $('#signupForm').submit(function(e) {
              
              
                e.preventDefault(); //Prevent the default form submission behavior
              $('#signup-btn').html('Processing...');
                //serialize the form data into a format that can be sent via AJAX
                var formData = $(this).serialize();

                
                $('.error-msg').html(''); //Clear any previous error messages

                //Perform an AJAX request for signup route
                $.ajax({
                    url: "{{ route('signup.store') }}",  
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                      $('.input-field').val(''); //Clear the input field after successful submission
                      $('#signup-btn').html('Signup');
                      
                      //Extract the success message from the server response
                      let message = response.message;

                      //Display the success message using the "sweat alert" library
                      swal("Thank you", message, 'success',{
                        button:false,
                      });

                      //Redirect to the home page after successful signup
                      window.location.href = "{{ route('login.form') }}";
                    },
                    error: function(xhr) {
                      $('#signup-btn').html('Signup');
                      //Handle errors by displaying corresponding error messages 
                        var errors = xhr.responseJSON.errors;
                          $.each(errors, function(field,error){
                            $('#' + field + '_error').html(error);
                          });
                    }
                });
            });
        });
        </script>
      @endpush
</x-Base-Layout>