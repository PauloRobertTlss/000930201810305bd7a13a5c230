<?php

namespace Leroy\Http\Controllers\Api;

use Illuminate\Http\Request;
use Leroy\Http\Controllers\Controller;
use Leroy\Repositories\Interfaces\DocumentRepository;
use Leroy\Criteria\DocumentInProcessedCriteria;
class DocumentsController extends Controller
{
    /**
     *
     * @var type 
     */
    private $repository;
    private $services;
    
    public function __construct(DocumentRepository $repository)
    {
       $this->repository = $repository;
    }
    
    public function show(string $hash)
    {
        return $this->repository->findByField('hash_endpoing', $hash);   
    }
    
    public function inProgress()
    {
        $this->repository->pushCriteria(new DocumentInProcessedCriteria(false));
        return $this->repository->all();
    }
    public function processed()
    {
        $this->repository->pushCriteria(new DocumentInProcessedCriteria(true));
        return $this->repository->all();   
    }
    
}
