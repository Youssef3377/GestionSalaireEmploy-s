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
    <form method="post" action="{{route('submitDefineAccess',$email)}}">

        @csrf
        @method('POST')

        <div class="box">


            <h1>Definissez vos Acces</h1>
           <!-- {{Hash::make('soufiss')}} -->
            @if (Session::get('error_msg'))
            <div class="error-message">
                {{ Session::get('error_msg') }}
            </div>
        @endif

            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="email" value="{{ $email }}" readonly/>

            </div>
            <div class="form-group">
                <label for="">Code</label>
                <input type="text" name="code" class="email" value="{{ old('code') }}"/>
                @error('code')
                <div class="error-message"> {{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
                <label for="">Mot de passe</label>
                <input type="password" name="password" class="password" />
                @error('password')
                <div class="error-message"> {{$message}}</div>
              @enderror
            </div>
            <div class="form-group">
                <label for="">Mot de passe de confirmation</label>
                <input type="password" name="confirm_password" class="password" />
                @error('confirm_password')
                <div class="error-message"> {{$message}}</div>
              @enderror
            </div>

            <div class="btn-container">
                <button type="submit">VALIDER</button>
            </div>

            <!-- End Btn -->
            <!-- End Btn2 -->
        </div>
        <!-- End Box -->
    </form>
</div>
</body>
</html>
