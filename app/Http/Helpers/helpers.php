<?php

use App\Enums\Setting as EnumsSetting;
use Carbon\Carbon;
use App\Models\User;
use App\Models\UserImage;
use App\Models\UserNetwork;
use App\Models\Bonus;
use App\Models\BonusLog;
use App\Models\Prospect;
use App\Models\Serial;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if (!function_exists('generate_otp')) {
    function generate_otp()
    {
        return random_int(1234, 9899);
    }
}

if (!function_exists('getIpInfo')) {

    function getIpInfo()
    {
        $ip = $_SERVER["REMOTE_ADDR"];

        //Deep detect ip
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        $xml = @simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=" . $ip);

        $country = @$xml->geoplugin_countryName;
        $city = @$xml->geoplugin_city;
        $area = @$xml->geoplugin_areaCode;
        $code = @$xml->geoplugin_countryCode;
        $long = @$xml->geoplugin_longitude;
        $lat = @$xml->geoplugin_latitude;

        $data['country'] = $country;
        $data['city'] = $city;
        $data['area'] = $area;
        $data['code'] = $code;
        $data['long'] = $long;
        $data['lat'] = $lat;
        $data['ip'] = request()->ip();
        $data['time'] = date('d-m-Y h:i:s A');

        return $data;
    }
}

if (!function_exists('getOsBrowser')) {

    function getOsBrowser()
    {
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        $osPlatform = "Unknown OS Platform";
        $osArray = array(
            '/windows nt 10/i' => 'Windows 10',
            '/windows nt 6.3/i' => 'Windows 8.1',
            '/windows nt 6.2/i' => 'Windows 8',
            '/windows nt 6.1/i' => 'Windows 7',
            '/windows nt 6.0/i' => 'Windows Vista',
            '/windows nt 5.2/i' => 'Windows Server 2003/XP x64',
            '/windows nt 5.1/i' => 'Windows XP',
            '/windows xp/i' => 'Windows XP',
            '/windows nt 5.0/i' => 'Windows 2000',
            '/windows me/i' => 'Windows ME',
            '/win98/i' => 'Windows 98',
            '/win95/i' => 'Windows 95',
            '/win16/i' => 'Windows 3.11',
            '/macintosh|mac os x/i' => 'Mac OS X',
            '/mac_powerpc/i' => 'Mac OS 9',
            '/linux/i' => 'Linux',
            '/ubuntu/i' => 'Ubuntu',
            '/iphone/i' => 'iPhone',
            '/ipod/i' => 'iPod',
            '/ipad/i' => 'iPad',
            '/android/i' => 'Android',
            '/blackberry/i' => 'BlackBerry',
            '/webos/i' => 'Mobile'
        );
        foreach ($osArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $osPlatform = $value;
            }
        }
        $browser = "Unknown Browser";
        $browserArray = array(
            '/msie/i' => 'Internet Explorer',
            '/firefox/i' => 'Firefox',
            '/safari/i' => 'Safari',
            '/chrome/i' => 'Chrome',
            '/edge/i' => 'Edge',
            '/opera/i' => 'Opera',
            '/netscape/i' => 'Netscape',
            '/maxthon/i' => 'Maxthon',
            '/konqueror/i' => 'Konqueror',
            '/mobile/i' => 'Handheld Browser'
        );
        foreach ($browserArray as $regex => $value) {
            if (preg_match($regex, $userAgent)) {
                $browser = $value;
            }
        }

        $data['os_platform'] = $osPlatform;
        $data['browser'] = $browser;

        return $data;
    }
}

if (!function_exists('formatWhatsappNumber')) {
    function formatWhatsappNumber($number) {
        if ($number != NULL || $number != "") {
            $split = str_split($number);
            if ($split[0] == 0) {
                $split[0] = '62';
                $number = implode('', $split);
            }
        }
        return $number;
    }
}

if (!function_exists('now_time')) {
    function now_time()
    {
        return Carbon::now()->tz(env('TIMEZONE'));
    }
}

if (!function_exists('active_menu')) {
    function active_menu(array $names)
    {
        if (in_array(request()->segment(1), $names)) {
            return 'active';
        }
    }
}

if (!function_exists('show_menu')) {
    function show_menu(array $names)
    {
        if (in_array(request()->segment(1), $names)) {
            return 'show';
        }
    }
}

if (!function_exists('getRealIP')) {
    function getRealIP() {
        $ip = $_SERVER["REMOTE_ADDR"];
        //Deep detect ip
        if (filter_var(@$_SERVER['HTTP_FORWARDED'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED'];
        }
        if (filter_var(@$_SERVER['HTTP_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_X_REAL_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        if (filter_var(@$_SERVER['HTTP_CF_CONNECTING_IP'], FILTER_VALIDATE_IP)) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
        if ($ip == '::1') {
            $ip = '127.0.0.1';
        }

        return $ip;
    }
}

if (!function_exists('generate_message')) {
    function generate_message(\Throwable $th, $error_production) {
        $message = $th->getMessage() . ' ' . $th->getLine() . ' ' . $th->getFile();
        if (env('APP_ENV') == 'production') return $error_production;

        return $message;
    }
}

if (!function_exists('base64url_encode')) {
    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}

if (!function_exists('base64url_decode')) {
    function base64url_decode($data) {
        return base64_decode(str_pad(strtr($data, '-_', '+/'), 4 - ((strlen($data) % 4) ?: 4), '=', STR_PAD_RIGHT));
    }
}

if (!function_exists('get_lang_code')) {
    function get_lang_code() {
        return config('app.locale');
    }
}

if (!function_exists('set_collection_key')) {
    function set_collection_key($data) {
        $out = [];
        foreach ($data as $key => $d) {
            $out[] = $d;
            $out[$key]['key'] = $key + 1;
        }

        return collect($out);
    }
}
