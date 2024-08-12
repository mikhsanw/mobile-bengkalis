<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
