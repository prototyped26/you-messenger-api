<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Langue
 * 
 * @property int $id
 * @property string $label
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $users
 *
 * @package App\Models
 */
class Langue extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'langue';

	protected $fillable = [
		'label',
		'code'
	];

	public function users()
	{
		return $this->hasMany(\App\Models\UserOld::class);
	}
}
