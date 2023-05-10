<?php

    namespace App\Http\Composers;

//    use App\Models\Basket;
    use App\Models\Billing;
//    use App\Models\BlogItem;
//    use App\Models\Tag;
//    use App\Models\VideoLesson;
    use App\Models\User;
    use Illuminate\Support\Facades\App;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Auth;
    use App\Models\Documenter;
    use App\Models\Templater;
    use App\Libs\Helpers;
    use Illuminate\Support\Facades\Lang;
    use Mirronix\FieldAccess\Models\AccessManager;


    class CommonComposer {
    public static function compose($view) {
        $methodName = 'compose' . studly_case(join('-', preg_split('#[\._]#', $view->getName())));

        if (method_exists(__CLASS__, $methodName)) {
            static::$methodName($view);
        }
    }



	public static function composeAdminMenu(&$view) {
	  	$view->with('balance', Billing::getBalance(Auth::id()));
	}




	public static function composeAdminTemplate(&$view) {
        $user = Auth::user();

        $fieldAccess = new AccessManager($user);
        $menu = $fieldAccess->getRoleMenu(config('global.site_menu'));

        $translate = function(&$menu) use (&$translate) {
            foreach ($menu as &$item) {
                if (isset($item->name)) {
                    $item->name = Lang::has($item->name) ? __($item->name) : '<span class="no_translate">' . $item->name . '</span>';
                }
                if (!empty($item->items)) {
                    $item->items = $translate($item->items);
                }
            }

            return $menu;
        };

		$menuJson = json_encode($translate($menu), JSON_UNESCAPED_UNICODE);

		$balance = Billing::getBalance(Auth::id(), false); // true очищает кэш и  запрашивает БД, лучше только во время отладки
		$menuJson = preg_replace("/_BALANCE_/", Helpers::VerbalDigit($balance, "бонус", "бонуса", "бонусов", true), $menuJson);

		$view->with('balance', $balance);
		$view->with('menu', $menuJson);
		$view->with('menuActiveUrl', $_SERVER['REQUEST_URI']);
        $view->with('impersonated', User::isSuperUser() && User::isSuperUser() != $user->id);
	}




    public static function composeAdminPartnererPartnerMatrix(&$view) {
        $subUsers = Auth::user()->getSubUsers(8);
        $tarifs = [
            '' => ['prefix' => 'ZERO'],
            'STANDART' => ['prefix' => 'ST'],
            'GOLD' => ['prefix' => 'GOLD'],
            'BUSINESS START' => ['prefix' => 'BST'],
            'BUSINESS OPTIMUM' => ['prefix' => 'BO'],
            'BUSINESS МАХ' => ['prefix' => 'BM']
        ];

        $matrix = (object) ['levels' => [], 'tariffs' => [], 'total' => 0];
        $level = 0;

        foreach ($tarifs as $tarifCode => $tarif) {
            $matrix->tariffs[$tarifCode] = (object) [
                'prefix' => $tarif['prefix'],
                'count' => 0,
            ];
        }

        foreach ($subUsers as $subUserData) {
            $levelData = (object) ['level' => ++$level, 'total' => 0, 'tariffs' => [], 'isActive' => true];

            foreach ($tarifs as $tarifCode => $tarif) {
                $stat = (object) (isset($subUserData[$tarifCode]) ? ['count' => $subUserData[$tarifCode]->count] : ['count' => 0]);

                $levelData->tariffs[] = (object) [
                    'code' => $tarifCode,
                    'prefix' => $tarif['prefix'],
                    'count' => $stat->count,
                ];

                $levelData->total += $stat->count;
                $matrix->tariffs[$tarifCode]->count += $stat->count;
                $matrix->total += $stat->count;
            }

            $matrix->levels[] = $levelData;
        }

        $view->with('matrix', $matrix);
    }
}
