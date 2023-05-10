<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use App\Orderer;
use App\Customer;
use App\CustomerGroup;

class CustomerGroupController extends Controller
{
   public function get(Request $request)
   {
      $user = User::find($request->user_id);
   		if (!empty($request->id)) {
   			$group = CustomerGroup::with('customers', 'orderers')->find($request->id);
        if ($user->role_id != 1000 && $group->subdivision_id != $user->subdivision_id) {
          return response([ 'status' => 0, 'text' => 'Error' ], 200); 
        }
        else {
          return response([ 'status' => 1, 'group' => $group ], 200); 
        }
   		}
   		else {
   			$groups = CustomerGroup::where('deleted', '!=', 'on')->where('subdivision_id', $request->subdivision_id);

        if (!empty($request->status)) {
          $groups->whereIn('status', $request->status);
        }
        $groups = $groups->get();

        foreach ($groups as $group)
        {
          $first_order = Orderer::where('customer_group_id', $group->id)->orderBy('date')->first();
          if (!empty($first_order)) {
            $now = date('Y-m-d');
            $last_order = Orderer::where('customer_group_id', $group->id)->orderBy('date', 'desc')->first();
            $next_order = Orderer::where('customer_group_id', $group->id)->where('date', '>=', $now)->orderBy('date', 'desc')->first();
            if (!empty($next_order)) {
              $group->next_date = $next_order->date;
            }
            else {
              $group->next_date = 'none';
            }
            $group->first_date = $first_order->date;
            $group->last_date = $last_order->date;
            $group->customers_qnt = $group->customers->count();
          }
        }
       	return response([ 'status' => 1, 'groups' => $groups ], 200); 
   		}
   }

   public function edit(Request $request)
   {
      $user = User::find($request->user_id);
   		if (!empty($request->id)) {
   			$group = CustomerGroup::find($request->id);
        $group->status = $request->status;
   		}
   		else {
   			$group = new CustomerGroup;
   		}
      if (!empty($request->subdivision_id)) {
        $group->subdivision_id = $request->subdivision_id;
      }
      else {
        $group->subdivision_id = $user->subdivision_id;
      }
   		$group->title = $request->title;
   		$group->save();
   		$text = 'Информация о группе успешно сохранена';
      
      return response([ 'status' => 1, 'text' => $text, 'group' => $group ], 200); 
   }

   public function delete(Request $request)
   {
   		$group = CustomerGroup::find($request->id);
   		if ($group->deleted == 'on') {
   			$group->deleted = '';
   		}
   		else {
   			$group->deleted = 'on';
   		}
   		$group->save();
   		$text = 'Информация о группе успешно сохранена';
       	return response([ 'status' => 1, 'text' => $text ], 200); 
   }

   public function sign(Request $request)
   {
   		foreach ($request->customers as $item) {
   			$customer = Customer::find($item['id']);
   			$customer->group_id = $request->group_id;
   			$customer->save();
   		}
   		$text = 'Клиенты успешно добавлены в группу';
       	return response([ 'status' => 1, 'text' => $text ], 200); 
   }

   public function add_orders(Request $request)
   {
      if (!empty($request->disciplines))
      {
        foreach ($request->disciplines as $discipline)
        {
          foreach ($discipline['items'] as $item)
          {
            if (!empty($item['date']))
            {
              $group = CustomerGroup::find($request->customer_group_id);
              $orderer = new Orderer;
              $orderer->date = $item['date'];
              $orderer->time = $item['time'];
              $orderer->date_time = $item['date'].' '.$item['time'].':00'; 
              $orderer->end_date_time = date('Y-m-d H:i:s', strtotime($orderer->date_time.'+ 120 minutes'));
              $orderer->time_to = date('H:i', strtotime($orderer->date_time.'+ 120 minutes'));
              $orderer->customer_group_id = $request->customer_group_id;
              $orderer->discipline_id = $item['discipline_id'];
              $orderer->directory_firm_id = $item['directory_firm']['id'];
              $orderer->directory_person_id = $item['directory_person']['id'];
              $orderer->subdivision_id = $group->subdivision_id;
              $orderer->save();
            }
          }
        }
      }
   }
}
