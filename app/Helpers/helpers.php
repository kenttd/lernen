<?php

use Amentotech\MeetFusion\Facades\MeetFusion;
use Amentotech\LaraGuppy\Services\MessagesService;
use Amentotech\LaraGuppy\Services\ThreadsService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Amentotech\LaraPayEase\Facades\PaymentDriver;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\Country;
use App\Models\User;
use App\Services\SiteService;
use App\Services\UserService;
use Illuminate\Support\Facades\File;


if (!function_exists('isActivePackage')) {
    function isActivePackage($name = '') {
        switch ($name) {    
            case 'upcertify':
                return class_exists('Amentotech\UpCertify\UpCertifyServiceProvider');
            default:
                return false;
        }
    }
}

/**
 *get site info
 *
 * @return response()
 */
if (! function_exists('getSiteInfo')) {

    function getSiteInfo()
    {

        $site_name      = setting('_site.site_name');
        $site_favicon   = setting('_site.site_favicon');
        $site_dark_logo = setting('_site.site_dark_logo');
        $site_lite_logo = setting('_site.site_lite_logo');

        if (!empty($site_favicon)) {
            $site_favicon   = $site_favicon[0]['path'];
        }

        if (!empty($site_dark_logo)) {
            $site_dark_logo  = $site_dark_logo[0]['path'];
        }

        if (!empty($site_lite_logo)) {
            $site_lite_logo  = $site_lite_logo[0]['path'];
        }

        $data = [
            'site_name'         => !empty($site_name)   ? $site_name : '',
            'site_favicon'      => $site_favicon,
            'site_dark_logo'    => $site_dark_logo,
            'site_lite_logo'    => $site_lite_logo,
        ];

        return $data;
    }
}

/**
 * Helper function to sanitize a string value from user input
 *
 * @param string    $string          String to sanitize.
 * @param bool      $keep_linebreak  Not compulsory Whether to keep newlines or not. Default: false.
 * @return string   Sanitized string.
 */

if (!function_exists('sanitizeTextField')) {

    function sanitizeTextField($string, $keep_linebreak = false)
    {


        if (is_object($string) || is_array($string)) {
            return '';
        }

        $string     = (string) $string;
        $filtered   = checkValidUTF8($string);

        // Decode HTML entities to handle encoded entries
        $filtered = html_entity_decode($filtered, ENT_QUOTES | ENT_HTML5, 'UTF-8');

        if (strpos($filtered, '<') !== false) {

            // This will strip extra whitespace.
            $filtered = stripAllTags($filtered, false);

            // Use HTML entities in a special case to make sure no later
            // newline stripping stage could lead to a functional tag.
            $filtered = str_replace("<\n", "&lt;\n", $filtered);
        }

        if (! $keep_linebreak) {
            $filtered = preg_replace('/[\r\n\t ]+/', ' ', $filtered);
        }
        $filtered = trim($filtered);

        $found = false;
        while (preg_match('/%[a-f0-9]{2}/i', $filtered, $match)) {
            $filtered = str_replace($match[0], '', $filtered);
            $found    = true;
        }

        if ($found) {
            // Strip out the whitespace that may now exist after removing the octets.
            $filtered = trim(preg_replace('/ +/', ' ', $filtered));
        }

        $filtered = clean($filtered, ['Attr.EnableID' => true]);

        return $filtered;
    }
}

if (!function_exists('SanitizeArray')) {

    function SanitizeArray(&$arr)
    {

        foreach ($arr as $key => &$el) {

            if (is_array($el)) {
                SanitizeArray($el);
            } else {
                $el = sanitizeTextField($el, true);
            }
        }
        return  $arr;
    }
}

/**
 * Checks for valid UTF8 or not in a string.
 *
 * @param string $string The text which is to be checked.
 * @return string Checked the text.
 */
if (!function_exists('checkValidUTF8')) {

    function checkValidUTF8($string_text)
    {

        $string_text = (string) $string_text;

        if (0 === strlen($string_text)) {
            return '';
        }

        // Store the site charset as a static to avoid multiple calls to get_option().
        static $isUtf8 = null;
        if (! isset($isUtf8)) {
            $isUtf8 = in_array('UTF-8', array('utf8', 'utf-8', 'UTF8', 'UTF-8'), true);
        }

        if (! $isUtf8) {
            return $string_text;
        }

        // Check for support for utf8 in the installed PCRE library once and store the result in a static.
        static $utf8Pcre = null;
        if (! isset($utf8Pcre)) {
            $utf8Pcre = @preg_match('/^./u', 'a');
        }

        // We can't demand utf8 in the PCRE installation, so just return the string in those cases.
        if (! $utf8Pcre) {
            return $string_text;
        }

        //  -- preg_match fails when it encounters invalid UTF8 in $string.
        if (1 === @preg_match('/^./us', $string_text)) {
            return $string_text;
        }

        return '';
    }
}

/**
 * Properly strip all HTML tags including script and style
 *
 * This differs from strip_tags() because it removes the contents of
 * the `<script>` and `<style>` tags. E.g. `strip_tags( '<script>something</script>' )`
 * will return 'something'. stripAllTags will return ''
 *
 * @param string $string        String containing HTML tags
 * @param bool   $remove_breaks Optional. Whether to remove left over line breaks and white space chars
 * @return string The processed string.
 */
if (!function_exists('stripAllTags')) {

    function stripAllTags($string, $remove_breaks_tag = false)
    {

        $string = preg_replace('@<(script|style)[^>]*?>.*?</\\1>@si', '', $string);
        $string = strip_tags($string, '<h1><h2><h3><h4><h5><6><div><b><strong><i><em><a><ul><ol><li><p><br><span><figure><sup><sub><table><tr><th><td><tbody><iframe><form><capture><label><fieldset><section>');

        if ($remove_breaks_tag) {
            $string = preg_replace('/[\r\n\t ]+/', ' ', $string);
        }
        return trim($string);
    }
}
if (!function_exists('uniqueImageName')) {

    function uniqueImageName($image, $uniqueString)
    {
        $extension = pathinfo($image, PATHINFO_EXTENSION);
        $image = Str::replace(' ', '-', $image);
        return  substr($image, 0, strrpos($image, '.')) . '-' . $uniqueString . '.' . $extension;
    }
}

if (!function_exists('joinExts')) {
    function joinExts($allowedExts = array(), $withDot = false)
    {
        if ($withDot)
            return join(",", array_map(function ($ext) {
                return ('.' . $ext);
            }, $allowedExts));
        else
            return join(",", $allowedExts);
    }
}


if (!function_exists('fileValidationText')) {
    function fileValidationText($ext)
    {
        $lastElement = array_pop($ext);
        $text = implode(', ', $ext);
        $text .= ' ' . __('general.or') . ' ' . $lastElement;
        return $text;
    }
}

if (!function_exists('uniqueFileName')) {

    function uniqueFileName($fileUrl, $name)
    {
        $path = storage_path('app/') . $fileUrl . '/' . $name;
        $parts = pathinfo($path);
        $dirName = $parts['dirname'];
        $name = $parts["filename"];
        $ext = $parts["extension"];
        $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $name));
        $i = 0;
        while (file_exists($dirName . '/' . $sanitizedName . '.' . $ext)) {
            $i++;
            $sanitizedName = $sanitizedName . " (" . $i . ")";
        }
        return $sanitizedName . '-' . Str::random(8) . '.' . $ext;
    }
}

/**
 * Upload base64 image into custom storage folder.
 *
 * @param string $dirName   Required. Directory name
 * @param string $imageUrl  Required. Base64 image string
 * @return array The process of array record
 */
if (! function_exists('uploadImage')) {

    function uploadImage($dirName, $imageUrl)
    {

        $random_key     = Str::random(5) . time();
        $file_ext       = ".png";
        $directoryUrl   = storage_path('app/public/' . $dirName);

        $i = 0;
        while (file_exists($directoryUrl . '/' . $random_key . $file_ext)) {
            $i++;
            $random_key = $random_key . "(" . $i . ")";
        }

        $fileName           = $random_key . $file_ext;
        $path               = $directoryUrl . '/' . $fileName;

        if (!is_dir($directoryUrl)) {
            mkdir($directoryUrl);
        }

        $storeFile = file_put_contents($path, file_get_contents($imageUrl));

        if ($storeFile) {
            return $dirName . '/' . $fileName;
        }

        return '';
    }
}

if (!function_exists('parseToUTC')) {

    function parseToUTC($date)
    {
        return Carbon::parse($date, getUserTimezone())->setTimezone('UTC');
    }
}

if (!function_exists('parseToUserTz')) {

    function parseToUserTz($date, $timeZone = null)
    {
        $tz = $timeZone ?? getUserTimezone();
        return Carbon::parse($date, 'UTC')->setTimezone($tz);
    }
}

if (!function_exists('calculatePercentageOfHour')) {

    function calculatePercentageOfHour($time)
    {
        $minutesPast = $time->minute + ($time->second / 60);
        return round(($minutesPast / 60) * 100);
    }
}

if (!function_exists('getEndOfWeek')) {

    function getEndOfWeek($startOfWeek)
    {
        return match ((int) $startOfWeek) {
            Carbon::SUNDAY => Carbon::SATURDAY,
            default        => Carbon::SUNDAY
        };
    }
}

if (!function_exists('getSession')) {

    function getSession($time)
    {
        if ($time->format('H:i') < '12:00')
            return 'morning';
        elseif ($time->format('H:i') >= '12:00' && $time->format('H:i') <= '17:00')
            return 'afternoon';
        else
            return 'evening';
    }
}

if (!function_exists('getEmailTemplates')) {

    function getEmailTemplates()
    {
        $templates = array();
        $templates = include "email-templates.php";
        return $templates;
    }
}

if (!function_exists('getRoleByName')) {

    function getRoleByName($name)
    {

        $role = Cache::rememberForever('getRoleByName-' . $name . '-cache', function () use ($name) {
            return DB::table('roles')->select('id')->where('name', $name)->get()->first();
        });
        if ($role) {
            return $role->id;
        }
    }
}

if (!function_exists('generatePassword')) {
    function generatePassword($length = 8)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@_*-!';
        $charLength = strlen($characters);
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, $charLength - 1)];
        }

        return $password;
    }
}

if (!function_exists('resizedImage')) {

    function resizedImage(string $image, int $width, int $height)
    {
        if (!Storage::disk('public')->exists($image))
            return "";
        $image_new = 'thumbnails/' . uniqueImageName($image, $width . 'x' . $height);
        $path = '';
        $directories = explode('/', dirname($image_new));

        foreach ($directories as $directory) {
            if (!$path) {
                $path = $directory;
            } else {
                $path = $path . '/' . $directory;
            }

            if (!Storage::disk('public')->exists($path)) {
                Storage::disk('public')->makeDirectory($path);
            }
        }

        if (!Storage::disk('public')->exists($image_new)) {
            $image = Image::read(Storage::disk('public')->path($image));
            $image->cover($width, $height)->save(Storage::disk('public')->path($image_new));
        }

        return url(Storage::disk('public')->url($image_new));
    }
}

/**
 *get user role
 *
 * @return response()
 */
if (! function_exists('getUserRole')) {

    function getUserRole()
    {

        $userId         = session()->get('userId');
        $profileId      = session()->get('profileId');
        $roleId         = session()->get('roleId');
        $roleName       = session()->get('roleName');

        if (!empty($userId) && !empty($profileId) && !empty($roleId) && !empty($roleName)) {
            return [
                'userId'        => $userId,
                'profileId'     => $profileId,
                'roleId'        => $roleId,
                'roleName'      => $roleName
            ];
        } elseif (Auth::user()) {
            $Auth       = Auth::user();
            $role       = $Auth->roles()->first();
            $profile    = $Auth->profile()->select('id')->where('user_id',  $Auth->id)->first();
            $data = [
                'userId'        => $Auth->id,
                'profileId'     => $profile?->id ?? '',
                'roleId'        => $role?->id ?? '',
                'roleName'      => $role?->name ?? ''
            ];

            session()->put($data);
            return $data;
        }
    }
}

/**
 *get file_path
 *
 * @return response()
 */
if (! function_exists('getProfileImageURL')) {
    function getProfileImageURL($file, $image_dimension)
    {
        $file_url     = null;
        $imageData  = !is_array($file) ? @unserialize($file) : $file;

        if ($imageData == 'b:0;' || $imageData !== false) {
            $file_url           = !empty($imageData[$image_dimension]) ? $imageData[$image_dimension] : null;
        } else {
            $file_url = $file;
        }

        return $file_url;
    }
}

if (!function_exists('getCurrencySymbol')) {
    function getCurrencySymbol() {
        $currency = setting('_general.currency') ?? 'USD';
        $currencyDetail        = !empty( $currency) ? currencyList($currency) : array();
        $currencySymbol        = '$';
        if (!empty($currencyDetail['symbol'])) {
            $currencySymbol = $currencyDetail['symbol'];
        }
        return $currencySymbol;
    }
}

if (!function_exists('formatAmount')) {
    function formatAmount($amount)
    {
        return getCurrencySymbol() . (string) number_format($amount, 2);
    }
}

if (!function_exists('allowFileExt')) {
    function allowFileExt($extensions)
    {
        $ext = is_array($extensions) ? $extensions : explode(',', $extensions);

        if (count($ext) > 1) {
            $lastElement = array_pop($ext);
            return strtoupper(implode(', ', $ext)) . ' ' .  __('general.or') . ' '  . strtoupper($lastElement);
        }
        return '';
    }
}

if (!function_exists('timeLeft')) {
    function timeLeft($timestamp, $timezone = null)
    {
        $date = parseToUserTz($timestamp, $timezone);
        $now  = parseToUserTz(now(), $timezone);
        $diff = $now->diff($date);
        return sprintf('%dD:%02dH:%02dM', $diff->d, $diff->h, $diff->i);
    }
}

if (!function_exists('getUserTimezone')) {
    function getUserTimezone($user = null)
    {

        if (empty($user)) {
            $user = Auth::user();
        }

        $tz = $user?->id ? Cache::rememberForever('userTimeZone_' . $user->id, function () use ($user) {
            return current($user->accountSetting()?->where('meta_key', 'timezone')->pluck('meta_value')->first() ?? []);
        }) : null;

        if ($tz)
            return $tz;
        else
            return setting('_general.timezone') ?? config('app.timezone');
    }
}


/**
 *get price format
 *
 * @return response()
 */
if (! function_exists('getPriceFormat')) {

    function getPriceFormat($symbol, $price)
    {
        $price = $symbol . number_format($price, 2);
        return $price;
    }
}

/**
 *get role by name
 *
 * @return response()
 */
if (!function_exists('getRoleByName')) {

    function getRoleByName($name)
    {

        $role = Cache::rememberForever('getRoleByName-' . $name . '-cache', function () use ($name) {
            return DB::table('roles')->select('id')->where('name', $name)->get()->first();
        });
        if ($role) {
            return $role->id;
        }
    }
}
/**
 * commission range list
 *
 * @param string $code code
 * @return array
 */
if (!function_exists('commissionRange')) {

    function commissionRange($type = 'fixed', $symbol = '')
    {

        $hourly_price_rnage = $fixed_price_range = [];

        $range = [500, 1000, 2000, 3000, 4000, 5000, 10000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 90000, 100000, 100001];

        for ($j = 0; $j < count($range); $j++) {

            $min = $range[$j] == 500 ? 1 : $range[$j - 1];
            $max = $range[$j];
            $key = $min . '-' . $max;

            if ($max == 100001) {
                $fixed_price_range[$min . '-'] = __('settings.maximum_range', ['value' => $symbol . number_format(100000)]);
            } else {
                $fixed_price_range[$key] = $symbol . number_format($min) . ' - ' . $symbol . number_format($max);
            }
        }

        for ($i = 0; $i <= 150; $i += 10) {
            $min = $i == 0 ? 1 : $i;
            $max = $i + 10;
            $key = $min . '-' . $max;
            if ($min == 150) {
                $hourly_price_rnage[$min . '-'] = __('settings.maximum_range', ['value' => $symbol . number_format(150)]);
            } else {
                $hourly_price_rnage[$key] = $symbol . number_format($min) . ' - ' . $symbol . number_format($max);
            }
        }

        return $type == 'fixed' ? $fixed_price_range : $hourly_price_rnage;
    }
}


/**
 *get country short_code
 *
 * @return string
 */
if (!function_exists('countryCode')) {
    function countryCode($country): string
    {
        $counrty = Country::where('name', ucwords($country))->select('short_code')->first();
        return $counrty?->short_code ?  strtolower($counrty?->short_code) : '';
    }
}

/**
 * Currency options for payment
 *
 * @param string $code code
 * @return array
 */
if (!function_exists('currencyOptionForPayment')) {

    function currencyOptionForPayment()
    {

        $currency_opt = [
            'USD' => __('settings.escrow_currency_opt_usd'),
            'EUR' => __('settings.escrow_currency_opt_eur'),
            'AUD' => __('settings.escrow_currency_opt_aud'),
            'GBP' => __('settings.escrow_currency_opt_gbp'),
            'CAD' => __('settings.escrow_currency_opt_cad'),
        ];
        return $currency_opt;
    }
}
/**
 * Currency options for payment
 *
 * @param string $code code
 * @return array
 */
if (!function_exists('inspectionPeriodOptions')) {

    function inspectionPeriodOptions()
    {

        $max_inspection_day_opt = 20;
        $inspection_day_opt = [];
        for ($i = 1; $i <= $max_inspection_day_opt; $i++) {
            $inspection_day_opt[$i] = $i == 1 ? __('settings.insp_period_opt_day1') : __('settings.insp_period_opt_day', ['day_count' => $i]);
        }
        return $inspection_day_opt;
    }
}
/**
 * Currency list
 *
 * @param string $code code
 * @return array
 */
if (!function_exists('currencyList')) {

    function currencyList($code = "")
    {

        $currency_array = array(
            'USD' => array(
                'numeric_code'  => 840,
                'code'          => 'USD',
                'name'          => 'United States dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent[D]',
                'decimals'      => 2
            ),
            'AED' => array(
                'numeric_code'  => 784,
                'code'          => 'AED',
                'name'          => 'United Arab Emirates dirham',
                'symbol'        => 'د.إ',
                'fraction_name' => 'Fils',
                'decimals'      => 2
            ),
            'AFN' => array(
                'numeric_code'  => 971,
                'code'          => 'AFN',
                'name'          => 'Afghan afghani',
                'symbol'        => '؋',
                'fraction_name' => 'Pul',
                'decimals'      => 2
            ),
            'ALL' => array(
                'numeric_code'  => 8,
                'code'          => 'ALL',
                'name'          => 'Albanian lek',
                'symbol'        => 'L',
                'fraction_name' => 'Qintar',
                'decimals'      => 2
            ),
            'AMD' => array(
                'numeric_code'  => 51,
                'code'          => 'AMD',
                'name'          => 'Armenian dram',
                'symbol'        => 'դր.',
                'fraction_name' => 'Luma',
                'decimals'      => 2
            ),
            'AMD' => array(
                'numeric_code'  => 51,
                'code'          => 'AMD',
                'name'          => 'Armenian dram',
                'symbol'        => 'դր.',
                'fraction_name' => 'Luma',
                'decimals'      => 2
            ),
            'ANG' => array(
                'numeric_code'  => 532,
                'code'          => 'ANG',
                'name'          => 'Netherlands Antillean guilder',
                'symbol'        => 'ƒ',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'AOA' => array(
                'numeric_code'  => 973,
                'code'          => 'AOA',
                'name'          => 'Angolan kwanza',
                'symbol'        => 'Kz',
                'fraction_name' => 'Cêntimo',
                'decimals'      => 2
            ),
            'ARS' => array(
                'numeric_code'  => 32,
                'code'          => 'ARS',
                'name'          => 'Argentine peso',
                'symbol'        => '$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'AUD' => array(
                'numeric_code'  => 36,
                'code'          => 'AUD',
                'name'          => 'Australian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'AWG' => array(
                'numeric_code'  => 533,
                'code'          => 'AWG',
                'name'          => 'Aruban florin',
                'symbol'        => 'ƒ',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'AZN' => array(
                'numeric_code'  => 944,
                'code'          => 'AZN',
                'name'          => 'Azerbaijani manat',
                'symbol'        => 'AZN',
                'fraction_name' => 'Qəpik',
                'decimals'      => 2
            ),
            'BAM' => array(
                'numeric_code'  => 977,
                'code'          => 'BAM',
                'name'          => 'Bosnia and Herzegovina convertible mark',
                'symbol'        => 'КМ',
                'fraction_name' => 'Fening',
                'decimals'      => 2
            ),
            'BBD' => array(
                'numeric_code'  => 52,
                'code'          => 'BBD',
                'name'          => 'Barbadian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'BDT' => array(
                'numeric_code'  => 50,
                'code'          => 'BDT',
                'name'          => 'Bangladeshi taka',
                'symbol'        => '৳',
                'fraction_name' => 'Paisa',
                'decimals'      => 2
            ),
            'BGN' => array(
                'numeric_code'  => 975,
                'code'          => 'BGN',
                'name'          => 'Bulgarian lev',
                'symbol'        => 'лв',
                'fraction_name' => 'Stotinka',
                'decimals'      => 2
            ),
            'BHD' => array(
                'numeric_code'  => 48,
                'code'          => 'BHD',
                'name'          => 'Bahraini dinar',
                'symbol'        => 'ب.د',
                'fraction_name' => 'Fils',
                'decimals'      => 3
            ),
            'BIF' => array(
                'numeric_code'  => 108,
                'code'          => 'BIF',
                'name'          => 'Burundian franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'BMD' => array(
                'numeric_code'  => 60,
                'code'          => 'BMD',
                'name'          => 'Bermudian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'BND' => array(
                'numeric_code'  => 96,
                'code'          => 'BND',
                'name'          => 'Brunei dollar',
                'symbol'        => '$',
                'fraction_name' => 'Sen',
                'decimals'      => 2
            ),
            'BND' => array(
                'numeric_code'  => 96,
                'code'          => 'BND',
                'name'          => 'Brunei dollar',
                'symbol'        => '$',
                'fraction_name' => 'Sen',
                'decimals'      => 2
            ),
            'BOB' => array(
                'numeric_code'  => 68,
                'code'          => 'BOB',
                'name'          => 'Bolivian boliviano',
                'symbol'        => 'Bs.',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'BRL' => array(
                'numeric_code'  => 986,
                'code'          => 'BRL',
                'name'          => 'Brazilian real',
                'symbol'        => 'R$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'BSD' => array(
                'numeric_code'  => 44,
                'code'          => 'BSD',
                'name'          => 'Bahamian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'BTN' => array(
                'numeric_code'  => 64,
                'code'          => 'BTN',
                'name'          => 'Bhutanese ngultrum',
                'symbol'        => 'BTN',
                'fraction_name' => 'Chertrum',
                'decimals'      => 2
            ),
            'BWP' => array(
                'numeric_code'  => 72,
                'code'          => 'BWP',
                'name'          => 'Botswana pula',
                'symbol'        => 'P',
                'fraction_name' => 'Thebe',
                'decimals'      => 2
            ),
            'BWP' => array(
                'numeric_code'  => 72,
                'code'          => 'BWP',
                'name'          => 'Botswana pula',
                'symbol'        => 'P',
                'fraction_name' => 'Thebe',
                'decimals'      => 2
            ),
            'BYR' => array(
                'numeric_code'  => 974,
                'code'          => 'BYR',
                'name'          => 'Belarusian ruble',
                'symbol'        => 'Br',
                'fraction_name' => 'Kapyeyka',
                'decimals'      => 2
            ),
            'BZD' => array(
                'numeric_code'  => 84,
                'code'          => 'BZD',
                'name'          => 'Belize dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'CAD' => array(
                'numeric_code'  => 124,
                'code'          => 'CAD',
                'name'          => 'Canadian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'CDF' => array(
                'numeric_code'  => 976,
                'code'          => 'CDF',
                'name'          => 'Congolese franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'CHF' => array(
                'numeric_code'  => 756,
                'code'          => 'CHF',
                'name'          => 'Swiss franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Rappen[I]',
                'decimals'      => 2
            ),
            'CLP' => array(
                'numeric_code'  => 152,
                'code'          => 'CLP',
                'name'          => 'Chilean peso',
                'symbol'        => '$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'CNY' => array(
                'numeric_code'  => 156,
                'code'          => 'CNY',
                'name'          => 'Chinese yuan',
                'symbol'        => '元',
                'fraction_name' => 'Fen[E]',
                'decimals'      => 2
            ),
            'COP' => array(
                'numeric_code'  => 170,
                'code'          => 'COP',
                'name'          => 'Colombian peso',
                'symbol'        => '$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'CRC' => array(
                'numeric_code'  => 188,
                'code'          => 'CRC',
                'name'          => 'Costa Rican colón',
                'symbol'        => '₡',
                'fraction_name' => 'Céntimo',
                'decimals'      => 2
            ),
            'CUC' => array(
                'numeric_code'  => 931,
                'code'          => 'CUC',
                'name'          => 'Cuban convertible peso',
                'symbol'        => '$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'CUP' => array(
                'numeric_code'  => 192,
                'code'          => 'CUP',
                'name'          => 'Cuban peso',
                'symbol'        => '$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'CVE' => array(
                'numeric_code'  => 132,
                'code'          => 'CVE',
                'name'          => 'Cape Verdean escudo',
                'symbol'        => 'Esc',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'CZK' => array(
                'numeric_code'  => 203,
                'code'          => 'CZK',
                'name'          => 'Czech koruna',
                'symbol'        => 'Kc',
                'fraction_name' => 'Haléř',
                'decimals'      => 2
            ),
            'DJF' => array(
                'numeric_code'  => 262,
                'code'          => 'DJF',
                'name'          => 'Djiboutian franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'DKK' => array(
                'numeric_code'  => 208,
                'code'          => 'DKK',
                'name'          => 'Danish krone',
                'symbol'        => 'kr',
                'fraction_name' => 'Øre',
                'decimals'      => 2
            ),
            'DKK' => array(
                'numeric_code'  => 208,
                'code'          => 'DKK',
                'name'          => 'Danish krone',
                'symbol'        => 'kr',
                'fraction_name' => 'Øre',
                'decimals'      => 2
            ),
            'DOP' => array(
                'numeric_code'  => 214,
                'code'          => 'DOP',
                'name'          => 'Dominican peso',
                'symbol'        => '$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'DZD' => array(
                'numeric_code'  => 12,
                'code'          => 'DZD',
                'name'          => 'Algerian dinar',
                'symbol'        => 'د.ج',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'EEK' => array(
                'numeric_code'  => 233,
                'code'          => 'EEK',
                'name'          => 'Estonian kroon',
                'symbol'        => 'KR',
                'fraction_name' => 'Sent',
                'decimals'      => 2
            ),
            'EGP' => array(
                'numeric_code'  => 818,
                'code'          => 'EGP',
                'name'          => 'Egyptian pound',
                'symbol'        => '£',
                'fraction_name' => 'Piastre[F]',
                'decimals'      => 2
            ),
            'ERN' => array(
                'numeric_code'  => 232,
                'code'          => 'ERN',
                'name'          => 'Eritrean nakfa',
                'symbol'        => 'Nfk',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'ETB' => array(
                'numeric_code'  => 230,
                'code'          => 'ETB',
                'name'          => 'Ethiopian birr',
                'symbol'        => 'ETB',
                'fraction_name' => 'Santim',
                'decimals'      => 2
            ),
            'EUR' => array(
                'numeric_code'  => 978,
                'code'          => 'EUR',
                'name'          => 'Euro',
                'symbol'        => '€',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'FJD' => array(
                'numeric_code'  => 242,
                'code'          => 'FJD',
                'name'          => 'Fijian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'FKP' => array(
                'numeric_code'  => 238,
                'code'          => 'FKP',
                'name'          => 'Falkland Islands pound',
                'symbol'        => '£',
                'fraction_name' => 'Penny',
                'decimals'      => 2
            ),
            'GBP' => array(
                'numeric_code'  => 826,
                'code'          => 'GBP',
                'name'          => 'British pound[C]',
                'symbol'        => '£',
                'fraction_name' => 'Penny',
                'decimals'      => 2
            ),
            'GEL' => array(
                'numeric_code'  => 981,
                'code'          => 'GEL',
                'name'          => 'Georgian lari',
                'symbol'        => 'ლ',
                'fraction_name' => 'Tetri',
                'decimals'      => 2
            ),
            'GHS' => array(
                'numeric_code'  => 936,
                'code'          => 'GHS',
                'name'          => 'Ghanaian cedi',
                'symbol'        => '₵',
                'fraction_name' => 'Pesewa',
                'decimals'      => 2
            ),
            'GIP' => array(
                'numeric_code'  => 292,
                'code'          => 'GIP',
                'name'          => 'Gibraltar pound',
                'symbol'        => '£',
                'fraction_name' => 'Penny',
                'decimals'      => 2
            ),
            'GMD' => array(
                'numeric_code'  => 270,
                'code'          => 'GMD',
                'name'          => 'Gambian dalasi',
                'symbol'        => 'D',
                'fraction_name' => 'Butut',
                'decimals'      => 2
            ),
            'GNF' => array(
                'numeric_code'  => 324,
                'code'          => 'GNF',
                'name'          => 'Guinean franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'GTQ' => array(
                'numeric_code'  => 320,
                'code'          => 'GTQ',
                'name'          => 'Guatemalan quetzal',
                'symbol'        => 'Q',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'GYD' => array(
                'numeric_code'  => 328,
                'code'          => 'GYD',
                'name'          => 'Guyanese dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'HKD' => array(
                'numeric_code'  => 344,
                'code'          => 'HKD',
                'name'          => 'Hong Kong dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'HNL' => array(
                'numeric_code'  => 340,
                'code'          => 'HNL',
                'name'          => 'Honduran lempira',
                'symbol'        => 'L',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'HRK' => array(
                'numeric_code'  => 191,
                'code'          => 'HRK',
                'name'          => 'Croatian kuna',
                'symbol'        => 'kn',
                'fraction_name' => 'Lipa',
                'decimals'      => 2
            ),
            'HTG' => array(
                'numeric_code'  => 332,
                'code'          => 'HTG',
                'name'          => 'Haitian gourde',
                'symbol'        => 'G',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'HUF' => array(
                'numeric_code'  => 348,
                'code'          => 'HUF',
                'name'          => 'Hungarian forint',
                'symbol'        => 'Ft',
                'fraction_name' => 'Fillér',
                'decimals'      => 2
            ),
            'IDR' => array(
                'numeric_code'  => 360,
                'code'          => 'IDR',
                'name'          => 'Indonesian rupiah',
                'symbol'        => 'Rp',
                'fraction_name' => 'Sen',
                'decimals'      => 2
            ),
            'ILS' => array(
                'numeric_code'  => 376,
                'code'          => 'ILS',
                'name'          => 'Israeli new sheqel',
                'symbol'        => '₪',
                'fraction_name' => 'Agora',
                'decimals'      => 2
            ),
            'INR' => array(
                'numeric_code'  => 356,
                'code'          => 'INR',
                'name'          => 'Indian rupee',
                'symbol'        => '₹',
                'fraction_name' => 'Paisa',
                'decimals'      => 2
            ),
            'IQD' => array(
                'numeric_code'  => 368,
                'code'          => 'IQD',
                'name'          => 'Iraqi dinar',
                'symbol'        => 'ع.د',
                'fraction_name' => 'Fils',
                'decimals'      => 3
            ),
            'IRR' => array(
                'numeric_code'  => 364,
                'code'          => 'IRR',
                'name'          => 'Iranian rial',
                'symbol'        => '',
                'fraction_name' => 'Dinar',
                'decimals'      => 2
            ),
            'ISK' => array(
                'numeric_code'  => 352,
                'code'          => 'ISK',
                'name'          => 'Icelandic króna',
                'symbol'        => 'kr',
                'fraction_name' => 'Eyrir',
                'decimals'      => 2
            ),
            'JMD' => array(
                'numeric_code'  => 388,
                'code'          => 'JMD',
                'name'          => 'Jamaican dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'JOD' => array(
                'numeric_code'  => 400,
                'code'          => 'JOD',
                'name'          => 'Jordanian dinar',
                'symbol'        => 'د.ا',
                'fraction_name' => 'Piastre[H]',
                'decimals'      => 2
            ),
            'JPY' => array(
                'numeric_code'  => 392,
                'code'          => 'JPY',
                'name'          => 'Japanese yen',
                'symbol'        => '¥',
                'fraction_name' => 'Sen[G]',
                'decimals'      => 2
            ),
            'KES' => array(
                'numeric_code'  => 404,
                'code'          => 'KES',
                'name'          => 'Kenyan shilling',
                'symbol'        => 'Sh',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'KGS' => array(
                'numeric_code'  => 417,
                'code'          => 'KGS',
                'name'          => 'Kyrgyzstani som',
                'symbol'        => 'KGS',
                'fraction_name' => 'Tyiyn',
                'decimals'      => 2
            ),
            'KHR' => array(
                'numeric_code'  => 116,
                'code'          => 'KHR',
                'name'          => 'Cambodian riel',
                'symbol'        => '៛',
                'fraction_name' => 'Sen',
                'decimals'      => 2
            ),
            'KMF' => array(
                'numeric_code'  => 174,
                'code'          => 'KMF',
                'name'          => 'Comorian franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'KPW' => array(
                'numeric_code'  => 408,
                'code'          => 'KPW',
                'name'          => 'North Korean won',
                'symbol'        => '',
                'fraction_name' => 'Chŏn',
                'decimals'      => 2
            ),
            'KRW' => array(
                'numeric_code'  => 410,
                'code'          => 'KRW',
                'name'          => 'South Korean won',
                'symbol'        => '',
                'fraction_name' => 'Jeon',
                'decimals'      => 2
            ),
            'KWD' => array(
                'numeric_code'  => 414,
                'code'          => 'KWD',
                'name'          => 'Kuwaiti dinar',
                'symbol'        => 'د.ك',
                'fraction_name' => 'Fils',
                'decimals'      => 3
            ),
            'KYD' => array(
                'numeric_code'  => 136,
                'code'          => 'KYD',
                'name'          => 'Cayman Islands dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'KZT' => array(
                'numeric_code'  => 398,
                'code'          => 'KZT',
                'name'          => 'Kazakhstani tenge',
                'symbol'        => '〒',
                'fraction_name' => 'Tiyn',
                'decimals'      => 2
            ),
            'LAK' => array(
                'numeric_code'  => 418,
                'code'          => 'LAK',
                'name'          => 'Lao kip',
                'symbol'        => '',
                'fraction_name' => 'Att',
                'decimals'      => 2
            ),
            'LBP' => array(
                'numeric_code'  => 422,
                'code'          => 'LBP',
                'name'          => 'Lebanese pound',
                'symbol'        => 'ل.ل',
                'fraction_name' => 'Piastre',
                'decimals'      => 2
            ),
            'LKR' => array(
                'numeric_code'  => 144,
                'code'          => 'LKR',
                'name'          => 'Sri Lankan rupee',
                'symbol'        => 'Rs',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'LRD' => array(
                'numeric_code'  => 430,
                'code'          => 'LRD',
                'name'          => 'Liberian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'LSL' => array(
                'numeric_code'  => 426,
                'code'          => 'LSL',
                'name'          => 'Lesotho loti',
                'symbol'        => 'L',
                'fraction_name' => 'Sente',
                'decimals'      => 2
            ),
            'LTL' => array(
                'numeric_code'  => 440,
                'code'          => 'LTL',
                'name'          => 'Lithuanian litas',
                'symbol'        => 'Lt',
                'fraction_name' => 'Centas',
                'decimals'      => 2
            ),
            'LVL' => array(
                'numeric_code'  => 428,
                'code'          => 'LVL',
                'name'          => 'Latvian lats',
                'symbol'        => 'Ls',
                'fraction_name' => 'Santims',
                'decimals'      => 2
            ),
            'LYD' => array(
                'numeric_code'  => 434,
                'code'          => 'LYD',
                'name'          => 'Libyan dinar',
                'symbol'        => 'ل.د',
                'fraction_name' => 'Dirham',
                'decimals'      => 3
            ),
            'MAD' => array(
                'numeric_code'  => 504,
                'code'          => 'MAD',
                'name'          => 'Moroccan dirham',
                'symbol'        => 'Dh',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'MDL' => array(
                'numeric_code'  => 498,
                'code'          => 'MDL',
                'name'          => 'Moldovan leu',
                'symbol'        => 'L',
                'fraction_name' => 'Ban',
                'decimals'      => 2
            ),
            'MGA' => array(
                'numeric_code'  => 969,
                'code'          => 'MGA',
                'name'          => 'Malagasy ariary',
                'symbol'        => 'MGA',
                'fraction_name' => 'Iraimbilanja',
                'decimals'      => 5
            ),
            'MKD' => array(
                'numeric_code'  => 807,
                'code'          => 'MKD',
                'name'          => 'Macedonian denar',
                'symbol'        => 'ден',
                'fraction_name' => 'Deni',
                'decimals'      => 2
            ),
            'MMK' => array(
                'numeric_code'  => 104,
                'code'          => 'MMK',
                'name'          => 'Myanma kyat',
                'symbol'        => 'K',
                'fraction_name' => 'Pya',
                'decimals'      => 2
            ),
            'MNT' => array(
                'numeric_code'  => 496,
                'code'          => 'MNT',
                'name'          => 'Mongolian tögrög',
                'symbol'        => '',
                'fraction_name' => 'Möngö',
                'decimals'      => 2
            ),
            'MOP' => array(
                'numeric_code'  => 446,
                'code'          => 'MOP',
                'name'          => 'Macanese pataca',
                'symbol'        => 'P',
                'fraction_name' => 'Avo',
                'decimals'      => 2
            ),
            'MRO' => array(
                'numeric_code'  => 478,
                'code'          => 'MRO',
                'name'          => 'Mauritanian ouguiya',
                'symbol'        => 'UM',
                'fraction_name' => 'Khoums',
                'decimals'      => 5
            ),
            'MUR' => array(
                'numeric_code'  => 480,
                'code'          => 'MUR',
                'name'          => 'Mauritian rupee',
                'symbol'        => '',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'MVR' => array(
                'numeric_code'  => 462,
                'code'          => 'MVR',
                'name'          => 'Maldivian rufiyaa',
                'symbol'        => 'ރ.',
                'fraction_name' => 'Laari',
                'decimals'      => 2
            ),
            'MWK' => array(
                'numeric_code'  => 454,
                'code'          => 'MWK',
                'name'          => 'Malawian kwacha',
                'symbol'        => 'MK',
                'fraction_name' => 'Tambala',
                'decimals'      => 2
            ),
            'MXN' => array(
                'numeric_code'  => 484,
                'code'          => 'MXN',
                'name'          => 'Mexican peso',
                'symbol'        => '$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'MYR' => array(
                'numeric_code'  => 458,
                'code'          => 'MYR',
                'name'          => 'Malaysian ringgit',
                'symbol'        => 'RM',
                'fraction_name' => 'Sen',
                'decimals'      => 2
            ),
            'MZN' => array(
                'numeric_code'  => 943,
                'code'          => 'MZN',
                'name'          => 'Mozambican metical',
                'symbol'        => 'MTn',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'NAD' => array(
                'numeric_code'  => 516,
                'code'          => 'NAD',
                'name'          => 'Namibian dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'NGN' => array(
                'numeric_code'  => 566,
                'code'          => 'NGN',
                'name'          => 'Nigerian naira',
                'symbol'        => '₦',
                'fraction_name' => 'Kobo',
                'decimals'      => 2
            ),
            'NIO' => array(
                'numeric_code'  => 558,
                'code'          => 'NIO',
                'name'          => 'Nicaraguan córdoba',
                'symbol'        => 'C$',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'NOK' => array(
                'numeric_code'  => 578,
                'code'          => 'NOK',
                'name'          => 'Norwegian krone',
                'symbol'        => 'kr',
                'fraction_name' => 'Øre',
                'decimals'      => 2
            ),
            'NPR' => array(
                'numeric_code'  => 524,
                'code'          => 'NPR',
                'name'          => 'Nepalese rupee',
                'symbol'        => '',
                'fraction_name' => 'Paisa',
                'decimals'      => 2
            ),
            'NZD' => array(
                'numeric_code'  => 554,
                'code'          => 'NZD',
                'name'          => 'New Zealand dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'OMR' => array(
                'numeric_code'  => 512,
                'code'          => 'OMR',
                'name'          => 'Omani rial',
                'symbol'        => 'ر.ع.',
                'fraction_name' => 'Baisa',
                'decimals'      => 3
            ),
            'PAB' => array(
                'numeric_code'  => 590,
                'code'          => 'PAB',
                'name'          => 'Panamanian balboa',
                'symbol'        => 'B/.',
                'fraction_name' => 'Centésimo',
                'decimals'      => 2
            ),
            'PEN' => array(
                'numeric_code'  => 604,
                'code'          => 'PEN',
                'name'          => 'Peruvian nuevo sol',
                'symbol'        => 'S/.',
                'fraction_name' => 'Céntimo',
                'decimals'      => 2
            ),
            'PGK' => array(
                'numeric_code'  => 598,
                'code'          => 'PGK',
                'name'          => 'Papua New Guinean kina',
                'symbol'        => 'K',
                'fraction_name' => 'Toea',
                'decimals'      => 2
            ),
            'PHP' => array(
                'numeric_code'  => 608,
                'code'          => 'PHP',
                'name'          => 'Philippine peso',
                'symbol'        => '₱',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'PKR' => array(
                'numeric_code'  => 586,
                'code'          => 'PKR',
                'name'          => 'Pakistani rupee',
                'symbol'        => 'PKR',
                'fraction_name' => 'Paisa',
                'decimals'      => 2
            ),
            'PLN' => array(
                'numeric_code'  => 985,
                'code'          => 'PLN',
                'name'          => 'Polish złoty',
                'symbol'        => 'zł',
                'fraction_name' => 'Grosz',
                'decimals'      => 2
            ),
            'PYG' => array(
                'numeric_code'  => 600,
                'code'          => 'PYG',
                'name'          => 'Paraguayan guaraní',
                'symbol'        => '',
                'fraction_name' => 'Céntimo',
                'decimals'      => 2
            ),
            'QAR' => array(
                'numeric_code'  => 634,
                'code'          => 'QAR',
                'name'          => 'Qatari riyal',
                'symbol'        => 'ر.ق',
                'fraction_name' => 'Dirham',
                'decimals'      => 2
            ),
            'RON' => array(
                'numeric_code'  => 946,
                'code'          => 'RON',
                'name'          => 'Romanian leu',
                'symbol'        => 'L',
                'fraction_name' => 'Ban',
                'decimals'      => 2
            ),
            'RSD' => array(
                'numeric_code'  => 941,
                'code'          => 'RSD',
                'name'          => 'Serbian dinar',
                'symbol'        => 'дин.',
                'fraction_name' => 'Para',
                'decimals'      => 2
            ),
            'RUB' => array(
                'numeric_code'  => 643,
                'code'          => 'RUB',
                'name'          => 'Russian ruble',
                'symbol'        => 'руб.',
                'fraction_name' => 'Kopek',
                'decimals'      => 2
            ),
            'RWF' => array(
                'numeric_code'  => 646,
                'code'          => 'RWF',
                'name'          => 'Rwandan franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'SAR' => array(
                'numeric_code'  => 682,
                'code'          => 'SAR',
                'name'          => 'Saudi riyal',
                'symbol'        => 'ر.س',
                'fraction_name' => 'Hallallah',
                'decimals'      => 2
            ),
            'SBD' => array(
                'numeric_code'  => 90,
                'code'          => 'SBD',
                'name'          => 'Solomon Islands dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'SCR' => array(
                'numeric_code'  => 690,
                'code'          => 'SCR',
                'name'          => 'Seychellois rupee',
                'symbol'        => '',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'SDG' => array(
                'numeric_code'  => 938,
                'code'          => 'SDG',
                'name'          => 'Sudanese pound',
                'symbol'        => 'ج.س',
                'fraction_name' => 'Piastre',
                'decimals'      => 2
            ),
            'SEK' => array(
                'numeric_code'  => 752,
                'code'          => 'SEK',
                'name'          => 'Swedish krona',
                'symbol'        => 'kr',
                'fraction_name' => 'Öre',
                'decimals'      => 2
            ),
            'SGD' => array(
                'numeric_code'  => 702,
                'code'          => 'SGD',
                'name'          => 'Singapore dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'SHP' => array(
                'numeric_code'  => 654,
                'code'          => 'SHP',
                'name'          => 'Saint Helena pound',
                'symbol'        => '£',
                'fraction_name' => 'Penny',
                'decimals'      => 2
            ),
            'SLL' => array(
                'numeric_code'  => 694,
                'code'          => 'SLL',
                'name'          => 'Sierra Leonean leone',
                'symbol'        => 'Le',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'SOS' => array(
                'numeric_code'  => 706,
                'code'          => 'SOS',
                'name'          => 'Somali shilling',
                'symbol'        => 'Sh',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'SRD' => array(
                'numeric_code'  => 968,
                'code'          => 'SRD',
                'name'          => 'Surinamese dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'STD' => array(
                'numeric_code'  => 678,
                'code'          => 'STD',
                'name'          => 'São Tomé and Príncipe dobra',
                'symbol'        => 'Db',
                'fraction_name' => 'Cêntimo',
                'decimals'      => 2
            ),
            'SVC' => array(
                'numeric_code'  => 222,
                'code'          => 'SVC',
                'name'          => 'Salvadoran colón',
                'symbol'        => '',
                'fraction_name' => 'Centavo',
                'decimals'      => 2
            ),
            'SYP' => array(
                'numeric_code'  => 760,
                'code'          => 'SYP',
                'name'          => 'Syrian pound',
                'symbol'        => '£',
                'fraction_name' => 'Piastre',
                'decimals'      => 2
            ),
            'SZL' => array(
                'numeric_code'  => 748,
                'code'          => 'SZL',
                'name'          => 'Swazi lilangeni',
                'symbol'        => 'L',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'THB' => array(
                'numeric_code'  => 764,
                'code'          => 'THB',
                'name'          => 'Thai baht',
                'symbol'        => '฿',
                'fraction_name' => 'Satang',
                'decimals'      => 2
            ),
            'TJS' => array(
                'numeric_code'  => 972,
                'code'          => 'TJS',
                'name'          => 'Tajikistani somoni',
                'symbol'        => 'ЅМ',
                'fraction_name' => 'Diram',
                'decimals'      => 2
            ),
            'TMM' => array(
                'numeric_code'  => 0,
                'code'          => 'TMM',
                'name'          => 'Turkmenistani manat',
                'symbol'        => 'm',
                'fraction_name' => 'Tennesi',
                'decimals'      => 2
            ),
            'TND' => array(
                'numeric_code'  => 788,
                'code'          => 'TND',
                'name'          => 'Tunisian dinar',
                'symbol'        => 'د.ت',
                'fraction_name' => 'Millime',
                'decimals'      => 3
            ),
            'TOP' => array(
                'numeric_code'  => 776,
                'code'          => 'TOP',
                'name'          => 'Tongan paʻanga',
                'symbol'        => 'T$',
                'fraction_name' => 'Seniti[J]',
                'decimals'      => 2
            ),
            'TRY' => array(
                'numeric_code'  => 949,
                'code'          => 'TRY',
                'name'          => 'Turkish lira',
                'symbol'        => 'TL',
                'fraction_name' => 'Kuruş',
                'decimals'      => 2
            ),
            'TTD' => array(
                'numeric_code'  => 780,
                'code'          => 'TTD',
                'name'          => 'Trinidad and Tobago dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'TWD' => array(
                'numeric_code'  => 901,
                'code'          => 'TWD',
                'name'          => 'New Taiwan dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'TZS' => array(
                'numeric_code'  => 834,
                'code'          => 'TZS',
                'name'          => 'Tanzanian shilling',
                'symbol'        => 'Sh',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'UAH' => array(
                'numeric_code'  => 980,
                'code'          => 'UAH',
                'name'          => 'Ukrainian hryvnia',
                'symbol'        => '',
                'fraction_name' => 'Kopiyka',
                'decimals'      => 2
            ),
            'UGX' => array(
                'numeric_code'  => 800,
                'code'          => 'UGX',
                'name'          => 'Ugandan shilling',
                'symbol'        => 'Sh',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'UYU' => array(
                'numeric_code'  => 858,
                'code'          => 'UYU',
                'name'          => 'Uruguayan peso',
                'symbol'        => '$',
                'fraction_name' => 'Centésimo',
                'decimals'      => 2
            ),
            'UZS' => array(
                'numeric_code'  => 860,
                'code'          => 'UZS',
                'name'          => 'Uzbekistani som',
                'symbol'        => 'UZS',
                'fraction_name' => 'Tiyin',
                'decimals'      => 2
            ),
            'VEF' => array(
                'numeric_code'  => 937,
                'code'          => 'VEF',
                'name'          => 'Venezuelan bolívar',
                'symbol'        => 'Bs F',
                'fraction_name' => 'Céntimo',
                'decimals'      => 2
            ),
            'VND' => array(
                'numeric_code'  => 704,
                'code'          => 'VND',
                'name'          => 'Vietnamese dong',
                'symbol'        => '₫',
                'fraction_name' => 'Hào[K]',
                'decimals'      => 10
            ),
            'VUV' => array(
                'numeric_code'  => 548,
                'code'          => 'VUV',
                'name'          => 'Vanuatu vatu',
                'symbol'        => 'Vt',
                'fraction_name' => 'None',
                'decimals'      => NULL
            ),
            'WST' => array(
                'numeric_code'  => 882,
                'code'          => 'WST',
                'name'          => 'Samoan tala',
                'symbol'        => 'T',
                'fraction_name' => 'Sene',
                'decimals'      => 2
            ),
            'XAF' => array(
                'numeric_code'  => 950,
                'code'          => 'XAF',
                'name'          => 'Central African CFA franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'XCD' => array(
                'numeric_code'  => 951,
                'code'          => 'XCD',
                'name'          => 'East Caribbean dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'XOF' => array(
                'numeric_code'  => 952,
                'code'          => 'XOF',
                'name'          => 'West African CFA franc',
                'symbol'        => 'FCFA',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'XPF' => array(
                'numeric_code'  => 953,
                'code'          => 'XPF',
                'name'          => 'CFP franc',
                'symbol'        => 'Fr',
                'fraction_name' => 'Centime',
                'decimals'      => 2
            ),
            'YER' => array(
                'numeric_code'  => 886,
                'code'          => 'YER',
                'name'          => 'Yemeni rial',
                'symbol'        => '',
                'fraction_name' => 'Fils',
                'decimals'      => 2
            ),
            'ZAR' => array(
                'numeric_code'  => 710,
                'code'          => 'ZAR',
                'name'          => 'South African rand',
                'symbol'        => 'R',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
            'ZMK' => array(
                'numeric_code'  => 894,
                'code'          => 'ZMK',
                'name'          => 'Zambian kwacha',
                'symbol'        => 'ZK',
                'fraction_name' => 'Ngwee',
                'decimals'      => 2
            ),
            'ZWR' => array(
                'numeric_code'  => 0,
                'code'          => 'ZWR',
                'name'          => 'Zimbabwean dollar',
                'symbol'        => '$',
                'fraction_name' => 'Cent',
                'decimals'      => 2
            ),
        );

        if (!empty($code) && array_key_exists($code, $currency_array)) {
            return $currency_array[$code];
        } else {
            return $currency_array;
        }
    }
}

// array:1 [▼ // app\Livewire\Frontend\Checkout.php:127
//   "stripe" => array:5 [▼
//     "status" => "on"
//     "currency" => "USD"
//     "exchange_rate" => ""
//     "stripe_key" => ""
//     "stripe_secret" => ""
//   ]
// ]

if (!function_exists('getGatewayObject')) {
    function getGatewayObject($gateway)
    {

        $data  = setting('admin_settings.payment_method');
        $settings = $data[$gateway] ?? null;
        $gateways = PaymentDriver::supportedGateways();
        if (!empty($data)) {
            $mode = !empty($settings['enable_test_mode']) ? 'test' : 'live';

            $keys = array_intersect_key($settings, $gateways[$gateway]['keys']);

            if ($gateway == 'payfast') {
                $keys['webhook_url'] = route('payfast.webhook');
            }

            $gatewayObj = PaymentDriver::{$gateway}();
            $gatewayObj->setKeys($keys);
            $gatewayObj->setCurrency($settings['currency'] ?? 'USD');
            $gatewayObj->setExchangeRate($settings['exchange_rate'] ?? '');
            $gatewayObj->setMode($mode);

            return $gatewayObj;
        } else {
            return '';
        }
    }
}

if (!function_exists('getMeetingObject')) {
    function getMeetingObject()
    {
        $service  = setting('_api.active_conference') ?? 'zoom';
        $confrences = MeetFusion::supportedConferences();
        if (!empty($service)) {
            $keys = [];
            foreach ($confrences[$service]['keys'] as $key => $value) {
                $keys[$key] = setting('_api.' . $service . "_" . $key);
            }
            $conferenceObj = MeetFusion::{$service}();
            $conferenceObj->setKeys($keys);
            return $conferenceObj;
        } else {
            return null;
        }
    }
}

if (!function_exists('isCalendarConnected')) {
    function isCalendarConnected($user = null)
    {
        if (empty($user) || !$user instanceof User) {
            $user = Auth::user();
        }

        $calendarSettings = (new UserService($user))->getAccountSetting('google_calendar_info')->toArray();

        if (!empty($calendarSettings) && !empty($calendarSettings['google_calendar_info']['id'])) {
            return true;
        }
        return false;
    }
}

if (! function_exists('uploadObMedia')) {
    function uploadObMedia($sourceImage)
    {
        $targetPath = 'optionbuilder/uploads';
        $filePath = explode('/', $sourceImage);
        $fileName = end($filePath);
        $sourceFile = public_path($sourceImage);
        $mimeType   = File::mimeType($sourceFile);
        $fileInfo = pathinfo($sourceFile);
        Storage::disk('public')->putFileAs($targetPath, $sourceFile, $fileName);
        if (substr($mimeType, 0, 5) == 'image') {
            return [
                'type'      => 'image',
                'name'      => $fileName,
                'path'      => 'optionbuilder/uploads/' . $fileName,
                'mime'      => $fileInfo['extension'] ?? '',
                'size'      => filesize($sourceFile),
                'thumbnail' => Storage::disk('public')->url($targetPath . '/' . $fileName),
            ];
        }
        return [
            'type'      => 'file',
            'name'      => $fileName,
            'path'      => 'optionbuilder/uploads/' . $fileName,
            'mime'      => $fileInfo['extension'] ?? '',
            'size'      => filesize($sourceFile),
            'thumbnail' => asset('vendor/optionbuilder/images/file-preview.png'),
        ];
    }
}

if (!function_exists('sendMessage')) {
    function sendMessage($to, $from, $message)
    {
        return (new MessagesService)->sendMessage($to, $from, $message);
    }
}

if (!function_exists('getUnreadMsgsCount')) {
    function getUnreadMsgsCount()
    {
        return (new ThreadsService)->getTotalUnreadMsgs();
    }
}

if (!function_exists('addBaseUrl')) {
    function addBaseUrl($text)
    {
        return preg_replace_callback('/href="([^"]+)"/', function ($matches) {
            $url = url($matches[1]);
            return 'href="' . $url . '"';
        }, $text);
    }
}

if (!function_exists('getMenu')) {
    function getMenu($location, $name = null)
    {
        return (new SiteService())->getSiteMenu($location, $name);
    }
}


if (!function_exists('getCommission')) {
    function getCommission($amount)
    {

        if (!empty(setting('admin_settings.commission_setting')['percentage'])) {
            $commissionPercentage = setting('admin_settings.commission_setting')['percentage']['value'] ?? 0;

            return number_format($amount * $commissionPercentage / 100, 2);
        }

        if (!empty(setting('admin_settings.commission_setting')['fixed'])) {
            return setting('admin_settings.commission_setting')['fixed']['value'] ?? 0;
        }

        return 0;
    }
}

if (!function_exists('isDemoSite')) {

    function isDemoSite()
    {

        $serverName = !empty($_SERVER["SERVER_NAME"]) ? $_SERVER["SERVER_NAME"] :  parse_url(config('app.url'), PHP_URL_HOST);
        if (in_array($serverName, array('lernen.codingeasel.com'))) {
            return true;
        } else {
            return false;
        }
    }
}

if (! function_exists('hierarchyTree')) {
    function hierarchyTree(&$arr)
    {

        foreach ($arr as $key => &$el) {

            $data = [
                'id'    => $el['id'],
                'title' => $el['name'],
            ];

            if (!empty($el['children']) && is_array($el['children'])) {
                $children = hierarchyTree($el['children']);
                $data['subs'] = $children;
            }
            $el = $data;
        }

        return  $arr;
    }
}
