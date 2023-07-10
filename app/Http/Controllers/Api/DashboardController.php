<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{
  public function getStatistikPendaftaran(Request $request)
  {
    $tahun_pendaftaran = Carbon::now()->format('Y');
    if ($request->has('tahun')) {
      if (!empty($request->tahun)) {
        $tahun_pendaftaran = $request->tahun;
      }
    }
    $userRegistered = User::toBase()
      ->selectRaw('month(created_at) as month')
      ->selectRaw('count(*) as count')
      ->whereYear('created_at', $tahun_pendaftaran)
      ->groupBy('month')
      ->orderBy('month')
      ->pluck('count', 'month');

    $monthFilled = [];
    for ($i = 0; $i < 12; $i++) {
      $monthFilled[$i] = array_key_exists($i + 1, $userRegistered->toArray()) ? $userRegistered->toArray()[$i + 1] : 0;
    }

    return $this->sendResponse(0, "Sukses", $monthFilled);
  }

  public function getStatistikPendapatan(Request $request)
  {
    $tahun_pendapatan = Carbon::now()->format('Y');
    if ($request->has('tahun')) {
      if (!empty($request->tahun)) {
        $tahun_pendapatan = $request->tahun;
      }
    }
    $userRegistered = Transaction::toBase()
      ->selectRaw('month(created_at) as month')
      ->selectRaw('sum(total_amount) as count')
      ->whereYear('created_at', $tahun_pendapatan)
      ->groupBy('month')
      ->orderBy('month')
      ->pluck('count', 'month');

    $monthFilled = [];
    for ($i = 0; $i < 12; $i++) {
      $monthFilled[$i] = array_key_exists($i + 1, $userRegistered->toArray()) ? $userRegistered->toArray()[$i + 1] : 0;
    }

    return $this->sendResponse(0, "Sukses", $monthFilled);
  }

  public function getDataDashboard()
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
      if ($previousMonthly > 0) {
        $percent = -$percent_from / $previousMonthly * 100; //decrease percent
      } else {
        $percent = 0; //decrease percent
      }

      $jenis = 'turun';
    }

    $tahun_sekarang = Carbon::now()->format('Y');
    $user_registered = User::whereYear('created_at', $tahun_sekarang)
      ->whereMonth('created_at', Carbon::now()->month)
      ->count();

    $userMonthly = User::whereYear('created_at', $tahun_sekarang)
      ->whereMonth('created_at', Carbon::now()->month)->count();

    $userPreviousMonthly = User::whereYear('created_at', $tahun_sekarang)
      ->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

    if ($userPreviousMonthly < $userMonthly) {
      if ($userPreviousMonthly > 0) {
        $user_precent_from = $userMonthly - $userPreviousMonthly;
        $user_percent = $user_precent_from / $userPreviousMonthly * 100; //increase user_percent
      } else {
        $user_percent = 100; //increase user_percent
      }
      $user_jenis = 'naik';
    } else {
      $user_percent_from = $userPreviousMonthly - $userMonthly;

      if ($userPreviousMonthly > 0) {
        $user_percent = -$user_percent_from / $userPreviousMonthly * 100; //increase user_percent
      } else {
        $user_percent = 0; //increase user_percent
      }
      $user_jenis = 'turun';
    }

    // transaksi
    $jumlah_transaksi = Transaction::whereYear('created_at', $tahun_sekarang)
      ->whereMonth('created_at', Carbon::now()->month)
      ->count();

    $transactionMonthly = Transaction::whereYear('created_at', $tahun_sekarang)
      ->whereMonth('created_at', Carbon::now()->month)->count();

    $transactionPrevMonthly = Transaction::whereYear('created_at', $tahun_sekarang)
      ->whereMonth('created_at', Carbon::now()->subMonth()->month)->count();

    if ($transactionPrevMonthly < $transactionMonthly) {
      if ($transactionPrevMonthly > 0) {
        $transaction_percent_from = $transactionMonthly - $transactionPrevMonthly;
        $transaction_percent = $transaction_percent_from / $transactionPrevMonthly * 100; //increase transaction_percent
      } else {
        $transaction_percent = 100; //increase transaction_percent
      }
      $transaction_jenis = 'naik';
    } else {
      $transaction_percent_from = $transactionPrevMonthly - $transactionMonthly;
      if ($transactionPrevMonthly > 0) {
        $transaction_percent = -$transaction_percent_from / $transactionPrevMonthly * 100; //decrease transaction_percent
      } else {
        $transaction_percent = 0; //decrease transaction_percent
      }
      $transaction_jenis = 'turun';
    }


    $data = [
      'total_pembelian' => [
        'nilai' => $total,
        'percent' => number_format($percent, 1),
        'naik_turun' => $jenis,
      ],
      'jumlah_pendaftar' => [
        'nilai' => $user_registered,
        'percent' => $user_percent,
        'naik_turun' => $user_jenis
      ],
      'jumlah_transaksi' => [
        'nilai' => $jumlah_transaksi,
        'percent' => $transaction_percent,
        'naik_turun' => $transaction_jenis
      ]
    ];

    return $this->sendResponse(0, "Sukses", $data);
  }

  public function getStatistikPenjualanGame(Request $request)
  {
    $tahun = Carbon::now()->format('Y');
    if ($request->has('tahun')) {
      if (!empty($request->tahun)) {
        $tahun = $request->tahun;
      }
    }
    $bulan = Carbon::now()->month;
    if ($request->has('bulan')) {
      if (!empty($request->bulan)) {
        $bulan = $request->bulan;
      }
    }

    $data = Transaction::selectRaw('games.title as title')->selectRaw('sum(total_amount) as total')
      ->join('transaction_detail', 'transaction.transaction_code', '=', 'transaction_detail.transaction_code')
      ->join('games_item', 'transaction_detail.item_code', '=', 'games_item.code')
      ->join('games', 'games_item.game_code', '=', 'games.code')
      ->whereYear('transaction.created_at', $tahun)
      ->whereMonth('transaction.created_at', $bulan)
      ->where('status', 'done')
      ->groupBy('games.title')
      ->get();

    $data_penjualan = [];
    $label = [];
    foreach ($data as $item) {
      $data_penjualan[] = $item->total;
      $label[] = $item->title;
    }

    $result = [
      'jumlah_penjualan' => $data_penjualan,
      'label' => $label
    ];

    if ($data) {
      return $this->sendResponse(0, "Sukses", $result);
    }
  }

  public function getListOrder(Request $request)
  {
    $tanggal = $request->tanggal;
    $select = [
      'transaction_code',
      'total_amount',
      'created_at',
      'status',
    ];
    $riwayat_pembelian = Transaction::select($select)
      ->when($request->has('tanggal') && !empty($tanggal), function ($query) use ($tanggal) {
        $query->whereDate('created_at', '=', $tanggal);
      })
    ->get();

    $waiting = $this->filterTransaction($riwayat_pembelian, "waiting");
    $success = $this->filterTransaction($riwayat_pembelian, "success");
    $failed = $this->filterTransaction($riwayat_pembelian, "failed");
    $expired = $this->filterTransaction($riwayat_pembelian, "expired");

    $result = [
      "transaksi_tanggal" => $tanggal,
      "transaksi_waiting" => $waiting,
      "transaksi_success" => $success,
      "transaksi_expired" => $expired,
      "transaksi_failed" => $failed,
    ];
    return $this->sendResponse(0, "Sukses", $result);
  }

  public function filterTransaction($params, $filter)
  {
    $filtering = $params->filter(function ($pembelian) use ($filter) {
      return $pembelian->status === $filter;
    });
    $count = $filtering->count();
    return $count;
  }
}
