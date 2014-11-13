<?php

namespace Ant\FilterBundle\Entity\Filter;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

interface Specification
{
	/**
	 * @param \Doctrine\ORM\QueryBuilder $qb
	 * @param string $dqlAlias
	 *
	 * @return \Doctrine\ORM\Query\Expr
	 ***/
	public function match(QueryBuilder $qb, $dqlAlias);
	
	/**
	 * @param \Doctrine\ORM\Query $query
	***/
	public function modifyQuery(Query $query);
}