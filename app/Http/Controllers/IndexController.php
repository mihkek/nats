<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//FED
use Illuminate\Support\Facades\Mail;

use App\Models\User;
use App\Models\News;
use App\Models\Drugs;

use App\AuctionCounter;

use App\Auction;
use App\AuctionRate;
use App\SaleRate;
use DB;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;

class IndexController extends Controller
{
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->get();
        foreach ($news as $new) {
            $new->created_formated = date('d.m.Y H:i', strtotime($new->created_at));
        }

        $now = date('Y-m-d H:i:s');
        $limit = 5;
        $tenders = DB::table('auctions')
            ->whereIn('type', ['drop', 'dropdv']);
        $tenders->whereIn('status', [1]);
        $tenders->where('over_date', '>', $now);
        $tenders = $tenders->orderBy('id', 'desc')->take($limit)->get();

        $sales = DB::table('auctions')
            ->where('type', 'sale');
        $sales = $sales->whereIn('status', [1]);
        $sales->where('over_date', '>', $now);
        $sales = $sales->orderBy('id', 'desc')->take($limit)->get();

        $res_tenders = array();
        $res_sales = array();

        foreach ($tenders as $auction) {
            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now; 

            $auction->title = ($auction->title == '') ? '-' : $auction->title;
            $slug = $auction->title . ' ' . $auction->active_material;
            $auction->slug = self::url_slug($slug, ['transliterate' => true]);

            $auction->datediff = floor($datediff / (60 * 60 * 24));
            $auction->timeiff = floor(($datediff / (60 * 60)) - $auction->datediff * 24);
            $auction->created = date('d.m.y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.y', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.y', strtotime($auction->delivery_date));
            $auction->article = str_pad($auction->id, 10 - mb_strlen($auction->id), '0', STR_PAD_LEFT);
            $auction->exclude_analogs = json_decode($auction->exclude_analogs, true);
            //$user = DB::table('users')->where('id', $auction->user_id)->first();

            // Если есть ставка
            if ($auction->type == 'rise') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price', 'desc')->first();
            } else if ($auction->type == 'drop') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            } //распродажи
            else if ($auction->type == 'sale') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }

            //21.07.22 распродажа стартовая ценаа
            if ($auction->type == 'sale') {
                $date_now = date('Y-m-d H:i:s');
                $sale_rate_item = SaleRate::where('auction_id', $auction->id)->where('date_price', '<=', $date_now)->orderBy('id', 'desc')->first();
                if (!empty($sale_rate_item)) {
                    $sale_rate_price = $sale_rate_item->price;
                    $auction->start_price = $sale_rate_price;
                }
            }

            if (!empty($rate)) {
                $rate->created = date('d.m.y H:i', strtotime($rate->created_at));
                $item = array(
                    'auction' => $auction,
                    'rate' => $rate,
                );
            } else {
                $item = array
                (
                    'auction' => $auction,
                    'rate' => [],
                );
            }
            array_push($res_tenders, $item);
        }

        foreach ($sales as $auction) {

            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now;

            $auction->title = ($auction->title == '') ? '-' : $auction->title;
            $slug = $auction->title . ' ' . $auction->active_material;
            $auction->slug = self::url_slug($slug, ['transliterate' => true]);

            $auction->datediff = floor($datediff / (60 * 60 * 24));
            $auction->timeiff = floor(($datediff / (60 * 60)) - $auction->datediff * 24);
            $auction->created = date('d.m.y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.y', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.y', strtotime($auction->delivery_date));
            $auction->article = str_pad($auction->id, 10 - mb_strlen($auction->id), '0', STR_PAD_LEFT);
            $auction->exclude_analogs = json_decode($auction->exclude_analogs, true);
            //$user = DB::table('users')->where('id', $auction->user_id)->first();

            // Если есть ставка
            if ($auction->type == 'rise') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price', 'desc')->first();
            } else if ($auction->type == 'drop') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            } //распродажи
            else if ($auction->type == 'sale') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }

            //21.07.22 распродажа стартовая цена
            if ($auction->type == 'sale') {
                $date_now = date('Y-m-d H:i:s');
                $sale_rate_item = SaleRate::where('auction_id', $auction->id)->where('date_price', '<=', $date_now)->orderBy('id', 'desc')->first();
                if (!empty($sale_rate_item)) {
                    $sale_rate_price = $sale_rate_item->price;
                    $auction->start_price = $sale_rate_price;
                }
            }

            if (!empty($rate)) {
                $rate->created = date('d.m.y H:i', strtotime($rate->created_at));
                $item = array(
                    'auction' => $auction,
                    'rate' => $rate,
                );
            } else {
                $item = array
                (
                    'auction' => $auction,
                    'rate' => [],
                );
            }
            array_push($res_sales, $item);
        }

        /*
        $customers = User::where('deleted', '<>', 'on');
        $customers = $customers->get();
        $userscount = $customers->count();

        $userscount = number_format($userscount, 0, ',', ' ');

        $auctions = DB::table('auctions');
        $auctions->where('type', 'drop');
        $tenderscount = $auctions->max('id');
        $tenderscount = number_format($tenderscount, 0, ',', ' ');

        $auctions = $auctions->get();
        $auction_counter = AuctionCounter::find(1);
        $summcount = $auction_counter->counter;
        $summcount = number_format($summcount, 0, ',', ' ');*/

        $data = [
            'news' => $news,
            'tenders' => $res_tenders,
            'sales' => $res_sales,

            //'counters' => ["userscount" => $userscount, "tenderscount" => $tenderscount, "summcount" => $summcount],     
        ];
        return view('index.index', $data);
    }


    //api news
    public function get_news(Request $request)
    {
        $news = News::orderBy('created_at', 'desc')->get();
        foreach ($news as $new) {
            $new->created_formated = date('d.m.Y H:i', strtotime($new->created_at));
        }
        return response(['status' => 1, 'news' => $news], 200);
    }

    public function getNewsList(Request $request)
    {
        $news = News::orderBy('created_at', 'desc')->get();
        foreach ($news as $new) {
            $new->created_formated = date('d.m.Y H:i', strtotime($new->created_at));
        }
        $data = [
            'news' => $news,
        ];
        return view('index.news.index', $data);
    }

    public function getNews(Request $request, $slug)
    {
        $news = News::where('slug', $slug)->first();
        if (!empty($news)) {

            $news->created_formated = date('d.m.Y H:i', strtotime($news->created_at));
            $data = [
                'news' => $news,
            ];
            return view('index.news.detail', $data);
        } else {
            abort(404);
            return false;
        }
    }

    public function get_auctions(Request $request)
    {
        $user = User::find($request->user_id);

        $now = date('Y-m-d H:i:s');
        $auctions = DB::table('auctions')
            ->whereIn('type', $request->type);

        // Фильтр по статусам
        if (!empty($request->status)) {
            $auctions->whereIn('status', $request->status);
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

        if (!empty($request->limit)) {
            $limit = (int)$request->limit;
            $auctions = $auctions->orderBy('created_at', 'desc')->take($limit)->get();
        } else {
            $auctions = $auctions->orderBy('created_at', 'desc')->get();
        }


        $res = array();

        foreach ($auctions as $auction) {

            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now;

            $auction->title = ($auction->title == '') ? '-' : $auction->title;
            $slug = $auction->title . ' ' . $auction->active_material;
            $auction->slug = self::url_slug($slug, ['transliterate' => true]);
            $auction->datediff = floor($datediff / (60 * 60 * 24));
            $auction->created = date('d.m.y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.y', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.y', strtotime($auction->delivery_date));
            $auction->article = str_pad($auction->id, 10 - mb_strlen($auction->id), '0', STR_PAD_LEFT);
            $auction->exclude_analogs = json_decode($auction->exclude_analogs, true);
            $user = DB::table('users')->where('id', $auction->user_id)->first();

            // Если есть ставка
            if ($auction->type == 'rise') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price', 'desc')->first();
            } else if ($auction->type == 'drop') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            } //распродажи
            else if ($auction->type == 'sale') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }

            //21.07.22 распродажа стартовая ценаа
            if ($auction->type == 'sale') {
                $date_now = date('Y-m-d H:i:s');
                $sale_rate_item = SaleRate::where('auction_id', $auction->id)->where('date_price', '<=', $date_now)->orderBy('id', 'desc')->first();
                if (!empty($sale_rate_item)) {
                    $sale_rate_price = $sale_rate_item->price;
                    $auction->start_price = $sale_rate_price;
                }
            }


            if (!empty($rate)) {
                $rate->created = date('d.m.y H:i', strtotime($rate->created_at));
                $item = array(
                    'auction' => $auction,
                    'rate' => $rate,
                    'user' => $user
                );
            } else {
                $item = array(
                    'auction' => $auction,
                    'user' => $user
                );
            }
            array_push($res, $item);
        }

        return response(['status' => 1, 'auctions' => $res], 200);
    }

    //api получение аукциона по id
    public function get_auction(Request $request, $tender_id)
    {
        $auction = Auction::find($tender_id);
        if (!empty($auction)) {

            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now;

            $auction->title = ($auction->title == '') ? '-' : $auction->title;
            $auction->datediff = floor($datediff / (60 * 60 * 24));
            $auction->created = date('d.m.y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.y', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.y', strtotime($auction->delivery_date));
            $auction->article = str_pad($auction->id, 10 - mb_strlen($auction->id), '0', STR_PAD_LEFT);
            $auction->exclude_analogs = json_decode($auction->exclude_analogs, true);
            $user = DB::table('users')->where('id', $auction->user_id)->first();

            // Если есть ставка
            if ($auction->type == 'rise') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price', 'desc')->first();
            } else if ($auction->type == 'drop') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            } //распродажи
            else if ($auction->type == 'sale') {
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }

            //21.07.22 распродажа стартовая ценаа
            if ($auction->type == 'sale') {
                $date_now = date('Y-m-d H:i:s');
                $sale_rate_item = SaleRate::where('auction_id', $auction->id)->where('date_price', '<=', $date_now)->orderBy('id', 'desc')->first();
                if (!empty($sale_rate_item)) {
                    $sale_rate_price = $sale_rate_item->price;
                    $auction->start_price = $sale_rate_price;
                }
            }

            if (!empty($rate)) {
                $rate->created = date('d.m.y H:i', strtotime($rate->created_at));
                //$auction->rate = $rate;
                $item = array(
                    'auction' => $auction,
                    'rate' => $rate,
                );
            } else {
                $item = array(
                    'auction' => $auction,
                );
            }


            return response(['status' => 1, 'item' => $item], 200);
        }

    }


    //старый счетчик
    public function get_counters_old(Request $request)
    {
        $customers = User::where('role_id', "<", 105)->where('deleted', '<>', 'on'); //->where('confirm', 'on')
        $customers = $customers->get();

        $auctions = DB::table('auctions');
        $auctions->where('type', 'drop');
        $auctions->whereIn('status', [1, 2]); // 0 - отменен, 1 - активный, 2 - завершен
        $auctions = $auctions->get();

        $summ = 0;
        foreach ($auctions as $auction) {
            $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            if (!empty($rate)) {
                $auction->rate = $rate;
                $summ += $rate->price * $auction->size;
            }
        }

        // постепенно сводим прибавляеое количество пользователей к нулю
        $addusers = 500;
        $usercount = $customers->count();
        if ($usercount <= 1401) {
            $addusers = floor((1401 - $usercount) / 2);
        } else {
            $addusers = 0;
        }
        // Поскольку с определенного момента учитываются и неподтвержденные пользователи, отменяем "накрутку"
        $addusers = 0;

        return response(['status' => 1, 'counters' => ["userscount" => $customers->count() + $addusers, "tenderscount" => $auctions->max('id'), "summcount" => $summ]], 200);
    }


    public function get_counters(Request $request)
    {
        $customers = User::where('deleted', '<>', 'on');
        $customers = $customers->get();
        $userscount = $customers->count();

        $auctions = DB::table('auctions');
        $auctions->where('type', 'drop');
        //$auctions->whereIn('status', [1, 2]);

        $tenderscount = $auctions->max('id');
        $auctions = $auctions->get();

        $auction_counter = AuctionCounter::find(1);

        //завершенные
        $summcount = $auction_counter->counter;


        //активные
        $auctions = DB::table('auctions');
        $auctions->where('type', 'drop');
        $auctions->whereIn('status', [1]); // 0 - отменен, 1 - активный, 2 - завершен
        $auctions = $auctions->get();

        $summactive = 0;

        foreach ($auctions as $auction) {
            $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            if (!empty($rate) && !empty($auction->size)) {
                //$auction->rate = $rate;
                $summactive += $rate->price * $auction->size;
            }
        }

        $summ = $summcount + $summactive;

        return response(['status' => 1, 'counters' => ["userscount" => $userscount, "tenderscount" => $tenderscount, "summcount" => $summ]], 200);
    }


    // FED
    public function callme(Request $request)
    {
        //info@agtender.com

        if (!empty($request->phone)) {
            //saturn
            if (!empty($request->inn)) {
                Mail::send('emails.callmesaturn', array('form_subject' => $request->form_subject, 'recipient' => $request->recipient, 'phone' => $request->phone, 'inn' => $request->inn, 'company' => $request->company, 'email' => $request->email), function ($message) {
                    $message->to('info@agtender.com')->subject('Обратный звонок');
                });
            } else {
                Mail::send('emails.callme', array('form_subject' => $request->form_subject, 'recipient' => $request->recipient, 'phone' => $request->phone), function ($message, $email_to, $sub) {
                    $message->to('info@agtender.com')->subject('Обратный звонок');
                });
            }
        }
        return 'success';
    }


    // Mobile Api Список тендеров (для неавторизованных)
    public function apiMobileGetAuctions(Request $request)
    {
        $user = User::find($request->user_id);

        $now = date('Y-m-d H:i:s');
        $auctions = DB::table('auctions')
            ->where('type', $request->type);

        // Фильтр по статусам
        if (!empty($request->status)) {
            $auctions->whereIn('status', $request->status);
        }

        if (!empty($request->verb)) {
            $verb = explode(" ", $request->verb);
            foreach ($verb as $search) {
                $auctions->where(function ($query) use ($search) {
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
            $user = DB::table('users')->where('id', $auction->user_id)->first();
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
                    'user' => $user
                );
            } else {
                $item = array(
                    'auction' => $auction,
                    'user' => $user
                );
            }
            array_push($res, $item);
        }

        return response(['status' => 1, 'auctions' => $res], 200);
    }


    public function getPageTender($auction_id)
    {
        $auction = Auction::find($auction_id);
        if (!empty($auction)) {
            $auction_title = $auction->title;
            $auction_full_title = "Тендер №" . $auction->id . " " . $auction_title . " " . $auction->active_material;

            $auction->created_formated = date('d.m.Y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.Y', strtotime($auction->over_date));
            $auction->over_date = date('Y-m-d', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.Y', strtotime($auction->delivery_date));


            $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();


            return view('page.tender', ['auction' => $auction, 'auction_id' => $auction_id, 'auction_title' => $auction_title, 'auction_full_title' => $auction_full_title, 'rate' => $rate]);
        }
    }


    public function getPageAuction($auction_id)
    {
        $auction = Auction::find($auction_id);
        if (!empty($auction)) {
            $auction_title = $auction->title;
            $auction_full_title = "Аукцион №" . $auction->id . " " . $auction_title . " " . $auction->active_material;

            $auction->created_formated = date('d.m.Y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.Y', strtotime($auction->over_date));
            $auction->over_date = date('Y-m-d', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.Y', strtotime($auction->delivery_date));
            return view('page.auction', ['auction' => $auction, 'auction_id' => $auction_id, 'auction_title' => $auction_title, 'auction_full_title' => $auction_full_title]);
        }
    }

    public function getPageSale($auction_id)
    {
        $auction = Auction::find($auction_id);
        if (!empty($auction)) {
            $auction_title = $auction->title;
            $auction_full_title = "Распродажа №" . $auction->id . " " . $auction_title . " " . $auction->active_material;

            $auction->created_formated = date('d.m.Y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.Y', strtotime($auction->over_date));
            $auction->over_date = date('Y-m-d', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.Y', strtotime($auction->delivery_date));
            return view('page.sale', ['auction' => $auction, 'auction_id' => $auction_id, 'auction_title' => $auction_title, 'auction_full_title' => $auction_full_title]);
        }
    }


    public function set_analogs()
    {

        $contents = Storage::get('public/analogs/analogs121222.csv');
        //echo $contents;
        //data = str_getcsv($contents, ":");

        $array_contents = explode("\n", $contents);
        //$cut_array_contents = array_slice($array_contents, 1000, 1000); 

        foreach ($array_contents as $line) {
            $row = str_getcsv($line, "|");

            echo "<h2>" . $row[0] . " " . "</h2>";
            $analog_name = trim($row[0]);
            if (!empty($row[1]) && $row[1] !== "--") {
                $analog = explode(";", $row[1]);
            } else {
                $analog = [];
            }
            //echo "<p>analog</p>"; var_dump($analog);

            $str = NULL;
            if (!empty($analog)) {
                $new_analog_arr = [];
                foreach ($analog as $analog_value) {
                    if (($analog_value !== "") && ($analog_value !== " ")) {
                        array_push($new_analog_arr, trim($analog_value));
                    }
                }
                $str = implode(";", $new_analog_arr);
                $new_analog_arr = [];
                if (empty($str)) {
                    $str = NULL;
                }
            }

            $drug = Drugs::where("title", '=', $analog_name)->first();
            //var_dump($drug);

            echo '<hr>';
            if (($drug !== NULL)) {
                $drug->analogs = $str;
                $drug->save();
                echo 'средство обновлено ' . $analog_name . '<br>';
                echo 'id' . $drug->id . '<br>';
                echo ' ' . $str . '<br>';
            } else {
                echo 'средство не найдено ' . $analog_name . '<br>';
            }

            $analog_name = NULL;
            $str = NULL;

        }

    }


    /**
     * Create a web friendly URL slug from a string.
     *
     * Although supported, transliteration is discouraged because
     *     1) most web browsers support UTF-8 characters in URLs
     *     2) transliteration causes a loss of information
     *
     * @param string $str
     * @param array $options
     * @return string
     * @author Sean Murphy <sean@iamseanmurphy.com>
     * @copyright Copyright 2012 Sean Murphy. All rights reserved.
     * @license http://creativecommons.org/publicdomain/zero/1.0/
     *
     */
    public function url_slug($str, $options = array())
    {
        // Make sure string is in UTF-8 and strip invalid UTF-8 characters
        $str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());

        $defaults = array(
            'delimiter' => '-',
            'limit' => null,
            'lowercase' => true,
            'replacements' => array(),
            'transliterate' => false,
        );

        // Merge options
        $options = array_merge($defaults, $options);

        $char_map = array(
            // Latin
            'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
            'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
            'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
            'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
            'ß' => 'ss',
            'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
            'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
            'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
            'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
            'ÿ' => 'y',
            // Latin symbols
            '©' => '(c)',
            // Greek
            'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
            'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
            'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
            'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
            'Ϋ' => 'Y',
            'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
            'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
            'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
            'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
            'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
            // Turkish
            'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
            'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
            // Russian
            'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
            'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
            'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
            'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
            'Я' => 'Ya',
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
            'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
            'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
            'я' => 'ya',
            // Ukrainian
            'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
            'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
            // Czech
            'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
            'Ž' => 'Z',
            'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
            'ž' => 'z',
            // Polish
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
            'Ż' => 'Z',
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
            'ż' => 'z',
            // Latvian
            'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
            'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
            'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
            'š' => 's', 'ū' => 'u', 'ž' => 'z'
        );

        // Make custom replacements
        $str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);

        // Transliterate characters to ASCII
        if ($options['transliterate']) {
            $str = str_replace(array_keys($char_map), $char_map, $str);
        }

        // Replace non-alphanumeric characters with our delimiter
        $str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);

        // Remove duplicate delimiters
        $str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);

        // Truncate slug to max. characters
        $str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');

        // Remove delimiter from ends
        $str = trim($str, $options['delimiter']);

        return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
    }


}
