<?php

namespace Ant\FilterBundle\Entity\Filter;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

use Ant\FilterBundle\Entity\Filter\Specification;

class AsArray implements Specification
{
    private $parent;

    public function __construct(Specification $parent)
    {
        $this->parent = $parent;
    }

    public function modifyQuery(Query $query)
    {
        $query->setHydrationMode(Query::HYDRATE_ARRAY);
    }

    public function match(QueryBuilder $qb, $dqlAlias)
    {
        return $this->parent->match($qb, $dqlAlias);
    }

    public function getParent()
    {
        return $this->parent;
    }
}