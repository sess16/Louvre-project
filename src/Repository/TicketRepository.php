<?php
/**
 * Created by PhpStorm.
 * Author: Selim Khaldi
 * Author URI: https://twitter.com/SelimKhaldi
 * Company: KHALSOMM Digital
 * Company URI: http://www.khalsomm.com
 * Date: 06/01/2018
 * Time: 17:50
 */

namespace App\Repository;


use Doctrine\ORM\EntityRepository;
use App\Entity\Ticket;

class TicketRepository extends EntityRepository
{
    /**Function to retrieve a ticket depending of a
     * visit duration and the rate
     *
     * @param integer $rate
     * @param integer $duration
     * @return Ticket
     */
    public function getTicketByRateAndDuration($rate, $duration){
        return $this->createQueryBuilder('t')
            ->andWhere('t.rate = :rate')
            ->andWhere('t.duration = :duration')
            ->setParameter('rate', $rate)
            ->setParameter('duration', $duration)
            ->getQuery()
            ->getSingleResult();
    }
}