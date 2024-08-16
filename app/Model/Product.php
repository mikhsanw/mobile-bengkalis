<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $casts=[
        'id'=>'string',
    ];

    protected $fillable=[
        'id', 'nama', 'deskripsi', 'harga', 'jenis', 'kim_id', 'kim_anggota_id',
    ];
    
	public function kim()
	{
		return $this->belongsTo('App\Model\Kim');
	}

	public function kimanggota()
	{
		return $this->belongsTo('App\Model\KimAnggota');
	}

	public function file()
    {
        return $this->morphMany(File::class, 'morph');
    }

    public function scopeByLevelKim($query)
    {
        if (isset(Auth::user()->kim_anggota->level_kim) && Auth::user()->kim_anggota->level_kim == 1) {
            return $query->where('kim_id',Auth::user()->kim_anggota->kim_id)->latest();
        }else{
            return $query->latest();
        }
    }
}
