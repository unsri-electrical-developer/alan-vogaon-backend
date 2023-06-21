<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatPembelianController extends ApiController
{
    public function getAllRiwayatPembelian(Request $request)
    {
        $select = [
            'transaction.transaction_code',
            'users.name',
            'transaction.total_amount',
            'transaction.created_at',
            'transaction.status'
        ];

        $riwayat_pembelian = Transaction::select($select)
            ->join('transaction_detail', 'transaction.transaction_code', '=', 'transaction_detail.transaction_code')
            ->join('users', 'transaction.users_code', '=', 'users.users_code')
            ->when($request->has('tanggal') && !empty($request->tanggal), function ($query) use ($request) {
                $query->whereDate('transaction.created_at', '=', $request->tanggal);
            })
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('transaction.created_at',)->get();

        foreach ($riwayat_pembelian as $item) {
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
        $previousMonthly = Transaction::whereBetween('created_at', [$previousDateFrom, $previousDateTo])->sum('total_amount');

        if ($previousMonthly < $monthly) {
            if ($previousMonthly > 0) {
                $percent_from = $monthly - $previousMonthly;
                $percent = $percent_from / $previousMonthly * 100; //increase percent
            } else {
                $percent = 100; //increase percent
            }
            $jenis = 'naik';
        } else {
            $percent_from = $previousMonthly - $monthly;
            $percent = - ($percent_from / $previousMonthly * 100); //decrease percent
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
        try {
            $kode_transaksi = $kode;
            $select = [
                'transaction.transaction_code',
                'users.name',
                'transaction.created_at',
                'transaction.status',
                'payment_method.pm_title as payment_method',
                'transaction.no_reference'
            ];
            $data = Transaction::where('transaction_code', $kode_transaksi)
                ->with([
                    'users:name,users_code',
                    'payment_method:pm_title,pm_code'
                ])
                // ->join('users', 'transaction.users_code', '=', 'users.users_code')
                // ->join('payment_method', 'payment_method.pm_code', '=', 'transaction.payment_method')
                ->select($select)
                ->first();

            if (!$data) {
                return $this->sendError(1, "Data tidak ditemukan!", []);
            }

            $product_list = TransactionDetail::select([
                'games.title as games_title',
                'games_item.title as item_title',
                'games_item.code'
            ])
                ->join('games_item', 'transaction_detail.item_code', '=', 'games_item.code')
                ->join('games', 'games_item.game_code', '=', 'games.code')
                ->where('transaction_code', $data->transaction_code)
                ->latest('transaction_detail.created_at')->get();

            $data->tanggal = $data->created_at->format('d/m/Y');

            $product_array = [];
            if ($product_list) {
                foreach ($product_list as $item) {
                    $product_array[] = $item->games_title . ' ' . $item->item_title;
                }
            }

            $data->product_list = $product_array;

            return $this->sendResponse(0, "Sukses", $data);
        } catch (\Exception $e) {
            return $this->sendError(2, 'Gagal', $e->getMessage());
        }
    }
}
