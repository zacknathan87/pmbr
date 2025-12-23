<?php

namespace App;

use App\Models\GameRoom;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

     //
     protected $fillable = [];

     protected $dates = [];
 
     protected $guarded = [];
 
     public static $rules = [
         // Validation rules
     ];
     

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function downline() {
        return $this->hasMany('App\User', 'parent_id', 'id');
    }

    public function referrer() {
        return $this->hasOne('App\User', 'id', 'parent_id');
    }


    public function country() {
        return $this->hasOne('App\Models\Country', 'id', 'country_id');
    }

    
    public function wallet() {
        return $this->hasOne('App\Models\UserWallet', 'user_id', 'id');
    }

    public function rank() {
        return $this->hasOne('App\Models\Rank', 'id', 'rank_id');
    }

    public function myBets() {
        return $this->hasMany('App\Models\Bet', 'user_id', 'id')->orderBy('id', 'desc');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction', 'user_id', 'id');
    }

    public function totalBetsCount()
    {
        return $this->hasMany('App\Models\Bet', 'user_id', 'id')->count();
    }

    public function totalBetsAmount()
    {
        return $this->hasMany('App\Models\Bet', 'user_id', 'id')->sum('amount');
    }

    public function totalWinning()
    {
        return $this->hasMany('App\Models\Transaction', 'user_id', 'id')->where('transaction_type_id', 4)->sum('amount');
    }

    public function createdByDetail()
    {
        return $this->hasOne('App\Models\Admin', 'id', 'created_by');
    }

    public function userCurrency() {
        return $this->hasOne('App\Models\Admin', 'id', 'created_by')->pluck('currency')->first();
    }


    public function todayBetCount()
    {
        return $this->hasMany('App\Models\Bet', 'user_id', 'id')->whereDate('created_at', date('Y-m-d'))->count();
    }

    public function todayBetAmount()
    {
        return $this->hasMany('App\Models\Bet', 'user_id', 'id')->whereDate('created_at', date('Y-m-d'))->sum('amount');
    }

    public function todayWinning()
    {
        return $this->hasMany('App\Models\Bet', 'user_id', 'id')->where('is_win', 1)->whereDate('created_at', date('Y-m-d'))->sum('win_amount');
    }

    public function todayDeposit()
    {
        return $this->hasMany('App\Models\Transaction', 'user_id', 'id')->whereDate('created_at', date('Y-m-d'))->where('transaction_type_id', 1)->sum('amount');
    }

    public function depositAmount()
    {
        return $this->hasMany('App\Models\Transaction', 'user_id', 'id')->where('transaction_type_id', 1)->sum('amount');
    }

    public function withdrawalAmount()
    {
        return $this->hasMany('App\Models\Transaction', 'user_id', 'id')->where('transaction_type_id', 2)->sum('amount');
    }
}
