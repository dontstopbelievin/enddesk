<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\statuses;
use Validator;

class StatusesController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $statuses = statuses::all();
    return response()->json($statuses);
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

    $new_status = new statuses;
    $new_status->name = $request->input('name');
    $new_status->save();

    session()->flash('success', 'Статус добавлен');
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
    $status = statuses::find($id);
    return response()->json($status);
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

    $status = statuses::find($id);
    if($status->name == 'Открыт' || $status->name == 'Сделано'){
      session()->flash('error', 'Этот статус нельзя изменить');
    }else{
      $status->name = $request->input('name');
      $status->save();
      session()->flash('success', 'Статус изменен');
    }

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
    $status = statuses::find($id);
    if($status->name == 'Открыт' || $status->name == 'Сделано'){
      session()->flash('error', 'Этот статус нельзя удалить');
    }else{
      $status->delete();
      session()->flash('success', 'Статус удален');
    }

    return '';
  }
}
