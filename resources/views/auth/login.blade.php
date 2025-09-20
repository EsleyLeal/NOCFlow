<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login - {{ config('app.name', 'Laravel') }}</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    :root{
      --bg:#0b1120;
      --panel:#0f172a;
      --muted:#94a3b8;
      --line:#1f2937;
      --neon:#39ff14;
      --neon-weak:#34d399;
    }
    html,body{height:100%}
    body.compact{
      background:linear-gradient(180deg,#0a0f1f 0%, #0b1120 40%, #0a1022 100%);
      color:#e5e7eb;
      font-family:"Instrument Sans", ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
      letter-spacing:.01em;
    }
    .neon{ color:var(--neon); text-shadow:0 0 6px rgba(57,255,20,.35) }
    .muted{ color:var(--muted) }

    .form-control{
      background:#0a1226; border:1px solid #253047; color:#e5e7eb;
    }
    .form-control:focus{
      border-color:#16a34a; box-shadow:0 0 0 3px rgba(57,255,20,.25); background:#0b152a;
    }

    .btn-neon{
      background:#39ff14; color:#041408; font-weight:700; border-radius:.4rem;
      border:1px solid #16a34a; padding:.5rem 1.2rem;
    }
    .btn-neon:hover{ background:#2fff10 }

    .login-card{
      background:var(--panel); border:1px solid var(--line);
      border-radius:.6rem; padding:2rem; max-width:420px;
      margin:auto; box-shadow:0 0 12px rgba(0,0,0,.4);
    }
  </style>
</head>
<body class="compact d-flex align-items-center justify-content-center">

  <div class="login-card w-100">
    <h1 class="text-center neon mb-4">Login</h1>

    @if(session('status'))
      <div class="alert alert-success small">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input id="nome" type="nome" name="nome" value="{{ old('nome') }}" required autofocus class="form-control @error('nome') is-invalid @enderror">
        @error('nome')
          <div class="invalid-feedback d-block small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3">
        <label for="password" class="form-label">Senha</label>
        <input id="password" type="password" name="password" required class="form-control @error('password') is-invalid @enderror">
        @error('password')
          <div class="invalid-feedback d-block small">{{ $message }}</div>
        @enderror
      </div>

      <div class="mb-3 form-check">
        <input type="checkbox" name="remember" id="remember" class="form-check-input">
        <label class="form-check-label" for="remember">Lembrar-me</label>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn-neon">Entrar</button>
      </div>
    </form>
  </div>

</body>
</html>
