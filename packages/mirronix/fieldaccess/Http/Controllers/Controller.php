<?php

namespace Mirronix\FieldAccess\Http\Controllers;

use App\Models\ConfigerUsersRoles;
use App\Models\User;
use Mirronix\FieldAccess\Models\AccessManager;
use Mirronix\FieldAccess\Models\FieldsAccess;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;


class Controller extends BaseController
{
    public function getRoles(Request $request) {
	    $roles = ConfigerUsersRoles::orderBy('id')->get(['id', 'name']);
	    return response()->json(['roles' => $roles], 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getAccessData(Request $request) {
        $user = auth()->guard('api')->user();
        $accessManager = new AccessManager($user);
        $access = [
            'fields' => $accessManager->getUserFieldAccess(),
        ];

        if ($accessManager->canAccess(FieldsAccess::class, '*')) {
            $access['roles'] = ConfigerUsersRoles::orderBy('id')->where('id', '!=', $user->role_id)->get(['id', 'name']);
            $access['canAdmin'] = true;
        }

        if (User::isSuperUser()) {
            $access['canSuper'] = true;
        }

        $access['whoami'] = $user->id;

        return response()->json($access, 200, [], JSON_UNESCAPED_UNICODE);
    }


    public function getModelFields(Request $request) {
        $user = auth()->guard('api')->user();
        $accessManager = new AccessManager($user);
        $access = [];

        if ($accessManager->canAccess(FieldsAccess::class, '*')) {
            $access = $accessManager->getModelAccessBulk($request->model);
        }

        return response()->json($access, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function postModelFields(Request $request) {
        $user = auth()->guard('api')->user();
        $accessManager = new AccessManager($user);

        if ($accessManager->canAccess(FieldsAccess::class, '*') == 'write') {
            if ($request->model && $request->field && $request->access) {
                $accessManager->setFieldAccessBulk($request->model, $request->field, $request->access);
            }
        }

        return $this->getModelFields($request);
    }

    public function getTest(Request $request) {
        print 'this is a field access test';
    }
}

