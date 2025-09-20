<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Mostrar o formulário de login.
     */
    public function showLoginForm()
    {
        return view('auth.login'); // a view que já criamos
    }

    /**
     * Processar tentativa de login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'nome'    => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/'); // redireciona para a home
        }

        return back()->withErrors([
            'nome' => 'As credenciais não conferem.',
        ])->onlyInput('nome');
    }

    /**
     * Fazer logout do usuário.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
