<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Groupe
 * 
 * @property int $id
 * @property string $label
 * @property string $photo
 * @property string $description
 * @property float $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $user_id
 * 
 * @property \App\Models\UserOld $user
 * @property \Illuminate\Database\Eloquent\Collection $administrateurs
 * @property \Illuminate\Database\Eloquent\Collection $membres
 *
 * @package App\Models
 */
class Groupe extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'groupe';

	protected $casts = [
		'note' => 'float',
		'user_id' => 'int'
	];

	protected $fillable = [
		'label',
		'photo',
		'description',
		'note',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(\App\Models\UserOld::class);
	}

	public function administrateurs()
	{
		return $this->hasMany(\App\Models\Administrateur::class);
	}

	public function membres()
	{
		return $this->hasMany(\App\Models\Membre::class);
	}
}
