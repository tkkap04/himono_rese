<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function show()
    {
        return view('payment');
    }

    public function processPayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
 
        $amount = $request->input('amount');

        $charge = Charge::create(array(
            'amount' => $amount,
            'currency' => 'jpy',
            'source' => $request->stripeToken,
        ));
        
       return back();
    }
}

