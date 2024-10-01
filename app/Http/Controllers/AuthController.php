<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        //zeigt das Anmeldeformular an
        return view('auth.login');
    }

    public function login(Request $request)
    {
        
        //speichert die Anmeldeinformationen in der Variablen $credentials
        $credentials = $request->only('email', 'password');

        //wenn die Anmeldeinformationen ungültig sind, wird der Benutzer zurück zum Anmeldeformular geleitet
        if (Auth::attempt($credentials)) {
           // prüft auf die Rolle des Benutzers und leitet ihn auf die entsprechende Seite weiter
            if (Auth::user()->isAdmin()) {
                return redirect()->intended('admin/adminDashboard');
            } else {
                return redirect()->intended('/');
            }
        }
    
        return redirect()->back()->withErrors([
            'email' => 'Ungültige Anmeldeinformationen.',
        ]);
    }

    public function showRegistrationForm()
    {
        //zeigt das Registrierungsformular an
        return view('auth.register');
    }

    public function register(Request $request)
    {
        //validiert die Registrierungsinformationen
        //email muss eindeutig sein
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => [
                'required',
                'string',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/', // muss mindestens einen Großbuchstaben enthalten
                'regex:/[a-z]/', // muss mindestens einen Kleinbuchstaben enthalten
                'regex:/[0-9]/', // muss mindestens eine Ziffer enthalten
                'regex:/[@$!%*?&]/' // muss mindestens ein Sonderzeichen enthalten
            ],
        ], 
        [
            'email.unique' => 'Diese E-Mail-Adresse ist bereits vergeben.',
            'password.min' => 'Das Passwort muss mindestens 8 Zeichen lang sein.',
            'password.regex' => 'Das Passwort muss mindestens einen Großbuchstaben, einen Kleinbuchstaben, eine Ziffer und ein Sonderzeichen enthalten.',
            'password.confirmed' => 'Die Passwortbestätigung stimmt nicht überein.',
        ]);
    
        //erstellt einen neuen Benutzer
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        //meldet den Benutzer an
        Auth::login($user);

        return redirect()->intended('/');
    }

    public function logout()
    {
        //meldet den Benutzer ab
        Auth::logout();
        return redirect('/');
    }
}
