<?php

namespace App\Http\Controllers\User;

use App\Models\Plan;
use App\Models\User;
use App\Models\Config;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionsController extends Controller
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

    //  User Transactions
    public function indexTransactions()
    {
        // Queries
        $active_plan = Plan::where('id', Auth::user()->plan_id)->first();
        $plan = User::where('id', Auth::user()->id)->first();

        // Check active plan
        if ($active_plan != null) {
            $transactions = Transaction::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $settings = Setting::where('status', 1)->first();
            $currencies = Currency::get();

            // Page view
            return view('user.pages.transactions.index', compact('transactions', 'settings', 'currencies'));
        } else {
            // Page redirect 
            return redirect()->route('user.plans');
        }
    }

    //  View Invoice
    public function viewInvoice($id)
    {
        // Queries
        $transaction = Transaction::where('id', $id)->orWhere('transaction_id', $id)->first();

        // Check data
        if ($transaction) {
            
            // Queries
            $settings = Setting::where('status', 1)->first();
            $config = Config::get();
            $currencies = Currency::get();
            $transaction['billing_details'] = json_decode($transaction['invoice_details'], true);

            return view('user.pages.transactions.view-invoice', compact('transaction', 'settings', 'config', 'currencies'));
        } else {
            // Redirect
            return redirect()->route('user.transactions')->with('failed', trans('No data available'));
        }
    }
}
