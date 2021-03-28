<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pomodoro extends Model
{
    /** JSONに含まれる属性 */
    protected $visible = [
        'count'
    ];

    /**
     * リレーションシップ：user_id
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }
}
