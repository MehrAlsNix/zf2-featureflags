<?php

namespace MehrAlsNix\FeatureToggle\Listener;

use MehrAlsNix\FeatureToggle\Annotation\Toggle;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleManager;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use ZfAnnotation\Event\ParseEvent;

class ToggleListener extends AbstractListenerAggregate
{
    private $toggleManager;

    private $context;

    private $listeners = [];

    public function __construct(ToggleManager $toggleManager, Context $context)
    {
        $this->toggleManager = $toggleManager;
        $this->context = $context;
    }

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(ParseEvent::EVENT_CLASS_PARSED, [$this, 'onClassParsed']);
    }

    public function onClassParsed(ParseEvent $event)
    {
        $classHolder = $event->getTarget();
        $classAnnotations = $classHolder->getAnnotations();
        foreach ($classAnnotations as $annotation) {
            if ($annotation instanceof Toggle) {
                $controller = $classHolder->getClass()->getName();
                if (! $this->toggleManager->active($annotation->name, $this->context)) {
                    throw new \RuntimeException();
                }
            }
        }

        $methodHolders = $classHolder->getMethods();;
        foreach ($methodHolders as $methodHolder) {
            foreach ($methodHolder->getAnnotations() as $annotation) {
                if ($annotation instanceof Toggle) {
                    if (! $this->toggleManager->active($annotation->name, $this->context)) {
                        throw new \RuntimeException();
                    }
                }
            }
        }
    }
}
