<?php 

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Promoter;

use DB;
use File;
use Storage;

use Intervention\Image\Facades\Image as ImageInt;

class PromoterController extends Controller
{
	public function getIndex()
    {
		return view('admin.promoter.index');
    }

    public function getList()
    {
		return view('admin.promoter.list');
    }

    public function getArchive()
    {
		return view('admin.promoter.archive');
    }

    public function getCard(Request $request)
    {
        $promoter = Promoter::find($request->id);
        $data = [
            'promoter' => $promoter,
        ];
		return view('admin.promoter.card', $data);
    }

    public function getNew()
    {
		return view('admin.promoter.new');
    }

    public function get(Request $request)
    {
        $user = User::find($request->user_id);
    	if (!empty($request->id)) {
    		$promoter = Promoter::find($request->id);
            if ($user->role_id != 1000 && $user->subdivision_id != $promoter->subdivision_id) {
                return response([ 'status' => 0, 'text' => 'Error' ], 200); 
            }
            else {
                return response([ 'status' => 1, 'promoter' => $promoter ], 200); 
            }
    	}
    	else {
    		$promoters = Promoter::with('user')->where('subdivision_id', $request->subdivision_id);

    		if ($request->limit > 0) {
    			$promoters = $promoters->take($request->limit);
    		}
    		if ($request->is_delete == true) {
                $promoters = $promoters->where('deleted', 'on');
            }
            else {
                $promoters = $promoters->where('deleted', '!=', 'on');
            }

            $promoters = $promoters->get();
        	return response([ 'status' => 1, 'promoters' => $promoters ], 200); 
    	}
    }

    public function get_users(Request $request)
    {
        $user = User::find($request->user_id);
    	$users = User::where('role_id', 1002)->where('subdivision_id', $user->subdivision_id)->get();
        return response([ 'status' => 1, 'users' => $users ], 200); 
    }

    public function edit(Request $request)
    {
        $user = User::find($request->user_id);
        $new = false;

    	if (!empty($request->id)) {
    		$promoter = Promoter::find($request->id);
    		$text = 'Информация о промоутере успешно изменена';
    	}
    	else {
            $old_promoter = Promoter::where('code_opc', $request->code_opc)->where('deleted', '!=', 'on')->first();
            if (!empty($old_promoter)) {
                $text = 'Указанный ОРС код уже используется';
                return response([ 'status' => 0, 'text' => $text ], 200); 
            }
    		$promoter = new Promoter;
    		$text = 'Промоутер успешно создан';
            $new = true;
    	}
        $promoter->subdivision_id = $request->subdivision_id;
        $promoter->scripts_rate = $request->scripts_rate;
        $promoter->hired_date = $request->hired_date;
        $promoter->fired_date = $request->fired_date;
        $promoter->full_name = $request->full_name;
    	$promoter->code_opc = $request->code_opc;
    	$promoter->user_id = $request->user_id;
    	$promoter->vk_link = $request->vk_link;
        $promoter->comment = $request->comment;
    	$promoter->birthday = $request->birthday;
    	$promoter->main_phone = $request->main_phone;
        $promoter->user_id = $request->user['id'];
    	$promoter->save();

        if ($new == true)
        {
            $promoter->create_user();
        }
        
        return response([ 'status' => 1, 'text' => $text, 'promoter' => $promoter ], 200); 
    }

    public function edit_img(Request $request)
    {
    	$promoter = Promoter::find($request->id);
    	if ($promoter->avatar != null)
        {
            Storage::disk('local')->delete('avatars/600x600.'.$promoter->avatar);
            Storage::disk('local')->delete('avatars/150x150.'.$promoter->avatar);
            Storage::disk('local')->delete('avatars/50x50.'.$promoter->avatar);
            Storage::disk('local')->delete('avatars/48x48.'.$promoter->avatar);
        }
        $path = storage_path('app/avatars/');
        $rand = rand(100,999);
        $fileName = $promoter->id.'-'.$rand.'.'.$request->file->getClientOriginalExtension();
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

        $promoter->avatar = $fileName;
        $promoter->save();

        $text = 'Фотография промоутера '.$promoter->full_name.' - успешно обновлена';
        return response([ 'status' => 1, 'text' => $text ], 200);
    }

    public function delete(Request $request)
    {
        $promoter = Promoter::find($request->id);
        $promoter->deleted = 'on';
        $promoter->save();
        $text = 'Промоутер "'.$promoter->full_name.'" успешно помещен в архив';
        return response([ 'status' => 1, 'promoter' => $promoter, 'text' => $text ], 200); 
    }

    public function restore(Request $request)
    {
        $promoter = Promoter::find($request->id);
        $promoter->deleted = '';
        $promoter->save();
        $text = 'Промоутер "'.$promoter->full_name.'" успешно восстановлен из архива';
        return response([ 'status' => 1, 'promoter' => $promoter, 'text' => $text ], 200); 
    }
}
