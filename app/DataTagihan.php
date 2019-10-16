<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataTagihan extends Model
{
	public $table = 'dev_tagihan_d';
	protected $primaryKey = 'kode_jenis';
	public $timestamps = false;
	
	protected $fillable = [
		'no_tagihan','kode_lokasi','kode_jenis','nilai'
	];
}