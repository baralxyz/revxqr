<?php

namespace App\Http\Controllers\User;

use App\Models\QrCode;
use App\Models\Setting;
use App\Models\Statistics;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;

class StatisticsController extends Controller
{
    // Dynamic link
    public function dynamicLink(Request $request, $id)
    {
        // Check custom url found 
        $qrcode_count = QrCode::where('qr_code_id', $id)->count();

        // count
        if ($qrcode_count >= 1) {
            // Queries
            $qrcode_details = QrCode::where('qr_code_id', $id)->first();

            // User ip address
            $ip = $request->ip();

            // Get location details
            $location = geoip()->getLocation($ip);

            // Get User Agent
            $agent = new Agent();
            $agent->setHttpHeaders($ip);

            // Set user lang
            $agentLang = "EN";
            if (isset($agent->languages()[1])) {
                $agentLang = $agent->languages()[1];
            }

            // Queries
            $settings = Setting::where('status', 1)->first();

            echo '<script async src="https://www.googletagmanager.com/gtag/js?id='.$settings->google_analytics_id.'"
            type="b3a3e2ad58df728c3930cf27-text/javascript"></script>
            <script type="b3a3e2ad58df728c3930cf27-text/javascript">
                window.dataLayer = window.dataLayer || [];
                function gtag(){dataLayer.push(arguments);}
                gtag("js", new Date());
        
                gtag("config", '.$settings->google_analytics_id.');
            </script>';

            // Save statistics
            $statistics = new Statistics();
            $statistics->qr_code_id = $id;
            $statistics->iso_code = $location->iso_code;
            $statistics->country_code = $location->country;
            $statistics->os_name = $agent->platform();
            $statistics->browser_name = $agent->browser();
            $statistics->city_name = $location->city;
            $statistics->referrer_host = "direct";
            $statistics->referrer_path = "";
            $statistics->device_type = $agent->device();
            $statistics->browser_language = $agentLang;
            $statistics->save();

            return Redirect::to(json_decode($qrcode_details->settings)->url_value);
        } else {
            return redirect()->route('user.dashboard')->with('failed', trans('URL not found.'));
        }
    }

    // View Statistics
    public function qrStatistics(Request $request, $id)
    {
        // Get Country wise count
        $countries = Statistics::where('qr_code_id', $id)
            ->groupBy('country_code')
            ->get(DB::raw('count(*) as total, statistics.country_code, statistics.iso_code'));

        // Get Reffer wise count
        $referrer_hosts = Statistics::where('qr_code_id', $id)
            ->groupBy('referrer_host')
            ->get(DB::raw('count(*) as total, statistics.referrer_host'));

        // Get Device wise count
        $device_types = Statistics::where('qr_code_id', $id)
            ->groupBy('device_type')
            ->get(DB::raw('count(*) as total, statistics.device_type'));

        // Get Operacting System wise count
        $os_names = Statistics::where('qr_code_id', $id)
            ->groupBy('os_name')
            ->get(DB::raw('count(*) as total, statistics.os_name'));

        // Get Browsers wise count
        $browser_names = Statistics::where('qr_code_id', $id)
            ->groupBy('browser_name')
            ->get(DB::raw('count(*) as total, statistics.browser_name'));

        // Get Languages wise count
        $browser_languages = Statistics::where('qr_code_id', $id)
            ->groupBy('browser_language')
            ->get(DB::raw('count(*) as total, statistics.browser_language'));

        return view('user.pages.statistics.index', compact('countries', 'referrer_hosts', 'device_types', 'os_names', 'browser_names', 'browser_languages'));
    }
}
