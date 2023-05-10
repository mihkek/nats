<?php

    namespace Mirronix\TranslationManager\Libs;

    class TranslationManager {

        public function storeKey($locale, $key, $value) {
            $keyParts = explode('.', $key);
            list ($fileKey, $inKey) = $keyParts;

            $languageFile = resource_path('lang/' . $locale . '/' . $fileKey . '.php');
            if (file_exists($languageFile)) {
                $data = include $languageFile;
            } else {
                $data = [];
            }

            if (empty($value)) {
                unset($data[$inKey]);
            } else {
                $data[$inKey] = $value;
            }


            $dataStr = var_export($data, true);
            $dataStr = preg_replace('#\)$#', ']', $dataStr);
            $dataStr = preg_replace('#^array \(#', '[', $dataStr);

            $dataStr = <<<EOT
<?php

return $dataStr;
EOT;

            if (!file_exists(dirname($languageFile))) {
                mkdir(dirname($languageFile), 0775);
                chmod(dirname($languageFile), 0775);
            }

            file_put_contents($languageFile, $dataStr);
        }
    }