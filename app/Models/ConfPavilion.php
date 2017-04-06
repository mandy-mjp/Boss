<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ConfPavilion
 *
 * @property integer $id
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property string $update_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfPavilion whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfPavilion whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfPavilion whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ConfPavilion whereUpdateAt($value)
 * @mixin \Eloquent
 */
class ConfPavilion extends Model
{
    protected $table = 'conf_pavilion';

    public $timestamps = true;

    protected $fillable = [
        'name',
        'update_at'
    ];

    protected $guarded = [];

        
}