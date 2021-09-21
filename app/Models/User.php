<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public static function checkToken($token)
    {
        if ($token->token) {
            return true;
        }
        return false;
    }
    public static function getCurrentUser($request)
    {
        if (!User::checkToken($request)) {
            return response()->json([
                'message' => 'Token is required'
            ], 422);
        }

        $user = JWTAuth::parseToken()->authenticate();
        return $user;
    }
    public function rekenings()
    {
        return $this->hasMany(Rekening::class)->where('user_id', $this->id);
    }
    public function all_transactions()
    {
        return $this->hasMany(Transaction::class)->where('user_id', $this->id);
    }
    public function transactions($daterange = null)
    {
        $return = $this->hasMany(Transaction::class)->where('user_id', $this->id);
        if ($daterange != null) {
            $date_range1 = explode(" / ", $daterange);
            $return = $return->where('created_at', '>=', $date_range1[0]);
            $return = $return->where('created_at', '<=', $date_range1[1]);
            return $return->get();
        }
        return $return->whereMonth('created_at', now()->month)->orderBy('created_at', 'desc');

        // if (request()->has('q')) {
        //     return (request()->q == 1)
        //         ? $this->hasMany(Transaction::class)->whereMonth('created_at', now()->subMonth()->month)->where('user_id', $this->id)
        //         : $this->hasMany(Transaction::class)->where('user_id', $this->id);
        // }
        // return $this->hasMany(Transaction::class)->whereMonth('created_at', now()->month)->where('user_id', $this->id);
    }
    public function utangs()
    {
        return $this->hasMany(Utang::class)->where('user_id', $this->id)->where('lunas', 0)->orderBy('created_at', 'desc');
    }
    public function utangtemans()
    {
        return $this->hasMany(Utangteman::class)->where('user_id', $this->id)->where('lunas', 0);
    }
    public function financialplans()
    {
        return $this->hasMany(FinancialPlan::class)->where('user_id', $this->id);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class)->where('user_id', $this->id)->latest();
    }
    public function p2ps()
    {
        return $this->hasMany(P2P::class)->where('user_id', $this->id)->latest();
    }
    public function p2pscount()
    {
        return $this->hasMany(P2P::class)->where('user_id', $this->id)->withTrashed()->count();
    }
    public function total_stocks()
    {
        return $this->stocks()->withTrashed()->sum('total');
    }
    public function total_mutual_funds()
    {
        return $this->mutual_funds()->withTrashed()->sum('total');
    }
    public function total_depositos()
    {
        return $this->depositos()->sum('jumlah');
    }
    public function mutual_funds()
    {
        return $this->hasMany(MutualFund::class)->where('user_id', $this->id)->latest();
    }
    public function depositos()
    {
        return $this->hasMany(Deposito::class)->where('user_id', $this->id)->latest();
    }
    public function total_stocks_gain_or_loss()
    {
        return $this->stocks()->withTrashed()->sum('gain_or_loss');
    }
    public function total_mutual_fund_gain_or_loss()
    {
        return $this->mutual_funds()->withTrashed()->sum('gain_or_loss');
    }
    public function total_p2ps()
    {
        return $this->p2ps()->sum('jumlah');
    }
    public function total_p2p_gain_or_loss()
    {
        return $this->p2ps()->onlyTrashed()->sum('gain_or_loss') + $this->previous_p2p;
    }
    public function total_depositos_gain_or_loss()
    {
        return $this->depositos()->onlyTrashed()->sum('gain_or_loss');
    }

    public function total_investments()
    {
        return $this->total_stocks() + $this->total_p2ps() + $this->total_mutual_funds() + $this->total_depositos();
    }
    public function uangmasuk($daterange = null)
    {
        return $this->transactions($daterange)->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10')->sum('jumlah');
    }
    public function uangmasuk_by_month($month = null)
    {
        return $this->hasMany(Transaction::class)->whereMonth('created_at', now()->subMonth($month)->month)->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10')->sum('jumlah');
    }
    public function uangkeluar_by_month($month = null)
    {
        return $this->hasMany(Transaction::class)->whereMonth('created_at', now()->subMonth($month)->month)->where('jenisuang_id', 2)->where('category_id', '!=', '10')->sum('jumlah');
    }
    public function uangkeluar($daterange = null)
    {
        return $this->transactions($daterange)->where('jenisuang_id', 2)->where('category_id', '!=', '10')->sum('jumlah');
    }
    public function saldoperbulan($daterange = null)
    {
        return $this->uangmasuk($daterange) - $this->uangkeluar($daterange);
    }
    public function saldo()
    {
        return $this->rekenings()->sum('saldo_sekarang') - $this->saldoMengendap();
    }
    public function saldoMengendap()
    {
        return $this->rekenings()->sum('saldo_mengendap');
    }
    public function totalutang()
    {
        return $this->utangs()->sum('jumlah');
    }
    public function totalutangteman()
    {
        return $this->utangtemans()->sum('jumlah');
    }
    public function uang()
    {
        return $this->saldo() - $this->totalutang() + $this->totalutangteman();
    }
    public function cicil_notifications()
    {
        return $this->hasMany(NotifCicilan::class)->where('user_id', $this->id)->latest();
    }
    public function total_notif()
    {
        return $this->cicil_notifications->where('check', 0)->count();
    }

    public function total_with_assets()
    {
        return $this->saldo() + $this->total_investments() - $this->totalutang() + $this->totalutangteman();
    }
    public function asset()
    {
        return $this->saldo() + $this->total_investments();
    }
    public function saldo_persen()
    {
        return round($this->saldo() / $this->asset() * 100);
    }
    public function stock_persen()
    {
        if ($this->stocks->count() != 0) {
            return round($this->total_stocks() / $this->asset() * 100);
        }
        return 0;
    }
    public function mutualfund_persen()
    {
        if ($this->mutual_funds->count() != 0) {
            return round($this->total_mutual_funds() / $this->asset() * 100);
        }
        return 0;
    }
    public function deposito_persen()
    {
        if ($this->depositos->count() != 0) {
            return round($this->total_depositos() / $this->asset() * 100);
        }
        return 0;
    }
    public function p2p_persen()
    {
        if ($this->p2ps()->count() != 0) {

            return round($this->total_p2ps() / $this->asset() * 100);
        }
        return 0;
    }
}
