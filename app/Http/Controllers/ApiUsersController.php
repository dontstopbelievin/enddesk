<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\usertypes;
use Validator;

class ApiUsersController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = User::with('usertype')->get();
    return response()->json($users);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $validator = Validator::make($request->all(),[
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|max:255|unique:users',
      'usertype' => 'required|numeric',
      'password' => 'required|string|min:6|confirmed',
    ]);

    if($validator->fails()){
      $response = $validator->messages();
      session()->flash('my_error', $response);
      return '';
    }

    $new_users = new User;
    $new_users->name = $request->input('name');
    $new_users->email = $request->input('email');
    $new_users->password = bcrypt($request->input('password'));
    $new_users->usertype_id = $request->input('usertype');
    $new_users->showtag = 'all';
    $new_users->timelapse = '5000';
    $new_users->per_page = '10';
    $new_users->save();
    session()->flash('success', 'Пользователь добавлен');
    return '';
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
      $users = User::find($id);
      return response()->json($users);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(),[
      'name' => 'required|string|max:255',
      'usertype' => 'required|numeric',
      'password' => 'required|string|min:6|confirmed',
    ]);

    if($validator->fails()){
      $response = $validator->messages();
      session()->flash('my_error', $response);
      return '';
    }

    $user = User::find($id);
    if($user->usertype_id == '1'){
      session()->flash('error', 'Данного пользователя нельзя изменить');
      return '';
    }
    $user->name = $request->input('name');
    $user->password = bcrypt($request->input('password'));
    $user->usertype_id = $request->input('usertype');
    $user->save();
    session()->flash('success', 'Изменения выполнены');
    return '';
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $user = User::find($id);
    if($user->usertype_id == '1'){
      session()->flash('error', 'Данного пользователя нельзя удалить');
      return '';
    }

    $user->delete();
    session()->flash('success', 'Пользователь удален');
    return '';
  }
}
