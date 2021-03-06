<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;

use App\Http\Requests;

use App\Email;

use Session;

use Cache;

use Queue;

class SubscribeController extends Controller
{
    public function index()
    {
        // $qtdeSubscribed = Email::count();
        $qtdeSubscribed = (int) Cache::get('qtdeSubscribed');

        $data = [
            'ipaddr'=> $_SERVER['SERVER_ADDR'], 
            'hostname'=> gethostname(), 
            'qtdeSubscribed' => $qtdeSubscribed
        ];

        return view('pages.subscribe', $data);
    }

    public function Subscribed()
    {
        $input = Request::all();
        Email::create($input);
        Cache::increment('qtdeSubscribed');

        $novoEmail = $input['email'];
        $data = ['novo-email' => $novoEmail];
        Queue::push('SendSubscribedEmails', $data);

        Session::flash('flash_message', 'Em breve você receberá nosso muito obrigado.' );
        return redirect('/');
    }
}
