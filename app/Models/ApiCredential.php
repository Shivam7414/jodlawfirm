<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiCredential extends Model
{
    use HasFactory;

    protected $fillable = [
		'name',
		'value',
	];

	public static function value($field)
	{
		$setting = ApiCredential::where('name', $field)->first();
		return $setting ? $setting->value : null;
	}
}
