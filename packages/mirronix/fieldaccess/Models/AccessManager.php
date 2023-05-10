<?php

    namespace Mirronix\FieldAccess\Models;

    use App\Models\User;

    class AccessManager {
        const FIELD_TYPE_STRING = 'string';
        const FIELD_TYPE_LIST = 'list';
        const FIELD_TYPE_AVATAR = 'avatar';

        protected $user = null;
        protected $fieldsAccess = null;

        public function __construct($user) {
            $this->user = $user;
        }

        public function canAccess($model, $field) {
            return ($this->getUserFieldAccess())[$model][$field] ?? null;
        }

        public function getModelFields($model) {
            $allFields = method_exists($model, 'getFields') ? $model::getFields() : [];
            $fieldAccess = $this->getUserFieldAccess();

            $fields = [];

            foreach ($allFields as $field) {
                $access = $fieldAccess[$field['code']] ?? $fieldAccess['*'] ?? null;
                if (!$access) continue;

                $field['access'] = $access;
                $fields[] = $field;
            }

            return $fields;
        }


        public function getRoleMenu($menu, $routes = null, $request = null) {
            $routes = $routes ?? app('router')->getRoutes();
            $request = $request ?? app('request');
            $validRoutes = [];

            foreach ($menu as $menuItem) {
                if (empty($menuItem->items)) {
                    try {
                        $routeName = $routes->match($request->create($menuItem->url))->getName();
                    } catch (\Exception $e) {
                        print "OMG" . $menuItem->url;
                        exit;
                    }
                    if ($routeName) {
                        if ($this->canAccess('access', $routeName) == 'disabled') {
                            continue;
                        }
                    }

                    $validRoutes[] = $menuItem;

                } else {
                    $subItems = $this->getRoleMenu($menuItem->items, $routes, $request);
                    if (count($subItems)) {
                        $menuItem->items = $subItems;
                        $validRoutes[] = $menuItem;
                    }
                }
            }

            return $validRoutes;
        }

        /*
        public function getWritableModelFields($model) {
            return array_filter(array_map(function($item) {
                return

            }, $this->getModelFields($model)), function($item) {
                return !!$item;
            });
        }
        */

        public function getModelAccessBulk($model) {
            $access = [];
            $query = FieldsAccess::where('model', $model);
            foreach ($query->get() as $q) {
                $access[$q->field][$q->role_id] = $q->access;
            }

            return $access;
        }

        public function getFieldAccessBulk($model, $field) {
            $access = [];
            $query = FieldsAccess::where('model', $model)->where('field', $field);
            foreach ($query->get() as $q) {
                $access[$q->role_id] = $q->access;
            }
            return $access;
        }

        public function setFieldAccessBulk($model, $field, $accessData) {
            FieldsAccess::where('model', $model)->where('field', $field)->delete();
            foreach ($accessData as $roleId => $access) {
                $this->setFieldAccess($model, $field, $roleId, $access);
            }
        }

        public function setFieldAccess($model, $field, $roleId, $access) {
            FieldsAccess::where('model', $model)->where('field', $field)->where('role_id', $roleId)->delete();
            $atom = new FieldsAccess();
            $atom->fill(['model' => $model, 'field' => $field, 'role_id' => $roleId, 'access' => $access]);
            $atom->save();
        }

        public function getUserFieldAccess() {
            if ($this->fieldsAccess === null) {
                $fields = [];
                if ($this->user) {
                    $query = FieldsAccess::where('role_id', $this->user->role_id);

                    foreach ($query->get() as $q) {
                        $fields[$q->model][$q->field] = $q->access;
                    }
                }

                $this->fieldsAccess = $fields;
            }

            return $this->fieldsAccess;
        }
    }
