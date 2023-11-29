<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ITEM STORE</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container bg-dark"><br>
    <div class="border rounded-3 border-dark">
        <div class="col-md-6 col-md-offset-3">
            <hr>
            <h3 class="text-center">ITEM STORE</h3>
            <hr>
            <!-- <img src="{{asset('img/sbd.jpg')}}" style="display:block;margin-left:auto; margin-right:auto; width:300px; height:400px;"> -->
            @if (session('error'))
                <div class="alert alert-danger">
                    <b>Opps!</b> {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('actionlogin') }}" method="post">
                @csrf
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Email"
                        required="">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" placeholder="Password" required="">
                </div>
                <button type="submit" class="btn btn-primary btn-block">Log In</button>
                <hr>
                <p class="text-center">Belum punya akun? <a href="register">Register</a> sekarang!</p>
            </form>
            <!-- <a type="button" href="/register" class="btn btn-primary btn-block">Register</a> -->
    </div>
</body>
</html>
