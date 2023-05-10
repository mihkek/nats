<?php

namespace App\Http\Controllers;

use App\Models\Barcode;
use Redirect;
use App\Customer;
use App\CustomerPerson;
use App\DirectoryFirm;
use App\DirectoryPerson;
use App\Libs\Helpers;
use App\Libs\Reports;
use App\Libs\ZoomUs;
use App\Mail\OrdererMeetingReminder;
use App\Models\BillingTariffs;
use App\Models\AccessManager;
use App\Models\Office;
use App\Models\Review;
use App\Models\User;
use App\Models\BlockSuplier;
use App\Models\News;

use App\Models\Partnerer;
use App\Models\PartnererTerritory;

//use App\Exceptions\BillingException;
//use App\Exceptions\OrdersException;
use App\Models\Billing;
use App\Models\Rating;

//use App\Models\BillingInvoice;
//use App\Models\Orders;
//use App\Models\Test;
//use App\Models\TestCategory;
//use App\Models\TestSession;
//use App\Libs\Robokassa;
use App\Orderer;
use App\Rules\Phone;
use DB;

// для валидации телефонов
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Mirronix\TranslationManager\Libs\TranslationManager;

use Kordy\Ticketit\Models\Setting;

class AdminController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function deleteBlockUser(Request $request, $id)
    {
        $user = Auth::user();
        $block_sup = BlockSuplier::where('id', $id)->first();
        $block_sup->delete();
        return response()->json(['result' => 'success', 'block_sup' => $block_sup]);
    }

    public function blockUser(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'auction_id' => 'required',
            'user' => 'required',
        ]);
        $user = Auth::user();
        $block_sup = new BlockSuplier();
        $block_sup->user_id = $user->id;
        $block_sup->suplier_id = $request['user']['id'];
        $block_sup->comment = $request['description'];
        $block_sup->auction_id = $request['id'];
        $block_sup->save();
        $user_send = User::where('id', $request['user']['id'])->first();

        $message = "Пользователь такой-то " . $user_send->email . " заблокировал Вас по  причине: $block_sup->comment. 
        Для разблокировки свяжитесь, пожалуйста, с оператором НАТС - info@agtender.com";
        mail($user_send->email, 'Ваc заблокировали в AGTENDER ', $message);


        return response()->json(['result' => 'success', 'block_sup' => $block_sup]);
    }


    public function indexSubliers(Request $request)
    {
        $user = Auth::user();
        $block_subliers = BlockSuplier::where('user_id', $user->id)->get();
        $data = [
            'block_subliers' => $block_subliers,
        ];
        return view('admin.block_supliers.index', $data);
    }

    public function indexJSONSubliers(Request $request)
    {
        $user = Auth::user();
        $block_subliers = BlockSuplier::where('user_id', $user->id)->with('user')->get();
        return response()->json(['result' => 'success', 'subliers' => $block_subliers]);
    }

    public function detailSubliers(Request $request, $id)
    {
        $user = Auth::user();
        $block_sublier = BlockSuplier::where('id', $id)->where('user_id', $user->id)->get();
        $data = [
            'block_sublier' => $block_sublier,
        ];
        return view('admin.block_supliers.detail', $data);
    }

    //news admin
    public function getNews(Request $request)
    {
        $news = News::all();
        $setting = new Setting();
        $data = [
            'news' => $news,
            'setting' => $setting,
        ];
        return view('admin.news.index', $data);
    }

    //news admin
    public function getNewsById(Request $request, $id)
    {
        $news = News::where('id', $id)->first();
        $data = [
            'news' => $news,
        ];
        return view('admin.news.detail', $data);
    }

    //news admin
    public function deleteNewsById(Request $request, $id)
    {
        $news = News::where('id', $id)->delete();
        return redirect('/admin/new-news/')->with('success', 'Успешно удалено');

    }

    //news admin
    public function postNewsById(Request $request, $id)
    {
        $request->validate([
            'slug' => 'required',
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
        ]);
        $slug = $request->input('slug');
        $content = $request->input('content');
        $description = $request->input('description');
        $title = $request->input('title');


        //не читаемый код
        /*libxml_use_internal_errors(true);
        $dom = new \DomDocument('1.0', 'UTF-8');
        $dom->loadHtml('<!DOCTYPE html><meta charset="UTF-8">' . $content);
        $images = $dom->getElementsByTagName('img');
        foreach ($images as $k => $img) {
            $data = $img->getAttribute('src');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $image_name = "/storage/uploads/" . time() . $k . '.png';
            $path = public_path() . $image_name;
            file_put_contents($path, $data);
            $img->removeAttribute('src');
            $img->setAttribute('src', $image_name);
        }
        $content = $dom->saveHTML();*/



        if ($id == 0) {
            $news = new News();
        } else {
            $news = News::where('id', $id)->first();
        }
        if ($request->file('image')) {
            $imagePath = $request->file('image');
            $imageName = $imagePath->getClientOriginalName();
            $path = $request->file('image')->storeAs('uploads', $imageName, 'public');
            $news->image = '/storage/' . $path;
        }
        $news->slug = $slug;
        $news->title = $title;
        $news->description = $description;
        $news->content = $content;
        $news->save();
        $data = [
            'news' => $news,
        ];
        return redirect('/admin/new-news/' . $news->id)->with('success', 'Успешно сохранено');
    }

    /*public function preload_img(Request $request) {
    {
        $user = User::find($request->user_id);
        if ($user->avatar != null)
        {
            Storage::disk('local')->delete('avatars/600x600.'.$user->avatar);
            Storage::disk('local')->delete('avatars/150x150.'.$user->avatar);
            Storage::disk('local')->delete('avatars/50x50.'.$user->avatar);
            Storage::disk('local')->delete('avatars/48x48.'.$user->avatar);
        }

        $path = storage_path('app/avatars/');
        $rand = rand(100,999);
        $fileName = $user->id.'-'.$rand.'.'.$request->file->getClientOriginalExtension();

        $img = ImageInt::make($request->file);
        $height = $img->height();
        $width = $img->width();

        if ($width > $height) {
            $img->crop($height, $height);
        }
        else {
            $img->crop($width, $width);
        }

        $img->resize(600, 600)->save($path.'600x600.'.$fileName);
        $img->resize(150, 150)->save($path.'150x150.'.$fileName);
        $img->resize(50, 50)->save($path.'50x50.'.$fileName);
        $img->resize(48, 48)->save($path.'48x48.'.$fileName);

        $user->avatar = $fileName;
        $user->save();
    }    */


    //############## ГЛАВНАЯ КАБИНЕТА ##############
    public function getIndex(Request $request)
    {
        $user = Auth::user();
        $tariffs = config('tariffs');

        $balance = Billing::getBalance($user->id, true); // TODO: убрать потом очистку кэша!
        $stats = Billing::getBalanceMonths($user->id, 6, 0, true); // TODO: убрать потом очистку кэша!
        $stats_tariffs = Billing::getTotalBonusesTariffs($user->id, true); // TODO: убрать потом очистку кэша!
        $rating = Rating::getUserRating($user->id, true); // TODO: убрать потом очистку кэша!
        $leaders = Billing::getLeaders(3, true); // TODO: убрать потом очистку кэша!

        $data = [
            'request' => $request,
            'user' => $user,
            'balance' => $balance,
            'tariffs' => $tariffs,
            'stats' => $stats,
            'stats_tariffs' => $stats_tariffs,
            'rating' => $rating,
            'leaders' => $leaders,
            'count' => 1,
        ];

        //090223 если пользователь удален в архиве
        if ($user->deleted === 'on') {
            Auth::logout();
            return redirect('/login');
        }

        //админ
        if ($user->role_id == 1000) {
            return view('admin.dashboard.role_1000', $data);
        } //помещение
        else if ($user->role_id == 103) {
            return view('admin.dashboard.role_103', $data);
        } //преподаватель
        else if ($user->role_id == 102) {
            return view('admin.dashboard.role_102', $data);
        } //пользователь
        else {
            return view('admin.dashboard.role_101', $data);
        }

    }


    //############## ПРОСТЫЕ ТЕКСТОВЫЕ СТРАНИЦЫ ##############
    public function getTest(Request $request)
    {
        $manager = new TranslationManager();
        $manager->storeKey('en', 'user.lame_true', 'This is very sad!');

        exit;

        $routes = app('router')->getRoutes();

        $data = $routes->match(app('request')->create('/admin/'))->getName();
        var_dump($data);

        exit;

        $zoom = new ZoomUs();
        App::setLocale('ru');
        $person = DirectoryPerson::find(9);
        var_dump($person->full_name);
        var_dump($person->main_address);
        $person->full_name = 'Zoomish Logopedish';
        $person->save();

        exit;
        return view('admin.test');
    }

    public function getHelp(Request $request)
    {
        return view('admin.settings.help');
    }

    //############## ПРОСТЫЕ ТЕКСТОВЫЕ СТРАНИЦЫ support ##############
    public function getSupportService(Request $request)
    {
        return view('admin.support.service');
    }

    public function getSupportFaq(Request $request)
    {
        return view('admin.support.faq');
    }

    public function getSupportNews(Request $request)
    {
        return view('admin.support.news');
    }

    public function getSupportContacts(Request $request)
    {
        return view('admin.support.contacts');
    }

    public function getSupportLearning(Request $request)
    {
        return view('admin.support.learning');
    }

    public function getSupportDocs(Request $request)
    {
        return view('admin.support.docs');
    }


    //############## НОВОСТИ ##############
//    public function getNewsList(Request $request)
//    {
//        return view('admin.news.list', ['user' => Auth::user()]);
//    }
//
//    public function getNews(Request $request)
//    {
//        $blade = "admin.news." . $request->y . "." . $request->m . "." . $request->d . "." . $request->file;
//        return view($blade, ['user' => Auth::user()]);
//    }


    //############## СТРАНИЦА ПАРТНЕРСКИХ ПРОГРАММ ##############
    public function getAfillaterIndex(Request $request)
    {
        $user = Auth::user();
        $tariffs = config('tariffs');
        $data = [
            'user' => $user,
            'referal' => $user->getReferalCode(),
            'tariffs' => $tariffs,
        ];
        return view('admin.afillater.index1', $data);
    }

    public function getInvite(Request $request)
    {
        $user = Auth::user();
        $data = [
            'referal' => $user->getReferalCode(),
        ];
        return view('admin.afillater.invite', $data);
    }

    public function getPartnership(Request $request)
    {
        $user = Auth::user();
        $tariffs = config('tariffs');
        $data = [
            'user' => $user,
            'referal' => $user->getReferalCode(),
            'tariffs' => $tariffs,
        ];
        return view('admin.afillater.partnership', $data);
    }


    /*############### ЛИЧНЫЕ ДАННЫЕ И ИХ ИЗМЕНЕНИЕ #############################*/
    public function getSettings(Request $request)
    {

        $user = Auth::user();

        // территории документов для выбора города пользователя
        $territories = PartnererTerritory::orderBy('name')->get();
        $territory = PartnererTerritory::find($request->territory_id);
        $territoryId = $territory->id ?? 0;

        $data = [
            'territories' => $territories,
            'territoryId' => $territoryId,
            'request' => $request,
            'user' => $user,
        ];

        return view('admin.settings.personal', $data);
    }

    public function postSettings(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'name_patronymic' => ['required'],
            'name_family' => ['required'],
            'sex' => ['required'],
            'city' => ['required'],
            'phone' => ['required', new Phone],
            'email' => ['required', 'email'],
            'currency' => ['required'],
        ]);

        $user = Auth::user();
        foreach (['name', 'name_patronymic', 'name_family', 'sex', 'city', 'phone', 'email', 'currency'] as $key) {
            $user->$key = $request->$key ?? '';
        }
        $user->save();

        return response()->json(['result' => 'success']);
    }

    public function postChangePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed',
        ], ['password.confirmed' => 'Введенные пароли не совпадают']);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['result' => 'success']);
    }

    public function postChangeAddress(Request $request)
    {
        $request->validate([
            'country' => ['required'],
            'zip' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
        ]);

        $user = Auth::user();
        foreach (['country', 'zip', 'city', 'address'] as $key) {
            $user->$key = $request->$key ?? '';
        }
        $user->save();

        return response()->json(['result' => 'success']);
    }

    public function postChangeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'mimes:jpg,jpeg,gif,png', 'max:5000', 'dimensions:min_width=500,min_height=500'],
        ]);

        $user = Auth::user();

        foreach (['avatar'] as $key) {
            $filenameWithExt = $request->file($key)->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file($key)->getClientOriginalExtension();
            //$fileNameToStore = $user->id . "_" . $key . '.' . $extension;
            $fileNameToStore = md5(microtime() . rand(0, 9999)) . '.' . $extension;
            $path = $request->file($key)->storeAs('avatars', $fileNameToStore);
            $user->$key = $fileNameToStore ?? '';
        }

        // создание квадратных аватарок и сохранение их на диск
        $filePatch = storage_path() . '/app/avatars/';
        $fileLoad = $filePatch . $fileNameToStore;
        $manager = new ImageManager(array('driver' => 'imagick'));
        $image = $manager->make($fileLoad)->fit(48, 48)->save($filePatch . "48x48." . $fileNameToStore, 100);
        $image = $manager->make($fileLoad)->fit(150, 150)->save($filePatch . "150x150." . $fileNameToStore, 100);
        $image = $manager->make($fileLoad)->fit(500, 500)->save($filePatch . "500x500." . $fileNameToStore, 100);

        $user->save();
//	return response()->json(['redirect' => '/admin/settings/personal'], 422);
        return response()->json(['result' => 'success']);
    }

    public function postChangeAfillate(Request $request)
    {
        $request->validate([
            'phone_afillate' => ['required', new Phone],
        ]);

        $ref_id = User::getReferalByPhone($request->phone_afillate);
        if (empty($ref_id)) {
            return response()->json(['result' => 'notfound']);
        }

        $user = Auth::user();
        $user->ref_id = $ref_id;
        $user->referal_phone = $request->phone_afillate;
        $user->save();

        return response()->json(['result' => 'success']);
    }
    /*###############  ///  ##################################################*/


    /*############### ДАННЫЕ ТСП ##################################################*/
    public function getTsp(Request $request)
    {

        $data = [
            'request' => $request,
            'user' => Auth::user(),
        ];

        return view('admin.settings.tsp', $data);
    }

    /*############### ПОЛУЧЕНИЕ ФАЙЛА ТСП ##################################################*/
    public function getTspFile(Request $request)
    {

        $user = Auth::user();

        if (!empty($request->file) && Storage::exists("docs_tsp/" . $request->file)) {
            $test = explode("_", $request->file);
            if ($test[0] == $user->id) {
                return response()->download(storage_path("app/docs_tsp/" . $request->file));
            }
        }
        return response(404);
    }

    /*############### ДАННЫЕ ТСП ИЗМЕНЕНИЕ ##################################################*/
    public function postTsp(Request $request)
    {

        $user = Auth::user();

        /*#### Сохранение формы с реквизитами #########*/
        if ($request->part == '1') {

            /*#### Для юрлиц #########*/
            if (empty($request->type)) {
                $request->validate([
                    'tsp_name' => ['required'],
                    'tsp_name_short' => ['required'],
                    'tsp_inn' => ['required', 'size:10'],
                    'tsp_kpp' => ['required', 'size:9'],
                    'tsp_ogrn' => ['required', 'size:13'],
                    'tsp_okved' => ['required'],
                    'tsp_okpo' => ['required', 'min:8', 'max:14'],
                    'tsp_address_post' => ['required'],
                    'tsp_address_ur' => ['required'],
                    'tsp_email' => ['required', 'email'],
                    'tsp_director' => ['required'],
                    'tsp_bank' => ['required'],
                ]);
                foreach (['tsp_name', 'tsp_name_short', 'tsp_inn', 'tsp_kpp', 'tsp_ogrn', 'tsp_okved', 'tsp_okpo', 'tsp_address_post', 'tsp_address_ur', 'tsp_email', 'tsp_director', 'tsp_bank'] as $key) {
                    $user->$key = $request->$key ?? '';
                }

                /*#### Для ИП #########*/
            } else if (!empty($request['type']) && $request['type'] == '2') {
                $request->validate([
                    'tsp_name' => ['required'],
                    'tsp_inn' => ['required', 'size:10'],
                    'tsp_ogrn' => ['required', 'size:15'],
                    'tsp_address_ur' => ['required'],
                    'tsp_email' => ['required', 'email'],
                    'tsp_bank' => ['required'],
                ]);
                foreach (['tsp_name', 'tsp_inn', 'tsp_ogrn', 'tsp_address_ur', 'tsp_email', 'tsp_bank'] as $key) {
                    $user->$key = $request->$key ?? '';
                }

            }
            /*##########*/

        } /*#### Сохранение формы с документами #########*/
        else if ($request->part == '2') {

            /*#### Для юрлиц #########*/
            if (empty($request->type)) {
                $request->validate([
                    'file_ogrn' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_ifns' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_prikaz' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_arenda' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_dover' => ['mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_ustav' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_karta' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                ]);
                foreach (['file_ogrn', 'file_ifns', 'file_prikaz', 'file_arenda', 'file_dover', 'file_ustav', 'file_karta'] as $key) {
                    $filenameWithExt = $request->file($key)->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file($key)->getClientOriginalExtension();
                    $fileNameToStore = $user->id . "_" . $key . '.' . $extension;
                    $path = $request->file($key)->storeAs('docs_tsp', $fileNameToStore);
                    $user->$key = $fileNameToStore ?? '';
                }

                /*#### Для ИП #########*/
            } else if (!empty($request['type']) && $request['type'] == '2') {
                $request->validate([
                    'file_ogrn' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_ifns' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_arenda' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                    'file_karta' => ['required', 'mimes:pdf,jpg,jpeg,png,doc,docx,zip', 'max:5000'],
                ]);

                foreach (['file_ogrn', 'file_ifns', 'file_arenda', 'file_karta'] as $key) {
                    $filenameWithExt = $request->file($key)->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $request->file($key)->getClientOriginalExtension();
                    $fileNameToStore = $user->id . "_" . $key . '.' . $extension;
                    $path = $request->file($key)->storeAs('docs_tsp', $fileNameToStore);
                    $user->$key = $fileNameToStore ?? '';
                }

            }
            /*##########*/

        }

        $user->save();
        return response()->json(['result' => 'success']);
    }

    public function getReports(Request $request)
    {
        $reports = new Reports();
        $data = $reports->getTariffReport(Auth::user()->id);

        return view('admin.reports.index', $data);
    }

    public function Review(Request $request)
    {

        $user = Auth::user();

        if (request()->isMethod('post')) {

            $review = new Review;
            $review->username = $user->company_name;
            $review->review = $request->review;

            $review->save();
            return response()->json(['success']);
        } else {
            return view('admin.reviews.personal_review', ['user' => $user]);
        }
    }

    public function ReviewList(Request $request)
    {

        $review = Review::all();
        return ['reviews' => $review];
    }

    public function updateReview(Request $request)
    {

        $review = Review::find($request->id);
        $review->review = $request->review;
        $review->save();

        return ['review' => $review->review];
    }

    public function deleteReview(Request $request)
    {

        $review = Review::find($request->id);
        $review->delete();

        return ['result' => 'success'];
    }



    // Mobile Api  Персональная партнерская ссылка
    public function apiMobileGetInvite(Request $request) 
    {
        $user = Auth::user();
        $generator = new Barcode();
        $param = Config('global.project.url') . "/?ref" . $user->getReferalCode();
        $options = Array();
        $options['w'] = 250;
        $options['h'] = 250;
        $options['wq'] = 0;
        $result = $generator->output_image("svg","qr",$param,$options);
        echo $result;
    }

    // Mobile Api  Персональная партнерская ссылка
    public function apiMobileGetInviteLink(Request $request)
    {
        $user = Auth::user();
        $param = Config('global.project.url') . "/?ref" . $user->getReferalCode();
        return response(['status' => 1, 'link' => $param], 200);
    }


}
