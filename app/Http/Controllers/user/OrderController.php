<?php

namespace App\Http\Controllers\user;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with([
            'product', 'flower', 'flowerColor', 'backgroundColor', 'listColor'
        ])
        ->orderByRaw("CASE WHEN status = 'paid' THEN 1 ELSE 0 END") // unpaid dulu, paid di bawah
        ->latest() // atau bisa gunakan orderBy('created_at', 'desc') jika ingin berdasarkan waktu
        ->get();

        return view('user.order', compact('orders'));
    }

    public function index2()
    {   
        $orders = Order::with([
            'product', 'flower', 'flowerColor', 'backgroundColor', 'listColor'
        ])
        ->orderByRaw("CASE WHEN status = 'unpaid' THEN 1 ELSE 0 END")
        ->orderByRaw("FIELD(status_order, 'pending', 'selesai', 'cancel')") // unpaid dulu, paid di bawah
        ->latest() // atau bisa gunakan orderBy('created_at', 'desc') jika ingin berdasarkan waktu
        ->get();

        return view('admin.order', [
            'title' => 'Order List',
            'orders'=> $orders,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'product_id' => 'required|exists:products,id',
            'flower_type' => 'required|exists:flowers,id',
            'flower_color' => 'required|exists:colors,id',
            'background_color' => 'required|exists:colors,id',
            'list_color' => 'required|exists:colors,id',
            'total_price' => 'required|numeric',
            'logo' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'kalimat' => 'required|string'
        ]);

        $imagePath = null;
        if ($request->hasFile('logo')) {
            $imagePath = $request->file('logo')->store('logos', 'public');
        }

        $order = Order::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => Auth::check() ? Auth::user()->email : $request->email,
            'product_id' => $request->product_id,
            'flower_id' => $request->flower_type,
            'flower_color_id' => $request->flower_color,
            'background_color_id' => $request->background_color,
            'list_color_id' => $request->list_color,
            'address' => $request->address,
            'total_price' => $request->total_price,
            'image_url' => $imagePath,
            'kalimat' => $request->kalimat,
        ]);

        return redirect()->route('user.katalog')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function store2(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status_order' => 'required',
        ]);

        // Temukan order yang ada
        $order = Order::findOrFail($request->order_id);

        // Update hanya status_order
        $order->update([
            'status_order' => $request->status_order,
        ]);

        session()->flash('success', 'Status order berhasil diperbarui');
        return redirect()->back();
    }


    public function checkout(Request $request)
    {
        $selectedOrderIds = explode(',', $request->input('selected_orders'));
        $totalAmount = $request->input('total_amount');

        $orders = Order::whereIn('id', $selectedOrderIds)->get();

        if ($orders->isEmpty()) {
            return response()->json(['error' => 'Order tidak ditemukan.'], 404);
        }

        $firstOrder = $orders->first();

        // Buat ID unik untuk Midtrans
        $midtransOrderId = 'TX-' . uniqid();

        // Simpan transaksi ke database
        $transaction = Transaction::create([
            'status' => 'unpaid',
            'total_amount' => $totalAmount,
            'name' => $firstOrder->name,
            'phone' => $firstOrder->phone,
            'email' => $firstOrder->email,
            'midtrans_order_id' => $midtransOrderId,
        ]);

        // Hubungkan semua order ke transaksi ini
        foreach ($orders as $order) {
            $order->transaction_id = $transaction->id;
            $order->save();
        }

        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Parameter Snap Redirect
        $params = [
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => (int) $transaction->total_amount,
            ],
            'customer_details' => [
                'name' => $transaction->name,
                'email' => $transaction->email,
                'phone' => $transaction->phone,
            ],
            'callbacks' => [
            'finish' => route('payment.success'),
        ],
        ];

        Log::info('Midtrans Snap Redirect Params', $params);

        // Buat transaksi dan ambil redirect URL
        try {
            $snapTransaction = \Midtrans\Snap::createTransaction($params);
            $redirectUrl = $snapTransaction->redirect_url;

            // Redirect langsung ke halaman pembayaran Midtrans
            return redirect($redirectUrl);

        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membuat transaksi Midtrans.');
        }
    }

    public function callback(Request $request)
    {
        // Konfigurasi Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        // Ambil notifikasi dari Midtrans
        $notification = new \Midtrans\Notification();

        $transactionStatus = $notification->transaction_status;
        $paymentType       = $notification->payment_type;
        $fraudStatus       = $notification->fraud_status;
        $orderId           = $notification->order_id;

        // Cari transaksi di database
        $transaction = Transaction::where('midtrans_order_id', $orderId)->first();

        if (!$transaction) {
            Log::error("Transaksi dengan order_id $orderId tidak ditemukan.");
            return response()->json(['message' => 'Transaksi tidak ditemukan.'], 404);
        }

        // Update status berdasarkan kondisi transaksi
        if ($transactionStatus === 'capture') {
            if ($paymentType === 'credit_card') {
                if ($fraudStatus === 'challenge') {
                    $transaction->status = 'challenge';
                } else {
                    $transaction->status = 'paid';
                }
            }
        } elseif ($transactionStatus === 'settlement') {
            $transaction->status = 'paid';
        } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $transaction->status = 'failed';
        } elseif ($transactionStatus === 'pending') {
            $transaction->status = 'pending';
        }

        $transaction->save();

        // Update semua order terkait juga (optional)
        Order::where('transaction_id', $transaction->id)->update([
            'status' => $transaction->status
        ]);

        Log::info('Callback Midtrans diterima', [
            'order_id' => $orderId,
            'status' => $transactionStatus,
            'saved_status' => $transaction->status
        ]);

        return response()->json(['message' => 'Callback diproses']);
    }



    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        session()->flash('success', 'Pesanan berhasil dihapus');
        return redirect()->back();
    }
}
