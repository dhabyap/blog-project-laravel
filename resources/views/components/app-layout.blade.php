<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <style>
        .sidebar-link {
            transition: background 0.3s, padding-left 0.3s;
        }

        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            padding-left: 10px;
            color: #ffc107 !important;
        }

        nav {
            box-shadow: 4px 0 10px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <button class="btn btn-success d-lg-none my-3 w-100 px-3" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                ☰ Menu
            </button>

            <nav id="sidebarMenu" class="offcanvas offcanvas-start d-lg-none bg-success text-white shadow-lg p-3"
                tabindex="-1" aria-labelledby="sidebarMenuLabel">

                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                    data-bs-dismiss="offcanvas" aria-label="Close"></button>

                <x-nav-layout></x-nav-layout>
            </nav>


            <nav
                class="col-lg-2 d-none d-lg-flex flex-column align-items-center bg-success text-white vh-100 p-3 position-sticky top-0">
                <x-nav-layout></x-nav-layout>
            </nav>

            <main class="col-lg-10 col-12">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            @if(session('success'))
                Toastify({
                    text: "{{ session('success') }}",
                    duration: 3000,
                    gravity: "top", 
                    position: "right",
                    backgroundColor: "#28a745",
                    stopOnFocus: true,
                }).showToast();
            @endif
    
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
                            text: "Redirecting to dashboard...",
                            timer: 1500,
                            showConfirmButton: false
                        });
    
                        setTimeout(() => {
                            window.location.href = "{{ route('dashboard.index') }}";
                        }, 1500);
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON?.errors || {};
                        let errorMessages = Object.values(errors)
                            .map(err => err.join("<br>"))
                            .join("<br>");
    
                        Swal.fire({
                            icon: "error",
                            title: "Login failed",
                            html: errorMessages || "An error occurred. Please try again.",
                        });
    
                        btn.prop('disabled', false).html('Login');
                    }
                });
            });
        });
    </script>


</body>

</html>