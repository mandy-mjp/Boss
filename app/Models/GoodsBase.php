<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GoodsBase
 *
 * @property integer $id
 * @property string $title
 * @property integer $supplier_id 供应商ID
 * @property integer $category_id 品类id
 * @property integer $pavilion 所属馆
 * @property string $cover 封面图
 * @property boolean $state -1删除 0未审核 1.上架 2下架 3驳回 4售罄
 * @property integer $num 库存数量
 * @property integer $num_sold 已销数量
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereSupplierId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase wherePavilion($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereCover($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereNumSold($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsBase whereLocation($value)
 * @mixin \Eloquent
 * @property string $location
 */
class GoodsBase extends Model
{
    const state_online = 1;
    const state_check = 0;
    const state_delete = -1;
    const state_down = 2;
    const state_return = 3;
    const state_finish = 4;

    protected $table = 'goods_base';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'supplier_id',
        'category_id',
        'pavilion',
        'cover',
        'state',
        'num',
        'num_sold',
        'state'
    ];

    protected $guarded = [];




        
}