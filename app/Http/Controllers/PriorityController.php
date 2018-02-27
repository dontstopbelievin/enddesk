<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\priorities;
use Validator;

class PriorityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $priorities = priorities::all();
    return response()->json($priorities);
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
      'name' => 'required'
    ]);

    if($validator->fails()){
      $response = $validator->messages();
      session()->flash('my_error', $response);
      return '';
    }

    $new_priority = new priorities;
    $new_priority->name = $request->input('name');
    $new_priority->save();

    session()->flash('success', 'Приоритет добавлен');
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
    $priority = priorities::find($id);
    return response()->json($priority);
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
      'name' => 'required'
    ]);

    if($validator->fails()){
      $response = $validator->messages();
      session()->flash('my_error', $response);
      return '';
    }

    $priority = priorities::find($id);
    $priority->name = $request->input('name');
    $priority->save();

    session()->flash('success', 'Приоритет изменен');
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
    $priority = priorities::find($id);
    $priority->delete();
    session()->flash('success', 'Приоритет удален');
    return '';
  }
}
