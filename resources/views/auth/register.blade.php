<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, maximum-scale=1, shrink-to-fit=no, viewport-fit=cover">
    <meta name="color-scheme" content="light dark">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" type="image/x-icon">

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700" rel="stylesheet">

    <!-- Template CSS -->
    <link class="css-lt" rel="stylesheet" href="{{ asset('assets/css/template.bundle.css') }}" media="(prefers-color-scheme: light)">
    <link class="css-dk" rel="stylesheet" href="{{ asset('assets/css/template.dark.bundle.css') }}" media="(prefers-color-scheme: dark)">

    <!-- Theme mode -->
    <script>
        if (localStorage.getItem('color-scheme')) {
            let scheme = localStorage.getItem('color-scheme');

            const LTCSS = document.querySelectorAll('link[class=css-lt]');
            const DKCSS = document.querySelectorAll('link[class=css-dk]');

            [...LTCSS].forEach((link) => {
                link.media = (scheme === 'light') ? 'all' : 'not all';
            });

            [...DKCSS].forEach((link) => {
                link.media = (scheme === 'dark') ? 'all' : 'not all';
            });
        }
    </script>
</head>

<body class="bg-light">

    <div class="container">
        <div class="row align-items-center justify-content-center min-vh-100 gx-0">

            <div class="col-12 col-md-5 col-lg-4">
                <div class="card card-shadow border-0">
                    <div class="card-body">
                        <form id="registerForm">
                            <div class="row g-6">
                                <div class="col-12">
                                    <div class="text-center">
                                        <h3 class="fw-bold mb-2">Sign Up</h3>
                                        <p>Follow the easy steps</p>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                                        <label for="name">Name</label>
                                    </div>
                                </div>
    
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="Email">
                                        <label for="email">Email</label>
                                    </div>
                                </div>
    
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
    
                                <div class="col-12">
                                    <button class="btn btn-block btn-lg btn-primary w-100" type="submit">Sign In</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Text -->
                <div class="text-center mt-8">
                    <p>Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
                </div>
            </div>
        </div> <!-- / .row -->
    </div>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/vendor.js') }}"></script>
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/ajax.js') }}"></script>
    <script>
        $(document).ready(function () {
            $("#registerForm").submit(function (e) { 
                e.preventDefault();
                let formData = new FormData(this);
                ajaxCall("{{ route('register') }}", 'POST', formData, function (response) {
                    if (response.status) {
                        window.location.href = "{{ route('chat.index') }}";
                    }
                }, function (error) {
                    $(".is-invalid").removeClass('is-invalid');
                    $(".invalid-feedback").remove();
                    var errors = JSON.parse(error.responseText);
                    $.each(errors.message, function (key, value) { 
                         $(`#${key}`).addClass('is-invalid').after(`<div class="invalid-feedback">${value}</div>`);
                    });
                });
            });
        });
    </script>
</body>
</html>