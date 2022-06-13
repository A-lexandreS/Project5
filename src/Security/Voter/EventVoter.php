<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class EventVoter extends Voter
{
    public const Register = 'register';

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::Register])
            && $subject instanceof \App\Entity\Event;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        return $subject->getMaxRegistration() > $subject->getTotalQuantityRegistrations();
    }
}
