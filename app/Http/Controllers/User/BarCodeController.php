<?php

namespace App\Http\Controllers\User;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Group;
use Spatie\Color\Hex;
use App\Models\Barcode;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BarCodeController extends Controller
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

    // All User Bar Codes
    public function index()
    {
        // Check active plans
        $active_plan = Plan::where('id', Auth::user()->plan_id)->where('status', '!=', 2)->first();

        // Check user plan
        $plan = User::where('id', Auth::user()->id)->first();

        // Check plan
        if ($active_plan != null) {
            // Get User Bar Codes
            $bar_codes = Barcode::leftJoin('groups', 'barcodes.group_id', '=', 'groups.group_id')->select('barcodes.*', 'groups.group_name')->where('barcodes.user_id', Auth::user()->id)->where('barcodes.status', '!=', 2)->orderBy('barcodes.id', 'desc')->get();
            $settings = Setting::where('status', 1)->first();

            // View page
            return view('user.pages.bar-codes.index', compact('bar_codes', 'settings'));
        } else {
            // Page redirect in plan is not activated
            return redirect()->route('user.plans');
        }
    }

    // Create Bar Code
    public function CreateBarCode()
    {
        // Get user created bar code counts
        $bar_code_counts = Barcode::where('user_id', Auth::user()->id)->count();

        // Get plan details
        $plan = User::where('id', Auth::user()->id)->where('status', 1)->first();
        $plan_details = json_decode($plan->plan_details);

        // Check validity
        $validity = User::where('id', Auth::user()->id)->whereDate('plan_validity', '>=', Carbon::now())->count();

        // Check no of qrcodes
        if ($plan_details->no_barcodes == 999) {
            $no_barcodes = 999999;
        } else {
            $no_barcodes = $plan_details->no_barcodes;
        }

        // Check user created qr code count
        if ($validity == 1) {
            if ($bar_code_counts < $no_barcodes) {
                // Groups
                $groups = Group::where('user_id', Auth::user()->id)->where('status', 1)->orderBy('id', 'desc')->get();

                return view('user.pages.bar-codes.create', compact('groups'));
            } else {
                return redirect()->route('user.all.barcode')->with('failed', trans('Maximum barcode creation limit is exceeded, Please upgrade your plan.'));
            }
        } else {
            // Redirect
            return redirect()->route('user.all.barcode')->with('failed', trans('Your plan is over. Choose your plan renewal or new package and use it.'));
        }
    }

    // Save bar code
    public function saveBarCode(Request $request)
    {
        // Generate barcode id
        $barcode_id = uniqid();

        // Show text
        $showtext = true;
        if ($request->showtext == null) {
            $showtext = false;
        }

        // Generate barcode
        $result = $request->barcode_type::getBarcodeSVG($request->content, $request->barcode_format, $request->width, $request->height, $request->color, $showtext);

        // Generate settings
        $settings =  json_encode(array(
            "barcode_type" => $request->barcode_type,
            "barcode_format" => $request->barcode_format,
            "content" => $request->content,
            "width" => $request->width,
            "height" => $request->height,
            "color" => $request->color,
            "showtext" => $request->showtext
        ));

        // Save Bar Code
        $barcode = new Barcode();
        $barcode->group_id = $request->group;
        $barcode->barcode_id = $barcode_id;
        $barcode->user_id = Auth::user()->id;
        $barcode->name = $request->name;
        $barcode->bar_code = $result;
        $barcode->settings = $settings;
        $barcode->save();

        // Redirect url
        return redirect()->route('user.download.barcode', $barcode_id)->with('success', trans('Barcode created successfully.'));
    }

    // Edit Barcode
    public function editBarCode($id)
    {
        // Queries
        $barcode_details = Barcode::where('barcode_id', $id)->where('user_id', Auth::user()->id)->first();
        $groups = Group::where('user_id', Auth::user()->id)->where('status', 1)->orderBy('id', 'desc')->get(); 

        // Check data
        if ($barcode_details) {
            return view('user.pages.bar-codes.edit', compact('groups', 'barcode_details'));
        } else {
            return redirect()->route('user.all.barcode')->with('failed', trans('No data available'));
        }
    }

    // Update bar code
    public function updateBarCode(Request $request)
    {
        // Show text
        $showtext = true;
        if ($request->showtext == null) {
            $showtext = false;
        }

        // Generate barcode
        $result = $request->barcode_type::getBarcodeSVG($request->content, $request->barcode_format, $request->width, $request->height, $request->color, $showtext);

        // Generate settings
        $settings =  json_encode(array(
            "barcode_type" => $request->barcode_type,
            "barcode_format" => $request->barcode_format,
            "content" => $request->content,
            "width" => $request->width,
            "height" => $request->height,
            "color" => $request->color,
            "showtext" => $request->showtext
        ));

        // Update barcode
        Barcode::where('barcode_id', $request->barcode_id)->where('user_id', Auth::user()->id)->update([
            'group_id' => $request->group, 'name' => $request->name, 'bar_code' => $result, "settings" => $settings
        ]);

        // Redirect url
        return redirect()->back()->with('success', trans('Barcode updated successfully.'));
    }

    // Update Barcode Status
    public function updateBarCodeStatus(Request $request)
    {
        // Get barcode details
        $barcode_details = Barcode::where('barcode_id', $request->query('id'))->where('user_id', Auth::user()->id)->first();

        // Check data
        if ($barcode_details) {
            if ($barcode_details == null) {
                return view('errors.404');
            } else {
                // Get user created qr code count
                $barcode_count = Barcode::where('user_id', Auth::user()->id)->where('status', 1)->count();

                // Get plan details
                $plan = User::where('id', Auth::user()->id)->where('status', 1)->first();
                $plan_details = json_decode($plan->plan_details);

                // Check validity
                $validity = User::where('id', Auth::user()->id)->whereDate('plan_validity', '>=', Carbon::now())->count();

                // Check no of qrcodes
                if ($plan_details->no_barcodes == 999) {
                    $no_barcodes = 999999;
                } else {
                    $no_barcodes = $plan_details->no_barcodes;
                }

                // Check user created barcode count
                if ($validity == 1) {
                    if ($barcode_count < $no_barcodes) {
                        // Check status
                        if ($barcode_details->status == 0) {
                            $status = 1;
                        } else {
                            $status = 0;
                        }

                        // Update status
                        Barcode::where('barcode_id', $request->query('id'))->where('user_id', Auth::user()->id)->update(['status' => $status]);
                        
                        return redirect()->back()->with('success', trans('Barcode Status Updated Successfully!'));
                    } else {
                        // Update status
                        Barcode::where('barcode_id', $request->query('id'))->where('user_id', Auth::user()->id)->update(['status' => 0]);

                        return redirect()->back()->with('failed', trans('Maximum barcode creation limit is exceeded, Please upgrade your plan.'));
                    }
                } else {
                    // Redirect
                    return redirect()->back()->with('failed', trans('Your plan is over. Choose your plan renewal or new package and use it.'));
                }
            }
        } else {
            return redirect()->route('user.all.barcode')->with('failed', trans('No data available'));
        }
    }

    // Delete Barcode
    public function deleteBarCode(Request $request)
    {
        // Update status
        Barcode::where('barcode_id', $request->query('id'))->where('user_id', Auth::user()->id)->update([
            'status' => 2
        ]);

        return redirect()->back()->with('success', trans('Barcode Deleted Successfully!'));
    }

    // Download Barcode
    public function downloadBarCode($id)
    {
        // Queries
        $barcode_details = Barcode::where('barcode_id', $id)->where('user_id', Auth::user()->id)->first();

        // Check data
        if ($barcode_details) {
            return view('user.pages.bar-codes.download', compact('barcode_details'));
        } else {
            return redirect()->route('user.all.barcode')->with('failed', trans('No data available'));
        }
    }

    // Regenerate Barcode
    public function regenerateBarCode(Request $request)
    {
        // Show text
        $showtext = true;
        if ($request->showtext == "false") {
            $showtext = false;
        }

        // Default content
        $content = '9876543210';
        if ($request->content) {
            $content = $request->content;
        }

        // Generate barcode
        $result = base64_encode($request->barcode_type::getBarcodeSVG($content, $request->barcode_format, $request->width, $request->height, $request->color, $showtext));

        // Redirect url
        return response()->json(['source' => "data:image/svg+xml;base64," . $result]);
    }
}
