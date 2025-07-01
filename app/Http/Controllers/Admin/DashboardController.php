<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pendapatan dari order yang statusnya 'selesai'
        $totalPendapatan = Order::where('status_order', 'selesai')->sum('total_price');

        // Jumlah order dengan status 'selesai'
        $jumlahSelesai = Order::where('status_order', 'selesai')->count();

        // Jumlah order dengan status 'pending' atau 'proses' atau belum selesai
        $jumlahBelumSelesai = Order::where('status_order', '!=', 'selesai')->count();

        // Total semua order
        $jumlahSemua = Order::count();

        return view('admin.dashboard-admin', [
            'title' => 'Dashboard',
            'totalPendapatan' => $totalPendapatan,
            'jumlahSelesai' => $jumlahSelesai,
            'jumlahBelumSelesai' => $jumlahBelumSelesai,
            'jumlahSemua' => $jumlahSemua,
        ]);
    }
}
