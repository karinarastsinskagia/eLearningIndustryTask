<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class RegisterController extends Controller
{
    public function create(){

        return view('register.create');
    }

    public function store(Request $request){


        $attributes =  $request->validate([
            'name'=>['required','min:5',Rule::unique('users','name')],
            'email'=>['required','email'],
            'password'=>['required','min:7'],

        ]);

        $user = User::create($attributes);

        auth()->login($user);

        return redirect('/articles');
    }
}
