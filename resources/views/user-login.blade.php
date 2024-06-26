<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <style>
        html, body {
            background-color: var(--primary-clr);
            color: var(--secondary-clr);
            /* font-family: 'Nunito', sans-serif; */
            font-weight: 400;
            height: 100vh;
            margin: 0;
            background-image: url('{{ asset('images/layered-waves-haikei.svg') }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            font-family: 'Poppins';
        }
    </style>
</head>
<body>
    <section class="login-section">
        <div class="login-container">
            <div class="">
                <h1>Login</h1>
                <p class="company-name">Etan Construction</p>
                <p class="company-team">Finishing Team</p>
            </div>
            <form action="{{ route('user-login') }}" method="POST"  class="login-form">
                @csrf
                <div class="login-inputs">
                    @if ($errors->has('error'))
                        <span class="error-message" id="error-container">{{ $errors->first('error') }}</span>
                    @endif
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="username" placeholder="Enter your username" required>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="password" placeholder="Enter your password" required>

                    <button type="submit" id="sign-in" class="sign-in">Sign In</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameInput = document.getElementById('username');
            const passwordInput = document.getElementById('password');
            const errorContainer = document.getElementById('error-container');

            usernameInput.addEventListener('input', function() {
                hideErrorMessage();
            });

            passwordInput.addEventListener('input', function() {
                hideErrorMessage();
            });

            function hideErrorMessage() {
                errorContainer.style.display = 'none';
            }
        });
    </script>
</body>
</html>
