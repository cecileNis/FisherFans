<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Outing;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Exceptions\NoBoatToGoOutException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CreateOutingController extends AbstractController
{
    public function __invoke(Outing $outing): Outing
    {
        /** @var User $user */
        $user = $this->getUser();
        $boats = $user->getBoats()->getValues();
        if (empty($boats)) {
            throw new NoBoatToGoOutException();
        }
        return $outing;
    }
}