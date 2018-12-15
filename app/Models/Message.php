<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Message
 * 
 * @property int $id
 * @property string $label
 * @property int $user_id
 * @property int $user_id1
 * @property int $membre_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $is_valid
 * @property int $administrateur_id
 * 
 * @property \App\Models\Administrateur $administrateur
 * @property \App\Models\Membre $membre
 * @property \App\Models\UserOld $user
 * @property \Illuminate\Database\Eloquent\Collection $piece_jointes
 * @property \Illuminate\Database\Eloquent\Collection $rejets
 *
 * @package App\Models
 */
class Message extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'message';

	protected $casts = [
		'user_id' => 'int',
		'user_id1' => 'int',
		'membre_id' => 'int',
		'is_valid' => 'int',
		'administrateur_id' => 'int'
	];

	protected $fillable = [
		'label',
		'user_id',
		'user_id1',
		'membre_id',
		'is_valid',
		'administrateur_id'
	];

	public function administrateur()
	{
		return $this->belongsTo(\App\Models\Administrateur::class);
	}

	public function membre()
	{
		return $this->belongsTo(\App\Models\Membre::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\UserOld::class, 'user_id1');
	}

	public function piece_jointes()
	{
		return $this->hasMany(\App\Models\PieceJointe::class);
	}

	public function rejets()
	{
		return $this->hasMany(\App\Models\Rejet::class);
	}
}
