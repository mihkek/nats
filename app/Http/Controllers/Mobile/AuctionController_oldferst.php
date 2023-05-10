<?php

namespace App\Http\Controllers\Mobile;

use App\Models\User;
use App\Models\BlockSuplier;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

use App\Auction;
use App\MyAuctionHistory;
use App\AuctionRate;
use App\SaleRate;
use App\AuctionCounter;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TendersExport;

use DB;
use PDF;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;


use App\Notification;
use Carbon\Carbon;

class AuctionController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // ссылка на карточку
    static function getLinkCard($auction_type, $auction_id)
    {
        $link_card = "";
        if ($auction_type === 'rise') {
            $link_card = 'https://agtender.com/admin/auction/now/card/' . $auction_id;
        }
        if ($auction_type === 'drop') {
            $link_card = 'https://agtender.com/admin/tender/now/card/' . $auction_id;
        }
        if ($auction_type === 'sale') {
            $link_card = 'https://agtender.com/admin/sale/now/card/' . $auction_id;
        }
        return $link_card;
    }

    public function firebase_push_send($user, $auction_type, $firebase_text)
    {
        $firebase_title = "НАТС Тендеры";
        $firebase_token = $user->firebase_token;
        if (isset($user->firebase_token) && !empty($firebase_token) && ($auction_type === "drop")) {
            $firebase_key = "AAAA8YW6Ths:APA91bHMAQYsCeehzLtkfrPznUKL1Cqdt38zTtUutwesuJXQTTmxvh7V6n1H156kTBkAbT3K8h-frGVNEA0WrKcJKioh8BMHrrVV9ODkXS110r7iN0GwY6MNrq6PT1lWi-pXR6Y7MfNA";
            $firebase_url = 'https://fcm.googleapis.com/fcm/send';
            $fields = array(
                'to' => $firebase_token,
                'notification' => array(
                    "title" => $firebase_title,
                    "body" => $firebase_text,
                    "badge" => 1,
                ),
            );
            $fields = json_encode($fields);
            $headers = array(
                'Authorization: key=' . $firebase_key,
                'Content-Type: application/json'
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $firebase_url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            $result = curl_exec($ch);
            //echo $result;
            curl_close($ch);
        }
    }


    // Mobile Api Список тендеров (для неавторизованных)
    public function get_auctions(Request $request)
    {
        $user = User::find($request->user_id);

        $now = date('Y-m-d H:i:s');
        $auctions = DB::table('auctions')
            ->where('type', $request->type);

        // Фильтр по статусам
        if (!empty($request->status)) {
            //$auctions->whereIn('status', $request->status);
            $auctions->where('status', 1);
        }

        /*if (!empty($request->verb)) {
            $verb = explode(" ", $request->verb);
            foreach ($verb as $search) {
                $auctions->where(function ($query) use ($search) {
                    $query->orWhere('title', 'like', '%' . $search . '%');
                    $query->orWhere('active_material', 'like', '%' . $search . '%');
                });
            }
        }*/

        // Фильтр по дате
        if (!empty($request->date_filter)) {
            if ($request->date_filter == 2) {
                if (!empty($request->date_from)) {
                    $auctions->where('created_at', '>=', $request->date_from);
                }
                if (!empty($request->date_to)) {
                    $auctions->where('created_at', '<=', $request->date_to);
                }
            }
            if ($request->date_filter == 1) {
                if (!empty($request->date_from) && $request->date_from != '') {
                    $auctions->where('over_date', '>=', $request->date_from);
                }
                if (!empty($request->date_to) && $request->date_to != '') {
                    $auctions->where('over_date', '<=', $request->date_to);
                }
            }
        }

        // Прошедние или активные аукционы
        $now = date('Y-m-d H:i:s');
        if (!empty($request->now)) {
            if ($request->now == true) {
                $auctions->where('over_date', '>', $now);
            } else if ($request->now == false) {
                $auctions->where('over_date', '<', $now);
            }
        }

        // Фильтр по региону
        if (!empty($request->region) && is_array($request->region)) {
            $regions = $request->region;
            $auctions->where(function ($query) use ($regions) {
                foreach ($regions as $region) {
                    $query->orWhere('delivery_region', 'like', '%' . $region . '%');
                }
            });
        }


        if (!empty($user)) {
            if ($request->own == true) {
                $auctions->where('user_id', $user->id);
            }
        }

        $auctions = $auctions->orderBy('created_at', 'desc')->get();
        $res = array();

        foreach ($auctions as $auction) {
            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now;

            $auction->datediff = floor($datediff / (60 * 60 * 24));
            $auction->created = date('d.m.y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.y', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.y', strtotime($auction->delivery_date));
            $auction->article = str_pad($auction->id, 10 - mb_strlen($auction->id), '0', STR_PAD_LEFT);
            $auction->exclude_analogs = json_decode($auction->exclude_analogs, true);

            //user
            //$auction_user = DB::table('users')->where('id', $auction->user_id)->first();

            // Если есть ставка
            if ($auction->type == 'rise') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price', 'desc')->first();
            } else if ($auction->type == 'drop') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }

            if (!empty($rate)) {
                $rate->created = date('d.m.y H:i', strtotime($rate->created_at));
                $item = array(
                    'auction' => $auction,
                    'rate' => $rate,
                    //'user' => $auction_user
                );
            } else {
                $item = array(
                    'auction' => $auction,
                    //'user' => $auction_user
                );
            }
            array_push($res, $item);
        }

        return response(['status' => 1, 'auctions' => $res], 200);
    }


    //страница тендера
    public function get_auction_page(Request $request)
    {

        $auction = Auction::where('id', $request->id)->first();


        if (!empty($auction)) {


            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now;

            $auction->datediff = floor($datediff / (60 * 60 * 24));
            $auction->created = date('d.m.y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.y', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.y', strtotime($auction->delivery_date));
            $auction->article = str_pad($auction->id, 10 - mb_strlen($auction->id), '0', STR_PAD_LEFT);
            $auction->exclude_analogs = json_decode($auction->exclude_analogs, true);

            //user
            $auction_user = DB::table('users')->where('id', $auction->user_id)->first();
            if (!empty($auction_user)) {
                if (!empty($auction_user->company_check_file)) {
                    $auction_user->company_check_file_link = "https://agtender.com/storage/proofs/" . $auction_user->company_check_file;
                } else {
                    $auction_user->company_check_file_link = NULL;
                }
            }
            $rate = 0;
            if ($auction->type == 'rise') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price', 'desc')->first();
            } else if ($auction->type == 'drop') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }

            $res = array(
                'auction' => $auction,
                'rate' => $rate,
                'user' => $auction_user,
            );
        } else {
            $res = array(
                'auction' => NULL,
                'rate' => NULL,
                'user' => NULL,
            );
        }

        return response(['status' => 1, 'item' => $res], 200);
    }


    public function add_rate(Request $request)
    {
        $auction = Auction::find($request->auction_id);
        $auction_user = User::find($auction->user_id);
        $rate_user = User::find(Auth::user()->id);
        $last_rate = AuctionRate::where('auction_id', $auction->id)
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->where('deleted', '')
            ->first();
        $last_rate_price = $auction->start_price;
        if (!empty($last_rate)) {
            $last_rate_user = User::find($last_rate->user_id);
            $last_rate_price = $last_rate->price;
        }
        /*else {
            $last_rate_price = $auction->start_price;
        }*/

        // если ставка равно или больше предыдущему ставку
        if ($last_rate_price <= $request->value) {
            $text = 'Предложите цену ниже текущей '.$last_rate_price.' руб.';
            return response(['status' => 1, 'text' => $text], 200);
        }

        $rate = new AuctionRate;
        $rate->auction_id = $request->auction_id;
        $rate->user_id = Auth::user()->id;
        $rate->price = $request->value;
        $rate->is_analog = 0;
        $rate->analog_name = '';
        $rate->save();


        //140122 обновление времени 5 минут
        /*if (!empty($auction->over_date)) {
            $current_over_date = $auction->over_date;
            $current_over_date_time = strtotime($current_over_date);
            $current_over_date_five = date('Y-m-d', $current_over_date_time);
            $current_over_date_five = $current_over_date_five . ' 16:59:59';
            $current_date = date('Y-m-d H:i:s', time());
            //если время больше 5 часов
            if ($current_date >= $current_over_date_five) {
                $new_current_over_date = date('Y-m-d H:i:s', strtotime('+5 minutes', $current_over_date_time));
                $auction->over_date = $new_current_over_date;
                $auction->save();
            }
        }


        // ссылка на карточку
        $link_card = self::getLinkCard($auction->type, $auction->id);

        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        if ($auction_user->notification_off === NULL) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $mail->to($auction_user->email);
            Mail::send($mail);
            self::firebase_push_send($auction_user, $auction->type, "Новая ставка в тендере " . $auction->id);
        }

        if ($rate_user->notification_off === NULL) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $mail->to($rate_user->email);
            Mail::send($mail);
            self::firebase_push_send($rate_user, $auction->type, "Новая ставка в тендере " . $auction->id);
        }

        if (!empty($last_rate)) {

            $last_rate_user = User::find($last_rate->user_id);
            if ($last_rate_user->notification_off === NULL) {
                $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
                $mail->to($last_rate_user->email);
                Mail::send($mail);
            }

        }*/

        $text = 'Ваша ставка успешно добавлена';
        return response(['status' => 1, 'text' => $text], 200);
    }

    public function add_rate_analog(Request $request)
    {

        $auction = Auction::find($request->auction_id);
        $auction_user = User::find($auction->user_id);
        $rate_user = User::find(Auth::user()->id);
        $last_rate = AuctionRate::where('auction_id', $auction->id)
            ->orderBy('id', 'desc')
            ->where('status', 1)
            ->where('deleted', '')
            ->first();

        if (!empty($last_rate)) {
            $last_rate_user = User::find($last_rate->user_id);
            $last_rate_price = $last_rate->price;
        } else {
            $last_rate_price = $auction->start_price;
        }

        $rate = new AuctionRate;
        $rate->auction_id = $request->auction_id;
        $rate->user_id = Auth::user()->id;
        $rate->price = $request->value;
        $rate->analog_name = $request->analog_name;
        $rate->is_analog = 1;
        $rate->save();

        //140122 обновление времени 5 минут
        if (!empty($auction->over_date)) {
            $current_over_date = $auction->over_date;
            $current_over_date_time = strtotime($current_over_date);
            $current_over_date_five = date('Y-m-d', $current_over_date_time);
            $current_over_date_five = $current_over_date_five . ' 16:59:59';
            $current_date = date('Y-m-d H:i:s', time());
            //если время больше 5 часов
            if ($current_date >= $current_over_date_five) {
                $new_current_over_date = date('Y-m-d H:i:s', strtotime('+5 minutes', $current_over_date_time));
                $auction->over_date = $new_current_over_date;
                $auction->save();
            }
        }


        // ссылка на карточку
        $link_card = self::getLinkCard($auction->type, $auction->id);

        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        if ($auction_user->notification_off === NULL) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $mail->to($auction_user->email);
            Mail::send($mail);
            self::firebase_push_send($auction_user, $auction->type, "Новая ставка в тендере " . $auction->id);
        }

        if ($rate_user->notification_off === NULL) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $mail->to($rate_user->email);
            Mail::send($mail);
        }

        self::firebase_push_send($rate_user, $auction->type, "Новая ставка в тендере " . $auction->id);

        if (!empty($last_rate)) {
            $last_rate_user = User::find($last_rate->user_id);
            if ($last_rate_user->notification_off === NULL) {
                $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
                $mail->to($last_rate_user->email);
                Mail::send($mail);
                self::firebase_push_send($last_rate_user, $auction->type, "Новая ставка в тендере " . $auction->id);
            }
        }

        $text = 'Ваша ставка успешно добавлена';
        return response(['status' => 1, 'text' => $text], 200);
    }


    // Mobile Api
    public function get_auction(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if (!empty($request->id)) {
            $user = Auth::user();
            $block_arr = [];
            $block_subliers_user = BlockSuplier::where('user_id', $user->id)->get();
            $block_subliers = BlockSuplier::all();
            foreach ($block_subliers as $sublier) {
                array_push($block_arr, $sublier->auction_id);
            }
            $auction = Auction::with('rates', 'win_rate', 'user')->where('id', $request->id)->first();
            if ($auction->rates->count() > 0) {
                if ($auction->type == 'rise') {
                    $rate = AuctionRate::with('user')->whereIn('status', [1, 2])->where('auction_id', $auction->id)->whereNotIn('id', $block_arr)->orderBy('price', 'desc')->where('deleted', '')->first();
                } elseif ($auction->type == '') {
                    $rate = AuctionRate::with('user')->whereIn('status', [1, 2])->where('auction_id', $auction->id)->whereNotIn('id', $block_arr)->orderBy('price')->where('deleted', '')->first();
                }
                if (isset($rate)) {
                    $auction->rate = $rate;
                    $auction->price = $rate->price;
                    foreach ($auction->rates as $rate) {
                        $rate->created_formated = date('d.m.Y H:i', strtotime($rate->created_at));
                    }
                } else {
                    $auction->price = null;

                }

                foreach ($auction->rates as $rate) {
                    $rate->block = false;
                    if (in_array($rate->id, $block_arr)) {
                        $rate->block = true;
                    }
                }

            } else {
                $auction->price = null;
            }
            $now = date('Y-m-d H:i:s');
            $over_date = date('Y-m-d H:i:s', strtotime($auction->over_date));
            if ($now > $over_date) {
                $auction->completed = 1;
            } else {
                $auction->completed = 0;
            }
            $auction->over_date = date('Y-m-d', strtotime($auction->over_date));
//            $auction->article = str_pad($auction->id, 6-mb_strlen($auction->id), '0', STR_PAD_LEFT);
            $auction->article = sprintf("%05s", $auction->id);
            $auction->exclude_analogs = json_decode($auction->exclude_analogs);

            $auction->customer_contract_files = json_decode($auction->customer_contract_files);
            $auction->supplier_contract_files = json_decode($auction->supplier_contract_files);

            $over_date = strtotime($auction->over_date);
            $deliv_date = strtotime($auction->delivery_date);
            $deliv_interval = $deliv_date - $over_date;
            $auction->deliv_interval = floor($deliv_interval / (60 * 60 * 24));

            $rate = AuctionRate::where('auction_id', '=', $request->id)->where('user_id', $user->id)->where('status', '=', 2)->first();
            //return response(['status' => 1, 'auction' =>  $rate], 200);
            if ($rate != null) {
                $get_tender_selection_notice = Notification::whereRaw('rateId=' . $rate->id . ' and userId=' . $rate->user_id . ' and type=1')->first();
                if ($get_tender_selection_notice) {
                    $get_tender_selection_notice->updated_at = Carbon::now();
                    $get_tender_selection_notice->save();
                } else {
                    $get_tender_selection_notice = new Notification();
                    $get_tender_selection_notice->rateId = $rate->id;
                    $get_tender_selection_notice->userId = $user->id;
                    $get_tender_selection_notice->type = 1; //уведомление о выборе поставщика
                    $get_tender_selection_notice->onDate = Carbon::now();
                    $get_tender_selection_notice->save();
                }


                //41. Поставщик получает уведомление о реквизитах и заключение договора
                $get_notif_supplier_about_conclusion = Notification::whereRaw('rateId=' . $rate->id . ' and userId=' . $user->id . ' and type=3')->first();
                if ($get_notif_supplier_about_conclusion) {
                    $get_notif_supplier_about_conclusion->updated_at = Carbon::now();
                    $get_notif_supplier_about_conclusion->save();
                } else {
                    //return response(['status' => 1, 'auction' => 'asdasdasd'], 200);
                    $get_notif_supplier_about_conclusion = new Notification();
                    $get_notif_supplier_about_conclusion->rateId = $rate->id;
                    $get_notif_supplier_about_conclusion->userId = $user->id;
                    $get_notif_supplier_about_conclusion->type = 3; //уведомление если оставили предложение на его тендер
                    $get_notif_supplier_about_conclusion->onDate = Carbon::now();
                    $get_notif_supplier_about_conclusion->save();
                }
            }

            $get_notif_submitted_offer_tender = Notification::whereRaw('rateId=' . $auction->id . ' and userId=' . $user->id . ' and type=2')->first();
            if ($get_notif_submitted_offer_tender) {
                $get_notif_submitted_offer_tender->updated_at = Carbon::now();
                $get_notif_submitted_offer_tender->save();
            } else {
                $get_notif_submitted_offer_tender = new Notification();
                $get_notif_submitted_offer_tender->rateId = $auction->id;
                $get_notif_submitted_offer_tender->userId = $user->id;
                $get_notif_submitted_offer_tender->type = 2; //eуведомление если оставили предложение на его тендер
                $get_notif_submitted_offer_tender->onDate = Carbon::now();
                $get_notif_submitted_offer_tender->save();
            }

            //40. Покупатель получает уведомление о реквизитах и заключение договора
            $get_notif_customer_about_conclusion = Notification::whereRaw('rateId=' . $auction->id . ' and userId=' . $user->id . ' and type=3')->first();
            if ($get_notif_customer_about_conclusion) {
                $get_notif_customer_about_conclusion->updated_at = Carbon::now();
                $get_notif_customer_about_conclusion->save();
            } else {
                $get_notif_customer_about_conclusion = new Notification();
                $get_notif_customer_about_conclusion->rateId = $auction->id;
                $get_notif_customer_about_conclusion->userId = $user->id;
                $get_notif_customer_about_conclusion->type = 3; //уведомление уведомление о реквизитах и заключение договора
                $get_notif_customer_about_conclusion->onDate = Carbon::now();
                $get_notif_customer_about_conclusion->save();
            }

            return response(['status' => 1, 'auction' => $auction], 200);
        } else {
            if (!empty($user)) {
                $subdivision_id = $user->subdivision_id;
            } else {
                $subdivision_id = 1;
            }

            // Выбираем аукционы или тендеры с нужным подразделением
            $auctions = Auction::where('type', $request->type)->where('subdivision_id', $subdivision_id);
            $delete_auction = MyAuctionHistory::where('user_id', Auth::user()->id)->pluck('auction_id')->toArray();
            if (isset($request->deleted_auction)) {
                if ($request->deleted_auction == 1) {
                    $auctions->whereIn('id', $delete_auction);
                }
            }
            // Если запрашиваются только собственные
            if (!empty($request->own)) {
                if ($request->own == true) {
                    if ($user->role_id == 101) {
                        $auctions->where('user_id', $user->id);
                    } elseif ($user->role_id == 102) {
                        $supplier_rates = AuctionRate::where('user_id', $user->id)->get();
                        $auctions_id = array();
                        foreach ($supplier_rates as $supplier_rate) {
                            array_push($auctions_id, $supplier_rate->auction_id);
                        }
                        $uniq_auctions_id = array_unique($auctions_id);
                        $auctions->whereIn('id', $uniq_auctions_id);
                    }
                }
            }

            // Фильтр по статусам
            if (!empty($request->status)) {
                $status = array();
                $i = 0;
                foreach ($request->status as $key => $stat) {
                    $status[$i] = $stat;
                    $i++;
                }
                //  return response(['status' => 1, 'auctions' => $status[0]], 200);
                $auctions->whereIn('status', $status);

            }

            // Прошедние или активные аукционы
            $now = date('Y-m-d H:i:s');
            if (!empty($request->now)) {
                if ($request->now == true) {
                    $auctions->where('over_date', '>=', $now);
                } elseif ($request->now == false) {
                    $auctions->where('over_date', '<=', $now);
                }
            }

            // Фильтр по строке поиска
            if (!empty($request->search)) {
                $searches = explode(" ", $request->search);
                foreach ($searches as $search) {
                    $auctions->where(function ($query) use ($search) {
                        $query->orWhere('id', 'like', '%' . $search . '%');
                        $query->orWhere('title', 'like', '%' . $search . '%');
                        $query->orWhere('active_material', 'like', '%' . $search . '%');
                    });
                }
            }

            // Фильтр по дате
            if (!empty($request->date_filter)) {
                if ($request->date_filter == 2) {
                    if (!empty($request->date_from)) {
                        $auctions->where('created_at', '>=', $request->date_from);
                    }
                    if (!empty($request->date_to)) {
                        $auctions->where('created_at', '<=', $request->date_to);
                    }
                }
                if ($request->date_filter == 1) {
                    if (!empty($request->date_from) && $request->date_from != '') {
                        $auctions->where('over_date', '>=', $request->date_from);
                    }
                    if (!empty($request->date_to) && $request->date_to != '') {
                        $auctions->where('over_date', '<=', $request->date_to);
                    }
                }
            }

            // Фильтр по региону
            if (!empty($request->region) && is_array($request->region)) {
                $regions = $request->region;
                $auctions->where(function ($query) use ($regions) {
                    foreach ($regions as $region) {
                        $query->orWhere('delivery_region', 'like', '%' . $region . '%');
                    }
                });
            }

            // Лимит ответа
            if (!empty($request->limit)) {
                $auctions->take($request->limit);
            }

            // Сортировка
            if (!empty($request->orderBy)) {
                $auctions->orderBy($request->orderBy, $request->orderType);
            }

            if (!empty($request->excel)) {
                if ($user->role_id != 1000) return response(['status' => 0, 'message' => 'Request denied - adimn rights required'], 200);
//              $auctions->leftjoin(AuctionRate);
                $auctions->select(
                    'id',
                    'user_id',
                    'title',
                    'active_material',
                    'is_analog',
                    'size',
                    'unit',
                    'over_date',
                    'delivery_date',
                    'delivery_condition',
                    'delivery_region',
                    'payment_condition',
                    'special_terms',
                    'status',
                    'customer_confirm',
                    'supplier_confirm',
                    'win_rate_id',
                    'cancel_reason',
                    'created_at',
                    'updated_at'
                );
                /**/
                $time = time();

                $files = Storage::files('public/excel');
                foreach ($files as $file) {
                    $filedate = explode('.', $file);
                    $filedate = array_shift($filedate);
                    $filedate = explode('-', $filedate);
                    $filedate = array_pop($filedate);
                    if (!preg_match("/^[0-9]{14}$/", $filedate)) continue;
                    if ($filedate < date('YmdHis', $time - 60)) {
//                  return response([ 'status' => 1, 'link' => '/storage/excel/'.basename($file)], 200);
                        Storage::delete('public/excel/' . basename($file));
                    }
                }

                Excel::store(new TendersExport($auctions), 'public/excel/НАТС_Тендеры-' . date('YmdHis', $time) . '.xls');
                return response(['status' => 1, 'link' => '/storage/excel/НАТС_Тендеры-' . date('YmdHis', $time) . '.xls'], 200);
            }


            $auctions = $auctions->get();
            //   return response(['1111'=>$auctions->get()],200);

            foreach ($auctions as $auction) {
                $now = time();
                $date = strtotime($auction->over_date);
                $datediff = $date - $now;

                $auction->datediff = floor($datediff / (60 * 60 * 24));

                $delivdate = strtotime($auction->delivery_date);
                $deliv_interval = $delivdate - $date;

                $auction->deliv_interval = floor($deliv_interval / (60 * 60 * 24));

                $rate = $auction->price();
                $rate = AuctionRate::where('auction_id', $auction->id)->with('user')->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
                $user_rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('user_id', $user->id)->where('deleted', '')->orderBy('price')->first();
                if (!empty($rate)) {
                    $auction->rate = $rate;
                }
                if (!empty($user_rate)) {
                    $auction->user_rate = $user_rate;
                }
//                $auction->article = str_pad($auction->id, 6-mb_strlen($auction->id), '0', STR_PAD_LEFT);
                $auction->article = sprintf("%05s", $auction->id);
                $auction->created_formated = date('d.m.Y H:i', strtotime($auction->created_at));
                $auction->date_formated = date('d.m.Y', strtotime($auction->over_date));
                $auction->over_date = date('Y-m-d', strtotime($auction->over_date));
                $auction->delivery_date_formated = date('d.m.Y', strtotime($auction->delivery_date));


            }

            return response(['status' => 1, 'auctions' => $auctions], 200);
        }
    }


    // Mobile Api - история ставок тендера
    public function get_auction_rates($auctionId)
    {
        $status = 1;
        if (!empty($auctionId)) {
            $rate = AuctionRate::with('user')
                ->whereIn('status', [1, 2])
                ->where('auction_id', $auctionId)
                ->orderBy('price', 'desc')
                ->where('deleted', '')
                ->get();
            if (count($rate) < 1) {
                $rate = 'Тендер не найден!';
                $status = 2;
            }
            return response(['status' => $status, 'rates' => $rate], 200);
        } else {
            return response(['status' => $status, 'rates' => 'Тендер не найден!'], 200);
        }
    }


    // Mobile Api
    public function get_tender_selection_notice()
    {
        $authuser = Auth::user()->id;
        $sql = DB::select('
                                SELECT
                                  *
                                FROM auction_rates ar
                                WHERE ar.user_id = ' . $authuser . '
                                AND ar.status = 2
                                AND ar.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId=' . $authuser . ' AND n.rateId=ar.id)
        ');
        $notifCount = count($sql);
        if ($sql > 0) {
            $text = 'У вас есть ' . count($sql) . ' подтвержденных(ое) предложений(ия)';
        } else {
            $text = 'нет подтвержденых предложений';
        }
        return response(['status' => 1, 'notifCount' => $notifCount, 'text' => $text, 'rate' => $sql], 200);
    }

    // Mobile Api
    public function get_notif_submitted_offer_tender()
    {
        $authuser = Auth::user()->id;
        $sql = DB::select('
                                SELECT
                                  ar.id,
                                  ar.auction_id,
                                  ar.user_id,
                                  ar.price,
                                  ar.is_analog,
                                  ar.analog_name,
                                  ar.status,
                                  ar.deleted,
                                  ar.created_at,
                                  ar.updated_at
                                 FROM auction_rates ar
                                INNER JOIN auctions as a on a.id=ar.auction_id
                                WHERE a.user_id = ' . $authuser . '
                                AND a.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId=' . $authuser . ' AND n.rateId=ar.auction_id AND n.type=2)
        ');
        $notifCount = count($sql);
        if ($sql > 0) {
            $text = 'У вас есть ' . count($sql) . ' оставленных(ая) предложений(ия)';
        } else {
            $text = 'нет подтвержденых предложений';
        }
        return response(['status' => 1, 'notifCount' => $notifCount, 'text' => $text, 'rate' => $sql], 200);
    }

    // Mobile Api 40. Покупатель
    public function get_notif_customer_about_conclusion()
    {
        $authuser = Auth::user()->id;
        $sql = DB::select('SELECT 
                                 *
                                FROM auctions a
                                INNER JOIN auction_rates ar ON ar.auction_id=a.id AND ar.status=2
                                WHERE a.user_id = ' . $authuser . ' AND a.status=2
                                AND a.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId= ' . $authuser . ' AND n.rateId=a.id AND n.type=3)
        ');
        $notifCount = count($sql);
        if ($sql > 0) {
            $text = 'У вас заключеные договора: ' . count($sql);
        } else {
            $text = 'нет заключенных договоров';
        }
        return response(['status' => 1, 'notifCount' => $notifCount, 'text' => $text, 'rate' => $sql], 200);
    }

    // Mobile Api 41. Поставщик
    public function get_notif_supplier_about_conclusion()
    {
        $authuser = Auth::user()->id;
        $sql = DB::select('
                                SELECT 
                                 *
                                FROM auction_rates ar 
                                INNER JOIN auctions a ON a.id= ar.auction_id AND a.status=2
                                WHERE ar.user_id = ' . $authuser . ' AND ar.status=2
                                AND ar.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId=' . $authuser . ' AND n.rateId=a.win_rate_id AND n.type=3);
        ');
        $notifCount = count($sql);
        if ($sql > 0) {
            $text = 'У вас заключеные договора: ' . count($sql);
        } else {
            $text = 'нет заключенных договоров';
        }
        return response(['status' => 1, 'notifCount' => $notifCount, 'text' => $text, 'rate' => $sql], 200);
    }

    // Mobile Api
    public function getRegions()
    {
        $auctions = DB::table('auctions')->whereRaw("delivery_region IS NOT NULL AND delivery_region !=''")
            ->select(
                'delivery_region'
            )->groupBy('delivery_region')->get();

        return response(['status' => 1, 'regions' => $auctions], 200);
    }


    // Mobile Api
    public function apiMobile_get_contract_file(Request $request)
    {

        $auction = DB::table('auctions')->where('id', $request->tender_id)->first();
        $customer = json_decode($auction->customer_contract_files);
        $supplier = json_decode($auction->supplier_contract_files);
        $data = [];
        if ($customer != '' || $customer != null) {
            foreach ($customer as $as) {
                $naz = explode('/', $as);
                $data["customer"][] = [
                    'name' => $naz[1],
                    'link' => $request->getHttpHost() . '/api/get_contract_file_download_file/' . $as,
                ];
            }
        }
        if ($supplier != '' || $supplier != null) {
            foreach ($supplier as $as) {
                $naz = explode('/', $as);
                $data["supplier"][] = [
                    'name' => $naz[1],
                    'link' => $request->getHttpHost() . '/api/get_contract_file_download_file/' . $as,
                ];
            }
        }
        $data["auction_contract"][] = [
            'name' => 'Договор поставки №ЭТП-' . $auction->id . '.pdf',
            'link' => $request->getHttpHost() . '/api/get_auction_contract_pdf/' . $auction->id,
        ];
        return response(['status' => 1, 'data' => $data], 200);
    }


    // Mobile Api
    public function apiMobile_get_contract_file_download_file($god, $naz)
    {
        {
            $file = storage_path('app/public/contracts/' . $god . '/' . $naz);
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download($file, $naz, $headers);
        }
    }


    // Mobile Api
    public function apiMobile_get_auction_contract_pdf($auctionId)
    {
        $auction = Auction::with('rates', 'win_rate', 'user')->whereRaw('id=' . $auctionId)->first();
        $auction->article = sprintf("%05s", $auction->id);
        $pdf = PDF::loadView('pdf.auction_contract', ['auction' => $auction]);
        return $pdf->download('Договор поставки №ЭТП-' . $auction->id . '.pdf');
        return response(['status' => 1, 'text' => "Файл договора сформирован и откроется в новой вкладке"], 200);
    }


}
