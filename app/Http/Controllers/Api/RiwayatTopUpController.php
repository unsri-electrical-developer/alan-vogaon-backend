<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;



class RiwayatTopUpController extends ApiController
{
    private $data_riwayat = [
        [
            'nama' => 'Rosa Amaliya',
            'nominal' => 50000,
            'no_transaksi' => 'INV7654356789',
            'waktu_transaksi' => '06/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691474'
        ],
        [
            'nama' => 'Putra Ahmad',
            'nominal' => 100000,
            'no_transaksi' => 'INV0813630766',
            'waktu_transaksi' => '06/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691473'
        ],
        [
            'nama' => 'Muhammad Kaeya',
            'nominal' => 50000,
            'no_transaksi' => 'INV6486265893',
            'waktu_transaksi' => '07/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691472'
        ],
        [
            'nama' => 'Kiara Larasati',
            'nominal' => 150000,
            'no_transaksi' => 'INV9176549256',
            'waktu_transaksi' => '06/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691472'
        ],
        [
            'nama' => 'Ferdiansyah Saputra',
            'nominal' => 200000,
            'no_transaksi' => 'INV2052087003',
            'waktu_transaksi' => '06/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691471'
        ],
        [
            'nama' => 'Rudy Bhaskara',
            'nominal' => 250000,
            'no_transaksi' => 'INV2672137822',
            'waktu_transaksi' => '06/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691470'
        ],
        [
            'nama' => 'Septi Oriana',
            'nominal' => 300000,
            'no_transaksi' => 'INV4672176712',
            'waktu_transaksi' => '05/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691469'
        ],
        [
            'nama' => 'Reina Septiani',
            'nominal' => 50000,
            'no_transaksi' => 'INV4676859101',
            'waktu_transaksi' => '05/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691468'
        ],
        [
            'nama' => 'Marcellino Putra',
            'nominal' => 150000,
            'no_transaksi' => 'INV5757143990',
            'waktu_transaksi' => '05/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691467'
        ],
        [
            'nama' => 'Marcellino Putra',
            'nominal' => 150000,
            'no_transaksi' => 'INV5757143990',
            'waktu_transaksi' => '05/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691467'
        ],
        [
            'nama' => 'Claire Kurumi',
            'nominal' => 300000,
            'no_transaksi' => 'INV5879241901',
            'waktu_transaksi' => '04/05/2023',
            'status' => "Selesai",
            'referensi' => 'VOG691466'
        ]
    ];

    public function getTotalTopUpSaldo()
    {
        $total = Transaction::where('status', 'success')
            ->where('transaction.type', 'topup')
            ->sum('total_amount');

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

    public function getRiwayatTopUpSaldo(Request $request)
    {
        
        // $data = $this->data_riwayat;
        // foreach ($data as $key => $value) {
        //     unset($data[$key]['referensi']);
        // }

        // return $this->sendResponse(0, "Sukses", $data);

        $select = [
            'transaction.transaction_code',
            'users.name',
            'transaction.total_amount',
            'transaction.created_at',
            'transaction.status',
            'transaction.type',
        ];

        $riwayat_topup = Transaction::select($select)
            ->join('users', 'transaction.users_code', '=', 'users.users_code')
            ->when($request->has('tanggal') && !empty($request->tanggal), function ($query) use ($request) {
                $query->whereDate('transaction.created_at', '=', $request->tanggal);
            })
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('users.name', 'like', '%' . $request->search . '%');
            })
            ->where('transaction.type', 'topup')
            ->orderBy('transaction.created_at',)->get();

        foreach ($riwayat_topup as $item) {
            $item->waktu_transaksi = $item->created_at->format('Y-m-d');
        }

        return $this->sendResponse(0, "Sukses", $riwayat_topup);
    }

    public function getDetailTopUpSaldo(Request $request, $kode)
    {
        // $kode_transaksi = $id;
        // $data = [];
        // foreach ($this->data_riwayat as $key => $value) {
        //     if ($value['no_transaksi'] == $kode_transaksi) {
        //         $data = $value;
        //         break;
        //     }
        // }

        // return $this->sendResponse(0, "Sukses", $data);
        try {
            $kode_transaksi = $kode;
            $select = [
                'transaction.transaction_code',
                'transaction.no_reference',
                'transaction.created_at',
                'transaction.status',
                'transaction.total_amount',
                'users.name',
                'users.email',
                'payment_method.pm_title as payment_method',

            ];
            $data = Transaction::select($select)
            ->join('users', 'transaction.users_code', '=', 'users.users_code')
            ->join('payment_method', 'payment_method.pm_code', '=', 'transaction.payment_method')
            ->where('transaction.transaction_code', $kode_transaksi)
            ->first();

            if (!$data) {
                return $this->sendError(1, "Data tidak ditemukan!", []);
            }
            
            $data->tanggal = $data->created_at->format('d/m/Y');
            

            return $this->sendResponse(0, "Sukses", $data);
        } catch (\Exception $e) {
            return $this->sendError(2, 'Gagal', $e->getMessage());
        }
        
    }
}
