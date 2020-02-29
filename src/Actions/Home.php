<?php
/**
 * Create by maxime
 * Date 2/28/2020
 * Time 9:25 PM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : Home.php as Home
 */

namespace App\Actions;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class DeleteEndUser
 * @package App\Actions
 * @Route(name="home", path="/")
 */
class Home
{
    public function __invoke()
    {
        return new RedirectResponse('api/doc', 302);
    }
}