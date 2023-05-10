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

    //############## АКТИВНЫЕ ТЕНДЕРЫ ##############
    public function getTenderListNow(Request $request)
    {
        return view('admin.tender.list');
    }

    //############## АРХИВ ТЕНДЕРОВ ##############
    public function getTenderList(Request $request)
    {
        return view('admin.tender.archive');
    }

    //############## АРХИВ ТЕНДЕРОВ ##############
    public function getTenderMyList(Request $request)
    {
        return view('admin.tender.mylist');
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

        if (!empty($request->id)) {
            $user = Auth::user();
            $block_arr = [];
            $block_subliers_user = BlockSuplier::where('user_id', $user->id)->get();
            $block_subliers = BlockSuplier::all();
            foreach ($block_subliers as $sublier) {
                array_push($block_arr, $sublier->auction_id);
            }
//            print_r($block_arr);
            $auction = Auction::with('rates', 'win_rate', 'user')->where('id', $request->id)->first();
            if ($auction->rates->count() > 0) {
                if ($auction->type == 'rise') {
                    $rate = AuctionRate::with('user')->whereIn('status', [1, 2])->where('auction_id', $auction->id)->whereNotIn('id', $block_arr)->orderBy('price', 'desc')->where('deleted', '')->first();
                } else if ($auction->type == 'drop') {
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
                if ($request->own == true && $request->type==='drop') {
                    if ($user->role_id == 101) {
                        $auctions->where('user_id', $user->id);
                    } else if ($user->role_id == 102) {
                        $supplier_rates = AuctionRate::where('user_id', $user->id)->get();
                        $auctions_id = array();
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
                    } else if ($user->role_id == 102) {                       
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
                } else if ($request->now == false) {
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

            foreach ($auctions as $auction) {
                $now = time();
                $date = strtotime($auction->over_date);
                $datediff = $date - $now;

                $auction->datediff = floor($datediff / (60 * 60 * 24));

                $delivdate = strtotime($auction->delivery_date);
                $deliv_interval = $delivdate - $date;

                $auction->deliv_interval = floor($deliv_interval / (60 * 60 * 24));

                if ($auction->type === 'rise') {
                    $rate = $auction->price();
                } else {
                   $rate = AuctionRate::where('auction_id', $auction->id)->whereIn('status', [1, 2])->where('deleted', '')->orderBy('price')->first(); // 050522
                }  
                
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

        $auction->is_analog = $request->is_analog;
        $auction->size = $request->size;
        $auction->unit = $request->unit;
        $auction->exclude_analogs = json_encode($request->exclude_analogs, true);
        $auction->over_date = $request->over_date . ' 16:59:59';
        $auction->delivery_date = $request->delivery_date??date('Y-m-d');
        $auction->delivery_condition = $request->delivery_condition;
        $auction->delivery_region = $request->delivery_region;
        $auction->payment_condition = $request->payment_condition;
        $auction->special_terms = $request->special_terms;
        if ($request->customer_warehouse_address) $auction->customer_warehouse_address = $request->customer_warehouse_address;
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
        if (!$customer->company_warehouse_address && $auction->customer_warehouse_address) $customer->company_warehouse_addressn = $auction->customer_warehouse_address;
        $customer->save();

        $win_rate = AuctionRate::find($auction->win_rate_id);

        $supplier = User::find($win_rate->user_id);
        if (!$supplier->company_ogrn && $auction->supplier_ogrn) $supplier->company_ogrn = $auction->supplier_ogrn;
        if (!$supplier->company_bank_account && $auction->supplier_bank_account) $supplier->company_bank_account = $auction->supplier_bank_account;
        if (!$supplier->company_correspondent_account && $auction->supplier_correspondent_account) $supplier->company_correspondent_account = $auction->supplier_correspondent_account;
        if (!$supplier->company_bank_bik && $auction->supplier_bank_bik) $supplier->company_bank_bik = $auction->supplier_bank_bik;
        if (!$supplier->company_warehouse_address && $auction->supplier_warehouse_address) $supplier->company_warehouse_addressn = $auction->supplier_warehouse_address;
        $supplier->save();

    }

    public function cancel(Request $request)
    {
        $auction = Auction::find($request->id);
        $auction->status = 0;
        $auction->cancel_reason = $request->cancel_reason;
        $auction->save();

        $text = 'Аукцион был успешно отменен';
        return response(['status' => 1, 'text' => $text], 200);
    }

    public function close(Request $request)
    {
        $auction = Auction::find($request->id);
        $rate = AuctionRate::where('auction_id', $auction->id)->orderBy('id', 'desc')->first();

        $auction->date = date('Y-m-d');
        $auction->time = date('H:i');
        $auction->date_time = date('Y-m-d H:i:s');
        $auction->status = 2;
        $auction->win_rate_id = $rate->id;
        $auction->save();

        $text = 'Аукцион досрочно завершен';
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
        $rate->save();

        // ссылка на карточку 
        $link_card = ($auction->type == 'rise') ? 'https://agtender.com/admin/auction/now/card/' . $auction->id : 'https://agtender.com/admin/tender/now/card/' . $auction->id;        

        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($auction_user->email);
        Mail::send($mail);

        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($rate_user->email);
        Mail::send($mail);

        if (!empty($last_rate)) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $last_rate_user = User::find($last_rate->user_id);
            $mail->to($last_rate_user->email);
            Mail::send($mail);
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

        // ссылка на карточку 
        $link_card = ($auction->type == 'rise') ? 'https://agtender.com/admin/auction/now/card/' . $auction->id : 'https://agtender.com/admin/tender/now/card/' . $auction->id; 

        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($auction_user->email);
        Mail::send($mail);

        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($rate_user->email);
        Mail::send($mail);

        if (!empty($last_rate)) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $last_rate_user = User::find($last_rate->user_id);
            $mail->to($last_rate_user->email);
            Mail::send($mail);
        }

        $text = 'Ваша ставка успешно добавлена';
    return response(['status' => 1, 'text' => $text], 200);
    }






    public function apiMobile_add_rate(Request $request)
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
        $rate->is_analog = 0;
        $rate->analog_name = '';
        $rate->save();

        // ссылка на карточку 
        $link_card = ($auction->type == 'rise') ? 'https://agtender.com/admin/auction/now/card/' . $auction->id : 'https://agtender.com/admin/tender/now/card/' . $auction->id; 

        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($auction_user->email);
        Mail::send($mail);

        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($rate_user->email);
        Mail::send($mail);

        if (!empty($last_rate)) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $last_rate_user = User::find($last_rate->user_id);
            $mail->to($last_rate_user->email);
            Mail::send($mail);
        }

        $text = 'Ваша ставка успешно добавлена';
        return response(['status' => 1, 'text' => $text], 200);
    }

    public function apiMobile_add_rate_analog(Request $request)
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

        // ссылка на карточку 
        $link_card = ($auction->type == 'rise') ? 'https://agtender.com/admin/auction/now/card/' . $auction->id : 'https://agtender.com/admin/tender/now/card/' . $auction->id; 

        // ОТПРАВКА НА ПОЧТУ УВЕДОМЛЕНИЯ
        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($auction_user->email);
        Mail::send($mail);

        $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
        $mail->to($rate_user->email);
        Mail::send($mail);

        if (!empty($last_rate)) {
            $mail = new \App\Mail\NewAuctionRate($auction, $rate->price, $last_rate_price, $link_card);
            $last_rate_user = User::find($last_rate->user_id);
            $mail->to($last_rate_user->email);
            Mail::send($mail);
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

        $rate->status = 2;
        $rate->save();

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
        $link_card = ($auction->type == 'rise') ? 'https://agtender.com/admin/auction/now/card/' . $auction->id : 'https://agtender.com/admin/tender/now/card/' . $auction->id; 

        // ОТПРАВКА НА ПОЧТУ КЛИЕНТУ
        $mail = new \App\Mail\CloseAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
        $mail->to($customer->email);
        Mail::send($mail);

        // ОТПРАВКА НА ПОЧТУ ПРОДАВЦУ
        $mail = new \App\Mail\CloseAuction($auction, $rate->price, $customer->company_name, $supplier->company_name, $link_card);
        $mail->to($supplier->email);
        Mail::send($mail);

        foreach ($lose_rates as $lose_rate) {
            $rate_user = User::find($lose_rate->user_id);
            $mail = new \App\Mail\LoseAuction($auction, $lose_rate->price, $rate->price, $link_card);
            $mail->to($rate_user->email);
            Mail::send($mail);
        }

        $text = 'Предложение было успешно подтверждено';
        return response(['status' => 1, 'text' => $text], 200);
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
        } else if ($request->type == 'supplier') {
            $auction->supplier_confirm = 1;
        }

        $text = 'Реквизиты ' . ($request->type == 'customer' ? 'покупателя' : 'поставщика') . ' подтверждены';
        $auction->save();

        $customer = User::find($auction->user_id);
        $supplier = User::find($rate->user_id);

        $type = $request->type;

        // ссылка на карточку 
        $link_card = ($auction->type == 'rise') ? 'https://agtender.com/admin/auction/now/card/' . $auction->id : 'https://agtender.com/admin/tender/now/card/' . $auction->id;

        if ($auction->supplier_confirm == 1 && $auction->customer_confirm == 1) {

            // ОТПРАВКА НА ПОЧТУ АДМИНИСТРАТОРАМ
            $mail = new \App\Mail\ConfirmAuction($auction, $rate->price . ' ₽/' . $auction->unit, $customer->company_name, $supplier->company_name, $link_card, $request->type);
            $mail->to('info@agtender.com');
            Mail::send($mail);

            $type = 'all';
        }

        if ($auction->supplier_confirm == 1) {
            // ОТПРАВКА НА ПОЧТУ КЛИЕНТУ
            $mail = new \App\Mail\ConfirmAuction($auction, $rate->price . ' ₽/' . $auction->unit, $customer->company_name, $supplier->company_name, $link_card, $type);
            $mail->to($customer->email);
            Mail::send($mail);
        }

        if ($auction->customer_confirm == 1) {
            // ОТПРАВКА НА ПОЧТУ ПРОДАВЦУ
            $mail = new \App\Mail\ConfirmAuction($auction, $rate->price . ' ₽/' . $auction->unit, $customer->company_name, $supplier->company_name, $link_card, $type);
            $mail->to($supplier->email);
            Mail::send($mail);
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
            array_push($options, ['id' => trim($drug->id),'title' => trim($drug->title), 'active_material' => trim($drug->active_material)]);
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









    // Mobile Api
    public function get_contract_file(Request $request)
    {
        $auction = Auction::find($request->tender_id);
        $auction = json_decode($auction->customer_contract_files);
        return response(['status' => 1, 'data' => $auction], 200);
    }

    // Mobile Api
    public function apiMobile_get_contract_file(Request $request)
    {

        $auction = DB::table('auctions')->where('id',$request->tender_id)->first();
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
        $data["auction_contract"][]=[
            'name'=>  'Договор поставки №ЭТП-' . $auction->id . '.pdf',
            'link'=>  $request->getHttpHost().'/api/get_auction_contract_pdf/'.$auction->id,
        ];
        return response(['status' => 1, 'data' => $data], 200);
    }



    // Mobile Api
    public function apiMobileGetAuction(Request $request)
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
                } else if ($auction->type == '') {
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

            $rate=AuctionRate::where('auction_id','=', $request->id)->where('user_id', $user->id)->where('status','=',2)->first();
                    //return response(['status' => 1, 'auction' =>  $rate], 200);
            if($rate!=null){
                $get_tender_selection_notice=Notification::whereRaw('rateId='.$rate->id.' and userId='.$rate->user_id.' and type=1')->first();
                if ($get_tender_selection_notice){
                    $get_tender_selection_notice->updated_at=Carbon::now();
                    $get_tender_selection_notice->save();
                }else{
                    $get_tender_selection_notice = new Notification();
                    $get_tender_selection_notice->rateId=$rate->id;
                    $get_tender_selection_notice->userId=$user->id;
                    $get_tender_selection_notice->type=1; //уведомление о выборе поставщика
                    $get_tender_selection_notice->onDate=Carbon::now();
                    $get_tender_selection_notice->save();
                }
              
              
                //41. Поставщик получает уведомление о реквизитах и заключение договора
                $get_notif_supplier_about_conclusion=Notification::whereRaw('rateId='.$rate->id.' and userId='. $user->id.' and type=3')->first();
                if ($get_notif_supplier_about_conclusion){
                    $get_notif_supplier_about_conclusion->updated_at=Carbon::now();
                    $get_notif_supplier_about_conclusion->save();
                }else{
                    //return response(['status' => 1, 'auction' => 'asdasdasd'], 200);
                    $get_notif_supplier_about_conclusion = new Notification();
                    $get_notif_supplier_about_conclusion->rateId=$rate->id;
                    $get_notif_supplier_about_conclusion->userId=$user->id;
                    $get_notif_supplier_about_conclusion->type=3; //уведомление если оставили предложение на его тендер
                    $get_notif_supplier_about_conclusion->onDate=Carbon::now();
                    $get_notif_supplier_about_conclusion->save();
                }
            }

            $get_notif_submitted_offer_tender=Notification::whereRaw('rateId='.$auction->id.' and userId='. $user->id.' and type=2')->first();
            if ($get_notif_submitted_offer_tender){
                $get_notif_submitted_offer_tender->updated_at=Carbon::now();
                $get_notif_submitted_offer_tender->save();
            }else{
                $get_notif_submitted_offer_tender = new Notification();
                $get_notif_submitted_offer_tender->rateId=$auction->id;
                $get_notif_submitted_offer_tender->userId=$user->id;
                $get_notif_submitted_offer_tender->type=2; //eуведомление если оставили предложение на его тендер
                $get_notif_submitted_offer_tender->onDate=Carbon::now();
                $get_notif_submitted_offer_tender->save();
            }

            //40. Покупатель получает уведомление о реквизитах и заключение договора
            $get_notif_customer_about_conclusion=Notification::whereRaw('rateId='.$auction->id.' and userId='. $user->id.' and type=3')->first();
            if ($get_notif_customer_about_conclusion){
                $get_notif_customer_about_conclusion->updated_at=Carbon::now();
                $get_notif_customer_about_conclusion->save();
            }else{
                $get_notif_customer_about_conclusion = new Notification();
                $get_notif_customer_about_conclusion->rateId=$auction->id;
                $get_notif_customer_about_conclusion->userId=$user->id;
                $get_notif_customer_about_conclusion->type=3; //уведомление уведомление о реквизитах и заключение договора
                $get_notif_customer_about_conclusion->onDate=Carbon::now();
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
            if (!empty($request->own)){
                if ($request->own == true) {
                    if ($user->role_id == 101) {
                        $auctions->where('user_id', $user->id);
                    } else if ($user->role_id == 102) {
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
              $i=0;
              foreach($request->status as $key=>$stat){
                $status[$i]=$stat;
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
                } else if ($request->now == false) {
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



    // Mobile Api
    public function get_tender_selection_notice(){
        $authuser=Auth::user()->id;
        $sql=DB::select('
                                SELECT
                                  *
                                FROM auction_rates ar
                                WHERE ar.user_id = '.$authuser.'
                                AND ar.status = 2
                                AND ar.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId='.$authuser.' AND n.rateId=ar.id)
        ');
        $notifCount=count($sql);
        if ($sql>0){
            $text='У вас есть '.count($sql).' подтвержденных(ое) предложений(ия)';
        }else{
            $text='нет подтвержденых предложений';
        }
        return response(['status' => 1,  'notifCount'=>$notifCount, 'text' => $text, 'rate'=>$sql], 200);
    }

    // Mobile Api
    public function get_notif_submitted_offer_tender(){
        $authuser=Auth::user()->id;
        $sql=DB::select('
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
                                WHERE a.user_id = '.$authuser.'
                                AND a.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId='.$authuser.' AND n.rateId=ar.auction_id AND n.type=2)
        ');
        $notifCount=count($sql);
        if ($sql>0){
            $text='У вас есть '.count($sql).' оставленных(ая) предложений(ия)';
        }else{
            $text='нет подтвержденых предложений';
        }
        return response(['status' => 1,  'notifCount'=>$notifCount, 'text' => $text, 'rate'=>$sql], 200);
    }

    // Mobile Api 40. Покупатель
    public function get_notif_customer_about_conclusion(){
        $authuser=Auth::user()->id;
        $sql=DB::select('SELECT 
                                 *
                                FROM auctions a
                                INNER JOIN auction_rates ar ON ar.auction_id=a.id AND ar.status=2
                                WHERE a.user_id = '.$authuser.' AND a.status=2
                                AND a.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId= '.$authuser.' AND n.rateId=a.id AND n.type=3)
        ');
        $notifCount=count($sql);
        if ($sql>0){
            $text='У вас заключеные договора: '.count($sql);
        }else{
            $text='нет заключенных договоров';
        }
        return response(['status' => 1,  'notifCount'=>$notifCount, 'text' => $text, 'rate'=>$sql], 200);
    }

    // Mobile Api 41. Поставщик
    public function get_notif_supplier_about_conclusion(){
        $authuser=Auth::user()->id;
        $sql=DB::select('
                                SELECT 
                                 *
                                FROM auction_rates ar 
                                INNER JOIN auctions a ON a.id= ar.auction_id AND a.status=2
                                WHERE ar.user_id = '.$authuser.' AND ar.status=2
                                AND ar.user_id NOT IN (SELECT n.userId FROM notif_view n WHERE n.userId='.$authuser.' AND n.rateId=a.win_rate_id AND n.type=3);
        ');
        $notifCount=count($sql);
        if ($sql>0){
            $text='У вас заключеные договора: '.count($sql);
        }else{
            $text='нет заключенных договоров';
        }
        return response(['status' => 1,  'notifCount'=>$notifCount, 'text' => $text, 'rate'=>$sql], 200);
    }

    // Mobile Api 
    public function getRegions(){
        $auctions =   DB::table('auctions')->whereRaw("delivery_region IS NOT NULL AND delivery_region !=''")
                            ->select(
                                        'delivery_region'
                                    )->groupBy('delivery_region')->get();

        return response(['status' => 1, 'regions' => $auctions], 200);
    }




    // Mobile Api 
    public function apiMobile_get_contract_file_download_file($god,$naz){
        {
            $file = storage_path('app/public/contracts/'.$god.'/' . $naz);
            $headers = array(
                'Content-Type: application/pdf',
            );
            return response()->download($file, $naz, $headers);
        }
    }


    // Mobile Api
    public function apiMobile_get_auction_contract_pdf($auctionId)
    { 
       $auction = Auction::with('rates', 'win_rate', 'user')->whereRaw('id='.$auctionId)->first();
        $auction->article = sprintf("%05s", $auction->id);
        $pdf = PDF::loadView('pdf.auction_contract', ['auction' => $auction]);
        return $pdf->download('Договор поставки №ЭТП-' . $auction->id . '.pdf');
        return response(['status' => 1, 'text' => "Файл договора сформирован и откроется в новой вкладке"], 200);
    }
  


}
