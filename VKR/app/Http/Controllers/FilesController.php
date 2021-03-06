<?php

namespace App\Http\Controllers;

use App\Models\User;
use DB;
use App\Http\Controllers\usercontroller;
use App\Models\FileManager;

use Illuminate\Http\Request;

class FilesController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }
    // функция для отправки сообщения, которая также проверяет наличие прикрепленного файла
    public function UpLoad(Request $request, $id_to, $quest_id) {
        $user = new User;  
        $file = $request->file('files');
        $text = $request->input('text');
        if ($file > 0){
            $file->store('files');
            $path = $request->file('files')->store('files');
            $message = FileManager::create([
            'href' => $path,
            'id_from' => auth()->id(),
            'id_to' => $id_to,
            'id_1' => $quest_id,
            'text' => $text
            ]);
         return back();
        }

        else { 
            $message = FileManager::create([
            'href' => 0,
            'id_from' => auth()->id(),
            'id_to' => $id_to,
            'id_1' => $quest_id,
            'text' => $text]);
            return back();
        }
    }
    //функция для загрузки файлов с сервера
    public function Download(Request $request) {
        $messagefrom = New FileManager;
        $text = $request->input('href');;

        return \Storage::download($text);
    }

}
