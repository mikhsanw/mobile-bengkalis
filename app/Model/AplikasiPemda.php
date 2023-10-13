<?php

namespace App\Model;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AplikasiPemda extends Model
{
    use HasFactory, SoftDeletes, Uuid;

    protected $casts=[
        'id'=>'string',
    ];

    protected $fillable=[
        'id', 'nama', 'keterangan', 'opd_id',
    ];
    
	public function opd()
	{
		return $this->belongsTo('App\Model\Opd');
	}
    
    public function file()
    {
        return $this->morphOne(File::class, 'morph');
    }
}
