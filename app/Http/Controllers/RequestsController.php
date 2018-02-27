<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\requests;
use App\statuses;
use App\priorities;
use App\User;
use Validator;
use App\Jobs\ProcessMails;
use Carbon\Carbon;

class RequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['store']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      if(Auth::guest()){
        $statuses = statuses::all();
        //getting request according to filters
        $requests = requests::leftJoin('priorities', 'requests.priority_id', '=', 'priorities.id')
          ->leftJoin('statuses', 'requests.status_id', '=', 'statuses.id')
          ->leftJoin('categories', 'requests.category_id', '=', 'categories.id')
          ->select('requests.id', 'requests.username', 'requests.priority_id', 'requests.category_id', 'requests.status_id', 'requests.theme',
          'requests.message', 'requests.admin_id', 'requests.email', 'requests.cabinet', 'requests.tel', 'requests.comment', 'requests.created_at',
          'priorities.name', 'statuses.name', 'categories.name')
          ->orderBy($request->input('sorting'), $request->input('ordering'))->with(['admin','status', 'priority', 'category'])->paginate(10);
        return response()->json(compact('requests', 'statuses'));
      }else{
        $statuses = statuses::all();
        if(Auth::user()->showtag == 'all'){
          //getting request according to filters
          $requests = requests::leftJoin('priorities', 'requests.priority_id', '=', 'priorities.id')
            ->leftJoin('statuses', 'requests.status_id', '=', 'statuses.id')
            ->leftJoin('categories', 'requests.category_id', '=', 'categories.id')
            ->select('requests.id', 'requests.username', 'requests.priority_id', 'requests.category_id', 'requests.status_id', 'requests.theme',
            'requests.message', 'requests.admin_id', 'requests.email', 'requests.cabinet', 'requests.tel', 'requests.comment', 'requests.created_at',
            'priorities.name', 'statuses.name', 'categories.name')
            ->orderBy($request->input('sorting'), $request->input('ordering'))
            ->with(['admin','status', 'priority', 'category'])
            ->paginate(Auth::user()->per_page);
        }else{
          //getting request according to filters
          $requests = requests::where('admin_id', Auth::id())
            ->leftJoin('priorities', 'requests.priority_id', '=', 'priorities.id')
            ->leftJoin('statuses', 'requests.status_id', '=', 'statuses.id')
            ->leftJoin('categories', 'requests.category_id', '=', 'categories.id')
            ->select('requests.id', 'requests.username', 'requests.priority_id', 'requests.category_id', 'requests.status_id', 'requests.theme',
            'requests.message', 'requests.admin_id', 'requests.email', 'requests.cabinet', 'requests.tel', 'requests.comment', 'requests.created_at',
            'priorities.name', 'statuses.name', 'categories.name')
            ->orderBy($request->input('sorting'), $request->input('ordering'))->with(['admin','status', 'priority', 'category'])->paginate(Auth::user()->per_page);
        }
        return response()->json(compact('requests', 'statuses'));
      }
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
        'email' => 'required|string|email|max:255',
        'select_category' => 'required|numeric',
        'cabinet' => 'required|string|max:255',
        'select_priority' => 'required|numeric',
        'message' => 'required',
      ]);

      if($validator->fails()){
        $response = $validator->messages();
        session()->flash('my_error', $response);
        return '';
      }

      $new_request = new requests;
      $new_request->category_id = $request->input('select_category');
      $new_request->priority_id = $request->input('select_priority');
      $new_request->status_id = '1';
      $new_request->username = $request->input('name');
      $new_request->email = $request->input('email');
      $new_request->cabinet = $request->input('cabinet');
      $new_request->tel = $request->input('tel');
      $new_request->theme = $request->input('theme');
      $new_request->message = $request->input('message');
      $new_request->save();

      //Queue the mail notification
      ProcessMails::dispatch($new_request->id);
                //->delay(Carbon::now()->addSeconds(1));

      session()->flash('success', 'Заявка принята');
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
        $requests = requests::where('id', $id)->with(['admin', 'status', 'priority', 'category'])->get();
        return response()->json($requests);
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
        'status' => 'required|numeric',
      ]);

      //CANNOT BE ERRORS FROM WEBPAGE
      if($validator->fails()){
        $response = $validator->messages();
        session()->flash('my_error', $response);
        return '';
      }

      $my_request = requests::find($id);
      switch($request->input('status')){
        case '1':
            $my_request->admin_id = null;
            break;
        case '3':
            $my_request->comment = $request->input('comment');
            $my_request->admin_id = $request->input('admin_id');
            $my_request->closed_time = date("Y-m-d H:i:s");
            session()->flash('success', 'Заявка закрыта');
            break;
        default:
            $my_request->admin_id = $request->input('admin_id');
      }
      $my_request->status_id = $request->input('status');
      $my_request->save();

      return 'Статус изменен';

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
