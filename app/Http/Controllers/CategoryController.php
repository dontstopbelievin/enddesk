<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\categories;
use Validator;

class CategoryController extends Controller
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
      $categories = categories::all();
      return response()->json($categories);
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

      $new_category = new categories;
      $new_category->name = $request->input('name');
      $new_category->save();

      session()->flash('success', 'Категория добавлена');
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
      $category = categories::find($id);
      return response()->json($category);
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

      $category = categories::find($id);
      $category->name = $request->input('name');
      $category->save();

      session()->flash('success', 'Категория изменена');
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
      $category = categories::find($id);
      $category->delete();
      session()->flash('success', 'Категория удалена');
      return '';
    }
}
