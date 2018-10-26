<?php

namespace Leroy\Http\Controllers\Api;

use Illuminate\Http\Request;
use Leroy\Http\Controllers\Controller;
use Leroy\Repositories\Interfaces\DocumentRepository;

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
    
    public function processed(string $hash)
    {
        return $this->repository->findByField('hash_endpoing', $hash);   
    }
    
}
