<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /** JSONに含まれる属性 */
    protected $visible = [
        'id', 'name', 'user_id', 'project_id',
        'context_id', 'start_date', 'due_date',
        'term', 'finished', 'done',
        'timer', 'repeat_id', 'priority',
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
