<?php

namespace App\Http\Controllers\Admin;

use App\Models\Group;
use App\Models\Barcode;
use App\Models\Setting;
use App\Imports\XlsxImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class BulkUploadController extends Controller
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

    // All Bulk upload
    public function index()
    {
        // Get User groups
        $groups = Group::where('user_id', Auth::user()->id)->where('status', 1)->orderBy('id', 'desc')->get();
        $settings = Setting::where('status', 1)->first();

        // View page
        return view('admin.pages.bulk-upload.index', compact('groups', 'settings'));
    }

    // Save Bulk upload
    public function importBulkUpload(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'group' => 'required',
            'file' => 'required|mimes:xlsx,xls'
        ]);

        if ($validator->fails()) {
            return back()->with('failed', $validator->messages()->all()[0])->withInput();
        }

        // Imports
        $barcodes = Excel::toArray(new XlsxImport, $request->file('file'));
        $barcodes = $barcodes[0];

        // Check condition
        for ($i = 1; $i < count($barcodes); $i++) {

            // Input values
            $name = $barcodes[$i][0];
            $type = $barcodes[$i][1];
            $format = $barcodes[$i][2];
            $value = $barcodes[$i][3];
            $width = $barcodes[$i][4];
            $height = $barcodes[$i][5];
            $showText = $barcodes[$i][6];

            // Required name
            if (!$name) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode name is required on the row number ' . $i));
            }

            // Required barcode type
            if (!$type) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode type is required on the row number ' . $i));
            }

            // Required barcode format
            if (!$format) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode format is required on the row number ' . $i));
            }

            // Required value
            if (!$value) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode value is required on the row number ' . $i));
            }

            // Required width
            if (!$width) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode width is required on the row number ' . $i));
            }

            // Required height
            if (!$height) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode height is required on the row number ' . $i));
            }

            // Required show text
            if (!$showText) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode show text is required on the row number ' . $i));
            }

            // Check max length of "Name"
            if (strlen($name) > 191) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode name minimum length of 1 or max length of 191 on the row number ' . $i));
            }

            // Check barcode types
            if ($type != "DNS1D" && $type != "DNS2D") {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Invalid barcode type on the row number ' . $i));
            }

            // Check barcode formats
            $availableFormats = array("C39", "C39+", "C39E+", "C93", "S25", "S25+", "I25", "I25+", "C128", "C128A", "C128B", "C128C", "EAN2", "EAN5", "EAN8", "EAN13", "UPCA", "MSI", "UPCE", "MSI+", "POSTNET", "PLANET", "RMS4CC", "KIX", "IMB", "CODABAR", "CODE11", "PHARMA", "PHARMA2T", "QRCODE", "PDF417", "DATAMATRIX");
            if (!in_array($format, $availableFormats)) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Invalid barcode format on the row number ' . $i));
            }

            // Check max length of "Value"
            if (strlen($value) > 191) {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Barcode value minimum length of 1 or max length of 191 on the row number ' . $i));
            }

            // Check show text
            if ($showText != "yes" && $showText != "no") {
                return redirect()->route('admin.bulk.upload')->with('failed', trans('Invalid show text value on the row number ' . $i));
            }

            // Show text
            $showtext = true;
            if ($showText == "no") {
                $showtext = false;
            }

            if ($type == "DNS1D") {
                // Generate barcode
                $result = $type::getBarcodeSVG((int)$value, $format, $width, $height, '#000000', $showtext);
            }

            if ($type == "DNS2D") {
                // Generate barcode
                $result = $type::getBarcodeSVG((string)$value, $format, $width, $height, '#000000', $showtext);
            }

            // Generate settings
            $settings =  json_encode(array(
                "barcode_type" => $type,
                "barcode_format" => $format,
                "content" => $value,
                "width" => $width,
                "height" => $height,
                "color" => "#000000",
                "showtext" => $showtext
            ));

            // Save
            $barcode = new Barcode();
            $barcode->group_id = $request->group;
            $barcode->barcode_id = uniqid();
            $barcode->user_id = Auth::user()->id;
            $barcode->name = $name;
            $barcode->bar_code = $result;
            $barcode->settings = $settings;
            $barcode->save();
        }

        return redirect()->route('admin.bulk.upload')->with('success', trans('Barcode generated successfully.'));
    }
}
