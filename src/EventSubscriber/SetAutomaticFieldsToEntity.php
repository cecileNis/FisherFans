<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Address;
use App\Entity\Boat;
use App\Entity\Company;
use App\Entity\Fish;
use App\Entity\FishingLog;
use App\Entity\Outing;
use App\Entity\Port;
use App\Entity\Reservation;
use App\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;

class SetAutomaticFieldsToEntity implements EventSubscriberInterface
{
    public function __construct(private readonly TokenStorageInterface $tokenStorage)
    {
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['setData', EventPriorities::PRE_WRITE],
        ];
    }

    public function setData(ViewEvent $event)
    {
        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($this->needExtraData($entity)) {
            if (Request::METHOD_POST === $method) {
                $this->setProperties($entity, $this->tokenStorage->getToken()->getUser());
            }
            if (Request::METHOD_PATCH === $method) {
                $this->updateProperties($entity);
            }
        }
    }

    /**
     * @param mixed $entity
     * @return bool
     */
    public function needExtraData(mixed $entity): bool
    {
        return $entity instanceof Boat || $entity instanceof Port || $entity instanceof Reservation || $entity instanceof Outing || $entity instanceof FishingLog || $entity instanceof Fish || $entity instanceof Company || $entity instanceof Address;
    }

    /**
     * @param mixed $entity
     * @param UserInterface $user
     * @return void
     */
    public function setProperties(mixed $entity, UserInterface $user): void
    {
        /** @var User $user */
        switch (get_class($entity)) {
            case Outing::class:
                /** @var Outing $entity */
                $entity->setOwner($user);
                break;
            case Boat::class:
                /** @var Boat $entity */
                $entity->setOwner($user);
                break;
            case FishingLog::class:
                /** @var FishingLog $entity */
                $entity->setOwner($user);
                break;
            case Reservation::class:
                /** @var Reservation $entity */
                $entity->setOwner($user);
                break;
        }
    }

    private function updateProperties(mixed $entity)
    {
        switch (get_class($entity)) {
        }
    }
}