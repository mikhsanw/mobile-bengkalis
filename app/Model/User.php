<?php

namespace App\Model;

use Carbon\Carbon;
use App\Traits\Uuid;
use Carbon\Traits\Cast;
use Laravel\Sanctum\Sanctum;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasUuids,SoftDeletes,Cast;
    
    protected $dates=['deleted_at'];
    protected $fillable=[
        'id','username','nama','email', 'password', 'email_verified_at', 'level', 'aksesgrup_id','remember_token'
    ];
    protected $hidden=[
        'password', 'remember_token',
    ];
    protected $casts=[
        'email_verified_at'=>'datetime',
        'id'=>'string',
    ];

    // public static function boot()
    // {
    //     parent::boot();
    //     static::creating(function ($model) {
    //         $model->id=\Ramsey\Uuid\Uuid::uuid4()->toString();
    //         $model->email_verified_at=Carbon::now();
    //     });
    // }

    public function setPasswordAttribute($value)
    {
        if ($value != "") {
            $this->attributes['password']=bcrypt(trim($value));
        }
    }

    public function scopeByLevel($query)
    {
        if (Auth::user()->level == 1) {
            return $query->where('aksesgrup_id','!=' ,2)->latest();
        }elseif(Auth::user()->level == 2){
            return $query->whereIn('aksesgrup_id', [2,3])->latest();
        }
        else {
            return $query->where('aksesgrup_id', '!=', 1)->latest();
        }
    }

    public function aksesgrup()
    {
        return $this->belongsTo('App\Model\Aksesgrup');
    }

    public function berita()
    {
        return $this->hasMany('App\Model\Berita');
    }

    public function kim_anggota()
    {
        return $this->hasOne(KimAnggota::class);
    }

    public function getUnorIdAttribute()
    {
        return $this->penempatan()->whereDefinitif(TRUE)->first()->unor_id ?? ($this->penempatan()->first()->unor_id ?? null);
    }

    public function tokens(): object
    {
        return $this->morphMany(Sanctum::$personalAccessTokenModel, 'tokenable');
    }
    
    public static function boot()
    {
        parent::boot();
        static::deleted(function ($user) {
            $user->tokens()->delete();
        });
    }
}
