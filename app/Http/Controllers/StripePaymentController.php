<?php

namespace App\Http\Controllers;

use App\Models\StripeOrder;
use Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripe()
    {
        $order_info = session('order_info');
        $name = session('name');
        $gtotal = session('gtotal');
        $mobile = session('mobile');
        $order_id = session('order_id');

        DB::table('stripe_orders')->updateOrInsert([
            'name' => $name,
            'email' => $order_info['email'],
            'phone' => $mobile,
            'order_id' => $order_id,
            'customer_id' => Auth::guard('CustLogin')->id(),
            'amount' => $gtotal,
            'status' => 'pending',
            'address' => $order_info['address'],
            'transaction_id' => 'Pending',
            'currency' => 'pending',
        ]);

        return view('stripe');
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function stripePost(Request $request)
    {
        $gtotal = session('gtotal');
        $order_id = session('order_id');

        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Stripe\Charge::create ([
			"amount" => 100 * $gtotal,
			"currency" => "bdt",
			"source" => $request->stripeToken,
			"description" => "Test payment", 
        ]);

        Session::flash('success', 'Payment successful!');

        if($charge->status == 'succeeded'){
            StripeOrder::where('order_id', $order_id)->update([
                'status' => 'succeeded',
                'transaction_id' => $charge->id,
                'currency' => $charge->currency,
            ]);

            return redirect()->route('order.complete')->with([
                'order_conf' => $order_id,
            ]);
        }
        else {
            return redirect()->route('order.failed');
        }
    }
}
