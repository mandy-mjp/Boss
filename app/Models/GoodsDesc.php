<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GoodsDesc
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $name 图片名称
 * @property string $description 描述
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsDesc whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsDesc whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsDesc whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsDesc whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsDesc whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsDesc whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoodsDesc extends Model
{
    protected $table = 'goods_desc';

    public $timestamps = true;

    protected $fillable = [
        'goods_id',
        'name',
        'description'
    ];

    protected $guarded = [];

        
}