<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kim extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $casts=[
        'id'=>'string',
    ];

    protected $fillable=[
        'id', 'nama', 'alamat', 'keterangan', 'wilayah_id',
    ];
    
	public function wilayah()
	{
		return $this->belongsTo('App\Model\Wilayah');
	}

    public function scopeByLevel($query)
    {
        if (isset(Auth::user()->kim_anggota->level_kim) && Auth::user()->kim_anggota->level_kim == 1) {
            return $query->where('id',Auth::user()->kim_anggota->kim_id)->latest();
        }else{
            return $query->latest();
        }
    }
}
