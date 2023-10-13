<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permohonan extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $casts=[
        'id'=>'string',
    ];

    protected $fillable=[
        'id', 'no_identitas', 'nama', 'alamat', 'email', 'no_telp', 'pekerjaan', 'rincian_informasi', 'tujuan_penggunaan', 'opd_id', 'cara_memperoleh', 'salinan_informasi', 'cara_mendapatkan','jenis_pemohon'
    ];
    
	public function datainformasis()
	{
		return $this->hasMany('App\Model\DataInformasi');
	}

	public function opd()
	{
		return $this->belongsTo('App\Model\Opd');
	}

	public function file()
    {
        return $this->morphOne(File::class, 'morph');
    }
}
