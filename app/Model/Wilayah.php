<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wilayah extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = ['id','kode','nama','level','parent_id'];
    protected $casts = [];
    protected $table = 'wilayahs';

	public function parent()
	{
		return $this->belongsTo(Wilayah::class);
	}

    public function children()
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    public function scopeProvinsi($query)
    {
        return $query->where('level', 'provinsi');
    }

    public function scopeKabupaten($query)
    {
        return $query->where('level', 'kabupaten');
    }

    public function scopeKecamatan($query)
    {
        return $query->where('level', 'kecamatan');
    }

    public function scopeKelurahan($query)
    {
        return $query->where('level', 'kelurahan');
    }
}
