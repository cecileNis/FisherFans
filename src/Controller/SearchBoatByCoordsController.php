<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Exceptions\NotValidCoordsException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchBoatByCoordsController extends AbstractController
{
  public function __construct(private ManagerRegistry $doctrine) {}

  public function __invoke($x1, $y1, $x2, $y2)
  {
    if (!is_numeric($x1) || !is_numeric($x2) || !is_numeric($y1) || !is_numeric($y2)) {
      throw new NotValidCoordsException();
    }

    $entityManager = $this->doctrine->getManager();
    $boatRepository = $entityManager->getRepository(Boat::class);
    $boats = $boatRepository->findAll();
    $boatsFiltered = [];

    foreach ($boats as $boat) {
      $boatX = explode(",", $boat->getCoords())[0];
      $boatY = explode(",", $boat->getCoords())[1];

      if ($x1 > $x2 && ($x2 > $boatX || $boatX > $x1)) {
        continue;
      }
      if ($x1 < $x2 && ($x2 < $boatX || $boatX < $x1)) {
        continue;
      }
      if ($y1 > $y2 && ($y2 > $boatY || $boatY > $y1)) {
        continue;
      }
      if ($y1 < $y2 && ($y2 < $boatY || $boatY < $y1)) {
        continue;
      }

      array_push($boatsFiltered, $boat);
    }
    return $boatsFiltered;
  }
}