<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
        .login-section{

            display: flex;
            justify-content: center;
            text-align: center;
        }
        .login-container{
            margin-top: calc(100vh - 95vh);
            width: 32.5rem;
            max-width: 32.5rem;
        }
        h1{
            font-size: 52px;
            margin: 0;
            text-transform: uppercase;
            margin-bottom: -0.5rem;
        }
        .company-name{
            margin: 0;
            font-size: 24px;
        }
        .company-team{
            margin: 0;
        }
        .login-inputs{
            margin-top: 1rem;
            display: flex;
            flex-direction: column;
            text-align: left;
        }
        label{
            margin-top: 0.5rem
        }
        .username, .password{
            max-width: 32.5rem;
            height:  3rem;
            border-radius: 0.5rem;
            padding: 0 1rem;
            border: 1px solid #E0E0E0;
        }
        .sign-in{
            max-width: 32.5rem;
            height:  3rem;
            border-radius: 0.5rem;
            background-color: var(--secondary-clr);
            color: var(--primary-clr);
            cursor: pointer;
            margin-top: 1rem;
            font-size: 1rem;
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
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="username" placeholder="Enter your username">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="password" placeholder="Enter your password">

                    <button type="submit" id="sign-in" class="sign-in">Sign In</button>
                </div>
            </form>
        </div>
    </section>
</body>
</html>
