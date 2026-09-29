<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QuarryOps - Login</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="login-wrap">
        <div class="login-box">
            <h1 class="brand-accent">Quarry<strong style="font-family:'Prata',serif;">Ops</strong></h1>
            <p class="tagline">Stone Quarry Management System</p>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" style="text-align:left;">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn big-btn">Login</button>
            </form>

            <p style="font-size:12px; color:#888; margin-top:20px;">
                Demo: admin@quarryops.com / password
            </p>
        </div>
    </div>
</body>
</html>
