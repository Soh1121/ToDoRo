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
        'timer', 'repeat_id', 'priority_id',
    ];

    /** 複数代入できる属性 */
    protected $fillable = [
        'name', 'project_id', 'context_id',
        'start_date', 'due_date', 'term', 'repeat_id', 'priority_id',
    ];

    /**
     * リレーションシップ：user_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id', 'id', 'users');
    }

    /**
     * リレーションシップ：project_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'id', 'projects');
    }

    /**
     * リレーションシップ：context_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function context()
    {
        return $this->belongsTo('App\Context', 'context_id', 'id', 'contexts');
    }

    /**
     * リレーションシップ：repeat_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function repeat()
    {
        return $this->belongsTo('App\Repeat', 'repeat_id', 'id', 'repeats');
    }

    /**
     * リレーションシップ：context_id
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function priority()
    {
        return $this->belongsTo('App\Priority', 'priority_id', 'id', 'priorities');
    }
}
