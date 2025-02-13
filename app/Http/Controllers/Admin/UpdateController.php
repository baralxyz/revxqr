<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use App\Models\Config;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request as serverReq;

class UpdateController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // Check
    public function check()
    {
        // Queries
        $settings = Setting::first();
        $config = Config::get();

        // Check verison
        if (!isset($config[40]->id)) {
            $filecode = str_replace(".", "", $config[33]->config_value);
            if (file_exists(app_path("./Classes/UltimateQrUpdater$filecode.php"))) {
                $baseClassName = "\App\Classes\UltimateQrUpdater";
                $dynamicClassName = $baseClassName . $filecode;
                if (class_exists($dynamicClassName)) {
                    $dynamicClass = new $dynamicClassName();
                    $dynamicClass->runUpdate();
                }
            }
        }

        return view('admin.pages.update.index', compact('settings', 'config'));
    }

    // Check Update
    public function checkUpdate(Request $request)
    {
        // Queries
        $config = Config::get();

        // Default message
        $resp_data = [];
        $errorMessage = trans("Something went wrong! Please contact author support team.");
        $server_name = serverReq::server("SERVER_NAME");
        $server_name = $server_name ? $server_name : "LOCAL.TEST";

        // Check update validator
        $client = new \GuzzleHttp\Client();
        $res = $client->post('https://verify.nativecode.in/check-update', [
            'form_params' => [
                'purchase_code' => $config[32]->config_value,
                'server_name' => $server_name,
                'version' => $config[33]->config_value
            ]
        ]);

        $resp_data = json_decode($res->getBody(), true);

        if ($resp_data) {
            if ($resp_data['status'] == true) {
                // Queries
                $settings = Setting::first();
                $purchase_code = $config[32]->config_value;

                // Response
                $response = ['message' => $resp_data['message'], 'version' => $resp_data['version'], 'update' => $resp_data['update'], 'notes' => $resp_data['notes']];
                return view('admin.pages.update.index', compact('response', 'settings', 'purchase_code', 'config'));
            } else {
                $errorMessage = $resp_data['message'];
                return redirect()->back()->with('failed', $errorMessage);
            }
        } else {
            return redirect()->back()->with('failed', $errorMessage);
        }
    }

    // Update code
    public function updateCode(Request $request)
    {
        // Queries
        $config = Config::get();
        
        // Default message
        $resp_data = [];
        $errorMessage = trans("Something went wrong! Please contact author support team.");
        $server_name = serverReq::server("SERVER_NAME");
        $server_name = $server_name ? $server_name : "LOCAL.TEST";

        // Check update validator
        $client = new \GuzzleHttp\Client();
        $res = $client->post('https://verify.nativecode.in/update-code', [
            'form_params' => [
                'purchase_code' => $config[32]->config_value,
                'server_name' => $server_name,
                'version' => $config[33]->config_value
            ]
        ]);

        // Get status code is "200
        if ($res->getStatusCode() == 200) {
            // Get file
            $download = uniqid();
            file_put_contents(public_path($download . '.zip'), $res->getBody());

            // ZipArchive
            $unzip = new ZipArchive;
            $out = $unzip->open($download . '.zip');

            if ($out === TRUE) {
                // Exact zip
                $unzip->extractTo('../');
                $unzip->close();
                // Delete zip
                unlink($download . '.zip');

                $filecode = str_replace(".", "", $request->app_version);
                if (file_exists(app_path("./Classes/UltimateQrUpdater$filecode.php"))) {
                    $baseClassName = "\App\Classes\UltimateQrUpdater";
                    $dynamicClassName = $baseClassName . $filecode;
                    if (class_exists($dynamicClassName)) {
                        $dynamicClass = new $dynamicClassName();
                        $dynamicClass->runUpdate();
                    }
                }

                // Update version
                Config::where('config_key', 'app_version')->update([
                    'config_value' => $request->app_version,
                ]);

                // Success message and redirect
                return redirect()->route('admin.check')->with('success', trans('New version installed successfully.'));
            } else {
                // Failed message and redirect
                return redirect()->route('admin.check')->with('failed', trans('Installation failed.'));
            }
        } else {
            // Success message and redirect
            $resp_data = json_decode($res->getBody(), true);
            return redirect()->route('admin.check')->with('failed', $resp_data['message']);
        }

        // Failed message and redirect
        return redirect()->route('admin.check')->with('failed', trans('Purchase code verified failed.'));
    }
}
