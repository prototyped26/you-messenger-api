<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:12 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Fichier
 * 
 * @property int $id
 * @property string $url
 * @property string $type
 * @property string $nom
 * @property \Carbon\Carbon $created_at
 * 
 * @property \Illuminate\Database\Eloquent\Collection $piece_jointes
 *
 * @package App\Models
 */
class Fichier extends Eloquent
{
	protected $table = 'fichier';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'id' => 'int'
	];

	protected $fillable = [
		'url',
		'type',
        'nom'
	];

	public function piece_jointes()
	{
		return $this->hasMany(\App\Models\PieceJointe::class);
	}
}
