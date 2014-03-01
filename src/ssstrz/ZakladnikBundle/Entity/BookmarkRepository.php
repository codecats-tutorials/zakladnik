<?php

namespace ssstrz\ZakladnikBundle\Entity;

use Doctrine\ORM\EntityRepository;
use ssstrz\ZakladnikBundle\Entity;
/**
 * BookmarkRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class BookmarkRepository extends EntityRepository
{
    public function getSuggestionFor(User $user, $greaterThan = 1) 
    {
        /*
SELECT 
    *
 , count(u.id) as sub_counter
FROM
    zakladnik.Bookmark b
left join
    user_bookmark ub ON b.id = ub.bookmark_id
left join
	User u on ub.user_id = u.id
	
where u.id <> 1
group by u.id
having sub_counter > 2
;
         */
        $qb = $this->createQueryBuilder('b')
                ->select('b', 'u')
                ->addSelect('count(u.id) as subscriberCounter')
                ->leftJoin('b.subscribers', 'u')
                ->where('u <> :user')
                ->groupBy('b.id')
                ->having('subscriberCounter > :greaterThan')
                ->setParameter('user', $user)
                ->setParameter('greaterThan', $greaterThan)
        ;

        return $qb->getQuery()->getResult();
    }
    public function findUrl($url) 
    {
        $qb = $this->createQueryBuilder('b')
                ->select('b')
                ->where('b.url LIKE :url')
                ->setParameter('url', $url)
                ->setMaxResults(1);
        
        return $qb->getQuery()->getResult();
    }
}
