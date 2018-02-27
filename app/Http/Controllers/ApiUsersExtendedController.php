<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;

class ApiUsersExtendedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
      switch ($request->input('func')) {
        case 'changePassword':
              $validator = Validator::make($request->all(),[
                'password' => 'required|string|min:6|confirmed',
              ]);

              if($validator->fails()){
                $response = $validator->messages();
                session()->flash('my_error', $response);
                return '';
              }

              $user = User::find($id);
              $user->password = bcrypt($request->input('password'));
              $user->save();
              session()->flash('success', 'Пароль изменен');
              return '';
        case 'per_page':
              $validator = Validator::make($request->all(),[
                'per_page' => 'required|numeric',
              ]);

              if($validator->fails()){
                $response = $validator->messages();
                session()->flash('my_error', $response);
                return '';
              }

              $user = User::find($id);
              $user->per_page = $request->input('per_page');
              $user->save();
              return '';
        case 'timelapse':
              $validator = Validator::make($request->all(),[
                'timelapse' => 'required|numeric',
              ]);

              if($validator->fails()){
                $response = $validator->messages();
                session()->flash('my_error', $response);
                return '';
              }

              $user = User::find($id);
              $user->timelapse = $request->input('timelapse');
              $user->save();
              return '';
        default:
              $validator = Validator::make($request->all(),[
                'showtag' => 'required|string',
              ]);

              if($validator->fails()){
                $response = $validator->messages();
                session()->flash('my_error', $response);
                return '';
              }

              $user = User::find($id);
              if($request->input('showtag') == 'all'){
                $user->showtag = 'all';
              }else{
                $user->showtag = 'mine';
              }
              $user->save();
              return '';
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
