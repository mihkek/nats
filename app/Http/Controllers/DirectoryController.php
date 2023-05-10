<?php 

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;

class DirectoryController extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;




	//############## СПИСОК ФИРМ ##############
	public function getListFirms(Request $request) {
		return view('admin.directory.list_firms');
		}
	public function getFirmsArchive(Request $request) {
		return view('admin.directory.archive_firms');
		}

	//############## СПИСОК ЛЮДЕЙ ##############
	public function getgetListNewPeoples(Request $request) {
		return view('admin.directory.list_new_peoples');
		}

	public function getgetListPeoples(Request $request) {
		return view('admin.directory.list_peoples');
		}

	public function getPeopleArchive(Request $request) {
		return view('admin.directory.archive_peoples');
		}

	//############## ФИРМА ##############
	public function getCardFirm(Request $request) {
		return view('admin.directory.list_firms_card');
		}

	public function getAddCardFirm(Request $request) {
		return view('admin.directory.list_firms_add_card');
		}	

	//############## ЧЕЛОВЕК ##############
	public function getCardPeople(Request $request) {
		return view('admin.directory.list_peoples_card');
		}

	public function getAddCardPeople(Request $request) {
		return view('admin.directory.list_peoples_add_card');
		}
	
	
}
