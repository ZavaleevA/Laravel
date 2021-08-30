<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \DB;
use \Auth;
use \Hash;

class NewUserDateController extends Controller
{
    public function new(Request $info){
        $name = $info->input('name');
        $passNew = $info->input('passNew');
        $passNewСonfirm = $info->input('passNewСonfirm');

        if ($name != ''){
            if ($name != Auth::user()->name){
                DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['name' => $name]);
                $name = "Имя обновлено! ";
            } else {
                $name = "";
            }
        } else {
            $name = "Вы не ввели новое имя!";
        }

        if ($passNew != ''){
            if ($passNew >= 8){
                if ($passNewСonfirm != ''){
                    if ($passNewСonfirm == $passNew){
                        $hashedPassword = Hash::make($passNew);
                        DB::table('users')
                            ->where('id', Auth::user()->id)
                            ->update(['password' => $hashedPassword]);
                        $passNew = "Пароль успешно обновлен!";
                    } else {
                        $passNew = "Повторный пароль введен не верно!";
                    }
                } else {
                    $passNew = "Вы не ввели повторно новый пароль!";
                }   
            } else {
                $passNew = "Слишком короткий пароль, пожалуйста, введите от 8 символов";    
            }
        }

        if ($name == $passNew){
            $name = "Данные не изменились!";
        }
        $conclusion = $name . $passNew;
        return redirect("newUserDate")->with('newData', $conclusion);
    }
}
