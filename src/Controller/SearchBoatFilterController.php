<?php

namespace App\Controller;

use ApiPlatform\Symfony\Security\Exception\AccessDeniedException;
use App\Entity\Boat;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchBoatFilterController extends AbstractController
{
  public function __construct(private ManagerRegistry $doctrine) {}

  public function __invoke($filter, $value)
  {
    $entityManager = $this->doctrine->getManager();
    $boatRepository = $entityManager->getRepository(Boat::class);
    $boats = $boatRepository->findAll();
    $filtered = [];

    switch ($filter) {
      case "brand":
        $filtered = array_filter($boats, fn ($boat) => strtolower($boat->getBrand()) == strtolower($value));
        break;
      case "year":
        $filtered = array_filter($boats, fn ($boat) => $boat->getYearOfFabrication() == $value);
        break;
      case "bed":
        $filtered = array_filter($boats, fn ($boat) => $boat->getNumberOfBeds() == $value);
        break;
      case "power":
        $filtered = array_filter($boats, fn ($boat) => $boat->getPower() == $value);
        break;
      default:
        throw new AccessDeniedException("You can not use this filter on boats.");
    }

    return $filtered;
  }
}