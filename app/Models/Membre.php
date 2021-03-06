<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Membre
 * 
 * @property int $id
 * @property int $groupe_id
 * @property int $user_id
 * @property boolean $is_blocked
 * 
 * @property \App\Models\Groupe $groupe
 * @property \App\Models\UserOld $user
 * @property \Illuminate\Database\Eloquent\Collection $messages
 *
 * @package App\Models
 */
class Membre extends Eloquent
{
	protected $table = 'membre';
	public $timestamps = false;

	protected $casts = [
		'groupe_id' => 'int',
		'user_id' => 'int',
        'is_blocked' => 'bool'
	];

	protected $fillable = [
		'groupe_id',
		'user_id',
        'is_blocked'
	];

	public function groupe()
	{
		return $this->belongsTo(\App\Models\Groupe::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\UserOld::class)->distinct();
	}

	public function messages()
	{
		return $this->hasMany(\App\Models\Message::class);
	}
}
