<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;

class PaymentController extends Controller
{
    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        if ($transaction) {
            return view('user.invoice', compact('transaction'));
        }
    }
}
