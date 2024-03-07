<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KegiatanKim extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $casts=[
        'id'=>'string',
    ];

    protected $fillable=[
        'id', 'nama', 'lokasi', 'tanggal', 'jenis', 'deskripsi', 'kim_id','kim_anggota_id'
    ];
    
	public function kim()
	{
		return $this->belongsTo('App\Model\Kim');
	}
	public function kim_anggota()
	{
		return $this->belongsTo('App\Model\Kim');
	}

	public function file()
    {
        return $this->morphOne(File::class, 'morph');
    }
}
