<?php

namespace Leroy\Repositories\Interfaces;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ProductRepository.
 *
 * @package namespace Leroy\Repositories\Interfaces;
 */
interface ProductRepository extends RepositoryInterface
{
    public function findCustomByField(string $field, $search );
}
