<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use DB;

class ReportController extends Controller
{
    public function getPromoters(Request $request)
    {
		return view('admin.reports.promoters');
    }

    public function getOperators(Request $request)
    {
		return view('admin.reports.operators');
    }

    public function getManagers(Request $request)
    {
		return view('admin.reports.managers');
    }

    public function getLids(Request $request)
    {
        return view('admin.reports.lids');
    }

    public function getGlobal(Request $request)
    {
        return view('admin.reports.global');
    }

    public function get_promoters(Request $request)
    {
        $user = User::find($request->user_id);
    	$items = array();

        $promoters = DB::table('promoters')->where('subdivision_id', $request->subdivision_id)->where('deleted', '!=', 'on')->get();

        foreach ($promoters as $promoter) {

            $requesters_count = 0; // Количество анкет
            $deal_count = 0; // Количество пришедших
            $deal_percent = 0; // Процент пришедших
            $pays_amount = 0; // Сумма оплат
            $pay_deal_count = 0; // Количество сделок с оплаченным первым платежом
            $pay_deal_percent = 0; // Процент сделок с оплаченным первым платежом
            $false_count = 0; // Количество ложных
            $false_percent = 0; // Процент ложных
            $cancel_count = 0; // Количество отказов
            $cancel_percent = 0; // Процент отказов
            $total_amount = 0; // Общая сумма сделок
            $working_count = 0; // Заявки в работе

            $requesters = DB::table('requesters')->where('promoter_id', $promoter->id)
                                                ->whereBetween('created_at', [$request->date_from, $request->date_to])->get();

            $requesters_count = $requesters->count();

            foreach ($requesters as $requester) {

                if ($requester->status == 7) {
                    $deal_count++;

                    $requester_customer = DB::table('requester_customers')->where('requester_id', $requester->id)->first();
                    if ($requester_customer->customer_id != null) {
                        $customer = DB::table('customers')->where('id', $requester_customer->customer_id)->first();
                        $pay = DB::table('customer_pays')->where('customer_id', $customer->id)->orderBy('date')->first();
                        if (!empty($pay)) {
                            if ($pay->is_paid == 1) {
                                $pay_deal_count++;
                                $pays_amount = $pays_amount + $pay->amount;
                            }
                            else if ($pay->income > 0) {
                                $pays_amount = $pays_amount + $pay->income;
                            }
                        }
                        $pays = DB::table('customer_pays')->where('customer_id', $customer->id)->where('income', '>', 0)->get();
                        foreach ($pays as $pay) {
                            $total_amount = $total_amount + $pay->income;
                        }
                    }
                }
                else if ($requester->status == 5) {
                    if ($requester->is_false == null) {
                        $cancel_count++;
                    }
                    else {
                        $false_count++;
                    }
                }
                else {
                    $working_count++;
                }
            }
            if ($requesters_count > 0) {
                $deal_percent = round(100*$deal_count/$requesters_count, 2);
                $false_percent = round(100*$false_count/$requesters_count, 2);
                $cancel_percent = round(100*$cancel_count/$requesters_count, 2);
                if ($deal_count > 0) {
                    $pay_deal_percent = $pay_deal_count/($deal_count/100);
                }
            }
            $item = array(
                'opc_code' => $promoter->code_opc,
                'requesters_count' => $requesters_count,
                'deal_count' => $deal_count,
                'deal_percent' => $deal_percent,
                'pays_amount' => $pays_amount,
                'pay_deal_count' => $pay_deal_count,
                'pay_deal_percent' => $pay_deal_percent,
                'false_count' => $false_count,
                'false_percent' => $false_percent,
                'cancel_count' => $cancel_count,
                'cancel_percent' => $cancel_percent,
                'total_amount' => $total_amount,
                'working_count' => $working_count,
            );
            array_push($items, $item);
        }
        return response([ 'status' => 1, 'items' => $items ], 200); 
    }

    public function get_operators(Request $request)
    {
    	$user = User::find($request->user_id);
        $items = array();

        $operators = DB::table('users')->where('subdivision_id', $request->subdivision_id)->where('role_id', 1001)->get();

        foreach ($operators as $operator) {

            $requesters_count = 0; // Количество анкет
            $records_count = 0; // Количество записей
            $deal_count = 0; // Количество пришедших
            $deal_percent = 0; // Процент пришедших
            $pays_amount = 0; // Сумма оплат
            $pay_deal_count = 0; // Количество сделок с оплаченным первым платежом
            $pay_deal_percent = 0; // Процент сделок с оплаченным первым платежом
            $false_count = 0; // Количество ложных
            $false_percent = 0; // Процент ложных
            $cancel_count = 0; // Количество отказов
            $cancel_percent = 0; // Процент отказов
            $total_amount = 0; // Общая сумма сделок
            $working_count = 0; // Заявки в работе

            $requesters = DB::table('requesters')->where('user_id', $operator->id)
                                                ->whereBetween('created_at', [$request->date_from, $request->date_to])->get();

            $requesters_count = $requesters->count();

            foreach ($requesters as $requester) {

                if ($requester->status == 6) {
                    $records_count++;
                }

                if ($requester->status == 7) {
                    $deal_count++;

                    $requester_customer = DB::table('requester_customers')->where('requester_id', $requester->id)->first();
                    if ($requester_customer->customer_id != null) {
                        $customer = DB::table('customers')->where('id', $requester_customer->customer_id)->first();
                        $pay = DB::table('customer_pays')->where('customer_id', $customer->id)->orderBy('date')->first();
                        if (!empty($pay)) {
                            if ($pay->is_paid == 1) {
                                $pay_deal_count++;
                                $pays_amount = $pays_amount + $pay->amount;
                            }
                            else if ($pay->income > 0) {
                                $pays_amount = $pays_amount + $pay->income;
                            }
                        }
                        $pays = DB::table('customer_pays')->where('customer_id', $customer->id)->where('income', '>', 0)->get();
                        foreach ($pays as $pay) {
                            $total_amount = $total_amount + $pay->income;
                        }
                    }
                }
                else if ($requester->status == 5) {
                    if ($requester->is_false == null) {
                        $cancel_count++;
                    }
                    else {
                        $false_count++;
                    }
                }
                else {
                    $working_count++;
                }
            }
            if ($requesters_count > 0) {
                $deal_percent = round(100*$deal_count/$requesters_count, 2);
                $false_percent = round(100*$false_count/$requesters_count, 2);
                $cancel_percent = round(100*$cancel_count/$requesters_count, 2);
                if ($deal_count > 0) {
                    $pay_deal_percent = round($pay_deal_count/($deal_count/100), 2);
                }
            }
            $item = array(
                'user_id' => $operator->id,
                'requesters_count' => $requesters_count,
                'records_count' => $records_count,
                'deal_count' => $deal_count,
                'deal_percent' => $deal_percent,
                'pays_amount' => $pays_amount,
                'pay_deal_count' => $pay_deal_count,
                'pay_deal_percent' => $pay_deal_percent,
                'false_count' => $false_count,
                'false_percent' => $false_percent,
                'cancel_count' => $cancel_count,
                'cancel_percent' => $cancel_percent,
                'total_amount' => $total_amount,
                'working_count' => $working_count,
            );
            array_push($items, $item);
        }
        return response([ 'status' => 1, 'items' => $items ], 200); 
    }

    public function get_managers(Request $request)
    {
    	$user = User::find($request->user_id);
        $items = array();

        $managers = DB::table('users')->where('subdivision_id', $request->subdivision_id)->where('role_id', 1003)->get();
        
        foreach ($managers as $manager) {

            $requesters_count = 0; // Количество анкет
            $cancel_count = 0; // Количество отказов
            $cancel_percent = 0; // Процент отказов
            $deal_count = 0; // Количество пришедших
            $deal_percent = 0; // Процент пришедших
            $waiting_count = 0; // Количество в ожидании
            $waiting_percent = 0; // Процент в ожидании
            $pays_amount = 0; // Сумма оплат
            $total_amount = 0; // Общая сумма сделок

            $requesters = DB::table('requesters')->where('manager_id', $manager->id)
                                                ->whereBetween('created_at', [$request->date_from, $request->date_to])->get();

            $requesters_count = $requesters->count();

            foreach ($requesters as $requester) {
                if ($requester->status == 5) {
                    $cancel_count++;
                }
                else if ($requester->status == 6) {
                    $waiting_count++;
                }
                else if ($requester->status == 7) {
                    $deal_count++;
                    $requester_customer = DB::table('requester_customers')->where('requester_id', $requester->id)->first();
                    if ($requester_customer->customer_id != null) {
                        $customer = DB::table('customers')->where('id', $requester_customer->customer_id)->first();
                        $pay = DB::table('customer_pays')->where('customer_id', $customer->id)->orderBy('date')->first();
                        if (!empty($pay)) {
                            if ($pay->is_paid == 1) {
                                $pays_amount = $pays_amount + $pay->amount;
                            }
                            else if ($pay->income > 0) {
                                $pays_amount = $pays_amount + $pay->income;
                            }
                        }
                        $pays = DB::table('customer_pays')->where('customer_id', $customer->id)->where('income', '>', 0)->get();
                        foreach ($pays as $pay) {
                            $total_amount = $total_amount + $pay->income;
                        }
                    }
                }
            }

            if ($requesters_count > 0) {
                $deal_percent = round(100*$deal_count/$requesters_count, 2);
                $cancel_percent = round(100*$cancel_count/$requesters_count, 2);
                $waiting_percent = round(100*$waiting_count/$requesters_count, 2);
            }

            $item = array(
                'user_id' => $manager->id,
                'requesters_count' => $requesters_count,
                'cancel_count' => $cancel_count,
                'cancel_percent' => $cancel_percent,
                'deal_count' => $deal_count,
                'deal_percent' => $deal_percent,
                'waiting_count' => $waiting_count,
                'waiting_percent' => $waiting_percent,
                'pays_amount' => $pays_amount,
                'total_amount' => $total_amount,
            );
            array_push($items, $item);

        }

        return response([ 'status' => 1, 'items' => $items ], 200); 
    }

    public function get_lids(Request $request)
    {
        
    }

    public function get_global(Request $request)
    {
        
    }
}
