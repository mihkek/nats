<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Auction;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MessagesExport;

use DB;
use PDF;
use File;
use Storage;


class MessageController extends Controller
{
	public function index()
	{
		$messages = Message::orderBy('id', 'desc')->get()->toArray();
		return response(['status' => 1, 'data' => $messages], 200);
	}

    public function index_new()
    {
        $messages = Message::where('published', 0)->orderBy('id', 'desc')->get()->toArray();
        return response(['status' => 1, 'data' => $messages], 200);
    }

    public function counter() 
    {
        $counter = Message::where('published', 0)->count();
        return response(['status' => 1, 'data' => $counter], 200);
    }

    public function list() {
        return view('admin.messages.list');
    }

    public function list_new() {
        return view('admin.messages.list_new');
    }

    public function get_messages(Request $request)
    {
        $auction_id = (int) $request->get('auction_id');
        $user_id = (int) $request->get('user_id');

        $messages = Message::where('auction_id', $auction_id)->where('published', 1)->get()->toArray();
        $current_messages = [];
        foreach ($messages as $message) {
            if ($message["user_from"] === $user_id || $message["user_to"] === $user_id) {
                array_push($current_messages, $message);
            }
        }

        return response(['status' => 1, 'data' => $current_messages], 200);
    }

    public function get_admin_messages(Request $request)
    {
        $auction_id = (int) $request->get('auction_id');
        $user_id = (int) $request->get('user_id');
        $messages = Message::where('auction_id', $auction_id)->get()->toArray();
        return response(['status' => 1, 'data' => $messages], 200);
    }

    public function send(Request $request)
    {
    	$new_message = $request->get('new_message');
        $new_message = trim(strip_tags($new_message));
        $name = $request->get('name');
        $auction_id = (int) $request->get('auction_id');
        $user_auction = (int) $request->get('user_auction');
        $user_from = (int) $request->get('user_from');
        $user_to = (int) $request->get('user_to');

    	if (!empty($new_message) && !empty($name)  && !empty($auction_id)) {
    		$message = new Message;
    		$message->auction_id = $auction_id;
    		$message->user_auction = $user_auction;
    		$message->user_from = $user_from;
    		$message->user_to = $user_to;
    		$message->name = $name;
    		$message->message = trim($new_message);
    		$message->published = 0;
    		$message->save();

            $auction = Auction::find($auction_id);
            $message_text = $message->message;  
            
            $user_to_email = "info@agtender.com";
            $subject = 'Новое сообщение на модерации';
            self::send_mail($auction_id, $auction, $message_text, $user_to_email, $subject);


    		return response(['status' => 1, 'msg' => 'Message sended'], 200);
    	}
        return response(['status' => 0, 'msg' => 'Error'], 200);
    	    	
    }


    public function send_mail($auction_id, $auction, $message_text, $user_to_email, $subject) {

        $link_card = '';
        $auction_title = '';

        if ($auction->type == 'rise') {
            $auction_title = 'Аукцион';
            $link_card = 'https://agtender.com/admin/auction/now/card/' . $auction_id;
        }
        if ($auction->type == 'drop') {
            $auction_title = 'Тендер';
            $link_card = 'https://agtender.com/admin/tender/now/card/' . $auction_id;
        }
        if ($auction->type == 'sale') {
            $auction_title = 'Распродажа';
            $link_card = 'https://agtender.com/admin/sale/now/card/' . $auction_id;
        }

        $mail = new \App\Mail\NewMessage($message_text, $auction_id, $auction_title, $link_card, $subject);            
       
        $mail->to($user_to_email);
        Mail::send($mail);
    }


    public function publish(Request $request)
    {    

        $id = (int) $request->get('id');
        $message = Message::find($id);
        if (!empty($message)) {

            $message_user_from = $message->user_from;
            $message_user_to = $message->user_to;
            $message_text = $message->message;
            $message->published = 1;
            $message->save();   

            $user_to = User::find($message_user_to);
            $user_to_email = $user_to->email;
            $subject = 'Новое сообщение';

            $auction = Auction::find($message->auction_id);
            self::send_mail($message->auction_id, $auction, $message_text, $user_to_email,$subject);

            
            return response(['status' => 1, 'msg' => 'Message published'], 200);
        }
        return response(['status' => 0, 'msg' => 'Error'], 200);
    }

    public function update(Request $request)
    {
        $id = (int) $request->get('id');
        $text = $request->get('text');
        $message = Message::find($id);
        if (!empty($message)) {
            $message->message = !empty($text) ? $text : "";
            $message->save();
            return response(['status' => 1, 'msg' => 'Message updated'], 200);
        }
        return response(['status' => 0, 'msg' => 'Error'], 200);
    }

    public function destroy($id)
    {       
        $message = Message::find($id);
        if (!empty($message)) {               
            $message = Message::destroy($id);
            return response(['status' => 1, 'msg' => 'Message deleted'], 200);
        } else {
             return response(['status' => 0, 'msg' => 'Error'], 200);
        }
    }

    public function get_xls(Request $request) {
        $messages = Message::where('published', 1)->get();
        $time = time();
        Excel::store(new MessagesExport($messages), 'public/excel/НАТС_Сообщения-' . date('YmdHis', $time) . '.xls');
        return response(['status' => 1, 'link' => '/storage/excel/НАТС_Сообщения-' . date('YmdHis', $time) . '.xls'], 200);
    }


}
