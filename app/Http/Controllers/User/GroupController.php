<?php

namespace App\Http\Controllers\User;

use App\Models\Group;
use App\Models\Barcode;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
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

    // All User Groups
    public function index()
    {
        // Get User groups
        $groups = Group::where('user_id', Auth::user()->id)->where('status', '!=', 2)->orderBy('id', 'desc')->get();
        $settings = Setting::where('status', 1)->first();

        // View page
        return view('user.pages.groups.index', compact('groups', 'settings'));
    }

    // Create Group
    public function CreateGroup()
    {
        return view('user.pages.groups.create');
    }

    // Save Group
    public function saveGroup(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->with('errors', $validator->messages()->all()[0])->withInput();
        }

        // Save Group
        $group = new Group();
        $group->group_id = uniqid();
        $group->user_id = Auth::user()->id;
        $group->group_name = $request->name;
        $group->save();

        return redirect()->route('user.create.group')->with('success', trans('Group created successfully.'));
    }

    // View group
    public function viewGroup(Request $request, $id)
    {
        // Check group id
        $groupId = $id;
        if ($id == "general") {
            $groupId = null;
        }

        // Get media images
        $groupBarcodes = Barcode::where('group_id', $groupId)->where('user_id', Auth::user()->id)->where('status', 1)->orderBy('id', 'desc')->paginate(8);
        $settings = Setting::where('status', 1)->first();

        // Check data 
        if ($groupBarcodes) {
            // View media
            return view('user.pages.groups.view', compact('groupBarcodes', 'settings'));
        } else {
            // Redirect
            return redirect()->route('user.all.groups')->with('failed', trans('No data available'));
        }
    }

    // Edit Group
    public function editGroup(Request $request, $id)
    {
        // Get group details
        $group_details = Group::where('group_id', $id)->where('user_id', Auth::user()->id)->first();

        // Check data 
        if ($group_details) {
            return view('user.pages.groups.edit', compact('group_details'));
        } else {
            // Redirect
            return redirect()->route('user.all.groups')->with('failed', trans('No data available'));
        }
    }

    // Update Group
    public function updateGroup(Request $request)
    {
        // Parameters
        $group_id = $request->group_id;

        // Update Group
        Group::where('group_id', $group_id)->where('user_id', Auth::user()->id)->update([
            'group_name' => $request->name
        ]);

        return redirect()->route('user.edit.group', $group_id)->with('success', trans('Group updated successfully.'));
    }

    // Update Group Status
    public function updateGroupStatus(Request $request)
    {
        // Get QRCode details
        $group_details = Group::where('group_id', $request->query('id'))->where('user_id', Auth::user()->id)->first();

        // Check data 
        if ($group_details) {
            // Check status
            if ($group_details->status == 0) {
                $status = 1;
            } else {
                $status = 0;
            }

            // Update
            Group::where('group_id', $request->query('id'))->where('user_id', Auth::user()->id)->update(['status' => $status]);

            return redirect()->back()->with('success', trans('Group status updated successfully!'));
        } else {
            // Redirect
            return redirect()->route('user.all.groups')->with('failed', trans('No data available'));
        }
    }

    // Delete Group
    public function deleteGroup(Request $request)
    {
        // Update status
        Group::where('group_id', $request->query('id'))->where('user_id', Auth::user()->id)->update([
            'status' => 2
        ]);

        // Move to general
        Barcode::where('group_id', $request->query('id'))->where('user_id', Auth::user()->id)->update([
            'group_id' => null
        ]);

        return redirect()->back()->with('success', trans('Group deleted successfully'));
    }

    // Download Group
    public function downloadGroup(Request $request, $id)
    {
        // Generate barcode
        $groupBarcodes = Barcode::where('group_id', $id)->where('user_id', Auth::user()->id)->where('status', 1)->get();

        // Check data 
        if (count($groupBarcodes) > 0) {
            // Delete folder
            File::deleteDirectory(public_path('/images/user/barcode/' . $groupBarcodes[0]->group_id));

            // Group barcodes
            for ($i = 0; $i < count($groupBarcodes); $i++) {
                // Parameters
                $groupId = $groupBarcodes[$i]->group_id;
                $barcodeId = $groupBarcodes[$i]->barcode_id;
                $type = json_decode($groupBarcodes[$i]->settings)->barcode_type;
                $format = json_decode($groupBarcodes[$i]->settings)->barcode_format;
                $value = json_decode($groupBarcodes[$i]->settings)->content;
                $width = json_decode($groupBarcodes[$i]->settings)->width;
                $height = json_decode($groupBarcodes[$i]->settings)->height;
                $color = json_decode($groupBarcodes[$i]->settings)->color;
                $showText = json_decode($groupBarcodes[$i]->settings)->showtext;

                // Color converter
                $rpgColor = $this->hex2rgb($color);

                if ($type == "DNS1D") {
                    // Generate barcode
                    $result = $type::getBarcodePNG((int)$value, $format, $width, $height, array($rpgColor[0], $rpgColor[1], $rpgColor[2]), $showText);
                    $image = "data:image/png;base64," . $result;
                }

                if ($type == "DNS2D") {
                    // Generate barcode
                    $result = $type::getBarcodePNG((string)$value, $format, $width, $height, array($rpgColor[0], $rpgColor[1], $rpgColor[2]), $showText);
                    $image = "data:image/png;base64," . $result;
                }

                // Group folder created
                $path = public_path() . '/images/user/barcode/' . $groupId;
                File::makeDirectory($path, 0777, true, true);

                // Convert to png image
                $image = str_replace(' ', '+', $image);
                $imageName = $barcodeId . '.' . 'png';
                File::put(public_path('images/user/barcode/' . $groupId) . '/' . $imageName, base64_decode($result));
            }

            // Group downloads
            $zip = new \ZipArchive();
            $zipName = $id . '.zip';
            if ($zip->open(public_path($zipName), \ZipArchive::CREATE) == TRUE) {
                $files = File::files(public_path('images/user/barcode/' . $id));
                foreach ($files as $key => $value) {
                    $relativeName = basename($value);
                    $zip->addFile($value, $relativeName);
                }
                $zip->close();
            }

            return response()->download(public_path($zipName))->deleteFileAfterSend(true);
        } else {
            // Redirect
            return redirect()->route('user.all.groups')->with('failed', trans('No data available'));
        }
    }

    // Color code to RBG
    function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        return array($r, $g, $b); // RETURN ARRAY INSTEAD OF STRING
    }
}
