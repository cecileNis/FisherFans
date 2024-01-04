<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Boat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Exceptions\UserNeedALicenceException;

class CreateBoatController extends AbstractController
{
    public function __invoke(Boat $boat): Boat
    {
        /** @var User $user */
        $user = $this->getUser();

        $licence = $user->getLicence();

        if ($licence == null || $licence == "None") {
            throw new UserNeedALicenceException();
        }

        return $boat;
    }
}