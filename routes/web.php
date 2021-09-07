<?php

use App\Http\Livewire\Cicilan;
use App\Http\Livewire\Financialplan;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Home;
use App\Http\Livewire\Investasi;
use App\Http\Livewire\Investasi\Deposito;
use App\Http\Livewire\Investasi\P2p;
use App\Http\Livewire\Investasi\Stock;
use App\Http\Livewire\Login;
use App\Http\Livewire\MutualFund;
use App\Http\Livewire\Register;
use App\Http\Livewire\Rekening;
use App\Http\Livewire\Rekening\Detail;
use App\Http\Livewire\Setting;
use App\Http\Livewire\Transaction;
use App\Http\Livewire\Transaction\Detail as TransactionDetail;
use App\Http\Livewire\Utang;
use App\Http\Livewire\Utangteman;

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



// From My Finance
Route::middleware('auth')->group(function () {
    // Route::resource('transactions', TransactionController::class);
    // Route::resource('investations', InvestationController::class);
    // Route::resource('stocks', StockController::class);
    // Route::resource('p2ps', P2PController::class);
    Route::put('p2ps/{p2p}/tujuan', [P2PController::class, 'updateTujuan'])->name('p2ps.update.tujuan');
    Route::post('p2ps/{p2p}/sell', [P2PController::class, 'sell'])->name('p2ps.sell');
    // Route::resource('cicilans', CicilanController::class);
    Route::put('stocks/{stock}/tujuan', [StockController::class, 'updateTujuan'])->name('stocks.update.tujuan');
    Route::post('stocks/{stock}/jual', [StockController::class, 'jual'])->name('stocks.jual');
    // Route::resource('financialplans', FinancialPlanController::class)->except('destroy');
    Route::post('financialplans/danadarurat', [FinancialPlanController::class, 'storeDanaDarurat'])->name('financialplans.danadarurat');
    Route::post('financialplans/{financialplan}/danadarurat', [FinancialPlanController::class, 'updateDanaDarurat'])->name('financialplans.danadarurat.update');
    Route::post('financialplans/danabelibarang', [FinancialPlanController::class, 'storeDanaMembeliBarang'])->name('financialplans.danabelibarang');
    Route::post('financialplans/{financialplan}/danabelibarang', [FinancialPlanController::class, 'updateDanaMembeliBarang'])->name('financialplans.danabelibarang.update');
    Route::post('financialplans/danamenabung', [FinancialPlanController::class, 'storeDanaMenabung'])->name('financialplans.danamenabung');
    Route::post('financialplans/{financialplan}/danamenabung', [FinancialPlanController::class, 'updateDanaMenabung'])->name('financialplans.danamenabung.update');
    Route::get('financialplans/{financialplan}/destroy', [FinancialPlanController::class, 'destroy'])->name('financialplans.destroy');
    // Route::resource('rekenings', RekeningController::class)->except('destroy');
    Route::get('rekenings/{id}/restore', [RekeningController::class, 'restore'])->name('rekenings.restore');
    Route::post('rekenings/{rekening}/adjust', [RekeningController::class, 'adjust'])->name('rekenings.adjust');
    Route::get('rekenings/{rekening}/destroy', [RekeningController::class, 'destroy'])->name('rekenings.destroy');
    Route::get('jenisuangs/{jenisuang}', [JenisuangController::class, 'show'])->name('jenisuangs.show');
    // Route::resource('utangs', UtangController::class);
    // Route::resource('utangtemans', UtangtemanController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('category_masuks', CategoryMasukController::class);
    // Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::get('categories/{category}/remove', [CategoryController::class, 'remove'])->name('categories.remove');
    Route::get('category_masuks/{category}/remove', [CategoryMasukController::class, 'remove'])->name('category_masuks.remove');
});
