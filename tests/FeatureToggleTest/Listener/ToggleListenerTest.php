<?php

namespace MehrAlsNix\FeatureToggleTest\Listener;

use MehrAlsNix\FeatureToggle\Listener\ToggleListener;
use PHPUnit_Framework_TestCase as TestCase;
use Zend\Code\Scanner\ClassScanner;
use ZfAnnotation\Event\ParseEvent;
use ZfAnnotation\Parser\ClassAnnotationHolder;

class ToggleListenerTest extends TestCase
{
    /**
     * @var ParseEvent
     */
    protected $parseEvent;

    /**
     * @var ToggleListener
     */
    protected $listener;

    public function setUp()
    {
        $this->parseEvent   = new ParseEvent();
        $this->parseEvent->setName('onClassParsed')
            ->setTarget(new ClassAnnotationHolder(new ClassScanner([])));
        $this->listener = new ToggleListener();
    }

    /**
     * @test
     */
    public function defaultFunction()
    {
        $this->assertNull($this->listener->onClassParsed($this->parseEvent));
    }
}
