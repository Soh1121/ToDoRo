<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Context extends Model
{
    /** JSONに含まれる属性 */
    protected $visible = [
        'id', 'user', 'context',
    ];

    /**
     * リレーションシップ
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }
}
