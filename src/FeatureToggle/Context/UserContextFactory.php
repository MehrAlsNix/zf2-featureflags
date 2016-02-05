<?php

namespace MehrAlsNix\FeatureToggle\Context;

use Qandidate\Toggle\Context;
use Qandidate\Toggle\ContextFactory;
use Zend\Authentication\AuthenticationServiceInterface;

class UserContextFactory extends ContextFactory
{
    /** @var AuthenticationServiceInterface $tokenStorage */
    private $tokenStorage;

    public function __construct(AuthenticationServiceInterface $storage)
    {
        $this->tokenStorage = $storage;
    }
    /**
     * {@inheritDoc}
     */
    public function createContext()
    {
        $context = new Context();
        $token = $this->tokenStorage->getIdentity();
        if (null !== $token) {
            $context->set('username', $this->tokenStorage->getIdentity());
        }
        return $context;
    }
}