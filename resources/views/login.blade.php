<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body class="bg-success">
    <div class="container">
        <section class="vh-100 gradient-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-success text-white shadow-lg" style="border-radius: 1rem;">
                            @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                            @endif
                            <div class="card-body p-5 text-center">

                                <form id="loginForm" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-md-5 mt-md-4 pb-1">
                                        <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                                        <p class="text-black-100 mb-5">Please enter your login and password!</p>

                                        <div class="form-outline form-white mb-4">
                                            <input type="email" name="email" id="typeEmailX"
                                                placeholder="example@email.com" class="form-control form-control-lg" />
                                            <label class="form-label" for="typeEmailX">Email</label>
                                            @error('email') <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="form-outline form-white mb-4">
                                            <input type="password" name="password" id="typePasswordX"
                                                class="form-control form-control-lg" placeholder="******" />
                                            <label class="form-label" for="typePasswordX">Password</label>
                                            @error('password') <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>
                                    </div>
                                </form>

                                <div>
                                    <p class="mb-0">Don't have an account? <a href="register"
                                            class="text-white-50 fw-bold">Register</a>
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
    $('#loginForm').on('submit', function (e) {
        e.preventDefault();

        let btn = $('button[type="submit"]');
        btn.prop('disabled', true).html('Logging in... <span class="spinner-border spinner-border-sm"></span>');

        let form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: "POST",
            data: form.serialize(),
            success: function (response) {
                Swal.fire({
                    icon: "success",
                    title: "Login successful!",
                    text: "Redirecting to home...",
                    timer: 1500,
                    showConfirmButton: false
                });

                setTimeout(() => {
                    window.location.href = response.redirect;
                }, 1500);
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('Login');

                if (xhr.status === 400) { // Validasi gagal
                    Swal.fire({
                        icon: "error",
                        title: "Validation Error",
                        html: formatErrors(xhr.responseJSON.errors),
                    });
                } else if (xhr.status === 401) { // Login gagal
                    Swal.fire({
                        icon: "error",
                        title: "Login Failed",
                        text: "Invalid email or password.",
                    });
                } else if (xhr.status === 500) { // Kesalahan server
                    Swal.fire({
                        icon: "error",
                        title: "Server Error",
                        text: "Something went wrong. Please try again later.",
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Unknown Error",
                        text: "An unexpected error occurred.",
                    });
                }
            }
        });
    });
});

function formatErrors(errors) {
    return Object.values(errors).map(err => `<p>${err.join("<br>")}</p>`).join("");
}

    </script>

</body>

</html>