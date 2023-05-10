<?php

    namespace App\Libs;

    use Illuminate\Support\Facades\Log;
    use Jose\Component\Core\AlgorithmManager;
    use Jose\Component\Core\JWK;
    use Jose\Component\Signature\Algorithm\HS256;
    use Jose\Component\KeyManagement\JWKFactory;
    use Jose\Component\Signature\JWSBuilder;
    use Jose\Component\Signature\Serializer\CompactSerializer;

    class ZoomUs {
        protected $config;

        public function __construct() {
            $this->config = (object) config('zoomus');
        }

        public function getUser($email) {
            $data = $this->request("users/$email");
        }

        public function createMeeting($email, $params) {
            $data = [
                'topic' => $params['name'] ?? 'Meeting',
                'type' => 2,
                'start_time' => str_replace(' ', 'T', $params['date_time']),
                'duration' => $params['duration'] ?? 60,
                'timezone' => 'Moscow',
            ];

            $data = $this->request("users/$email/meetings", $data, 'post');

            if (!empty($data->id)) {
                return (object) [
                    'id' => strval($data->id),
                    'url_start' => $data->start_url,
                    'url_join' => $data->join_url,
                ];
            } else {
                return null;
            }
        }

        public function updateMeeting($meetingId, $params) {
            $data = [
                'topic' => $params['name'] ?? 'Meeting',
                'type' => 2,
                'start_time' => str_replace(' ', 'T', $params['date_time']),
                'duration' => $params['duration'] ?? 60,
                'timezone' => 'Moscow',
            ];

            $data = $this->request("/meetings/$meetingId", $data, 'patch');
            return true;
        }

        public function getMeetings($email) {
            $data = $this->request("users/$email/meetings");
            return $data->meetings ?? [];
        }

        public function deleteMeeting($meetingId) {
            $this->request("meetings/$meetingId", [], 'delete');
        }

        public function request($point, $params = [], $method = 'get') {
            $url = $this->config->api_point . $point;
            $ch = curl_init();

            if ($method == 'post') {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            } else if ($method == 'patch') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            } else if ($method == 'delete') {
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            } else{
                if (!empty($params)) {
                    $url .= '?' . http_build_query($params);
                }
            }

            $authorization = "Authorization: Bearer " . $this->generateJWT();
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    $authorization,
                ],
            ]);

            Log::stack(['zoom'])->info($url);
            $result = curl_exec($ch);
            Log::stack(['zoom'])->info($result);
            curl_close($ch);

            return json_decode($result);
        }


        public function generateJWT() {
            $jwk = JWKFactory::createFromSecret(
                $this->config->api_secret,       // The shared secret
                [                      // Optional additional members
                    'alg' => 'HS256',
                    'use' => 'sig'
                ]
            );

            $algorithmManager = new AlgorithmManager([ new HS256() ]);
            $jwsBuilder = new JWSBuilder($algorithmManager);

            $payload = json_encode([
                'iat' => time(),
                'nbf' => time() - 86400,
                'exp' => time() + 3600,
                'iss' => $this->config->api_key,
            ]);

            $jws = $jwsBuilder
                ->create()                               // We want to create a new JWS
                ->withPayload($payload)                  // We set the payload
                ->addSignature($jwk, ['alg' => 'HS256']) // We add a signature with a simple protected header
                ->build();                               // We build it

            $serializer = new CompactSerializer();
            $token = $serializer->serialize($jws, 0);

            return $token;
        }
    }