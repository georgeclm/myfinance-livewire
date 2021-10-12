<?php

use App\Http\Livewire\{
    Cicilan,
    Financialplan,
    Home,
    Investasi,
    Investasi\Deposito,
    Investasi\P2p,
    Investasi\Stock,
    Login,
    MutualFund,
    Register,
    Rekening,
    Rekening\Detail,
    Setting,
    Transaction,
    Transaction\Detail as TransactionDetail,
    Utang,
    Utangteman
};
use Illuminate\Support\Facades\Route;
use App\Models\Bank;
use App\Models\Ticker;
use Illuminate\Http\Request;
use App\Http\Controllers\GoogleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/register', Register::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/', Home::class)->name('home');
    Route::get('/pockets', Rekening::class)->name('rekening');
    Route::get('/debts', Utang::class)->name('utang');
    Route::get('/frdebts', Utangteman::class)->name('utangteman');
    Route::get('/pockets/{rekening}', Detail::class)->name('rekening.show');
    Route::get('/transactions', Transaction::class)->name('transaction');
    Route::get('/repetitions', Cicilan::class)->name('cicilan');
    Route::get('/financialplans', Financialplan::class)->name('financialplan');
    Route::get('/investments', Investasi::class)->name('investasi');
    Route::get('/stocks', Stock::class)->name('stock');
    Route::get('/p2ps', P2p::class)->name('p2p');
    Route::get('/settings', Setting::class)->name('setting');
    Route::get('/mutualfunds', MutualFund::class)->name('mutualfund');
    Route::get('/deposito', Deposito::class)->name('deposito');
    Route::get('/transactions/{id}', TransactionDetail::class)->name('transaction.detail');
});

Route::get('bank-search', function (Request $request) {
    $search = false;
    if ($request->has('q') && $request->input('q') !== '') {
        $search = true;
    }
    $banks = Bank::where('code', '!=', '9999')
        ->when($search, function ($query) use ($request) {
            $query->where('nama', 'LIKE', "%{$request->input('q')}%");
        })->get();
    return response()->json($banks);
});
Route::get('ticker-search', function (Request $request) {
    $search = false;
    if ($request->has('q') && $request->input('q') !== '') {
        $search = true;
    }
    $tickers = Ticker::when($search, function ($query) use ($request) {
        $query->where('nama', 'LIKE', "%{$request->input('q')}%")
            ->orWhere('code', 'LIKE', "%{$request->input('q')}%");
    })->get();
    return response()->json($tickers);
});
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
