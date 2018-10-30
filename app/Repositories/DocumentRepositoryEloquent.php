<?php

namespace Leroy\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Repositories\Interfaces\DocumentRepository;
use Leroy\Entities\Document;
use Leroy\Presenters\DocumentPresenter;
use Leroy\Events\DocumentStoredEvent;
/**
 * Class DocumentRepositoryEloquent.
 *
 * @package namespace Leroy\Repositories;
 */
class DocumentRepositoryEloquent extends BaseRepository implements DocumentRepository
{
    
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Document::class;
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
        return DocumentPresenter::class;
    }
    
    public function create(array $attributes)
    {

        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);
        
        $attributes = array_prepend($attributes,$this->hashGenerate(),'hash_endpoing');
        $model =  parent::create($attributes);
        //New Queues
        event(new DocumentStoredEvent($model));
        $this->skipPresenter = $skipPresenter;
        return $this->parserResult($model);

    }
    
    private function hashGenerate(){
        return bin2hex(openssl_random_pseudo_bytes(8)).".".uniqid(date('HisYmd'));
    }
    
}
