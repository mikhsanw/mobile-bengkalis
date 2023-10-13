<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opd extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $casts=[
        'id'=>'string',
    ];

    protected $fillable=[
        'id', 'nama', 'singkatan',
    ];
    
	public function aplikasis()
	{
		return $this->hasMany('App\Model\Aplikasi');
	}

	public function permohonans()
	{
		return $this->hasMany('App\Model\Permohonan');
	}

	public function file()
    {
        return $this->morphOne(File::class, 'morph');
    }
}
