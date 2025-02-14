<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-success">
    <div class="container">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5 mb-5">
                        <div class="card bg-success text-white mb-5 shadow-lg" style="border-radius: 1rem;">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                            <div class="card-body p-5 text-center">
                                <form id="registrationForm" action="{{ route('register') }}" method="POST">
                                    @csrf
                                    <div class="mb-md-5 mt-md-4 pb-1">
                                        <h2 class="fw-bold mb-2 text-uppercase">Register</h2>
                                        <p class="text-white-100 mb-5">Please fill in the details to create an account!
                                        </p>

                                        <div data-mdb-input-init class="form-outline form-white mb-4">
                                            <input type="text" id="fullname" name="fullname" placeholder="John Doe"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="fullname">Full Name</label>
                                            <div id="fullnameError" class="text-danger small mt-1"></div>
                                        </div>

                                        <div data-mdb-input-init class="form-outline form-white mb-4">
                                            <input type="email" name="email" id="email" placeholder="example@email.com"
                                                class="form-control form-control-lg" />
                                            <label class="form-label" for="email">Email</label>
                                            <div id="emailError" class="text-danger small mt-1"></div>
                                        </div>

                                        <div data-mdb-input-init class="form-outline form-white mb-4">
                                            <input type="password" name="password" id="password"
                                                class="form-control form-control-lg" placeholder="******" />
                                            <label class="form-label" for="password">Password</label>
                                            <div id="passwordError" class="text-danger small mt-1"></div>
                                        </div>

                                        <div data-mdb-input-init class="form-outline form-white mb-4">
                                            <input type="password" name="password_confirmation"
                                                id="password_confirmation" class="form-control form-control-lg"
                                                placeholder="******" />
                                            <label class="form-label" for="password_confirmation">Confirm
                                                Password</label>
                                            <div id="password_confirmationError" class="text-danger small mt-1"></div>
                                        </div>

                                        <button id="registerBtn" class="btn btn-outline-light btn-lg px-5"
                                            type="submit">
                                            Register
                                            <span id="loadingSpinner" class="spinner-border spinner-border-sm d-none"
                                                role="status" aria-hidden="true"></span>
                                        </button>

                                    </div>
                                </form>
                                <div>
                                    <p class="mb-0">Already have an account? <a href="login"
                                            class="text-white-50 fw-bold">Login</a>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function () {
            $('#registrationForm').on('submit', function (e) {
                e.preventDefault();
    
                $('.text-danger').text('');
                Swal.close();
    
                $('#registerBtn').prop('disabled', true);
                $('#loadingSpinner').removeClass('d-none');
    
                let errors = [];
    
                const fullname = $('#fullname').val().trim();
                if (fullname.length < 3 || fullname.length > 255) {
                    errors.push("Full Name must be between 3 and 255 characters.");
                }
    
                const email = $('#email').val().trim();
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    errors.push("Please enter a valid email address.");
                }
    
                const password = $('#password').val().trim();
                if (password.length < 8) {
                    errors.push("Password must be at least 8 characters long.");
                }
    
                const password_confirmation = $('#password_confirmation').val().trim();
                if (password_confirmation !== password) {
                    errors.push("Passwords do not match.");
                }
    
                if (errors.length > 0) {
                    Swal.fire({
                        icon: "error",
                        title: "Validation Error",
                        html: errors.join("<br>"),
                    });
    
                    $('#registerBtn').prop('disabled', false);
                    $('#loadingSpinner').addClass('d-none');
    
                    return;
                }
    
                this.submit();
            });
        });
    </script>

</body>

</html>