<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfCategory
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfCategory whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ConfCategory extends Model
{
    protected $table = 'conf_category';

    public $timestamps = true;

    protected $fillable = [
        'name'
    ];

    protected $guarded = [];

        
}