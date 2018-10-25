<?php

namespace Leroy\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Product.
 *
 * @package namespace Leroy\Entities;
 */
class Product extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id','lm','name','description','free_shipping','price','category_id'];
    
    public function category(){
         return $this->belongsTo(Category::class,'category_id','id');
    }
}
