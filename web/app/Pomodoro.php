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

    /**
     * ユーザーIDで検索するスコープ
     *
     * @param mixed $query
     * @param int $user_id
     * @return mixed
     */
    public function scopeUserIdEqual($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /**
     * 日付で検索するスコープ
     *
     * @param mixed $query
     * @param string $str
     * @return mixed
     */
    public function scopeDateEqual($query, $str)
    {
        return $query->where('date', $str);
    }
}
