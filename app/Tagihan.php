<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tagihan extends Model
{
	public $table = 'dev_tagihan_m';
	protected $primaryKey = 'no_tagihan';
	public $timestamps = false;
	
	protected $fillable = [
		'no_tagihan','kode_lokasi','nim','tanggal','keterangan','periode'
	];
}