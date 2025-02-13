<?php

namespace App\Http\Controllers\User;

use SepaQr\Data;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\QrCode;
use App\Models\Setting;
use Illuminate\Http\Request;
use Endroid\QrCode\Builder\Builder;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class EPCQRCodeController extends Controller
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

    // All User EPC QR Codes
    public function index()
    {
        // Check active plans
        $active_plan = Plan::where('id', Auth::user()->plan_id)->first();

        // Check user plan
        $plan = User::where('id', Auth::user()->id)->first();

        // Check plan
        if ($active_plan != null) {
            // Get User Bar Codes
            $epc_qrcodes = QrCode::where('user_id', Auth::user()->id)->where('type', 'epc')->where('status', '!=', 2)->orderBy('id', 'desc')->get();
            $settings = Setting::where('status', 1)->first();

            // View page
            return view('user.pages.epc-qrcodes.index', compact('epc_qrcodes', 'settings'));
        } else {
            // Page redirect in plan is not activated
            return redirect()->route('user.plans');
        }
    }

    // Create EPC QR Code
    public function CreateEPCQr()
    {
        // Get user created qr code count
        $qr_code_count = QrCode::where('user_id', Auth::user()->id)->count();

        // Get plan details
        $plan = User::where('id', Auth::user()->id)->where('status', 1)->first();
        $plan_details = json_decode($plan->plan_details); 

        // Check validity
        $validity = User::where('id', Auth::user()->id)->whereDate('plan_validity', '>=', Carbon::now())->count();

        // Check no of qrcodes
        if ($plan_details->no_qrcodes == 999) {
            $no_qrcodes = 999999;
        } else {
            $no_qrcodes = $plan_details->no_qrcodes;
        }

        // Check user created qr code count
        if ($validity == 1) {
            if ($qr_code_count < $no_qrcodes) {
                return view('user.pages.epc-qrcodes.create');
            } else {
                return redirect()->route('user.all.epc.qr')->with('failed', trans('Maximum creation limit is exceeded, Please upgrade your plan.'));
            }
        } else {
            // Redirect
            return redirect()->route('user.all.epc.qr')->with('failed', trans('Your plan is over. Choose your plan renewal or new package and use it.'));
        }
    }

    // Save EPC QR Code
    public function saveEPCQr(Request $request)
    {
        // Save file path
        $qr_code_id = uniqid();
        $fileName = uniqid();
        $savePath = public_path('images/user/qr-code/epc/epc-' . $fileName . '.png');

        // Create EPC QR
        $epcQrData = Data::create();

        // Set name
        $name = "-";
        if ($request->name) {
            $name = $request->name;
        }

        // Set amount
        if ($request->amount) {
            $epcQrData->setAmount((float)$request->amount);
        }

        // Set IBAN
        $iban = "BE72000000001616";
        if ($request->iban) {
            $iban = $request->iban;
        }

        // Set BIC/SWIFT
        $bic = "BPOTBEB1";
        if ($request->bic) {
            $bic = $request->bic;
        }

        // Set Payment Reference
        if ($request->reference) {
            $epcQrData->setRemittanceReference($request->reference);
        }

        // Set Purpose
        if ($request->purpose) {
            $epcQrData->setPurpose($request->purpose);
        }

        // Set Note
        if ($request->note) {
            $epcQrData->setInformation($request->note);
        }

        // Generate QR
        $epcQrData->setName($name)->setBic($bic)->setIban($iban)->setServiceTag($request->tag)->setIdentification($request->sepa)->setVersion((int)$request->version);
        Builder::create()->encoding(new Encoding('UTF-8'))->errorCorrectionLevel(ErrorCorrectionLevel::Medium)->data($epcQrData)->build()->saveToFile($savePath);

        // Render path
        $renderPath = 'images/user/qr-code/epc/epc-' . $fileName . '.png';

        // Generate settings
        $settings =  json_encode(array(
            "name" => $name,
            "amount" => (float)$request->amount,
            "tag" => $request->tag,
            "sepa" => $request->sepa,
            "version" => (int)$request->version,
            "iban" => $iban,
            "bic" => $bic,
            "reference" => $request->reference,
            "purpose" => $request->purpose,
            "note" => $request->note,
        ));

        // Save QR code text
        $qrCode = new QrCode();
        $qrCode->qr_code_id = $qr_code_id;
        $qrCode->user_id = Auth::user()->id;
        $qrCode->name = $name;
        $qrCode->type = 'epc';
        $qrCode->qr_code_logo = "";
        $qrCode->qr_code_logo_size = "";
        $qrCode->qr_code = $renderPath;
        $qrCode->settings = $settings;
        $qrCode->save();

        return redirect()->route('user.download.qrcode', $qr_code_id)->with('success', trans('QR Code created successfully.'));
    }

    // Edit EPC QR Code
    public function editEPCQr(Request $request, $id)
    {
        // Get QR code details
        $qr_code_details = QrCode::where('qr_code_id', $id)->where('user_id', Auth::user()->id)->first();

        // Check data
        if ($qr_code_details) {
            return view('user.pages.epc-qrcodes.edit', compact('qr_code_details'));
        } else {
            // Redirect
            return redirect()->route('user.all.epc.qr')->with('failed', trans('No data available'));
        }
    }

    // Update EPC QR Code
    public function updateEPCQr(Request $request)
    {
        // Parameters
        $qr_code_id = $request->qr_code_id;
        $fileName = uniqid();
        $savePath = public_path('images/user/qr-code/epc/epc-' . $fileName . '.png');

        // Create EPC QR
        $epcQrData = Data::create();

        // Set name
        $name = "-";
        if ($request->name) {
            $name = $request->name;
        }

        // Set amount
        if ($request->amount) {
            $epcQrData->setAmount((float)$request->amount);
        }

        // Set IBAN
        $iban = "BE72000000001616";
        if ($request->iban) {
            $iban = $request->iban;
        }

        // Set BIC/SWIFT
        $bic = "BPOTBEB1";
        if ($request->bic) {
            $bic = $request->bic;
        }

        // Set Payment Reference
        if ($request->reference) {
            $epcQrData->setRemittanceReference($request->reference);
        }

        // Set Purpose
        if ($request->purpose) {
            $epcQrData->setPurpose($request->purpose);
        }

        // Set Note
        if ($request->note) {
            $epcQrData->setInformation($request->note);
        }

        // Generate QR
        $epcQrData->setName($name)->setBic($bic)->setIban($iban)->setServiceTag($request->tag)->setIdentification($request->sepa)->setVersion((int)$request->version);
        Builder::create()->encoding(new Encoding('UTF-8'))->errorCorrectionLevel(ErrorCorrectionLevel::Medium)->data($epcQrData)->build()->saveToFile($savePath);

        // Render path
        $renderPath = 'images/user/qr-code/epc/epc-' . $fileName . '.png';

        // Generate settings
        $settings =  json_encode(array(
            "name" => $name,
            "amount" => (float)$request->amount,
            "tag" => $request->tag,
            "sepa" => $request->sepa,
            "version" => (int)$request->version,
            "iban" => $iban,
            "bic" => $bic,
            "reference" => $request->reference,
            "purpose" => $request->purpose,
            "note" => $request->note,
        ));

        // Update QR code text
        QrCode::where('qr_code_id', $qr_code_id)->where('user_id', Auth::user()->id)->update([
            'name' => $request->name, 'qr_code_logo' => "", 'qr_code_logo_size' => "$request->upload_logo_size", "qr_code" => $renderPath, "settings" => $settings
        ]);

        return redirect()->route('user.download.qrcode', $qr_code_id)->with('success', trans('QR Code updated successfully.'));
    }

    // Regenerate EPC QR Code
    public function regenerateEPCQr(Request $request)
    {
        // Save file path
        $fileName = uniqid();
        $savePath = public_path('images/user/qr-code/epc/epc-' . $fileName . '.png');

        // Create EPC QR
        $epcQrData = Data::create();

        // Set name
        $name = "-";
        if ($request->name) {
            $name = $request->name;
        }

        // Set amount
        if ($request->amount) {
            $epcQrData->setAmount((float)$request->amount);
        }

        // Set IBAN
        $iban = "BE72000000001616";
        if ($request->iban) {
            $bic = $request->iban;
        }

        // Set BIC/SWIFT
        $bic = "BPOTBEB1";
        if ($request->bic) {
            $bic = $request->bic;
        }

        // Set Payment Reference
        if ($request->reference) {
            $epcQrData->setRemittanceReference($request->reference);
        }

        // Set Purpose
        if ($request->purpose) {
            $epcQrData->setPurpose($request->purpose);
        }

        // Set Note
        if ($request->note) {
            $epcQrData->setInformation($request->note);
        }

        // Generate QR
        $epcQrData->setName($name)->setBic($bic)->setIban($iban)->setServiceTag($request->tag)->setIdentification($request->sepa)->setVersion((int)$request->version);
        Builder::create()->encoding(new Encoding('UTF-8'))->errorCorrectionLevel(ErrorCorrectionLevel::Medium)->data($epcQrData)->build()->saveToFile($savePath);

        // Render path
        $renderPath = asset('images/user/qr-code/epc/epc-' . $fileName . '.png');

        return response()->json(['status' => true, 'source' => $renderPath]);
    }
}
