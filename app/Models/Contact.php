<?php
/**
 * Created by PhpStorm.
 * User: edlly
 * Date: 31/01/2019
 * Time: 14:26
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


class Contact extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'contact';

    protected $fillable = [
        'telephone',
        'label',
        'pays',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\UserOld::class);
    }
}
