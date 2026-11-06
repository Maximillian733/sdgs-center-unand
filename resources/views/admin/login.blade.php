<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex"><title>Login Admin | SDGs Center</title><link rel="stylesheet" href="{{ asset('css/app.css') }}"></head>
<body><main class="login f" id="main">
 <div class="login-brand"><img src="{{ asset('images/logo-sdgs-unand.png') }}" width="78" height="78" alt="Logo SDGs Center UNAND"></div>
 <h1 style="font-size:1.4rem">Login Admin</h1>
 <p class="meta">SDGs Center Universitas Andalas</p>
 @include('admin.partials.flash')
 <form method="post" action="{{ route('admin.login.post') }}" novalidate>
  @csrf
  <label for="login">Username atau surel</label>
  <input id="login" type="text" name="login" value="{{ old('login') }}" autocomplete="username" required autofocus>
  <label for="password">Password</label>
  <input id="password" type="password" name="password" autocomplete="current-password" required>
  <p><button class="btn dark" type="submit" style="width:100%">Masuk</button></p>
 </form>
 <p><a href="{{ route('home') }}">← Kembali ke situs</a></p>
</main></body></html>
