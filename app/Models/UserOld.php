<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 07 Dec 2018 15:58:13 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class UserOld
 * 
 * @property int $id
 * @property string $nom
 * @property string $prenom
 * @property string $telephone
 * @property string $photo
 * @property string $pseudo
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property int $langue_id
 * 
 * @property \App\Models\Langue $langue
 * @property \Illuminate\Database\Eloquent\Collection $administrateurs
 * @property \Illuminate\Database\Eloquent\Collection $groupes
 * @property \Illuminate\Database\Eloquent\Collection $membres
 * @property \Illuminate\Database\Eloquent\Collection $messages
 *
 * @package App\Models
 */
class UserOld extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'user';

	protected $casts = [
		'langue_id' => 'int'
	];

	protected $fillable = [
		'nom',
		'prenom',
		'telephone',
		'photo',
		'pseudo',
		'langue_id'
	];

	public function langue()
	{
		return $this->belongsTo(\App\Models\Langue::class);
	}

	public function administrateurs()
	{
		return $this->hasMany(\App\Models\Administrateur::class);
	}

	public function groupes()
	{
		return $this->hasMany(\App\Models\Groupe::class);
	}

	public function membres()
	{
		return $this->hasMany(\App\Models\Membre::class);
	}

	public function messages()
	{
		return $this->hasMany(\App\Models\Message::class, 'user_id1');
	}
}
