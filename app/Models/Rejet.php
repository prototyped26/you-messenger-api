<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Rejet
 * 
 * @property int $id
 * @property string $label
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $administrateur_id
 * @property int $message_id
 * 
 * @property \App\Models\Administrateur $administrateur
 * @property \App\Models\Message $message
 *
 * @package App\Models
 */
class Rejet extends Eloquent
{
	use \Illuminate\Database\Eloquent\SoftDeletes;
	protected $table = 'rejet';

	protected $casts = [
		'administrateur_id' => 'int',
		'message_id' => 'int'
	];

	protected $fillable = [
		'label',
		'administrateur_id',
		'message_id'
	];

	public function administrateur()
	{
		return $this->belongsTo(\App\Models\Administrateur::class);
	}

	public function message()
	{
		return $this->belongsTo(\App\Models\Message::class);
	}
}
