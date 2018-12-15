<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class PieceJointe
 * 
 * @property int $id
 * @property int $message_id
 * @property int $fichier_id
 * 
 * @property \App\Models\Fichier $fichier
 * @property \App\Models\Message $message
 *
 * @package App\Models
 */
class PieceJointe extends Eloquent
{
	protected $table = 'piece_jointe';
	public $timestamps = false;

	protected $casts = [
		'message_id' => 'int',
		'fichier_id' => 'int'
	];

	protected $fillable = [
		'message_id',
		'fichier_id'
	];

	public function fichier()
	{
		return $this->belongsTo(\App\Models\Fichier::class);
	}

	public function message()
	{
		return $this->belongsTo(\App\Models\Message::class);
	}
}
