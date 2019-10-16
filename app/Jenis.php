<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jenis extends Model
{
	public $table = 'dev_jenis';
	
	protected $fillable = [
		'kode_jenis','nama'
	];
}