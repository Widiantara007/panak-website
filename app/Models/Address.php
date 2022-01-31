<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 * 
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @package App\Models
 */
class Address extends Model
{
	protected $table = 'addresses';
	public $timestamps = false;

	protected $fillable = [
		'code',
		'name'
	];

	public static function getProvince($code){
		$code = substr($code, 0, 2);
		$province = Address::where('code', $code)->pluck('name')[0];

		return $province;
	}
	public static function getDistrict($code)
	{
		$code = substr($code, 0, 5);
		$district = Address::where('code', $code)->pluck('name')[0];
		return $district;
	}
	public static function getSubDistrict($code)
	{
		$code = substr($code, 0, 8);
		$sub_district = Address::where('code', $code)->pluck('name')[0];
		return $sub_district;
	}

	public static function getFullAddress($location_code)
	{
		$province_code = substr($location_code, 0, 2);
		$district_code = substr($location_code, 0, 5);
		$sub_district_code = substr($location_code, 0, 8);
		$village_code = $location_code;

		$province = Address::where('code', $province_code)->pluck('name')[0];
		$district = Address::where('code', $district_code)->pluck('name')[0];
		$sub_district = Address::where('code', $sub_district_code)->pluck('name')[0];
		$village = Address::where('code', $village_code)->pluck('name')[0];

		return $village.', '.$sub_district.', '.$district.', '.$province;
	}

	public static function getFullAddressCertificate($location_code)
	{
		$province_code = substr($location_code, 0, 2);
		$district_code = substr($location_code, 0, 5);
		$sub_district_code = substr($location_code, 0, 8);
		$village_code = $location_code;

		$province = Address::where('code', $province_code)->pluck('name')[0];
		$district = Address::where('code', $district_code)->pluck('name')[0];
		$sub_district = Address::where('code', $sub_district_code)->pluck('name')[0];
		$village = Address::where('code', $village_code)->pluck('name')[0];

		$text = "Desa {$village}, Kec. {$sub_district}, {$district}, {$province}";
		return $text;
		// return $village.', '.$sub_district.', '.$district.', '.$province;
	}


}
