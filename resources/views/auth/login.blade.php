<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="{{ asset('logo.png') }}">

    <title>Signin Sponsor & Exhibitor Portal</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/css/signin.css') }}" rel="stylesheet">
</head>

<body class="text-center">
    <form class="form-signin" action="{{ route('login') }}" method="POST">
        @csrf
        <img class="mb-4" src="{{ asset('logo.png') }}" alt="" height="100px">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>

        <!-- Display errors at the top of the form -->
        @if (session('status'))
            <div class="alert alert-danger" role="alert">
                {{ session('status') }}
            </div>
        @endif
        @error('email')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror
        @error('password')
            <div class="alert alert-danger" role="alert">
                <strong>{{ $message }}</strong>
            </div>
        @enderror

        <label for="email" class="sr-only">Email address</label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Email address" required
            autofocus>

        <label for="password" class="sr-only">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>

        <div class="checkbox mb-3">

        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
    </form>
</body>

</html>
