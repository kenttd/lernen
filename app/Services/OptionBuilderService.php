<?php

namespace App\Services;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class OptionBuilderService {

    protected $publicTabKeys    = array();

    public function __construct() {
        $this->publicTabKeys = [
            '_general' => '*',
            '_email' => '*',
            '_lernen' => '*',
            '_social' => '*'
        ];
    }

    private function isPublicKey($tab, $key = null): bool {
        if (!empty($this->publicTabKeys[$tab])) {
            if ($this->publicTabKeys[$tab] == '*')
                return true;
            elseif (!empty($key) && in_array($key, $this->publicTabKeys[$tab]))
                return true;
            else
                return false;
        }
        return false;
    }



    public function getPublicKeys() {
        $settings   = $this->getSettings();
        $allSettings = [];
        if (!empty($settings)) {
            foreach ($settings as $section => $fields) {
                foreach ($fields as $settingKey => $value) {
                    if ($this->isPublicKey($section, $settingKey)) {
                        $allSettings[$section][$settingKey] = $this->decodeValue($value);
                    }
                }
            }
        }
        return $allSettings;
    }

    private function decodeValue($settingValue) {

        $value = @unserialize($settingValue);
        if ($value == 'b:0;' || $value !== false) {
            $temp = [];
            foreach ($value as $key => $data) {
                if (is_array($data)) {
                    $temp[$key] = self::jsonDecodedArr($data);
                } else {
                    if (self::isJSON($data)) {
                        $temp[$key] = json_decode($data, true);
                    } else {
                        $temp[$key] = $data;
                    }
                }
            }
            return $temp;
        } else {
            if (self::isJSON($settingValue)) {
                return (json_decode($settingValue, true));
            } else {
                return $settingValue;
            }
        }
    }

    /**
     * get json_decoded array
     * @param $arr Array
     * @param mixed String $value
     * @return Void
     */
    private function jsonDecodedArr(&$arr) {

        foreach ($arr as $key => &$el) {

            if (is_array($el)) {
                self::jsonDecodedArr($el);
            } else {
                if (self::isJSON($el)) {
                    $el = json_decode($el, true);
                }
            }
        }
        return  $arr;
    }
    /**
     * check string is json or not
     * @param $string String
     * @param mixed String $value
     * @return Void
     */
    private function isJSON($string) {

        return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }

    public function getSettings() {

        if (config('cache', true)) {
            return Cache::rememberForever('optionbuilder__settings', function () {
                return $this->fetchSettings();
            });
        } else {
            return $this->fetchSettings();
        }
    }


    /**
     * fetch From DB
     * @return array
     */
    private function fetchSettings() {

        $sections = [];
        $settings =  DB::table('optionbuilder__settings')->get();
        if (!empty($settings)) {
            foreach ($settings as $single) {
                $sections[$single->section][$single->key] = $single->value;
            }
        }
        return $sections;
    }

}
