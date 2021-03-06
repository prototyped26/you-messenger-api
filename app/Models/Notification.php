<?php
/**
 * Created by PhpStorm.
 * User: edlly
 * Date: 31/01/2019
 * Time: 14:28
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


class Notification extends Eloquent
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $table = 'notification';

    protected $casts = [
        'user_id' => 'int',
        'read' => 'bool',
        'complete' => 'bool'
    ];

    protected $fillable = [
        'label',
        'read',
        'user_id',
        'complete',
        'id_message'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\UserOld::class);
    }
}
