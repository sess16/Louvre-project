<?php
/**
 * Created by PhpStorm.
 * Author: Selim Khaldi
 * Author URI: https://twitter.com/SelimKhaldi
 * Company: KHALSOMM Digital
 * Company URI: http://www.khalsomm.com
 * Date: 27/11/2017
 * Time: 18:51
 */

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends Controller
{
    /**
     * @return Response
     * @Route("/", name="index")
     * @Method("GET")
     */
    public function index()
    {
        return $this->render('Default/index.html.twig');
    }

    /**
     * @return Response
     * @Route("/info", name="info")
     * @Method("GET")
     */
    public function info()
    {
        return $this->render('Default/info.html.twig');
    }
}