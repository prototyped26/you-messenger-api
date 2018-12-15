<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*protected $casts = [
        'langue_id' => 'int'
    ];*/

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'photo',
        'pseudo',
        'langue_id',
        'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
       'password', 'remember_token',
    ];

    /*public function langue()
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
    }*/
}
