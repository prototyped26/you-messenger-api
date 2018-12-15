<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class LangueCopy4
 * 
 * @property int $id
 * @property string $label
 * @property string $code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class LangueCopy4 extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'langue_copy4';

	protected $fillable = [
		'label',
		'code'
	];
}
