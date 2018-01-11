<?php
/**
 * Created by PhpStorm.
 * Author: Selim Khaldi
 * Author URI: https://twitter.com/SelimKhaldi
 * Company: KHALSOMM Digital
 * Company URI: http://www.khalsomm.com
 * Date: 06/01/2018
 * Time: 17:49
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository
{
    public function getNumberTicketLeftForDate(\DateTime $venueDate)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.venueDate = :venueDate')
            ->setParameter('venueDate', $venueDate)
            ->andWhere('o.orderPaid = 1')
            ->innerJoin('o.items', 'i')
            ->select('COUNT (i.id) as sold')
            ->getQuery()
            ->getSingleResult();
    }
}