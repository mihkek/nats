<?php

    namespace Mirronix\LogGlobal\Traits;

    use Mirronix\LogGlobal\Models\LogGlobal;
    use App\Libs\Helpers;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;

    trait LogGlobalTrait {
        public function save(array $options = []) {
            if (!empty($this->attributes[$this->primaryKey])) {
                $changedData = [];
                foreach ($this->attributes as $field => $value) {
                    if (($this->original[$field] ?? '') != $value) {
                        $changedData[] = [
                            'created' => date('Y-m-d H:i:s'),
                            'model' => static::class,
                            'model_id' => $this->attributes[$this->primaryKey] ?? 0,
                            'user_id' => Auth::id(),
                            'field' => $field,
                            'old_value' => $this->original[$field] ?? '',
                            'new_value' => $value,
                        ];
                    }
                }

                if (count($changedData)) {
                    LogGlobal::insert($changedData);
                }
            }

            parent::save($options);
        }

        public static function getChangeLog(array $params = []) {
            $query = LogGlobal::where('model', static::class);
            $params = array_merge(['take' => 100, 'orderBy' => ['created', 'desc']], $params);

            foreach (array_intersect(array_keys($params), ['model_id', 'user_id', 'field']) as $key) {
                $query->where($key, $params[$key]);
            }

            foreach (array_intersect(array_keys($params), ['take', 'skip', 'orderBy']) as $key) {
                call_user_func_array([$query, $key], is_array($params[$key]) ? $params[$key] : [$params[$key]]);
            }

            if (empty($params['compact'])) {
                return $query->get();

            } else {
                $data = [];
                $fields = [];
                if (method_exists(static::class, 'getFields')) {
                    foreach (static::getFields() as $field) {
                        $fields[$field['code']] = $field['name'];
                    }
                }

                foreach ($query->get() as $q) {
                    if (!isset($data[$q->created])) {
                        $data[$q->created] = [
                            'user' => $q->user ? $q->user->only('id', 'name', 'avatar', 'email') : $q->user_id,
                            'fields' => [],
                            'created' => $q->created,
                            'createdVerbal' => Helpers::DateTime($q->created, true),
                        ];
                    }

                    $data[$q->created]['fields'][] = [
                        'name' => $fields[$q->field] ?? $q->field,
                        'old' => $q->old_value,
                        'new' => $q->new_value,
                    ];
                }

                ksort($data);
                return array_values($data);
            }
        }
    }
