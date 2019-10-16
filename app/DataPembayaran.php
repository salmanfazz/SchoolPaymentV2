<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DataPembayaran extends Model
{
	public $table = 'dev_bayar_d';
	public $timestamps = false;
	
	protected $fillable = [
		'no_tagihan','kode_lokasi','keterangan','nilai'
	];
}