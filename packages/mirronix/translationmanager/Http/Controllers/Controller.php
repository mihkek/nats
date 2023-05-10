<?php

namespace Mirronix\TranslationManager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Mirronix\TranslationManager\Libs\TranslationManager;


class Controller extends BaseController
{
    public function getTranslation(Request $request) {
        $key = $request->key;
        $cfg = config('localization-js');

        $data = [
            'translations' => [],
            'languages' => array_map(function($key) use ($cfg) {
                return ['id' => $key, 'name' => $cfg['languages_verbal'][$key] ?? '???'];
            }, $cfg['languages']),
        ];

        foreach ($cfg['languages'] as $language) {
            $str = __($key, [], $language);
            $data['translations'][$language] = $str == $key ? '' : $str;
        }

        return response()->json($data);
    }

    public function postTranslation(Request $request) {
        $user = auth()->guard('api')->user();

        if ($user->role_id == 1000) {
            $manager = new TranslationManager();
            foreach ($request->translations as $locale => $translation) {
                $manager->storeKey($locale, $request->key, $translation);
            }

            Artisan::call('lang:js', ['target' => public_path('js/lang.js')]);
        }

        return response()->json([]);
    }
}
