<?php

use App\Http\Controllers\BrickController;
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
use App\Http\Livewire\Investasi\Stock\History;

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
    Route::get('/stocks/history', History::class)->name('stocks.history');
    Route::get('/p2ps', P2p::class)->name('p2p');
    Route::get('/settings', Setting::class)->name('setting');
    Route::get('/mutualfunds', MutualFund::class)->name('mutualfund');
    Route::get('/deposito', Deposito::class)->name('deposito');
    Route::get('/transactions/{id}', TransactionDetail::class)->name('transaction.detail');
});
Route::get('brick/access-token', [BrickController::class, 'getAccessToken']);
Route::get('brick/institution-list', [BrickController::class, 'getInstitutionList']);
Route::get('brick/create-bank', [BrickController::class, 'brickWidget'])->name('create.bankacc');
Route::middleware(['cors'])->group(function () {
    Route::post('brick/store-bank', [BrickController::class, 'storeBankAcc'])->name('store.bankacc');
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
    if ($banks->isEmpty()) {
        $banks = Bank::where('nama', 'Other Bank')->get();
    }
    return response()->json($banks);
});
Route::get('ticker-search', function (Request $request) {
    if ($request->has('q') && $request->input('q') !== '') {
        $tickers1 = Ticker::where('code', 'LIKE', "%{$request->input('q')}%")->get();
        $tickers2 = Ticker::where('nama', 'LIKE', "%{$request->input('q')}%")->get();
        $tickers = $tickers1->merge($tickers2);
    } else {
        $tickers = Ticker::all();
    }
    // $tickers = Ticker::when($search, function ($query) use ($request) {
    //     $query->where('code', 'LIKE', "%{$request->input('q')}%")
    //         ->orWhere('nama', 'LIKE', "%{$request->input('q')}%");
    // })->get();
    return response()->json($tickers);
});
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('fetch/{stock}', function ($stock) {
    $queryString = http_build_query([
        'access_key' => '3fb12d1ba1ca20adc1d483f362ce81be'
    ]);
    $code = $stock;
    $ch = curl_init(sprintf('%s?%s', "http://api.marketstack.com/v1/tickers/$code.XIDX/eod/latest", $queryString));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $json = curl_exec($ch);
    curl_close($ch);

    $apiResult = json_decode($json, true);
    dd($apiResult);
    if (!array_key_exists("close", $apiResult)) {
        return 0;
    }
    $price = $apiResult['close'];
    // dd($apiResult);
    return $price;
});
