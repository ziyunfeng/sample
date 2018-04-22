<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {

    public function create() {

        return view ("user.create");
    }

    public function show(User $user,Request $request) {

        return view ("user.show", compact ('user'));
    }

    public function store(StoreUser $request){

        $user= User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password' => bcrypt ($request->password)
        ]);

        Auth::login ($user);
        session ()->flash ('success', '欢迎,您将在这里开启一段新的旅程');
        return redirect ()->route ('user.show',[$user]);
    }


}
