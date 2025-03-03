<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gestion des Salaires</title>
</head>
<body>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:700,600" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="{{asset('css/auth.css')}}">

    <div class="login-form-container">
        <img src="{{ asset('images/armoirie-burkina-faso.png') }}" alt="Logo" class="login-logo">
    <form method="post" action="{{route('handleLogin')}}">

        @csrf
        @method('POST')

        <div class="box">


            <h1>Espace de CONNEXION</h1>
           <!-- {{Hash::make('soufiss')}} -->
           @if (Session::get('success-message'))
                    <div class="alert alert-success success-message fade-in">
                   <i class="fa fa-check-circle"></i> {{ Session::get('success-message') }}
                 </div>
            @endif


            @if (Session::get('error_msg'))
            <div class="error-message">
                {{ Session::get('error_msg') }}
            </div>
        @endif

            <input type="email" name="email" class="email" />

            <input type="password" name="password" class="email" />

            <div class="btn-container">
                <button type="submit">CONNEXION</button>
            </div>

            <!-- End Btn -->
            <!-- End Btn2 -->
        </div>
        <!-- End Box -->
    </form>
</div>
</body>
</html>
