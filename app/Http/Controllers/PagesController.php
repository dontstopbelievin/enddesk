<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function getHome(){
      return view('home');
    }
    public function guest_page(){
      return view('guest_page');
    }
    public function getSettings(){
      return view('settings.settings')->with('user', Auth::user());
    }
    public function getSettings2($id){
      return view('settings.settings')->with(['user' => Auth::user(), 'menu' => $id]);
    }
    public function getCategory(){
      return view('settings.category');
    }
    public function getPriority(){
      return view('settings.priority');
    }
    public function getStatus(){
      return view('settings.status');
    }
    public function getUser(){
      return view('settings.user');
    }
    public function exportToExcel(){
      return view('export_to_excel');
    }
    public function closeReq($id){
      return view('close_request')->with('id', $id);
    }
    public function printReq($id){
      return view('print_request')->with('id', $id);
    }
}
