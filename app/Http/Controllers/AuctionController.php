<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\BlockSuplier;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

use App\Auction;
use App\MyAuctionHistory;
use App\AuctionRate;
use App\SaleRate;
use App\AuctionCounter;
use App\AuctionUser;


use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TendersExport;

use DB;
use PDF;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;


use App\Notification;
use Carbon\Carbon;

class AuctionController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //############## НОВЫЙ АУКЦИОН ##############
    public function getAddCard(Request $request)
    {
        return view('admin.auction.card_add');
    }

    //############## АКТИВНЫЕ АУКЦИОНЫ ##############
    public function getListNow(Request $request)
    {
        return view('admin.auction.list');
    }

    //############## АРХИВ АУКЦИОНОВ ##############
    public function getList(Request $request)
    {
        return view('admin.auction.archive');
    }

    //############## МОИ АУКЦИОНЫ ##############
    public function getMyList(Request $request)
    {
        return view('admin.auction.mylist');
    }

    //############## АУКЦИОН ##############
    public function getCard(Request $request)
    {
        return view('admin.auction.card');
    }

    //############## НОВЫЙ ТЕНДЕР ##############
    public function getTenderAddCard(Request $request)
    {
        return view('admin.tender.card_add');
    }


    //############## НОВЫЙ ТЕНДЕР ДВ ##############
    public function getTenderDvAddCard(Request $request)
    {
        return view('admin.tenderdv.card_add');
    }

    //############## АКТИВНЫЕ ТЕНДЕРЫ ##############
    public function getTenderListNow(Request $request)
    {
        return view('admin.tender.list');
    }

    //############## АКТИВНЫЕ ТЕНДЕРЫ ДВ ##############
    public function getTenderDvListNow(Request $request)
    {
        return view('admin.tenderdv.list');
    }

    //############## АРХИВ ТЕНДЕРОВ ##############
    public function getTenderList(Request $request)
    {
        return view('admin.tender.archive');
    }

    //############## АРХИВ ТЕНДЕРОВ ДВ ##############
    public function getTenderDvList(Request $request)
    {
        return view('admin.tenderdv.archive');
    }    

    //############## АРХИВ ТЕНДЕРОВ ##############
    public function getTenderMyList(Request $request)
    {
        return view('admin.tender.mylist');
    }

    //############## АРХИВ ТЕНДЕРОВ ДВ ##############
    public function getTenderDvMyList(Request $request)
    {
        return view('admin.tenderdv.mylist');
    }

    //############## Удаленные ТЕНДЕРы ##############
    public function getDeletedTenderMyList(Request $request)
    {
        return view('admin.tender.deletedList');
    }

    //############## ТЕНДЕР ##############
    public function getTenderCard(Request $request)
    {
        return view('admin.tender.card');
    }

    //############## ТЕНДЕР ДВ ##############
    public function getTenderDvCard(Request $request)
    {
        return view('admin.tenderdv.card');
    }

    //############## НОВАЯ РАСПРОДАЖА ##############
    public function getSaleAddCard(Request $request)
    {
        return view('admin.sale.card_add');
    }

    //############## АКТИВНЫЕ РАСПРОДАЖИ ##############
    public function getSaleListNow(Request $request)
    {
        return view('admin.sale.list');
    }

    //############## АРХИВ РАСПРОДАЖИ ##############
    public function getSaleList(Request $request)
    {
        return view('admin.sale.archive');
    }

    //############## АРХИВ РАСПРОДАЖИ ##############
    public function getSaleMyList(Request $request)
    {
        return view('admin.sale.mylist');
    }

    //############## РАСПРОДАЖА ##############
    public function getSaleCard(Request $request)
    {
        return view('admin.sale.card');
    }

    //############## ИСТОРИЯ СТАВОК ##############
    public function getTenderHistory(Request $request)
    {
        return view('admin.tender.history');
    }
















    //############## Тендеры покупателя ##############
    public function getTenderUserList(Request $request)
    {
        $author_user_id = $request->id;
        return view('admin.tender.userlist', [
            'author_user_id' => $author_user_id,
        ]);
    }


    static function enableNotification() {         
        return true;
    }

    // ссылка на карточку
    static function getLinkCard($auction_type, $auction_id) {       
        $link_card = "";
        if ($auction_type === 'rise') {
           $link_card = 'https://agtender.com/admin/auction/now/card/' . $auction_id;
        }
        if ($auction_type === 'drop') {
           $link_card = 'https://agtender.com/admin/tender/now/card/' . $auction_id;
        }
        if ($auction_type === 'dropdv') {
           $link_card = 'https://agtender.com/admin/tenderdv/now/card/' . $auction_id;
        }
        if ($auction_type === 'sale') {
           $link_card = 'https://agtender.com/admin/sale/now/card/' . $auction_id;
        }
        return $link_card;
    }


    public function firebase_push_send($user, $auction_type, $firebase_text) {
        $firebase_title = "НАТС Тендеры";
        $firebase_token = $user->firebase_token;
        if (isset($user->firebase_token) && !empty($firebase_token) && ($auction_type === "drop")) {          
        $firebase_key = "AAAA8YW6Ths:APA91bHMAQYsCeehzLtkfrPznUKL1Cqdt38zTtUutwesuJXQTTmxvh7V6n1H156kTBkAbT3K8h-frGVNEA0WrKcJKioh8BMHrrVV9ODkXS110r7iN0GwY6MNrq6PT1lWi-pXR6Y7MfNA";
        $firebase_url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
            'to' => $firebase_token,
            'notification' => array (
                "title" =>  $firebase_title,
                "body" => $firebase_text,
                "badge" => 1,
            ),
        );
        $fields = json_encode($fields);
        $headers = array (
            'Authorization: key=' . $firebase_key,
            'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $firebase_url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        //echo $result;
        curl_close ( $ch );
        }
    }

    public function getBlocked(Request $request)
    {
        $user = Auth::user();
        $block_subliers = BlockSuplier::where('suplier_id', $user->id)->get();
        $block_arr = [];
        foreach ($block_subliers as $sublier) {
            array_push($block_arr, $sublier->auction_id);
        }
        return response(['status' => 1, 'block_arr' => $block_arr], 200);
    }

    public function addMyAuction(Request $request, $id)
    {
        $delete_auction = new  MyAuctionHistory();
        $delete_auction->user_id = Auth::user()->id;
        $delete_auction->auction_id = $id;
        $delete_auction->save();
        return response(['status' => 1], 200);
    }

    public function deleteMyAuction(Request $request, $id)
    {
        $delete_auction = MyAuctionHistory::where('auction_id', $id)
            ->where('user_id',Auth::user()->id)->first();
        $delete_auction->delete();
        return response(['status' => 1], 200);
    }

    public function MyAuctionHistoryList(Request $request)
    {
        $delete_auction = MyAuctionHistory::where('user_id', Auth::user()->id)->pluck('auction_id')->toArray();
        return response(['status' => 1, 'my_auction_history' => $delete_auction, ''], 200);
    }


    public function get(Request $request)
    {
        $user = User::find($request->user_id);
        $current_user_id = $user->id;

        //один акцион
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
                } elseif ($auction->type == 'drop' || $auction->type == 'dropdv') {
                    $rate = AuctionRate::with('user')->whereIn('status', [1, 2])->where('auction_id', $auction->id)->whereNotIn('id', $block_arr)->orderBy('price')->where('deleted', '')->first();
                }
                // распродажи
                elseif ($auction->type == 'sale') {
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


            // 21.07.22 распродажи
            if ($auction->type === 'sale') {
                $start_price = 0;
                $date_now = date('Y-m-d H:i:s');
                $sale_rate_item = SaleRate::where('auction_id', $auction->id)->where('date_price', '<=',  $date_now)->orderBy('id','desc')->first();       
                if (!empty($sale_rate_item)) {
                    $start_price =  $sale_rate_item->price;                    
                } else {
                    $start_price = $auction->start_price;
                }
                $auction->start_price = $start_price;
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

            //140223
            $auction->doc_files = json_decode($auction->doc_files);

            $over_date = strtotime($auction->over_date);
            $deliv_date = strtotime($auction->delivery_date);
            $deliv_interval = $deliv_date - $over_date;
            $auction->deliv_interval = floor($deliv_interval / (60 * 60 * 24));

            return response(['status' => 1, 'auction' => $auction], 200);
        } else { //несколько аукционов
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

                // мои тендеры
                if ($request->own == true && $request->type==='drop') {
                    if ($user->role_id == 101) {
                        $auctions->where('user_id', $user->id);
                    } elseif ($user->role_id == 102) {
                        //поставщики

                        $auctions_id = array();

                        //кнопка добавить в мои тендеры 191222
                        $auction_users = AuctionUser::where('user_id', $user->id)->get();
                        $auctions_users_id = array();
                        foreach ($auction_users as $auction_user) {
                            array_push($auctions_id, $auction_user->auction_id);
                        }

                        //было
                        $supplier_rates = AuctionRate::where('user_id', $user->id)->get();
                        //$auctions_id = array();
                        foreach ($supplier_rates as $supplier_rate) {
                            array_push($auctions_id, $supplier_rate->auction_id);
                        }
                        $uniq_auctions_id = array_unique($auctions_id);
                        $auctions->whereIn('id', $uniq_auctions_id);
                    }
                }

                // мои аукционы поставщиков 
                if ($request->own == true && $request->type==='rise') {
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
                        $auctions->orWhere('user_id', $user->id);
                    }
                }


                // мои распродажи 
                if ($request->own == true && $request->type==='sale') {
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
                        $auctions->orWhere('user_id', $user->id);
                    }
                }

            }

            // Фильтр по статусам
            if (!empty($request->status)) {
                $auctions->whereIn('status', $request->status);
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



            //241022
            if ($current_user_id === 2285) {
                $auctions->where('size', '>=', 100);
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
//				$auctions->leftjoin(AuctionRate);
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
//					return response([ 'status' => 1, 'link' => '/storage/excel/'.basename($file)], 200);
                        Storage::delete('public/excel/' . basename($file));
                    }
                }

                Excel::store(new TendersExport($auctions), 'public/excel/НАТС_Тендеры-' . date('YmdHis', $time) . '.xls');
                return response(['status' => 1, 'link' => '/storage/excel/НАТС_Тендеры-' . date('YmdHis', $time) . '.xls'], 200);
            }


            $auctions = $auctions->get();


            foreach ($auctions as $auction_key => $auction) {
                
                $now = time();
                $date = strtotime($auction->over_date);
                $datediff = $date - $now;

                $auction->datediff = floor($datediff / (60 * 60 * 24));

                $delivdate = strtotime($auction->delivery_date);
                $deliv_interval = $delivdate - $date;

                $auction->deliv_interval = floor($deliv_interval / (60 * 60 * 24));

                if ($auction->type === 'rise') {
                    $rate = $auction->price();
                } 
                elseif  ($auction->type === 'sale') { // распродажи
                    $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
                }
                else {
                   $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first(); // 050522
                }  
                
                $user_rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('user_id', $user->id)->where('deleted', '')->orderBy('price')->first();



                //21.07.22 распродажи
                if ($auction->type === 'sale') {
                    $date_now = date('Y-m-d H:i:s');
                    $sale_rate = SaleRate::where('auction_id', $auction->id)->where('date_price', '<=',  $date_now)->orderBy('id','desc')->first();                     
                    if (!empty($sale_rate)) {
                        $auction->sale_rate = $sale_rate;
                    }           
                }                


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


    public function edit(Request $request)
    {
        if ($request->auction_user_id) $user = User::find($request->auction_user_id);
        else $user = User::find($request->user_id); // remove after card.vue updated

        $new = false;

        if (!empty($request->id)) {
            $auction = Auction::find($request->id);
            if ($auction->type == 'rise') {
                $text = 'Информация об аукционе успешно изменена';
            }
            if ($auction->type == 'drop') {
                $text = 'Информация о тендере успешно изменена';
            }
            if ($auction->type == 'sale') {
                $text = 'Информация о распродаже успешно изменена';
            }
            if ($auction->type == 'dropdv') {
                $text = 'Информация о тендере успешно изменена';
            }     
        } else {
            $new = true;
            $auction = new Auction;
            $auction->subdivision_id = $user->subdivision_id;
            $auction->user_id = $user->id;
            $auction->type = $request->type;
            if ($request->type == 'rise') {
                $text = 'Новый аукцион успешно создан';
            }
            if ($request->type == 'drop') {
                $text = 'Новый тендер успешно создан';
            }
            if ($request->type == 'sale') {
                $text = 'Новая распродажа успешно создана';
            }
            if ($request->type == 'dropdv') {
                $text = 'Новый тендер успешно создан';
            }
        }
        $auction->title = $request->title;
        $auction->active_material = $request->active_material;
        if ($request->title) {
            $drug = DB::table('auction_drug_list')
                ->where('title', $request->title)
                ->first();
            if (!empty($drug)) $auction->active_material = $drug->active_material;
        }

        // новое поле стартовая цена
        if (isset($request->start_price)) {
            $auction->start_price = $request->start_price;
        }

        //180722 analog
        $is_analog = 0;
        if (isset($request->is_analog)) {
            $request_is_analog = $request->is_analog;
            if ($request_is_analog == 1) {
                $is_analog = 1;
            } 
            if ($request_is_analog == 0) {
                $is_analog = 0;
            }
            //mobile error
            if ($request_is_analog == 2) {
                $is_analog = 0;
            } 
        }

        $auction->is_analog = $is_analog;
        $auction->size = $request->size;
        $auction->unit = $request->unit;

        //180722 exclude analog
        //$exclude_analogs = $request->exclude_analogs;
        //mobile error
        /*if ($exclude_analogs == "1" || $exclude_analogs == "2") {
             $exclude_analogs= NULL;
        }*/

        $auction->exclude_analogs = (!empty($request->exclude_analogs)) ? json_encode($request->exclude_analogs, true) : NULL;




        $auction->over_date = $request->over_date . ' 17:04:59'; // 16:59:59
        $auction->delivery_date = $request->delivery_date??date('Y-m-d');
        $auction->delivery_condition = $request->delivery_condition;
        $auction->delivery_region = $request->delivery_region;
        $auction->payment_condition = $request->payment_condition;
        $auction->special_terms = $request->special_terms;
        if ($request->customer_warehouse_address) { $auction->customer_warehouse_address = $request->customer_warehouse_address; }
        if (!$new) {
            $auction->customer_ogrn = $request->customer_ogrn;
            $auction->customer_bank_account = $request->customer_bank_account;
            $auction->customer_correspondent_account = $request->customer_correspondent_account;
            $auction->customer_bank_bik = $request->customer_bank_bik;
            $auction->customer_warehouse_address = $request->customer_warehouse_address;

            $auction->supplier_ogrn = $request->supplier_ogrn;
            $auction->supplier_bank_account = $request->supplier_bank_account;
            $auction->supplier_correspondent_account = $request->supplier_correspondent_account;
            $auction->supplier_bank_bik = $request->supplier_bank_bik;
            $auction->supplier_warehouse_address = $request->supplier_warehouse_address;

            $this->updateRequisits($auction);
        }



        $auction->save();


        //21/07/22 sale steps
        if ($new && $request->type == 'sale') {
        if (isset($request->start_price_step) && isset($request->start_price_percent) && isset($auction->id) && isset($request->start_price) & isset($request->over_date)) {  
            $sale_steps = (int) $request->start_price_step;
            $sale_percent = (int) $request->start_price_percent;

            $date_over_price = $request->over_date . ' 16:59:59';
            $date_over_price = date('Y-m-d H:i:s', strtotime($date_over_price));
            $date_now = date('Y-m-d H:i:s');

            $date_price_time = strtotime($date_over_price);
            $date_now_time = strtotime($date_now);
            $step_time = ($date_price_time - $date_now_time) / $sale_steps;
            $step_time = intval($step_time);
            $current_time = $date_now_time;

            $start_price = (int) $request->start_price;
            $current_price = $start_price;
            $step_price = ($sale_percent * $start_price) / 100;
            $step_price = intval($step_price);

            for ($i = 0; $i < $sale_steps; $i++) {
                $sale_rate = new SaleRate;
                $sale_rate->auction_id = $auction->id;
                $sale_rate->user_id = $user->id;
                $sale_rate->price = $current_price;
               /* $sale_rate->is_analog = 0;
                $sale_rate->analog_name = '';
                $sale_rate->status = 1;*/
                $sale_rate->date_price = date('Y-m-d H:i:s', $current_time);
                $sale_rate->save();
                $current_time = $current_time + $step_time;
                $current_price = $current_price - $step_price;
            }
        } 
        } 





        return response(['status' => 1, 'auction' => $auction, 'text' => $text], 200);
    }

    private function updateRequisits($auction)
    {
        if ($auction->status < 2) return;

        $customer = User::find($auction->user_id);
        if (!$customer->company_ogrn && $auction->customer_ogrn) $customer->company_ogrn = $auction->customer_ogrn;
        if (!$customer->company_bank_account && $auction->customer_bank_account) $customer->company_bank_account = $auction->customer_bank_account;
        if (!$customer->company_correspondent_account && $auction->customer_correspondent_account) $customer->company_correspondent_account = $auction->customer_correspondent_account;
        if (!$customer->company_bank_bik && $auction->customer_bank_bik) $customer->company_bank_bik = $auction->customer_bank_bik;
        //if (!$customer->company_warehouse_address && $auction->customer_warehouse_address) $customer->company_warehouse_addressn = $auction->customer_warehouse_address;
        if (!$customer->company_warehouse_address && $auction->customer_warehouse_address) $customer->company_warehouse_address = $auction->customer_warehouse_address;
        $customer->save();

        $win_rate = AuctionRate::find($auction->win_rate_id);

        $supplier = User::find($win_rate->user_id);
        if (!$supplier->company_ogrn && $auction->supplier_ogrn) $supplier->company_ogrn = $auction->supplier_ogrn;
        if (!$supplier->company_bank_account && $auction->supplier_bank_account) $supplier->company_bank_account = $auction->supplier_bank_account;
        if (!$supplier->company_correspondent_account && $auction->supplier_correspondent_account) $supplier->company_correspondent_account = $auction->supplier_correspondent_account;
        if (!$supplier->company_bank_bik && $auction->supplier_bank_bik) $supplier->company_bank_bik = $auction->supplier_bank_bik;
        //if (!$supplier->company_warehouse_address && $auction->supplier_warehouse_address) $supplier->company_warehouse_addressn = $auction->supplier_warehouse_address;
        if (!$supplier->company_warehouse_address && $auction->supplier_warehouse_address) $supplier->company_warehouse_address = $auction->supplier_warehouse_address;
        $supplier->save();

    }

    public function cancel(Request $request)
    {
        $auction = Auction::find($request->id);
        $auction->status = 0;
        $auction->cancel_reason = $request->cancel_reason;
        $auction->save();
        $text = 'Аукцион был успешно отменен';

        $rate = AuctionRate::where('auction_id', $auction->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->where('deleted', '')
            ->first();       


        if (!empty($rate)) {
            $supplier = User::find($rate->user_id);                 
            $customer = User::find($auction->user_id);    
            // ссылка на карточку 
            $link_card = self::getLinkCard($auction->type, $auction->id);

            if ( self::enableNotification() ) {
            // ОТПРАВКА НА ПОЧТУ КЛИЕНТУ
            $mail = new \App\Mail\CancelAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
            $mail->to($customer->email);
            Mail::send($mail);
            self::firebase_push_send($customer, $auction->type, "Тендер отменен №".$auction->id);
                    
            // ОТПРАВКА НА ПОЧТУ ПРОДАВЦУ
            $mail = new \App\Mail\CancelAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
            $mail->to($supplier->email);
            Mail::send($mail);
            self::firebase_push_send($supplier, $auction->type, "Тендер отменен №".$auction->id);
            }
        }    

        return response(['status' => 1, 'text' => $text], 200);
    }

    //140722
    public function close(Request $request)
    {
        $auction = Auction::find($request->id);
        $auction->over_date = date('Y-m-d H:i:s');
        $auction->save();
        $text = 'Аукцион досрочно завершен';
        return response(['status' => 1, 'text' => $text], 200);
    }

    //281222 восстановление тендера
    public function restore(Request $request)
    {
        $auction = Auction::find($request->id);
        $current_date = date('Y-m-d', time());
        $current_date = $current_date . ' 17:04:59';
        $new_over_date = date('Y-m-d H:i:s', strtotime('+1 day', strtotime($current_date)));
        $auction->over_date = $new_over_date;
        $auction->win_rate_id = NULL;
        $auction->status = 1;
        $auction->complete_reason = NULL;
        $auction->save();
        $text = 'Аукцион восстановлен';
        return response(['status' => 1, 'text' => $text], 200);
    }

    //160223 завершение тендера покупателем
    public function complete(Request $request)
    {
        $auction = Auction::find($request->id);
       
        $complete_reason = $request->complete_reason;

        if (!empty($complete_reason) && !empty($auction)) {

            $rate = AuctionRate::where('auction_id', $auction->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->where('deleted', '')
            ->first();

            if (!empty($rate)) {
                $auction->win_rate_id = $rate->id;
                $auction->status = 2;
               
                $auction->complete_reason = $complete_reason;
                $auction->save();

                $customer = User::find($auction->user_id);
                $supplier = User::find($rate->user_id);        

                // ссылка на карточку 
                $link_card = self::getLinkCard($auction->type, $auction->id);
                        
                if ( self::enableNotification() ) {        
                // ОТПРАВКА НА ПОЧТУ ПРОДАВЦУ
                $mail = new \App\Mail\CloseAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
                $mail->to($supplier->email);
                Mail::send($mail);
                self::firebase_push_send($supplier, $auction->type, "Тендер завершен с вашей ставкой №".$auction->id);
                }
          
                $text = 'Тендер завершен';
                return response(['status' => 1, 'text' => $text], 200);
            }
        }
        $text = 'Ошибка';
        return response(['status' => 1, 'text' => $text], 200);
        
    }


    public function add_photo(Request $request)
    {
        $auction = Auction::find($request->id);
        $image = chunk_split($request->file);
        preg_match("/data:image\/(.*?);/", $image, $image_extension); // extract the image extension
        $image = preg_replace('/data:image\/(.*?);base64,/', '', $image); // remove the type part
        $image = str_replace(' ', '+', $image);
        $imageName = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
        Storage::disk('local')->put('public/avatars/auctions/' . $imageName, base64_decode($image));
        $auction->photo = $imageName;
        $auction->save();
        return response(['status' => 1, 'auction' => $auction], 200);
    }

    public function edit_photo(Request $request)
    {
        $auction = Auction::find($request->id);
        $path = storage_path('app/public/avatars/auctions/');

        if ($auction->photo != null) {
            Storage::disk('local')->delete('public/avatars/auctions/' . $auction->photo);
        }

        $rand = rand(100, 999);
        $fileName = $auction->id . '-' . $rand . '.' . $request->file->getClientOriginalExtension();
        $img = ImageInt::make($request->file);
        $height = $img->height();
        $width = $img->width();
        if ($width > $height) {
            $img->crop($height, $height);
        } else {
            $img->crop($width, $width);
        }
        $img->resize(600, 600)->save($path . $fileName);
        $auction->photo = $fileName;
        $auction->save();
        $text = 'Фотография аукциона успешно обновлена';
        return response(['status' => 1, 'text' => $text], 200);
    }

    public function get_rates(Request $request)
    {
        $user = User::find($request->user_id);

        $rates = AuctionRate::with('auction')->where('deleted', '');

        $delete_auction = MyAuctionHistory::where('user_id', Auth::user()->id)->pluck('auction_id')->toArray();
        if (count($delete_auction) >= 1) {
            $rates->whereNotIn('auction_id', $delete_auction);
        }

        if ($user->role_id != 1000) {
            $rates->where('user_id', $user->id);
        }
        if (!empty($request->limit)) {
            $rates->take($request->limit);
        }
        if (!empty($request->orderBy)) {
            $rates->orderBy($request->orderBy, $request->orderType);
        }
        $rates = $rates->get();


        foreach ($rates as $rate) {
            $price_array = $rate->auction->price();
            $rate->auction->price = $price_array['price'];
            $rate->created_formated = date('d.m.Y H:i', strtotime($rate->created_at));
        }

        return response(['status' => 1, 'rates' => $rates], 200);
    }

    public function add_rate(Request $request)
    {
        $auction = Auction::find($request->auction_id);
        $auction_user = User::find($auction->user_id);
        $rate_user = User::find($request->user_id);
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
        $rate->user_id = $request->user_id;
        $rate->price = $request->value;
        $rate->is_analog = 0;
        $rate->analog_name = '';

        //060423
        if (!empty($request->title_name)) {
            $rate->title_name = trim($request->title_name);
            $auction->title = trim($request->title_name);
        }

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
               
            }
        }

        $auction->save();

        // ссылка на карточку 
        $link_card = self::getLinkCard($auction->type, $auction->id);     


        if ( self::enableNotification() ) {
        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        if($auction_user->notification_off === NULL) {
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($auction_user->email);
        Mail::send($mail);
        self::firebase_push_send($auction_user, $auction->type, "Новая ставка в тендере ".$auction->id);
        }

        if($rate_user->notification_off === NULL) {
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($rate_user->email);
        Mail::send($mail);
        self::firebase_push_send($rate_user, $auction->type, "Новая ставка в тендере ".$auction->id);
        }

        if (!empty($last_rate)) {            
            $last_rate_user = User::find($last_rate->user_id);
            if($last_rate_user->notification_off === NULL) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $mail->to($last_rate_user->email);
            Mail::send($mail);
            self::firebase_push_send($last_rate_user, $auction->type, "Новая ставка в тендере ".$auction->id);
            }
        }
        }




        $text = 'Ваша ставка успешно добавлена';
        return response(['status' => 1, 'text' => $text], 200);
    }

    public function add_rate_analog(Request $request)
    {
        $auction = Auction::find($request->auction_id);
        $auction_user = User::find($auction->user_id);
        $rate_user = User::find($request->user_id);
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
        $rate->user_id = $request->user_id;
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

        if ( self::enableNotification() ) {
        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        if($auction_user->notification_off === NULL) {
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($auction_user->email);
        Mail::send($mail);
        self::firebase_push_send($auction_user, $auction->type, "Новая ставка в тендере ".$auction->id);
        }

        if($rate_user->notification_off === NULL) {
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($rate_user->email);
        Mail::send($mail);
        self::firebase_push_send($rate_user, $auction->type, "Новая ставка в тендере ".$auction->id);
        }

        if (!empty($last_rate)) {            
            $last_rate_user = User::find($last_rate->user_id);
            if($last_rate_user->notification_off === NULL) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $mail->to($last_rate_user->email);
            Mail::send($mail);
            self::firebase_push_send($last_rate_user, $auction->type,  "Новая ставка в тендере ".$auction->id);
            }
        }
        }

        $text = 'Ваша ставка успешно добавлена';
    return response(['status' => 1, 'text' => $text], 200);
    }












    public function cancel_rate(Request $request)
    {
        $auction = Auction::find($request->id);

        $rate = AuctionRate::where('auction_id', $auction->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->where('deleted', '')
            ->first();

        $rate->status = 0;
        $rate->save();

        $text = 'Предложение было успешно отклонено';
        return response(['status' => 1, 'text' => $text], 200);
    }



    public function confirm_rate(Request $request)
    {
        $auction = Auction::find($request->id);

        $rate = AuctionRate::where('auction_id', $auction->id)
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->where('deleted', '')
            ->first();

        if (!empty($rate)) {
            $rate->status = 2;
            $rate->save();

        self::update_auction_counter($rate,$auction);
       

        $auction->win_rate_id = $rate->id;
        $auction->status = 2;
        $auction->save();

        $lose_rates = AuctionRate::where('auction_id', $auction->id)
            ->where('status', 1)
            ->where('deleted', '')
            ->get();

        $customer = User::find($auction->user_id);
        $supplier = User::find($rate->user_id);

        // ссылка на карточку 
        $link_card = self::getLinkCard($auction->type, $auction->id);

        if ( self::enableNotification() ) {
        // ОТПРАВКА НА ПОЧТУ КЛИЕНТУ
        $mail = new \App\Mail\CloseAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
        $mail->to($customer->email);
        Mail::send($mail);
        self::firebase_push_send($customer, $auction->type, "Предложение было успешно подтверждено в тендере ".$auction->id);

        // ОТПРАВКА НА ПОЧТУ ПРОДАВЦУ
        $mail = new \App\Mail\CloseAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
        $mail->to($supplier->email);
        Mail::send($mail);
        self::firebase_push_send($supplier, $auction->type, "Предложение было успешно подтверждено в тендере ".$auction->id);

        foreach ($lose_rates as $lose_rate) {
            $rate_user = User::find($lose_rate->user_id);
            $mail = new \App\Mail\LoseAuction($auction, $lose_rate->price, $rate->price, $link_card);
            $mail->to($rate_user->email);
            Mail::send($mail);
        }
        }

        $text = 'Предложение было успешно подтверждено';
        return response(['status' => 1, 'text' => $text], 200);
         }
    }


    //03/10/22
    public function confirm_sale_rate(Request $request)
    {
        $auction = Auction::find($request->auction_id);

        $start_price = 0;

        if ($auction->type === 'sale') {        
            $date_now = date('Y-m-d H:i:s');
            $sale_rate_item = SaleRate::where('auction_id', $request->auction_id)->where('date_price', '<=',  $date_now)->orderBy('id','desc')->first();       
            if (!empty($sale_rate_item)) {
                $start_price =  $sale_rate_item->price;                    
            } else {
                $start_price = $auction->start_price;
            }       
        }

        $rate = new AuctionRate;
        $rate->auction_id = $request->auction_id;
        $rate->user_id = $request->user_id;
        $rate->price = $start_price;
        $rate->is_analog = 0;
        $rate->analog_name = '';
        $rate->status = 2;               
        $rate->save();

        self::update_auction_counter($rate, $auction);


        $auction->win_rate_id = $rate->id;
        $auction->status = 2;
        $auction->over_date = date('Y-m-d H:i:s');
        $auction->save();

        $lose_rates = AuctionRate::where('auction_id', $auction->id)
            ->where('status', 1)
            ->where('deleted', '')
            ->get();

        $customer = User::find($auction->user_id);
        $supplier = User::find($rate->user_id);

        // ссылка на карточку 
        $link_card = self::getLinkCard($auction->type, $auction->id);

        if ( self::enableNotification() ) {
        // ОТПРАВКА НА ПОЧТУ КЛИЕНТУ
        $mail = new \App\Mail\CloseAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
        $mail->to($customer->email);
        Mail::send($mail);
        self::firebase_push_send($customer, $auction->type, "Тендер ".$auction->id." был успешно завершен");

        // ОТПРАВКА НА ПОЧТУ ПРОДАВЦУ
        $mail = new \App\Mail\CloseAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
        $mail->to($supplier->email);
        Mail::send($mail);
        self::firebase_push_send($supplier, $auction->type, "Тендер ".$auction->id." был успешно завершен");

        foreach ($lose_rates as $lose_rate) {
            $rate_user = User::find($lose_rate->user_id);
            $mail = new \App\Mail\LoseAuction($auction, $lose_rate->price, $rate->price, $link_card);
            $mail->to($rate_user->email);
            Mail::send($mail);
        }
        }

        $text = 'Предложение было успешно подтверждено';
        return response(['status' => 1, 'text' => $text], 200);
    }


    //171122 обновление счетчика на главной странице
    public function update_auction_counter($rate, $auction) 
    {
        if (!empty($rate->price) && (!empty($auction->size))) {
            $id = 1;
            $auction_counter = AuctionCounter::find($id);            
            $rate_summ = intval($rate->price) * intval($auction->size);          
            $auction_counter->counter = $auction_counter->counter + $rate_summ;
            $auction_counter->save();
        }
        
    } 

    public function delete_rate(Request $request)
    {
        $rate = AuctionRate::find($request->id);
        $rate->deleted = 'on';
        $rate->save();

        $text = 'Предложение успешно удалено';
        return response(['status' => 1, 'text' => $text], 200);
    }

    public function get_pdf(Request $request)
    {
        $now = date('l, d F Y');
        $auction = Auction::with('rates', 'win_rate', 'user')->where('id', $request->auction_id)->first();

//		$auction->article = str_pad($auction->id, 6-mb_strlen($auction->id), '0', STR_PAD_LEFT);1
        $auction->article = sprintf("%05s", $auction->id);

        $pdf = PDF::loadView('pdf.auction_contract', ['auction' => $auction]);
        // $pdf->save(storage_path() . '/app/contracts/Договор поставки №'.$auction->id.'.pdf');
        return $pdf->download('Договор поставки №ЭТП-' . $auction->id . '.pdf');
        return response(['status' => 1, 'text' => "Файл договора сформирован и откроется в новой вкладке"], 200);
    }

    public function confirm_contract(Request $request)
    {
        $auction = Auction::find($request->id);
        $rate = AuctionRate::find($auction->win_rate_id);
        if ($request->type == 'customer') {
            $auction->customer_confirm = 1;
        } elseif ($request->type == 'supplier') {
            $auction->supplier_confirm = 1;
        }

        $text = 'Реквизиты ' . ($request->type == 'customer' ? 'покупателя' : 'поставщика') . ' подтверждены';
        $auction->save();

        $customer = User::find($auction->user_id);
        $supplier = User::find($rate->user_id);

        $type = $request->type;

        // ссылка на карточку 
        $link_card = self::getLinkCard($auction->type, $auction->id);

        if ($auction->supplier_confirm == 1 && $auction->customer_confirm == 1) {
            if ( self::enableNotification() ) {
            // ОТПРАВКА НА ПОЧТУ АДМИНИСТРАТОРАМ
            $mail = new \App\Mail\ConfirmAuction($auction, $rate->price . ' ₽/' . $auction->unit, $customer->company_name, $supplier->company_name, $link_card, $request->type);
            $mail->to('info@agtender.com');
            Mail::send($mail);            
            $type = 'all';
            }
        }

        if ($auction->supplier_confirm == 1) {
            if ( self::enableNotification() ) {
            // ОТПРАВКА НА ПОЧТУ КЛИЕНТУ
            $mail = new \App\Mail\ConfirmAuction($auction, $rate->price . ' ₽/' . $auction->unit, $customer->company_name, $supplier->company_name, $link_card, $type);
            $mail->to($customer->email);
            Mail::send($mail);
            self::firebase_push_send($customer, $auction->type, $text." в тендере ".$auction->id);
            }
        }

        if ($auction->customer_confirm == 1) {
            if ( self::enableNotification() ) {
            // ОТПРАВКА НА ПОЧТУ ПРОДАВЦУ
            $mail = new \App\Mail\ConfirmAuction($auction, $rate->price . ' ₽/' . $auction->unit, $customer->company_name, $supplier->company_name, $link_card, $type);
            $mail->to($supplier->email);
            Mail::send($mail);
            self::firebase_push_send($supplier, $auction->type, $text." в тендере ".$auction->id);
            }
        }

        return response(['status' => 1, 'text' => $text], 200);
    }

    public function add_contract_file(Request $request)
    {
        $auction = Auction::find($request->id);

//		return response([ 'status' => 1, 'text' => print_r($request->filenames[0], true) ], 200);

        if (!empty($auction) && $request->filenames && $request->type) {
            if ($request->type == 'customer') $contract_files = $auction->customer_contract_files ? json_decode($auction->customer_contract_files) : [];
            elseif ($request->type == 'supplier') $contract_files = $auction->supplier_contract_files ? json_decode($auction->supplier_contract_files) : [];

            $filenumber = 1;
            if (!empty($contract_files)) {
                foreach ($contract_files as $saved_file) {
                    if (preg_match('/ ([0-9]+)\.[0-9a-z]+\.[a-z]+$/', $saved_file, $saved_number)) $filenumber = $filenumber > $saved_number[1] ? $filenumber : $saved_number[1] + 1;
                }
            }

            $yearfolder = substr($auction->over_date, 0, 4);
            $counter = 0;
            foreach ($request->filenames as $file) {
//				return response([ 'status' => 1, 'text' => $file ], 200);

                $ext = strtolower($file->getClientOriginalExtension());

                $fileName = 'Договор поставки №ЭТП-' . $auction->id . ' от ' . ($request->type == 'supplier' ? 'поставщика' : 'покупателя') . ' ' . $filenumber . '.' . substr(md5(rand() + time()), 0, 3) . '.' . $ext;
                $filePath = $yearfolder . '/' . $fileName;

                Storage::disk('local')->put('public/contracts/' . $filePath, file_get_contents($file), 'public');

                $path = storage_path('app/public/contracts/' . $filePath);

                if ($ext != 'pdf') {
                    $img = ImageInt::make($path);
                    $height = $img->height();
                    $width = $img->width();

                    if ($width > $height) {
                        $img->resize(null, 200, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        $img->resize(200, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    }
                    $img->save(substr($path, 0, -4) . '.tumb.jpg', 80, 'jpg');
                }

                array_push($contract_files, $filePath);
                $counter++;
                $filenumber++;
            }

            if ($request->type == 'customer') $auction->customer_contract_files = json_encode(array_filter($contract_files));
            elseif ($request->type == 'supplier') $auction->supplier_contract_files = json_encode(array_filter($contract_files));

            $auction->save();

            if ($counter % 100 > 10 && $counter % 100 < 15) {
                $text = 'Успешно загружено ' . $counter . ' файлов';
            } elseif ($counter % 10 > 1 && $counter % 10 < 5) {
                $text = 'Успешно загружено ' . $counter . ' файла';
            } elseif ($counter % 10 == 1) {
                $text = 'Успешно загружен ' . $counter . ' файл';
            } else {
                $text = 'Успешно загружено ' . $counter . ' файлов';
            }

            return response(['status' => 1, 'text' => $text], 200);
        }

        if (!empty($auction) && !empty($request->file) && $request->type && 1 == 2) {
            if ($request->type == 'customer') $contract_files = $auction->customer_contract_files ? json_decode($auction->customer_contract_files) : [];
            elseif ($request->type == 'supplier') $contract_files = $auction->supplier_contract_files ? json_decode($auction->supplier_contract_files) : [];
//            return response([ 'status' => 1, 'text' => print_r($contract_files,true) ], 200);


            $filenumber = 1;
            if (!empty($contract_files)) {
                foreach ($contract_files as $saved_file) {
                    if (preg_match('/ ([0-9]+)\.[0-9a-z]+\.[a-z]+$/', $saved_file, $saved_number)) $filenumber = $filenumber > $saved_number[1] ? $filenumber : $saved_number[1] + 1;
                }
            }

            $yearfolder = substr($auction->over_date, 0, 4);

            $fileName = 'Договор поставки №ЭТП-' . $auction->id . ' от ' . ($request->type == 'supplier' ? 'поставщика' : 'покупателя') . ' ' . $filenumber . '.' . substr(md5(time()), 0, 3) . '.' . $request->file->getClientOriginalExtension();
            $filePath = $yearfolder . '/' . $fileName;


            array_push($contract_files, $filePath);

            if ($request->type == 'customer') $auction->customer_contract_files = json_encode(array_filter($contract_files));
            elseif ($request->type == 'supplier') $auction->supplier_contract_files = json_encode(array_filter($contract_files));

            $auction->save();

            Storage::disk('local')->put('public/contracts/' . $filePath, file_get_contents($request->file), 'public');

            $text = 'Файл ' . $request->file->getClientOriginalName() . ' успешно загружен под именем ' . $fileName;
            return response(['status' => 1, 'text' => $text], 200);
        }
    }

    public function delete_contract_file(Request $request)
    {
        $auction = Auction::find($request->id);

//		return response([ 'status' => 1, 'text' => print_r($request->filenames[0], true) ], 200);

        if (!empty($auction) && $request->deletefile) {
            $found = false;

            $contract_files = $auction->customer_contract_files ? json_decode($auction->customer_contract_files) : [];
            $updated_contract_files = [];
            foreach ($contract_files as $contract_file) {
                if ($contract_file == $request->deletefile) {
                    $found = $contract_file;
                    continue;
                }
                array_push($updated_contract_files, $contract_file);
            }
            $auction->customer_contract_files = json_encode(array_filter($updated_contract_files));

            $contract_files = $auction->supplier_contract_files ? json_decode($auction->supplier_contract_files) : [];
            $updated_contract_files = [];
            foreach ($contract_files as $contract_file) {
                if ($contract_file == $request->deletefile) {
                    $found = $contract_file;
                    continue;
                }
                array_push($updated_contract_files, $contract_file);
            }
            $auction->supplier_contract_files = json_encode(array_filter($updated_contract_files));

            $auction->save();

            if ($found) {
                Storage::disk('local')->delete('public/contracts/' . $found);
                Storage::disk('local')->delete('public/contracts/' . substr($found, 0, -4) . '.tumb.jpg');
                $text = 'Документ «' . substr($found, 5) . '» удален';
            } else $text = 'Не удалось удалить документ';

            return response(['status' => 1, 'text' => $text], 200);
        }
    }

    public function get_title_options()
    {
        $options = array();
        $drugs = DB::table('auction_drug_list')->orderBy('title')->groupBy('title')->get();
        foreach ($drugs as $drug) {
            $analogs = !empty($drug->analogs) ? $drug->analogs : NULL;
            array_push($options, ['id' => trim($drug->id),'title' => trim($drug->title), 'active_material' => trim($drug->active_material),
                'analogs' => $analogs
            ]);
        }
        
        return response($options, 200);
    }
    
    public function get_title_options2(Request $request)
    {
        $options = array();
        $auction = DB::table('auctions')->where(['id' => $request['id']])->get();
        $count = count($auction);
        $auction = $count > 0 ? $auction[0] : null;
        $active_material = $auction != null ? $auction->active_material : null;
        $drugs = DB::table('auction_drug_list')->orderBy('title')->groupBy('title')->get();
        foreach ($drugs as $drug) {
            if($drug->active_material == $active_material)
                array_push($options, ['title' => trim($drug->title), 'active_material' => trim($drug->active_material)]);
        }
        
        return response($options, 200);
    }


    //050423 список препаратов по дв
    public function get_dv_options()
    {
        $options = array();
        $drugs = DB::table('auction_drug_list')->groupBy('title')->get();
        foreach ($drugs as $drug) {
            $analogs = !empty($drug->analogs) ? $drug->analogs : NULL;
            if (!in_array($drug->active_material, $options)) {
                array_push($options,  trim($drug->active_material) );
            }
        }
        return response($options, 200);
    }


    // 281122 список аналогов у одного тендера
    public function get_analog_title_options(Request $request)
    {
        $options = array();
        if (!empty($request->tender_id)) {           
            $auction = Auction::find($request->tender_id);
            if (!empty($auction)) {   
                $auction_title = $auction->title;

                // исключенные аналоги
                $auction_exclude_array = (!empty($auction->exclude_analogs)) ? json_decode($auction->exclude_analogs) : [];
                
                $drug_array = array();
                $all_drugs = DB::table('auction_drug_list')->orderBy('title')->groupBy('title')->get();

                foreach ($all_drugs as $drug) {
                    if ($drug->title === $auction_title) {
                        $drug_array = (!empty($drug->analogs)) ? explode(";",$drug->analogs) : [];
                    }
                }

                 //если аналоги веществ есть
                if (!empty($drug_array)) {
                    $options = [];
                    foreach ($drug_array as $drug_item) {     
                        foreach ($all_drugs as $drug) {
                            if ($drug->title === $drug_item) {
                               if (!in_array($drug_item, $auction_exclude_array, true)) { 
                                    array_push($options, ['id' => trim($drug->id),'title' => trim($drug->title),
                                    'active_material' => trim($drug->active_material)   
                                    ]);        
                                }
                            }
                        }
                    }
                }

                //если аналогов веществ нет вывод всех
                if (empty($drug_array)) {
                    $options = [];
                    foreach ($all_drugs as $drug) {                   
                        array_push($options, ['id' => trim($drug->id),'title' => trim($drug->title), 'active_material' => trim($drug->active_material)                       
                        ]);
                    }
                }    
               
        }
        }
        return response($options, 200);
    }





    public function get_contract_file(Request $request)
    {
        $auction = Auction::find($request->tender_id);
        $auction = json_decode($auction->customer_contract_files);
        return response(['status' => 1, 'data' => $auction], 200);
    }








    public function firebase_test() {

        $firebase_title = "НАТС Тендеры";
        $firebase_text = "НАТС Тендеры тест";
      
        $firebase_token = "d5fZgBIWgEaWgdt_Xn6Jt8:APA91bFkAFCLDTp-GsXmkWxQn0tNppThts2rMe6FCoEhDNk3hS17S7ieEeoYR4B8nCdo4D1LH696suxPIdLYakUlmKrmyCTlAFJooysqvZRk-hzKemqjUm589ROevKjPbEQHDM8xvjY0";

        if (!empty($firebase_token)) {          
        $firebase_key = "AAAA8YW6Ths:APA91bHMAQYsCeehzLtkfrPznUKL1Cqdt38zTtUutwesuJXQTTmxvh7V6n1H156kTBkAbT3K8h-frGVNEA0WrKcJKioh8BMHrrVV9ODkXS110r7iN0GwY6MNrq6PT1lWi-pXR6Y7MfNA";
        $firebase_url = 'https://fcm.googleapis.com/fcm/send';
        $fields = array (
            'to' => $firebase_token,
            'notification' => array (
                "title" =>  $firebase_title,
                "body" => $firebase_text,
                "badge" => 1,
            ),
        );
        $fields = json_encode($fields);
        $headers = array (
            'Authorization: key=' . $firebase_key,
            'Content-Type: application/json'
        );
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $firebase_url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );
        $result = curl_exec ( $ch );
        echo $result;
        curl_close ( $ch );
        }
        
    }









    //история тендеров
    public function get_history(Request $request)
    {
        //$user = Auth::user();

        $type="drop";            

        $auctions = Auction::where('type', $type);
        $auctions->where('status', 2);



        // Фильтр по строке поиска
        if (!empty($request->search)) {
            $searches = explode(" ", $request->search);
            foreach ($searches as $search) {
                $auctions->where(function ($query) use ($search) {
                    /*$query->orWhere('id', 'like', '%' . $search . '%');*/
                    $query->orWhere('title', 'like', '%' . $search . '%');
                    $query->orWhere('active_material', 'like', '%' . $search . '%');
                });
            }
        }


        $auctions = $auctions->get();

        foreach ($auctions as $auction_key => $auction) {
            
            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now;

            $auction->datediff = floor($datediff / (60 * 60 * 24));

            $delivdate = strtotime($auction->delivery_date);
            $deliv_interval = $delivdate - $date;

            $auction->deliv_interval = floor($deliv_interval / (60 * 60 * 24));

            if ($auction->type === 'rise') {
                $rate = $auction->price();
            } 
            elseif  ($auction->type === 'sale') { // распродажи
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }
            else {
               $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first(); // 050522
            }   

            if (!empty($rate)) {
                $auction->rate = $rate;
            }      

            $auction->article = sprintf("%05s", $auction->id);
            $auction->created_formated = date('d.m.Y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.Y', strtotime($auction->over_date));
            $auction->over_date = date('Y-m-d', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.Y', strtotime($auction->delivery_date));

        }

        return response(['status' => 1, 'auctions' => $auctions], 200);


    }





    //добавить в мои тендеры
    public function add_my_tender(Request $request)
    {      
        $auction_id = $request->auction_id;
        $user_id = $request->user_id;
        if (($auction_id > 0) && ($user_id > 0)) {
            $old_auction_user = AuctionUser::where('auction_id', $auction_id)->where('user_id', $user_id)->first();
            if (empty($old_auction_user)) {
                $auction_user = new AuctionUser;
                $auction_user->auction_id = $auction_id;
                $auction_user->user_id = $user_id;
                $auction_user->save();
                return response(['status' => 1], 200);
            }
        }
        return response(['status' => 0], 200);
    }






    //тендеры одного пользователя
    public function get_user_list(Request $request)
    {
        $user = Auth::user();
        
        $author_user_id = $request->author_user_id;

        $type="drop";            

        $auctions = Auction::where('type', $type);
        $auctions->where('user_id', $author_user_id);

        $auctions->where('status', 1);

        // активные аукционы
        $now = date('Y-m-d H:i:s');       
        $auctions->where('over_date', '>=', $now);        



        // Фильтр по строке поиска
        if (!empty($request->search)) {
            $searches = explode(" ", $request->search);
            foreach ($searches as $search) {
                $auctions->where(function ($query) use ($search) {
                    /*$query->orWhere('id', 'like', '%' . $search . '%');*/
                    $query->orWhere('title', 'like', '%' . $search . '%');
                    $query->orWhere('active_material', 'like', '%' . $search . '%');
                });
            }
        }


            if (!empty($request->excel)) {
                if ($user->role_id != 1000) return response(['status' => 0, 'message' => 'Request denied - admin rights required'], 200);

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
      
                $time = time();

                $files = Storage::files('public/excel');
                foreach ($files as $file) {
                    $filedate = explode('.', $file);
                    $filedate = array_shift($filedate);
                    $filedate = explode('-', $filedate);
                    $filedate = array_pop($filedate);
                    if (!preg_match("/^[0-9]{14}$/", $filedate)) continue;
                    if ($filedate < date('YmdHis', $time - 60)) {
                        Storage::delete('public/excel/' . basename($file));
                    }
                }

                Excel::store(new TendersExport($auctions), 'public/excel/НАТС_Тендеры-' . date('YmdHis', $time) . '.xls');
                return response(['status' => 1, 'link' => '/storage/excel/НАТС_Тендеры-' . date('YmdHis', $time) . '.xls'], 200);
            }
        


        $auctions = $auctions->get();

        foreach ($auctions as $auction_key => $auction) {
            
            $now = time();
            $date = strtotime($auction->over_date);
            $datediff = $date - $now;

            $auction->datediff = floor($datediff / (60 * 60 * 24));

            $delivdate = strtotime($auction->delivery_date);
            $deliv_interval = $delivdate - $date;

            $auction->deliv_interval = floor($deliv_interval / (60 * 60 * 24));

            if ($auction->type === 'rise') {
                $rate = $auction->price();
            } 
            elseif  ($auction->type === 'sale') { // распродажи
                $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first();
            }
            else {
               $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first(); // 050522
            }   

            if (!empty($rate)) {
                $auction->rate = $rate;
            }      

            $auction->article = sprintf("%05s", $auction->id);
            $auction->created_formated = date('d.m.Y H:i', strtotime($auction->created_at));
            $auction->date_formated = date('d.m.Y', strtotime($auction->over_date));
            $auction->over_date = date('Y-m-d', strtotime($auction->over_date));
            $auction->delivery_date_formated = date('d.m.Y', strtotime($auction->delivery_date));

        }

        return response(['status' => 1, 'auctions' => $auctions], 200);

    }





    //130223 загрузка вложенных файлов
    public function add_doc_file(Request $request)
    {
        $auction = Auction::find($request->auction_id);

        $user = Auth::user();

        if (!empty($auction) && $request->filenames) {

            $counter = 0;
            $auctionfolder = $auction->id;

            $filenumber = 1;
            $doc_files = [];

            foreach ($request->filenames as $file) {
                $ext = strtolower($file->getClientOriginalExtension());

                $fileName = 'tender_file_' . $filenumber . '.' . $ext;
                $filePath = $auctionfolder . '/' . $fileName;

                Storage::disk('local')->put('public/docs/' . $filePath, file_get_contents($file), 'public');

                $path = storage_path('app/public/docs/' . $filePath);

                array_push($doc_files, $filePath);
                $counter++;
                $filenumber++;
            }

            $auction->doc_files = json_encode(array_filter($doc_files));
            $auction->save();

            if ($counter % 100 > 10 && $counter % 100 < 15) {
                $text = 'Успешно загружено ' . $counter . ' файлов';
            } elseif ($counter % 10 > 1 && $counter % 10 < 5) {
                $text = 'Успешно загружено ' . $counter . ' файла';
            } elseif ($counter % 10 == 1) {
                $text = 'Успешно загружен ' . $counter . ' файл';
            } else {
                $text = 'Успешно загружено ' . $counter . ' файлов';
            }

            return response(['status' => 1, 'text' => $text], 200);

        }

    }




     //130223 скачивание вложенных файлов
    public function get_doc_file(Request $request)
    {
        if (!empty($request->doc_file)) {
            $doc_file = $request->doc_file;
            return Storage::download('public/docs/'.$doc_file);
        }
    }
    

}
