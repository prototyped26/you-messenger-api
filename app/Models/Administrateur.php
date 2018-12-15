<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Administrateur
 * 
 * @property int $id
 * @property int $user_id
 * @property int $groupe_id
 * 
 * @property \App\Models\Groupe $groupe
 * @property \App\Models\UserOld $user
 * @property \Illuminate\Database\Eloquent\Collection $messages
 * @property \Illuminate\Database\Eloquent\Collection $rejets
 *
 * @package App\Models
 */
class Administrateur extends Eloquent
{
	protected $table = 'administrateur';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'groupe_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'groupe_id'
	];

	public function groupe()
	{
		return $this->belongsTo(\App\Models\Groupe::class);
	}

	public function user()
	{
		return $this->belongsTo(\App\Models\UserOld::class);
	}

	public function messages()
	{
		return $this->hasMany(\App\Models\Message::class);
	}

	public function rejets()
	{
		return $this->hasMany(\App\Models\Rejet::class);
	}
}
