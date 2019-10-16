<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
	public $table = 'dev_jur';
	
	protected $fillable = [
		'kode_jur','nama'
	];
}