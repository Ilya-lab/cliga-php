<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }

    /**
 * Пользователи системы
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
    public function users()
    {
        if (!Auth::user()->isAdmin()) abort(403);

        $users = User::all();
        return view('home.users', ['users' => $users]);
    }

    public function profile($id)
    {
        if (!Auth::user()->isAdmin() && Auth::user()->id != $id) abort(403);

        $user = User::findOrFail($id);

        return view('home.profile', ['user' => $user]);
    }

    public function profileUpdate($id, Request $request) {
        if (!Auth::user()->isAdmin() && Auth::user()->id != $id) abort(403);

        $user_id = 0;
        if($request->has('id')) $user_id = $request->input('id');
        if($user_id == 0) return redirect()->route('users')->with('error','Пользователь не найден!');

        $user = User::findOrFail($user_id);
        if($request->has('name')) $user->name = $request->input('name');
        if($request->has('password') && $request->has('password_confirmation')) {
            if($request->input('password') != $user->password ) {
                // новый пароль введён
                if($request->input('password') != $request->input('password_confirmation')) {
                    // пароли не совпадают
                    return redirect()->back()->with('error', 'Пароли не совпадают');
                }
                $user->password = Hash::make($request->input('password'));
            }
        }
        if($request->has('user_type')) $user->user_type = $request->input('user_type') == "on" ? 1 : 0;
        elseif(Auth::user()->isAdmin() && Auth::user()->id != $id) $user->user_type = 0;

        if($request->has('active')) $user->active = $request->input('active') == "on" ? 1 : 0;
        elseif(Auth::user()->isAdmin() && Auth::user()->id != $id) $user->active = 0;
        $user->updated_at = now();

        $user->save();

        return redirect()->route('users')->with('info','Анкета обновлена');
    }

    public function usersAdded() {
        return redirect()->route('users')->with('info','Новый пользователь зарегистрирован!');
    }

    public function userDelete($id) {
        if (!Auth::user()->isAdmin() && Auth::user()->id != $id) abort(403);

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('info','Пользователь удалён!');
    }
}
