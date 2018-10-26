<?php

namespace Leroy\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Leroy\Repositories\Interfaces\DocumentRepository;
use Leroy\Entities\Document;
use Leroy\Validators\DocumentValidator;

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
    
}
