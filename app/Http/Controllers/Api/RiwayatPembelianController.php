<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RiwayatPembelianController extends ApiController
{
        public function getAllRiwayatPembelian(Request $request)
    {
        $select = [
            'transaction.transaction_code',
            'users.name',
            'games_item.title as item_title',
            'games_item.price',
            'games.title as game_title',
            'transaction.created_at',
            'transaction.status'
        ];

        $riwayat_pembelian = Transaction::select($select)
        ->join('transaction_detail', 'transaction.transaction_code', '=', 'transaction_detail.transaction_code')
        ->join('users', 'transaction.users_code', '=', 'users.users_code')
        ->join('games_item', 'transaction_detail.item_code', '=', 'games_item.code')
        ->join('games', 'games.code', '=', 'games_item.game_code')
        ->when($request->has('tanggal'), function ($query) use ($request) {
            $query->whereDate('transaction.created_at', '=', $request->tanggal);
        })
        ->when($request->has('search'), function ($query) use ($request) {
            $query->where('games.title', 'like', '%' . $request->search . '%')
            ->orWhere('games_item.title', 'like', '%' . $request->search . '%')
            ->orWhere('users.name', 'like', '%' . $request->search . '%');
        })
        ->orderBy('transaction.created_at', )->get();

        foreach ($riwayat_pembelian as $item) {
            $item->nama_produk = $item->game_title . " " . $item->item_title;
            $item->waktu_transaksi = $item->created_at->format('Y-m-d');
        }

        return $this->sendResponse(0, "Sukses", $riwayat_pembelian);
    }

    public function getJumlahPendapatan(Request $request)
    {
        $total = Transaction::where('status', 'done')->sum('total_amount');

        $dateFrom = Carbon::now()->subDays(30);
        $dateTo = Carbon::now();
        $monthly = Transaction::whereBetween('created_at', [$dateFrom, $dateTo])->sum('total_amount');

        $previousDateFrom = Carbon::now()->subDays(60);
        $previousDateTo = Carbon::now()->subDays(31);
        $previousMonthly = Transaction::whereBetween('created_at', [$previousDateFrom,$previousDateTo])->sum('total_amount');
        
        if($previousMonthly < $monthly){
            if($previousMonthly >0){
                $percent_from = $monthly - $previousMonthly;
                $percent = $percent_from / $previousMonthly * 100; //increase percent
            }else{
                $percent = 100; //increase percent
            }
            $jenis = 'naik';
        }else{
            $percent_from = $previousMonthly -$monthly;
            $percent = -($percent_from / $previousMonthly * 100); //decrease percent
            $jenis = 'turun';
        }

        return $this->sendResponse(0, "Sukses", [
            "jumlah_pendapatan" => $total,
            "persentase" => number_format($percent, 1),
            "naik_turun" => $jenis,
        ]);
    }

    public function getDetailPembelian(Request $request, $kode)
    {
        $kode_transaksi = $kode;
        $select = [
            'transaction.transaction_code',
            'users.name',
            'games_item.title as item_title',
            'games_item.price',
            'games.title as game_title',
            'transaction.created_at',
            'transaction.status',
            'payment_method.pm_title as payment_method',
            'transaction.no_reference'
        ];
        $data = Transaction::select($select)
        ->join('transaction_detail', 'transaction.transaction_code', '=', 'transaction_detail.transaction_code')
        ->join('users', 'transaction.users_code', '=', 'users.users_code')
        ->join('games_item', 'transaction_detail.item_code', '=', 'games_item.code')
        ->join('games', 'games.code', '=', 'games_item.game_code')
        ->join('payment_method', 'payment_method.pm_code', '=', 'transaction.payment_method')
        ->where('transaction.transaction_code', $kode_transaksi)
        ->first();

        if (!$data) {
            return $this->sendError(1, "Data tidak ditemukan!", []);
        }

        $data->nama_produk = $data->game_title . " " . $data->item_title;
        $data->tanggal = $data->created_at->format('d/m/Y');

        return $this->sendResponse(0, "Sukses", $data);
    }
}
