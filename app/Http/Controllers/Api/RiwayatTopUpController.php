<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class RiwayatTopUpController extends ApiController
{
    private $data_riwayat = [
        [
            'name' => 'Rosa Amaliya',
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
        return $this->sendResponse(0, "Sukses", [
            "jumlah_pendapatan" => 20000000,
            "persentase" => 24.5,
            "naik_turun" => "naik",
        ]);
    }

    public function getRiwayatTopUpSaldo()
    {
        
        $data = $this->data_riwayat;
        foreach ($data as $key => $value) {
            unset($data[$key]['referensi']);
        }

        return $this->sendResponse(0, "Sukses", $data);
    }

    public function getDetailTopUpSaldo(Request $request, $id)
    {
        $kode_transaksi = $id;
        $data = [];
        foreach ($this->data_riwayat as $key => $value) {
            if ($value['no_transaksi'] == $kode_transaksi) {
                $data = $value;
                break;
            }
        }

        return $this->sendResponse(0, "Sukses", $data);
    }
}
