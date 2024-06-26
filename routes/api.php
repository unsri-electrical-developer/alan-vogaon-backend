<?php

use App\Http\Controllers\Api\VoucherResend;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\GamesController;
use App\Http\Controllers\Api\GamesItemController;
use App\Http\Controllers\Api\GamesVoucherController;
use App\Http\Controllers\Api\GeneralInfoController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\PaymentGatewayController;
use App\Http\Controllers\Api\PaymentMethodController;
use App\Http\Controllers\Api\PrivacyPolicyController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\RiwayatPembelianController;
use App\Http\Controllers\Api\RiwayatTopUpController;
use App\Http\Controllers\Api\SlidersController;
use App\Http\Controllers\Api\SyaratKetentuanController;
use App\Http\Controllers\Api\TestController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\AuthorCollection;

Route::group(['prefix' => 'v1'], function () {
  Route::get('/', [TestController::class, 'test']);
  Route::post('/test', [TestController::class, 'test']);
  Route::post('/login', [AuthController::class, 'login']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum', 'ability:admin']], function () {

  // Auth
  Route::post('/check/token', [AuthController::class, 'tokenCheck']);

  Route::post('/logout', [AuthController::class, 'logout']);

  // Users
  Route::get('/users/saldo/all', [UserController::class, 'saldoUsers']);
  Route::apiResource('/users', UserController::class);

  Route::post('/users/pin/change', [UserController::class, 'changeUserPin']);
  Route::post('/users/status/change', [UserController::class, 'changeUserStatus']);
  Route::post('/users/password/change', [UserController::class, 'changeUserPassword']);
  Route::post('/users/level/change', [UserController::class, 'changeUserLevel']);
  Route::delete('/users/delete/{users_code}', [UserController::class, 'deleteUser']);
  

  // Category
  Route::apiResource('/category', CategoryController::class);

  // Games
  Route::apiResource('/games', GamesController::class);


  // GamesVoucher
  Route::apiResource('/game_voucher', GamesVoucherController::class);
  Route::post('/game_voucher/{game_code}', [GamesVoucherController::class, 'store']);
  Route::get('/game_voucher/voucher/list', [GamesVoucherController::class, 'listProductVoucher']);

  // Sliders
  Route::apiResource('/sliders', SlidersController::class);

  // Games Item / Products
  Route::apiResource('/games_item/{game_code}/products', GamesItemController::class);

 

  // Payment Gateway
  Route::apiResource('/payment_gateway', PaymentGatewayController::class);

  // Payment Method
  Route::apiResource('/payment_method', PaymentMethodController::class);
  Route::post('/payment_method/change/reorder', [PaymentMethodController::class, 'reorderPaymentMethod']);
  Route::post('/payment_method/{pm_code}', [PaymentMethodController::class, 'togglePaymentMethod']);


  // Riwayat Pembelian
  Route::get('/transaction/riwayat_pembelian', [RiwayatPembelianController::class, 'getAllRiwayatPembelian']);
  Route::get('/transaction/riwayat_pembelian/total', [RiwayatPembelianController::class, 'getJumlahPendapatan']);
  Route::get('/transaction/detail_pembelian/{kode}', [RiwayatPembelianController::class, 'getDetailPembelian']);
  Route::patch('/transaction/edit_status', [RiwayatPembelianController::class, 'editStatusPembelian']);

  // Riwayat Top Up Saldo
  Route::get('/transaction/riwayat_topupsaldo', [RiwayatTopUpController::class, 'getRiwayatTopUpSaldo']);
  Route::get('/transaction/total_topupsaldo', [RiwayatTopUpController::class, 'getTotalTopUpSaldo']);
  Route::get('/transaction/detail_topupsaldo/{kode}', [RiwayatTopUpController::class, 'getDetailTopUpSaldo']);
  Route::get('/transaction/users_topup', [RiwayatTopUpController::class, 'getUsersTopup']);
  Route::get('/transaction/detail_user_topup/{user_code}', [RiwayatTopUpController::class, 'getDetailUserTopup']);
  Route::patch('/transaction/ganti_saldo', [RiwayatTopUpController::class, 'updateUserSaldo']);

  // General Info
  Route::get('/general_info', [GeneralInfoController::class, 'getGeneralInfo']);
  Route::post('/general_info', [GeneralInfoController::class, 'setGeneralInfo']);

  // Faq
  Route::get('/faq', [FaqController::class, 'getFaq']);
  Route::post('/faq', [FaqController::class, 'setFaq']);

  // S&K
  Route::get('/syarat_ketentuan', [SyaratKetentuanController::class, 'getSyaratKetentuan']);
  Route::post('/syarat_ketentuan', [SyaratKetentuanController::class, 'setSyaratKetentuan']);

  // Privacy Policy
  Route::get('/privacy_policy', [PrivacyPolicyController::class, 'getPrivacyPolicy']);
  Route::post('/privacy_policy', [PrivacyPolicyController::class, 'setPrivacyPolicy']);

  // Dashboard
  Route::get('/dashboard/data_dashboard', [DashboardController::class, 'getDataDashboard']);
  Route::get('/dashboard/statistik_pendapatan', [DashboardController::class, 'getStatistikPendapatan']);
  Route::get('/dashboard/statistik_pendaftaran', [DashboardController::class, 'getStatistikPendaftaran']);
  Route::get('/dashboard/statistik_penjualan_game', [DashboardController::class, 'getStatistikPenjualanGame']);
  Route::get('/dashboard/dataorder', [DashboardController::class, 'getListOrder']);

  // Profile
  Route::patch('/profile/edit_profile', [ProfileController::class, 'editProfile']);
  Route::get('/profile/get_profile', [ProfileController::class, 'getProfile']);

  // KODE PROMO
  Route::get('/promo', [PromoController::class, 'getPromo']);
  Route::get('/promo/{code}', [PromoController::class, 'getDetailPromo']);
  Route::post('/promo/add', [PromoController::class, 'addPromo']);
  Route::post('/promo/edit', [PromoController::class, 'editPromo']);
  Route::post('/promo/edit/status', [PromoController::class, 'updateStatusPromo']);
  Route::delete('/promo/delete/{code}', [PromoController::class, 'deletePromo']);

  // Admin
  Route::get('/admin', [AdminController::class, 'getAdmin']);
  Route::get('/admin/{code}', [AdminController::class, 'getDetailAdmin']);
  Route::post('/admin/add', [AdminController::class, 'addAdmin']);
  Route::post('/admin/edit', [AdminController::class, 'editAdmin']);
  Route::delete('/admin/delete/{code}', [AdminController::class, 'deleteAdmin']);

  Route::get('/fa_barcode', [AdminController::class, 'getFABarcode']);
  Route::post('/fa_barcode/pair', [AdminController::class, 'pairFABarcode']);

  Route::post('/maintenance', [AdminController::class, 'setMaintenanceMode']);
  Route::post('/voucher/resend_email', [VoucherResend::class, 'resendByEmail']);
});
