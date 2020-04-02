<?php
/**
 * Create by maxime
 * Date 4/2/2020
 * Time 9:14 AM
 * Project :  projet7
 * IDE : PhpStorm
 * FileName : AddEndUserResolverInterface.php as ${NAME}
 */

namespace App\Domain\EndUsers;

use App\Inputs\EndUserInputs;
use Symfony\Component\HttpFoundation\Request;

interface AddEndUserResolverInterface
{

    /**
     * @param Request $request
     * @return mixed
     */
    public function resolve(Request $request);

    /**
     * @param EndUserInputs $input
     * @return mixed
     */
    public function hydrate(EndUserInputs $input);

    /**
     * @param EndUserInputs $inputs
     * @return mixed
     */
    public function validateInput(EndUserInputs $inputs);

    /**
     * @param $email
     * @return mixed
     */
    public function emailExist($email);
}