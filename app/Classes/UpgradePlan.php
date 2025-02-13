<?php

namespace App\Classes;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\QrCode;
use App\Models\Barcode;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class UpgradePlan
{
    public function upgrade($transactionId, $res)
    {
        // Queries
        $config = DB::table('configs')->get();
        $orderId = $transactionId;

        // Get transaction details
        $transaction_details = Transaction::where('transaction_id', $orderId)->where('status', 1)->first();
        $user_details = User::find($transaction_details->user_id);

        // Get plan details
        $plan_data = Plan::where('id', $transaction_details->plan_id)->first();
        $term_days = $plan_data->validity;

        if ($user_details->plan_validity == "") {

            // Add Days
            $plan_validity = Carbon::now();
            $plan_validity->addDays($term_days);

            // Transaction count
            $invoice_count = Transaction::where("invoice_prefix", $config[15]->config_value)->count();
            $invoice_number = $invoice_count + 1;

            // Update Transaction details
            Transaction::where('transaction_id', $orderId)->update([
                'transaction_id' => $transactionId,
                'invoice_prefix' => $config[15]->config_value,
                'invoice_number' => $invoice_number,
                'payment_status' => 'SUCCESS',
            ]);

            User::where('id', $transaction_details->user_id)->update([
                'plan_id' => $transaction_details->plan_id,
                'term' => $term_days,
                'plan_validity' => $plan_validity,
                'plan_activation_date' => now(),
                'plan_details' => $plan_data
            ]);

            // Generate JSON
            $encode = json_decode($transaction_details['invoice_details'], true);
            $details = [
                'from_billing_name' => $encode['from_billing_name'],
                'from_billing_email' => $encode['from_billing_email'],
                'from_billing_address' => $encode['from_billing_address'],
                'from_billing_city' => $encode['from_billing_city'],
                'from_billing_state' => $encode['from_billing_state'],
                'from_billing_country' => $encode['from_billing_country'],
                'from_billing_zipcode' => $encode['from_billing_zipcode'],
                'transaction_id' => $transactionId,
                'to_billing_name' => $encode['to_billing_name'],
                'to_vat_number' => $encode['to_vat_number'],
                'invoice_currency' => $transaction_details->transaction_currency,
                'subtotal' => $encode['subtotal'],
                'tax_amount' => (float)($plan_data->plan_price) * (float)($config[25]->config_value) / 100,
                'invoice_amount' => $encode['invoice_amount'],
                'invoice_id' => $config[15]->config_value . $invoice_number,
                'invoice_date' => $transaction_details->created_at,
                'description' => $transaction_details->desciption,
                'email_heading' => $config[27]->config_value,
                'email_footer' => $config[28]->config_value,
            ];

            // Send email to user email
            try {
                Mail::to($encode['to_billing_email'])->send(new \App\Mail\SendEmailInvoice($details));
            } catch (\Exception $e) {
            }

            // Page redirect
            return redirect()->route('user.plans')->with('success', trans('Plan activation success!'));
        } else {

            $message = "";
            if ($user_details->plan_id == $transaction_details->plan_id) {
                // Check if plan validity is expired or not.
                $plan_validity = \Carbon\Carbon::createFromFormat('Y-m-d H:s:i', $user_details->plan_validity);
                $current_date = Carbon::now();
                $remaining_days = $current_date->diffInDays($plan_validity, false);

                // Remaining deys
                if ($remaining_days > 0) {
                    $plan_validity = Carbon::parse($user_details->plan_validity);
                    $plan_validity->addDays($term_days);
                    $message = "Plan renewed successfully!";
                } else {
                    $plan_validity = Carbon::now();
                    $plan_validity->addDays($term_days);
                    $message = "Plan renewed successfully!";
                }

                // Making all QR codes inactive, For Plan change
                QrCode::where('user_id', $transaction_details->user_id)->update([
                    'status' => 0,
                ]);
                // Making all Barcodes inactive, For Plan change
                Barcode::where('user_id', $transaction_details->user_id)->update([
                    'status' => 0,
                ]);
            } else {

                // Making all QR codes inactive, For Plan change
                QrCode::where('user_id', $transaction_details->user_id)->update([
                    'status' => 0,
                ]);
                // Making all Barcodes inactive, For Plan change
                Barcode::where('user_id', $transaction_details->user_id)->update([
                    'status' => 0,
                ]);

                // Add days
                $plan_validity = Carbon::now();
                $plan_validity->addDays($term_days);
                $message = trans("Plan activated successfully!");
            }

            $invoice_count = Transaction::where("invoice_prefix", $config[15]->config_value)->count();
            $invoice_number = $invoice_count + 1;

            // Update transaction details
            Transaction::where('transaction_id', $orderId)->update([
                'transaction_id' => $transactionId,
                'invoice_prefix' => $config[15]->config_value,
                'invoice_number' => $invoice_number,
                'payment_status' => 'SUCCESS',
            ]);

            // Update plan details
            User::where('id', $transaction_details->user_id)->update([
                'plan_id' => $transaction_details->plan_id,
                'term' => $term_days,
                'plan_validity' => $plan_validity,
                'plan_activation_date' => now(),
                'plan_details' => $plan_data
            ]);

            // Generate JSON
            $encode = json_decode($transaction_details['invoice_details'], true);
            $details = [
                'from_billing_name' => $encode['from_billing_name'],
                'from_billing_email' => $encode['from_billing_email'],
                'from_billing_address' => $encode['from_billing_address'],
                'from_billing_city' => $encode['from_billing_city'],
                'from_billing_state' => $encode['from_billing_state'],
                'from_billing_country' => $encode['from_billing_country'],
                'from_billing_zipcode' => $encode['from_billing_zipcode'],
                'transaction_id' => $transactionId,
                'to_billing_name' => $encode['to_billing_name'],
                'to_vat_number' => $encode['to_vat_number'],
                'invoice_currency' => $transaction_details->transaction_currency,
                'subtotal' => $encode['subtotal'],
                'tax_amount' => (float)($plan_data->plan_price) * (float)($config[25]->config_value) / 100,
                'invoice_amount' => $encode['invoice_amount'],
                'invoice_id' => $config[15]->config_value . $invoice_number,
                'invoice_date' => $transaction_details->created_at,
                'description' => $transaction_details->desciption,
                'email_heading' => $config[27]->config_value,
                'email_footer' => $config[28]->config_value,
            ];

            // Send email to user email
            try {
                Mail::to($encode['to_billing_email'])->send(new \App\Mail\SendEmailInvoice($details));
            } catch (\Exception $e) {
            }

            // Page redirect
            Auth::loginUsingId($user_details->id);
            return redirect()->route('user.plans')->with('success', $message);
        }

        return redirect()->route('user.plans')->with('failed', trans('Payment failed.'));
    }
}
