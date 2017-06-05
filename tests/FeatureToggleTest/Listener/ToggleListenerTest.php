<?php

namespace MehrAlsNix\FeatureToggleTest\Listener;

use MehrAlsNix\FeatureToggle\Listener\ToggleListener;
use PHPUnit_Framework_TestCase as TestCase;
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
        $this->parseEvent->setName('onClassParsed');
        $this->parseEvent->setTarget(new ClassAnnotationHolder(new \ReflectionClass($this)));
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
