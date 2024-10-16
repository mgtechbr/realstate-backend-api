<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'location',
        'price',
        'description',
        'bathroom',
        'bedroom',
        'area',
        'type',
        'city_id',
        'state_id',
        'district_id',
        'image',
    ];

	public function images()
	{
		return $this->hasMany(PropertyImage::class);
	}

}
