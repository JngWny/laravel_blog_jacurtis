<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use Mail;
use Session;

class PagesController extends Controller {

    public function getIndex() {
        $posts = Post::orderBy('created_at', 'desc')->limit(4)->get();
        return view('pages.welcome')->withPosts($posts);
    }

    public function getAbout() {
        $first = 'Wahida';
        $last = 'Moon';

        $fullname = $first . " " . $last;
        $email = 'wahida.moon80@gmail.com';
        $data = [];
        $data['email'] = $email;
        $data['fullname'] = $fullname;

        //return view('pages.about')->with('email',$email); //works
        /*
          <p> Email: {{$email}} </p>
          <p> Email: <?= $email ?> </p>
        */

     /*   return view('pages.about')->with([
            'email' => $email,
            'fullname' => $fullname
        ]);*/


        /*
        return view('pages.about')->withEmail($email)->withFullname($fullname);
        //email is the key and $email is the value
        //fullname is the key and $fullname is the value
        */

        return view('pages.about')->withData($data); //$data array

        /*$a = "This is variable a";
        $b = "This is variable b";
        $c = "This is variable c";

        return view('pages.about',compact('a','b','c'));*/
    }

    public function getContact() {
        return view('pages.contact');
    }

    public function postContact(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'min:3',
            'message' => 'min:10']);

        $data = array(
            'email' => $request->email,
            'subject' => $request->subject,
            'bodyMessage' => $request->message
        );

        Mail::send('emails.contact', $data, function($message) use ($data){
            $message->from($data['email']);
            $message->to('selimcse98@gmail.com');
            $message->subject($data['subject']);
        });

        Session::flash('success', 'Your Email was Sent!');

        return redirect('/');
    }


}