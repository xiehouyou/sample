<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;
use Mail;
class UsersController extends Controller
{ 

	/*使用 Laravel 提供身份验证（Auth）中间件来过滤未登录用户的 edit, update 动作。*/
	  public function __construct()
    {
        $this->middleware('auth', [            
            'except' => ['show', 'create', 'store','index','confirmEmail']
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
    /*在我们前面章节加入的登录操作中，用户即使没有激活也能够正常登录。接下来我们需要对之前的登录代码进行修改，当用户没有激活时，则视为认证失败，用户将会被重定向至首页，并显示消息提醒去引导用户查收邮件。*/
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

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');
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

 /*用户控制器定义一个 sendEmailConfirmationTo方法，该方法将用于发送邮件给指定用户。我们会在用户注册成功之后调用该方法来发送激活邮件*/
 /*   protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@yousails.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }*/
     protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }
 /*   完成前面定义的 confirm_email 路由对应的控制器方法 confirmEmail*/
       public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
    } 
}
