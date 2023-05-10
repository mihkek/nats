<?php

namespace App\Http\Controllers;

use App\DirectoryFirm;
use App\Models\User;
use App\Libs\Helpers;
use App\Orderer;
use App\OrdererStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Config;


class CalendarController extends BaseController
{
    public function getEvents(Request $request) {
	    $query = Orderer::query()->orderBy('date_time', 'desc');

	    foreach (['directory_firm_id', 'directory_person_id'] as $key) {
	        if ($request->has($key)) {
	            $query->where($key, $request->$key);
            }
        }

	    if ($request->has('status')) {
	        $statusCodes = is_array($request->status) ? $request->status : [$request->status];
	        $query->whereIn('status', OrdererStatus::whereIn('code', $statusCodes)->pluck('id')->toArray());
        }

        $items = $query->get()->map([$this, 'eventToCalendar']);


	    return response()->json(['items' => $items], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function eventToCalendar($event) {
        return [
            'id' => $event->id,
            'url' => '/admin/orderer/now/card/' . $event->id,
            'status' => $event->order_status,
            'person' => $event->directory_person,
            'customer' => $event->customer,
            'datetime' => $event->date_time,
            'review' => [
                'text' => $event->customer_review,
                'rate' => $event->customer_review_rate * 1,
            ],
        ];
    }
}
