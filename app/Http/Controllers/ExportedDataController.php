<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\requests;
use App\priorities;
use App\statuses;
use App\categories;
use App\User;
use Validator;
use Illuminate\Support\Facades\Storage;
use Excel;

class ExportedDataController extends Controller
{

    //SEND EXPORTED FILE TO AJAX
    public function store(Request $request)
    {

      $validator = Validator::make($request->all(),[
        'sortTo' => 'required',
        'sortFrom' => 'required'
      ]);

      if($validator->fails()){
        $response = $validator->messages();
        session()->flash('my_error', $response);
        return '';
      }

      //getting inputs
      $sortfrom = date($request->input('sortFrom'));
      $sortto = date($request->input('sortTo'));
      $select_category = $request->input('select_category');
      $select_priority = $request->input('select_priority');
      $select_status = $request->input('select_status');
      $select_admin = $request->input('select_admin');

      //query
      $query = requests::leftJoin('priorities', 'requests.priority_id', '=', 'priorities.id')
        ->leftJoin('statuses', 'requests.status_id', '=', 'statuses.id')
        ->leftJoin('users', 'requests.admin_id', '=', 'users.id')
        ->leftJoin('categories', 'requests.category_id', '=', 'categories.id');
      $query->whereBetween('requests.created_at', [$sortfrom, $sortto]);

      //FILTERS for query to requests
      if($select_category != 'all'){  $query->where('requests.category_id', '=', $select_category);}
      if($select_priority != 'all'){  $query->where('requests.priority_id', '=', $select_priority);}
      if($select_status != 'all'){  $query->where('requests.status_id', '=', $select_status);}
      if($select_admin != 'all'){  $query->where('requests.admin_id', '=', $select_admin);}

      $query->select('categories.name as Категория', 'requests.theme as Тема', 'requests.message as Запрос', 'requests.created_at as Дата', 'priorities.name as Приоритет',
      'statuses.name as Статус', 'requests.username as Имя', 'requests.email as Email', 'requests.cabinet as Кабинет', 'requests.tel as Телефон', 'users.name as Исполнитель',
      'requests.comment as Комментарий', 'requests.closed_time as Был закрыт');
      //get requests
      $requests = $query->get();

      //Excel description of filters
      if($select_category == 'all'){$my_category = 'все';}else{
        $q_category = categories::find($select_category);
        $my_category = $q_category->name;
      }
      if($select_priority == 'all'){$my_priority = 'все';}else{
        $q_priority = priorities::find($select_priority);
        $my_priority = $q_priority->name;
      }
      if($select_status == 'all'){$my_status = 'все';}else{
        $q_status = statuses::find($select_status);
        $my_status = $q_status->name;
      }
      if($select_admin == 'all'){$my_admin = 'все';}else{
        $q_admin = User::find($select_admin);
        $my_admin = $q_admin->name;
      }
      $output[] = ['Фильтры использованные для экспорта данных'];
      $output[] = ['От', $sortfrom];
      $output[] = ['До', $sortto];
      $output[] = ['Категория', $my_category];
      $output[] = ['Приоритет', $my_priority];
      $output[] = ['Статус', $my_status];
      $output[] = ['Исполнитель', $my_admin];
      $output[] = [''];

      // Define the Excel spreadsheet headers
      $output[] = ['Категория', 'Тема', 'Запрос', 'Дата создания', 'Приоритет', 'Статус', 'Имя', 'Email', 'Кабинет', 'Телефон', 'Исполнитель', 'Комментарий', 'Был закрыт'];

      // Convert each member of the returned collection into an array,
      // and append it to the payments array.
      foreach ($requests as $request) {
          $output[] = $request->toArray();
      }

      $myFile= Excel::create("filename", function($excel) use($output) {
         $excel->setTitle('title');

         $excel->sheet('sheet 1', function($sheet) use($output) {
           $sheet->mergeCells('A1:B1');
           //insert data STARTING ROW 5
           $sheet->fromArray($output, null, 'A1', false, false);
           //styleing
           $sheet->row(1,function($row){
             $row->setFont(array('bold' => true));
           });
           $sheet->row(9,function($row){
             $row->setFont(array('bold' => true));
           });
           $range = "A1:B7";
           $sheet->setBorder($range, 'thin');
           $req_count = sizeof($output);
           $range = "A9:M".$req_count;
           $sheet->setBorder($range, 'thin');
           $range = "A1:M".$req_count;
           $sheet->cells($range, function($cells) {
             $cells->setFont(array( 'size' => '12'));
             $cells->setAlignment('center');
           });
           $range = "A9:M9";
           $sheet->setBorder($range, 'medium');
           $range = "A1:B1";
           $sheet->setBorder($range, 'medium');
           $sheet->setWidth('A', 26);
           $sheet->setWidth('B', 26);
           $sheet->setWidth('C', 46);
           $sheet->setWidth('D', 20);
           $sheet->setWidth('E', 12);
           $sheet->setWidth('F', 12);
           $sheet->setWidth('G', 15);
           $sheet->setWidth('H', 26);
           $sheet->setWidth('I', 9);
           $sheet->setWidth('J', 15);
           $sheet->setWidth('K', 15);
           $sheet->setWidth('L', 20);
           $sheet->setWidth('M', 20);
         });
      });
	
      $myFile = $myFile->string('xlsx'); //change xlsx for the format you want, default is xls
      $response =  array(
         'name' => "exported_data", //no extention needed
         'file' => "data:application/vnd.openxmlformats-officedocument.spreadsheetml.sheet;base64,".base64_encode($myFile) //mime type of used format
      );
      return response()->json($response);
    }

}
