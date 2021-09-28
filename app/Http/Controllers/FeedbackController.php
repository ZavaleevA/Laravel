<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class FeedbackController extends Controller
{
    public function dataFeedback(Request $req){
        $name = $req->input('name');
        $email = $req->input('email');
        $text = $req->input('text');
        if (($name == NULL) AND ($email == NULL) AND ($text == NULL)) {
            return redirect()->back()->with('error', 'Вы не заполнили обязательные поля! Пожалуйста, заполните все поля!');
        }
        if ($name == NULL) {
            return redirect()->back()->with('error', 'Вы не ввели свое имя! Пожалуйста, заполните все поля еще раз!');
        } elseif ($email == NULL) {
            return redirect()->back()->with('error', 'Вы не ввели email! Пожалуйста, заполните все поля еще раз!');
        } elseif ($text == NULL) {
            return redirect()->back()->with('error', 'Вы не ввели текст сообщения! Пожалуйста, заполните все поля еще раз!');
        }

        $textForEmail = '💫Получен новый отзыв от пользвателя ' . $name . ' с сайта Laravel! Ниже находиться вся подробная информация.' . "\n\n" . 
            '✅Имя: ' . $name . "\n" . 
            '🔥Почта: ' . $email . "\n" .  
            '✉Текст сообщения: ' . $text . "\n";

            $data = array( 'email' => 'zavaleev.sbase@gmail.com', 'emailSlack' => 'c9d7u8j1d5y4o8e6@sbase-team.slack.com', 'first_name' => 'Отзыв с сайта Laravel', 'from' => 'zavaleev.sbase@gmail.com',  'from_name' => 'Laravel', 'textMessege' => $textForEmail);

            Mail::send( [], $data, function( $message ) use ($data) {
                $message->to( $data['email'] )->from( $data['from'], 
                $data['first_name'] )->subject( '💥Получен новый отзыв с сайта!' )->setBody($data['textMessege']);
            });
            Mail::send( [], $data, function( $message ) use ($data) {
                $message->to( $data['emailSlack'] )->from( $data['from'], 
                $data['first_name'] )->subject( '💥Получен новый отзыв с сайта!' )->setBody($data['textMessege']);
            });
        return redirect("feedback")->with('success', 'Сообщение было отправлено!');
    }
}