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
 * @property int $groupe_id
 * @property int $is_send
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $is_valid
 * @property string $id_message
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
		'groupe_id' => 'int',
		'is_send' => 'int',
		'is_valid' => 'int',
	];

	protected $fillable = [
		'label',
		'user_id',
		'id_message',
		'is_send',
		'is_valid',
		'groupe_id',
        'date'
	];


	public function grupe()
	{
		return $this->belongsTo(\App\Models\Groupe::class);
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
