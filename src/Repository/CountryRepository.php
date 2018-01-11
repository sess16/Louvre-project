<?php
/**
 * Created by PhpStorm.
 * Author: Selim Khaldi
 * Author URI: https://twitter.com/SelimKhaldi
 * Company: KHALSOMM Digital
 * Company URI: http://www.khalsomm.com
 * Date: 06/01/2018
 * Time: 17:44
 */

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class CountryRepository extends EntityRepository
{
    public function getCountriesByAlphabeticalOrder()
    {
        return $this
            ->createQueryBuilder('c')
            ->orderBy('c.name','ASC');
    }
}