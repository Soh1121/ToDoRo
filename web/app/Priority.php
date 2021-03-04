<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    /** JSONに含まれる属性 */
    protected $visible = [
        'id', 'name',
    ];

    /**
     * リレーションシップ - tasksテーブル
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany('App\Tasks');
    }
}
