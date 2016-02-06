<?php

namespace MehrAlsNix\FeatureToggle\Listener;

use MehrAlsNix\FeatureToggle\Annotation\Toggle;
use MehrAlsNix\FeatureToggle\Traits\ToggleAware;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use ZfAnnotation\Event\ParseEvent;

class ToggleListener extends AbstractListenerAggregate
{
    use ToggleAware;

    public function attach(EventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(ParseEvent::EVENT_CLASS_PARSED, [$this, 'onClassParsed']);
    }

    public function onClassParsed(ParseEvent $event)
    {
        $classHolder = $event->getTarget();
        $classAnnotations = $classHolder->getAnnotations();
        foreach ($classAnnotations as $annotation) {
            if ($annotation instanceof Toggle
                && !$this->toggleManager->active($annotation->getName(), $this->getContext())
            ) {
                throw new \RuntimeException();
            }
        }

        $methodHolders = $classHolder->getMethods();
        foreach ($methodHolders as $methodHolder) {
            foreach ($methodHolder->getAnnotations() as $annotation) {
                if ($annotation instanceof Toggle
                    && !$this->toggleManager->active($annotation->getName(), $this->getContext())
                ) {
                    throw new \RuntimeException();
                }
            }
        }
    }
}
