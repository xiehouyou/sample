<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
class UsersController extends Controller
{ 

	/*使用 Laravel 提供身份验证（Auth）中间件来过滤未登录用户的 edit, update 动作。*/
	  public function __construct()
    {
        $this->middleware('auth', [            
            'except' => ['show', 'create', 'store','index']
        ]);
         $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
      public function index()
    {
        /*$users = User::all();*/
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }
    

    public function create()
    {
    	return view('users.create');
    }
    public function show(User $user)
    {
    	return view('users.show',compact('user'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开展新的旅程');
        return redirect()->route('users.show', [$user]);
    }
    public function edit(User $user)
    {
        $this->authorize('update',$user);
    	return view('users.edit',compact('user'));
    }
    public function update(User $user,Request $request)
    {
    	$this->validate($request,[
    		'name'=>'required|max:50',
    		'password'=>'required|confirmed|min:6'
    	]);
    	/*$user->update([
    	 *	'name'=>$request->name,
    	 *	'password'=>bcrypt($request->password),
    	 *]);
        */      
        $this->authorize('update', $user);
    	$data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功！');
    	return redirect()->route('users.show',$user->id);
    }

     public function destroy(User $user)
    {	
    	$this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
 
}
