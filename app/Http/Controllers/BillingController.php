<?php

namespace App\Http\Controllers;

//use App\Exceptions\OrdersException;
use App\Exceptions\BillingException;
use App\Models\Billing;
use App\Models\BillingInvoice;
use App\Models\BillingTariffs;
use App\Models\BillingCards;
use App\Models\User;
use App\Libs\Robokassa;
use App\Libs\Helpers;

use App\Orderer;
use App\CustomerSubscription;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Config;

class BillingController extends BaseController {

	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;





	//############## ПРОСТЫЕ ТЕКСТОВЫЕ СТРАНИЦЫ ##############
	public function getPayment(Request $request) {
		$data = [
			'request' => $request,
		];
		return view('admin.billing.pay', $data);
	}
	public function getFinancial(Request $request) {
        $data = [
            'history' => Billing::getExtendedHistory(Auth::id()),
            'pay_result' => $request->pay_result,
        ];
        return view('admin.billing.history', $data);
	}

	public function getSubscriptions(Request $request) {
        return view('admin.billing.subscriptions_history');
	}

	public function createPay(Request $request) {
		return view('admin.billing.create');
	}

	public function createPayOut(Request $request) {
		return view('admin.billing.create_payout');
	}
	


	public function create_pay(Request $request)
	{
		Billing::addPayment($request->user_id, $request->sum, $request->comment, null);
		return response()->json(['status' => 1, 'text' => 'Начисление успешно добавлено']);
	}

	public function create_payout(Request $request)
	{
		Billing::addPayment($request->user_id, -$request->sum, $request->comment, null);
		return response()->json(['status' => 1, 'text' => 'Выплата успешно добавлена']);
	}


	//############## ТАРИФЫ И УСЛУГИ ##############
	public function getSaving(Request $request) {
		$user = Auth::user();
		$tariffs = config('tariffs');
		$data = [
			'request' => $request,
			'user' =>$user,
			'tariffs' => $tariffs,
		];
		return view('admin.billing.saving', $data);
	}
	public function getEarning(Request $request) {
		$user = Auth::user();
		$tariffs = config('tariffs');
		$data = [
			'request' => $request,
			'user' =>$user,
			'tariffs' => $tariffs,
		];
		return view('admin.billing.earning', $data);
	}




	//############## МОИ КАРТЫ ##############
	public function getCards(Request $request) {
		$user = Auth::user();
		$tariffs = config('tariffs');
		// получение номеров карт, баркода и qr-кода
		$user->num_card = Helpers::cсardNumberVusial( BillingCards::getCard($user->id, "ccard") );
		$user->num_barcode = BillingCards::getCard($user->id, "barcode");
		$user->num_qrcode = BillingCards::getCard($user->id, "qrcode");

		// данные для показа подарочных карт которые можно подарить
		$gifts = (object)Array();
		$gifts->cards_gifts1_left = BillingTariffs::getCardsGiftLeft($user, 'GOLD');
		$gifts->cards_gifts2_left = BillingTariffs::getCardsGiftLeft($user, 'BUSINESS START');

		$data = [
			'request' => $request,
			'user' =>$user,
			'tariffs' => $tariffs,
			'gifts' => $gifts,
		];
		return view('admin.billing.cards', $data);
	}



	//############## ПРИОБРЕТЕНИЕ УСЛУГИ  ##############
	public function getOrder(Request $request) {

		$user = Auth::user();
		$tariffs = config('tariffs');

		if (	empty($request->tariff) ||
			empty($tariffs[ $request->tariff ])
		) {
			//return redirect()->back();
			return redirect('admin/billing/services');
		}

		if ($user->tariff == $request->tariff) {
			return redirect('admin/billing/cards');
		}

		// подсчет стоимость тарифа при уcловии вычета цены предыдущего тарифа
		$price = $tariffs[ $request->tariff ]['price'] - $tariffs[ $user->tariff ]['price'];
		
		$data = [
			'request' => $request,
			'user' =>$user,
			'tariffs' => $tariffs,
			'balance' => Billing::getBalance($user->id),
			'price' => $price,
		];

		return view('admin.billing.order', $data);
	}
	//############## ПРИОБРЕТЕНИЕ УСЛУГИ ##############
	public function postOrder(Request $request) {

		$user = Auth::user();
		$tariffs = config('tariffs');

		if (	empty($request->tariff) ||
			empty($tariffs[ $request->tariff ])
		) {
			return redirect()->back();
		}

		if ($user->tariff == $request->tariff) {
			return redirect('admin/billing/cards');
		}

		//приобретение тарифа
		Billing::orderTariff($user, $tariffs[$request->tariff]);

		return redirect('admin/billing/cards');
	}






	//############## ОПЛАТА ##############
	public function postPaymentRobokassa(Request $request) {
        $sum = $request->sum;
        $threshold = 100;
        $minimumString = 'Минимальный платеж — не менее ' . $threshold . ' рублей.<BR>Оплаченные деньги будут просто добавлены на счёт, и их можно будет в будущем использовать на любые услуги сайта.';

        if ($sum < $threshold) {
            return response()->json(['errors' => ['sum' => $minimumString]], 422);
        }

        try {
//            return response()->json(['error' => 'test'], $sum);
            $url = Billing::getPaymentUrl(Auth::id(), $sum, 'Лицензионный платеж за право использования программы для ЭВМ');

        } catch (BillingException $e) {
            return response()->json(['error' => $e->getMessage()], 422);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка пополнения счёта. Попробуйте позже'], 422);
        }

        return response()->json(['url' => $url]);
	}






	//############## ОБРАБОТКА РОБОКАССЫ ##############
	public function postRobokassaResult(Request $request) {
        try {
            $robokassa = new Robokassa();
            $data = $robokassa->checkResult('result', $request);

            \DB::transaction(function() use ($data, $request) {
                $invoice = BillingInvoice::find($data->invoiceId);
                if (!$invoice) {
                    throw new BillingException('No invoice', BillingException::INVOICE_NOT_FOUND);
                }

                if ($invoice->processed == 'on') return $invoice;
                Billing::addPayment($invoice->user_id, $invoice->sum, 'Пополнение баланса через платёжный сервис Robokassa');
                $invoice->processed = 'on';
                $invoice->save();
            });

            print 'ok';

        } catch (\Exception $e) {
            print 'noooo';
        }
	}






	//############## ОТПРАВКА ПОДАРКА КАРТЫ В ПОДАРОК ##############
	public function postGiftcards(Request $request) {
		$user = Auth::user();
		$tariffs = config('tariffs');

		// валидация переданных данных
		$request->validate([
			'tariff' => ['required'],
			'gift' => ['required'],
			'email' => ['required', 'email'],
		]);
		if (!isset($tariffs[$request->tariff])) {
			return response()->json(['result' => 'error']);
		}

		//проверка у дарителя лимита на подарки
		$total = BillingTariffs::getCardsGiftLeft($user, $request->tariff);
		if ($total <= 0) {
			return response()->json(['result' => 'total', 'gift' => $request->gift]);
		}

		// поиск юзера по емейл
		$toUser = User::where('email', $request->email)->orderBy('id', 'desc')->first();
		if (empty($toUser)) {
			return response()->json(['result' => 'notfound', 'gift' => $request->gift]);
		}

		// проверка подарка самому себе
		if ($toUser->id == $user->id) {
			return response()->json(['result' => 'myselt', 'gift' => $request->gift]);
		}

		// проверки у юзера его текущего тарифа
		if ($request->tariff == 'GOLD' && (
			$toUser->tariff=='GOLD' ||
			$toUser->tariff=='BUSINESS START' ||
			$toUser->tariff=='BUSINESS OPTIMUM' ||
			$toUser->tariff=='BUSINESS MAX'
			)
		) {return response()->json(['result' => 'notariff', 'gift' => $request->gift]);}
		if ($request->tariff == 'BUSINESS START' && (
			$toUser->tariff=='BUSINESS START' ||
			$toUser->tariff=='BUSINESS OPTIMUM' ||
			$toUser->tariff=='BUSINESS MAX'
			)
		) {return response()->json(['result' => 'notariff', 'gift' => $request->gift]);}

		//приобретение тарифа для юзера
		Billing::orderTariff($toUser, $tariffs[$request->tariff], false, $user->id);

		return response()->json(['result' => 'success']);
	}
	

	//############## ИСТОРИЯ ##############
	public function get_history(Request $request)
	{
		$user = User::find($request->user_id);
		if ($user->role_id == 1000) {
			$billing_history = Billing::with('orderer', 'user')->get();
		}
		else {
			$billing_history = Billing::with('orderer')->where('user_id', $user->id)->get();
		}
		$total_come = 0;
		$balance = 0;
		foreach ($billing_history as $item)
		{
			$balance = $balance + $item->sum;
			if ($item->sum > 0) {
				$total_come = $total_come + $item->sum;
			}
		}
		$total = [
			'come' => $total_come,
			'balance' => $balance,
		];
		return response()->json(['status' => 1, 'history' => $billing_history, 'total' => $total]);
	}

	//############## АБОНЕМЕНТЫ ##############
	public function get_subscriptions_history(Request $request)
	{
		$user = User::find($request->user_id);
		$items = Billing::with('customer_subscription', 'user')->where('customer_subscription_id', '>', 0);
		$orders = Orderer::where('customer_subscription_id', '>', 0);
		$history = array();

		if ($user->role_id == 101) {
			$items->where('user_id', $user->id);
			$customers = Customer::where('user_id', $user->id)->get();
			$customers_id = array();
			foreach ($customers as $customer)
			{
				array_push($customers_id, $customer->id);
			}
			$orders->whereIn('customer_id', $customers_id);
		}
		else {
			$billing_items = $items->get();
			$orderers = $orders->get();
			foreach ($billing_items as $billing_item)
			{
				array_push($history, $billing_item);
			}
			foreach ($orderers as $order) 
			{
				$subscription = CustomerSubscription::find($order->customer_subscription_id);
				if (!empty($subscription))
				{
					$order_user = User::find($order->customer->user_id);
					$item = array(
						'created' => $order->date_time,
						'sum' => $subscription->price/$subscription->number_of_paid_orderers,
						'description' => 'Оплата по абонементу',
						'orderer_id' => $order->id,
						'user' => $order_user,
					);
					array_push($history, $item);
				}
			}
		}
		return response()->json(['status' => 1, 'history' => $history]);
	}


}
