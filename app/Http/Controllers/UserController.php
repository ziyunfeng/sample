<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller {


    public function __construct ()
    {

        $this->middleware ('auth', [
            'except'    => ['show', 'create', 'store']  //  不使用auth过滤的动作
        ]);
//
        $this->middleware('guest', [
            'only' => ['create']
        ]);

    }

    public function index(){
        $users = User::paginate(10);
        return view ("user.index", compact ('users'));
    }

    //  注册
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

    public function edit(User $user) {

        $this->authorize ('update', $user);
        return view ('user.edit', compact ('user'));
    }

    public function update(User $user, Request $request) {
        $this->authorize ('update', $user);
        $this->validate ($request, [
            'name'  =>  'required|max:50',
            'password'=> 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name']   =   $request->name;

        if($request->password) {
            $data['password'] = bcrypt ($request->password);
        }

        session()->flash('success', '个人资料更新成功！');

        return redirect ()->route ('user.show', $user->id);

    }

    public function destroy(User $user) {

        $this->authorize('destroy', $user);

        $user->delete ();
        session ()->flash ('success','删除用户成功');
        return back ();

    }


}
