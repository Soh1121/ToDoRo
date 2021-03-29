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
     * @param [type] $query
     * @param [string] $str
     * @return void
     */
    public function scopeUserIdEqual($query, $str)
    {
        return $query->where('user_id', $str);
    }

    /**
     * 日付で検索するスコープ
     *
     * @param [type] $query
     * @param [string] $str
     * @return void
     */
    public function scopeDateEqual($query, $str)
    {
        return $query->where('date', $str);
    }
}
