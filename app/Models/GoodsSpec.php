<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class GoodsSpec
 *
 * @property integer $id
 * @property integer $goods_id
 * @property string $name
 * @property string $pack_num 包装数
 * @property integer $num 数量
 * @property integer $num_sold 已售数量
 * @property float $weight 重量
 * @property float $weight_net 净重
 * @property string $long 长
 * @property string $wide 宽
 * @property string $height 高
 * @property float $price 市场价
 * @property float $price_buying 进价
 * @property float $platform_fee 平台服务费
 * @property float $guide_rate 导游分成
 * @property float $travel_agency_rate 旅行社分成
 * @property boolean $express_fee_mode 1包邮 2设置邮费
 * @property boolean $state
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereGoodsId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec wherePackNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereNum($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereNumSold($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereWeightNet($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereLong($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereWide($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereHeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec wherePrice($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec wherePriceBuying($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec wherePlatformFee($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereGuideRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereTravelAgencyRate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereExpressFeeMode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereState($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\GoodsSpec whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class GoodsSpec extends Model
{
    protected $table = 'goods_spec';

    public $timestamps = true;

    protected $fillable = [
        'goods_id',
        'name',
        'pack_num',
        'num',
        'num_sold',
        'weight',
        'weight_net',
        'long',
        'wide',
        'height',
        'price',
        'price_buying',
        'platform_fee',
        'guide_rate',
        'travel_agency_rate',
        'express_fee_mode',
        'state'
    ];

    protected $guarded = [];

        
}