<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{

	public $table = 'dev_bayar_m';
	protected $primaryKey = 'nim';
	public $timestamps = false;
	
	protected $fillable = [
		'no_bayar','kode_lokasi','nim','tanggal','keterangan','periode'
	];
}