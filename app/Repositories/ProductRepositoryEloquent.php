<?php

namespace Leroy\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Repositories\Interfaces\ProductRepository;
use Leroy\Entities\Product;
use Leroy\Validators\ProductValidator;
use Leroy\Presenters\ProductPresenter;

/**
 * Class ProductRepositoryEloquent.
 * Using Repository Pattern
 * 
 * @package namespace Leroy\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{
    /**
     * Provided Worksheet Suggests that the primary key of the template is.
     * 
     */
    const PRIMARY_KEY_COLUMN = 'lm';
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Product::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    /**
     * Presentation
     * Responsible for the default presentation layer of the repository
     * @return type
     */
    public function presenter() {
        return ProductPresenter::class;
    }
    
    /**
     * This method only provides the convenient way to fetch an entity by a specified column
     * 
     * @param       $field
     * @param       $search
     * @return mixed | null
     */
    public function findCustomByField(string $field, $search ) {
            
            $temporarySkipPresenter = $this->skipPresenter;
            $this->skipPresenter();
            
            $p = $this->scopeQuery(function ($query) use($field,$search){
                return $query->select("products.*")
                    ->where($field,'=',$search);
            })->first();
            
            $this->skipPresenter($temporarySkipPresenter); 
            if(!is_null($p)){
                $this->applyScope();
                $model = $this->model->findOrFail($p->id);
                $this->resetModel();
                return $this->parserResult($model);
                
            }
            
            return null;
    
        
    }
    
    
}
