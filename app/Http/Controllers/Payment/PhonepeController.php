<?php

namespace App\Http\Controllers\Payment;

use App\Models\Plan;
use App\Models\User;
use App\Models\Transaction;
use App\Classes\UpgradePlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PhonepeController extends Controller
{
    public function preparePhonpe($planId)
    {
        if (Auth::user()) {

            // Queries
            $config = DB::table('configs')->get();
            $userData = User::where('id', Auth::user()->id)->first();
            $plan_details = Plan::where('id', $planId)->where('status', 1)->first();

            // Check plan details
            if ($plan_details == null) {
                return view('errors.404');
            } else {

                // Paid amount
                $amountToBePaid = ((float)($plan_details->plan_price) * (float)($config[25]->config_value) / 100) + (float)($plan_details->plan_price);
                $amountToBePaidPaise = (float)number_format($amountToBePaid, 2) * 100;

                try {
                    // sta payment intent
                    $data = array(
                        'merchantId' => $config[40]->config_value,
                        'merchantTransactionId' => uniqid(),
                        'merchantUserId' => $config[40]->config_value,
                        'amount' => $amountToBePaidPaise,
                        'redirectUrl' => route('phonepe.payment.status'),
                        'redirectMode' => 'POST',
                        'callbackUrl' => route('phonepe.payment.status'),
                        'mobileNumber' => $userData->billing_phone,
                        'paymentInstrument' =>
                        array(
                            'type' => 'PAY_PAGE',
                        ),
                    );

                    $encode = base64_encode(json_encode($data));

                    $saltKey = $config[41]->config_value;
                    $saltIndex = 1;

                    $string = $encode . '/pg/v1/pay' . $saltKey;
                    $sha256 = hash('sha256', $string);

                    $finalXHeader = $sha256 . '###' . $saltIndex;

                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'X-VERIFY' => $finalXHeader,
                    ])->post('https://api-preprod.phonepe.com/apis/hermes/pg/v1/pay', [
                        'request' => $encode,
                    ]);

                    $rData = json_decode($response);

                    if (isset($rData)) {
                        if ($rData->success == true) {
                            // Generate JSON
                            $invoice_details = [];

                            $invoice_details['from_billing_name'] = $config[16]->config_value;
                            $invoice_details['from_billing_address'] = $config[19]->config_value;
                            $invoice_details['from_billing_city'] = $config[20]->config_value;
                            $invoice_details['from_billing_state'] = $config[21]->config_value;
                            $invoice_details['from_billing_zipcode'] = $config[22]->config_value;
                            $invoice_details['from_billing_country'] = $config[23]->config_value;
                            $invoice_details['from_vat_number'] = $config[26]->config_value;
                            $invoice_details['from_billing_phone'] = $config[18]->config_value;
                            $invoice_details['from_billing_email'] = $config[17]->config_value;
                            $invoice_details['to_billing_name'] = $userData->billing_name;
                            $invoice_details['to_billing_address'] = $userData->billing_address;
                            $invoice_details['to_billing_city'] = $userData->billing_city;
                            $invoice_details['to_billing_state'] = $userData->billing_state;
                            $invoice_details['to_billing_zipcode'] = $userData->billing_zipcode;
                            $invoice_details['to_billing_country'] = $userData->billing_country;
                            $invoice_details['to_billing_phone'] = $userData->billing_phone;
                            $invoice_details['to_billing_email'] = $userData->billing_email;
                            $invoice_details['to_vat_number'] = $userData->vat_number;
                            $invoice_details['tax_name'] = $config[24]->config_value;
                            $invoice_details['tax_type'] = $config[14]->config_value;
                            $invoice_details['tax_value'] = (float)($config[25]->config_value);
                            $invoice_details['invoice_amount'] = $amountToBePaid;
                            $invoice_details['subtotal'] = $plan_details->plan_price;
                            $invoice_details['tax_amount'] = (float)($plan_details->plan_price) * (float)($config[25]->config_value) / 100;

                            // Save transactions
                            $transaction = new Transaction();
                            $transaction->transaction_date = now();
                            $transaction->transaction_id = $rData->data->merchantTransactionId;
                            $transaction->user_id = Auth::user()->id;
                            $transaction->plan_id = $plan_details->id;
                            $transaction->desciption = $plan_details->plan_name . " Plan";
                            $transaction->payment_gateway_name = "Phonepe";
                            $transaction->transaction_amount = $amountToBePaid;
                            $transaction->transaction_currency = $config[1]->config_value;
                            $transaction->invoice_details = json_encode($invoice_details);
                            $transaction->payment_status = "PENDING";
                            $transaction->save();

                            return redirect()->to($rData->data->instrumentResponse->redirectInfo->url);
                        }
                    } else {
                        return redirect()->route('user.plans')->with('failed', trans('Payment failed.'));
                    }
                } catch (\Exception $e) {
                    return redirect()->route('user.plans')->with('failed', trans('Payment failed.'));
                }
            }
        } else {
            return redirect()->route('user.plans')->with('failed', trans('Payment failed.'));
        }
    }

    public function phonepePaymentStatus(Request $request)
    {
        // Queries
        $config = DB::table('configs')->get();
        $input = $request->all();

        if (count($request->all()) > 0 && isset($input['transactionId'])) {

            $merchantId = $config[40]->config_value;
            $saltKey = $config[41]->config_value;
            $saltIndex = 1;

            $finalXHeader = hash('sha256', '/pg/v1/status/' . $merchantId . '/' . $input['transactionId'] . $saltKey) . '###' . $saltIndex;

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'accept' => 'application/json',
                'X-VERIFY' => $finalXHeader,
                'X-MERCHANT-ID' => $merchantId
            ])->get('https://api-preprod.phonepe.com/apis/hermes/pg/v1/status/' . $merchantId . '/' . $input['transactionId']);

            $res = json_decode($response);

            try {
                if ($res->code == "PAYMENT_SUCCESS") {

                    // Plan upgrade
                    $upgradePlan = new UpgradePlan;
                    $upgradePlan->upgrade($input['transactionId'], $res);

                    // Page redirect
                    return redirect()->route('user.plans')->with('success', trans("Plan renewed successfully!"));
                } else {
                    return redirect()->route('user.plans')->with('failed', trans('Payment failed.'));
                }
            } catch (\Throwable $th) {
                return redirect()->route('user.plans')->with('failed', trans('Payment failed.'));
            }
        } else {
            return redirect()->route('user.plans')->with('failed', trans('Payment failed.'));
        }
    }
}
