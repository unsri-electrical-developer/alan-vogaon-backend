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
            ->orWhere('games_item.title', 'like', '%' . $request->search . '%');
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
        
        return $this->sendResponse(0, "Sukses", [
            "jumlah_pendapatan" => $total
        ]);
    }
}
