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
        'google_id'
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
        return $this->hasMany(Rekening::class);
    }
    public function all_transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    public function transactions($daterange = null)
    {
        $return = $this->hasMany(Transaction::class);
        if ($daterange != null) {
            $date_range1 = explode(" / ", $daterange);
            $return = $return->where('created_at', '>=', $date_range1[0]);
            $return = $return->where('created_at', '<=', $date_range1[1]);
            return $return->latest()->get();
        }
        return $return->whereMonth('created_at', now()->month)->orderBy('created_at', 'desc');
    }
    public function utangs()
    {
        return $this->hasMany(Utang::class)->where('lunas', 0)->latest();
    }
    public function utangtemans()
    {
        return $this->hasMany(Utangteman::class)->where('lunas', 0)->latest();
    }
    public function financialplans()
    {
        return $this->hasMany(FinancialPlan::class);
    }
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }
    public function p2ps()
    {
        return $this->hasMany(P2P::class)->latest();
    }
    public function mutual_funds()
    {
        return $this->hasMany(MutualFund::class);
    }
    public function depositos()
    {
        return $this->hasMany(Deposito::class)->latest();
    }
    public function cicil_notifications()
    {
        return $this->hasMany(NotifCicilan::class)->latest();
    }
    public function total_stocks()
    {
        return $this->stocks()->withTrashed();
    }
    public function total_mutual_funds()
    {
        return $this->mutual_funds()->withTrashed();
    }
    public function total_depositos()
    {
        return $this->depositos->sum('jumlah');
    }
    public function total_stocks_gain_or_loss()
    {
        return $this->stocks()->withTrashed()->sum('gain_or_loss') + $this->previous_stock;
    }
    public function total_mutual_fund_gain_or_loss()
    {
        return $this->mutual_funds()->withTrashed()->sum('gain_or_loss') + $this->previous_reksadana;
    }
    public function total_p2ps()
    {
        return $this->p2ps->sum('jumlah');
    }
    public function total_p2p_gain_or_loss()
    {
        return $this->p2ps()->onlyTrashed()->sum('gain_or_loss') + $this->previous_p2p;
    }
    public function total_depositos_gain_or_loss()
    {
        return $this->depositos()->onlyTrashed()->sum('gain_or_loss') + $this->previous_deposito;
    }

    public function total_investments()
    {
        return $this->total_stocks->sum('total') + $this->total_p2ps() + $this->total_mutual_funds->sum('total') + $this->total_depositos();
    }
    // public function uangmasuk($daterange = null)
    // {
    //     return $this->transactions($daterange)->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10')->sum('jumlah');
    // }
    public function uangmasuk($daterange = null)
    {
        return $this->transactions($daterange)->where('jenisuang_id', 1)->where('category_masuk_id', '!=', '10');
    }

    public function uangkeluar($daterange = null)
    {
        return $this->transactions($daterange)->where('jenisuang_id', 2)->where('category_id', '!=', '10');
    }
    public function saldoperbulan()
    {
        return $this->uangmasuk->sum('jumlah') - $this->uangkeluar->sum('jumlah');
    }
    public function saldo()
    {
        return $this->rekenings->sum('saldo_sekarang') - $this->saldoMengendap();
    }
    public function saldoMengendap()
    {
        return $this->rekenings->sum('saldo_mengendap');
    }
    public function totalutang()
    {
        return $this->utangs->sum('jumlah');
    }
    public function totalutangteman()
    {
        return $this->utangtemans->sum('jumlah');
    }
    public function uang()
    {
        return $this->saldo() - $this->totalutang() + $this->totalutangteman();
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
        return round($this->total_stocks->sum('total') / $this->asset() * 100);
    }
    public function mutualfund_persen()
    {
        return round($this->total_mutual_funds->sum('total') / $this->asset() * 100);
    }
    public function deposito_persen()
    {
        return round($this->total_depositos() / $this->asset() * 100);
    }
    public function p2p_persen()
    {
        return round($this->total_p2ps() / $this->asset() * 100);
    }
}
