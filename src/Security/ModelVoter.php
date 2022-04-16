<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\Model;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ModelVoter extends Voter
{
    public const SHOW = 'show';

    protected function supports(string $attribute, $subject)
    {
        if (!in_array($attribute, [
            self::SHOW,
        ])) {
            return false;
        }

        if (!$subject instanceof Model) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        // you know $subject is a Post object, thanks to `supports()`
        /** @var Model $model */
        $model = $subject;

        switch ($attribute) {
            case self::SHOW:
                return $this->canShow($model, $token);
        }

        throw new \LogicException('This code should not be reached!');
    }

    private function canShow(Model $model, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            // the user must be logged in; if not, deny access
            return false;
        }

        return true;
    }
}
