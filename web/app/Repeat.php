<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Repeat extends Model
{
    /** JSONに含まれる属性 */
    protected $visible = [
        'id', 'name',
    ];
}
