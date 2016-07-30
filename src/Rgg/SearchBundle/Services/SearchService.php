<?php

namespace Rgg\SearchBundle\Services;

use Doctrine\ORM\EntityManager;

class SearchService
{
	private $entityManager;

	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function query($searchQuery, $priceAsc = false, $isAdmin = false)
	{
		$tempQuery = $this->entityManager->getRepository("AppBundle:Giveaway")->createQueryBuilder('g')->where('g.name LIKE :query')->andWhere('g.deletedAt is null');

		if($isAdmin == false) {
			$tempQuery->andWhere('g.isAdmin != 1');
		}
		
		if($priceAsc == true) {
			$tempQuery->orderby('g.price', 'ASC');
		} else {
			$tempQuery->orderby('g.price', 'DESC');
		}


		$query = $tempQuery->setParameter('query', '%'.$searchQuery."%")
			->getQuery();

		return $query->getResult();
	}
}

?>