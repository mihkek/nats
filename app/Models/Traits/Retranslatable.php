<?php

    namespace App\Models\Traits;

    use Dimsav\Translatable\Translatable;

    trait Retranslatable {
        use Translatable {
            getNewTranslation as getNewTranslationDimsav;
        }

        public function getNewTranslation($locale) {
            $storeData = parent::only($this->translatedAttributes);
            $translation = $this->getNewTranslationDimsav($locale);
            $translation->fill($storeData);

            return $translation;
        }
    }