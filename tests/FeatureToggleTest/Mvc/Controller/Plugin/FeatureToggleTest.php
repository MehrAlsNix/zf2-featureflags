<?php

namespace MehrAlsNix\FeatureToggleTest\Mvc\Controller\Plugin;

use MehrAlsNix\FeatureToggle\Mvc\Controller\Plugin\FeatureToggle as Plugin;

class FeatureToggleTest extends \PHPUnit_Framework_TestCase
{
    protected $plugin;
    protected $toggleManager;
    protected $context;
    public function setUp()
    {
        $plugin = new Plugin();
        $this->plugin = $plugin;
        $toggleManager = $this->getMock('Qandidate\Toggle\ToggleManager', [], [], '', false);
        $this->toggleManager = $toggleManager;
        $context = $this->getMock('Qandidate\Toggle\Context');
        $this->context = $context;
        $plugin->setToggleManager($toggleManager);
        $plugin->setContext($context);
    }

    /**
     * @test
     */
    public function invoke()
    {
        $result = $this->plugin->__invoke();
        $this->assertInstanceOf('MehrAlsNix\FeatureToggle\Mvc\Controller\Plugin\FeatureToggle', $result);
    }

    /**
     * @test
     */
    public function getterSetter()
    {
        $this->assertInstanceOf('Qandidate\Toggle\ToggleManager', $this->plugin->getToggleManager());
        $this->assertInstanceOf('Qandidate\Toggle\Context', $this->plugin->getContext());
        $this->assertNull($this->plugin->isActive('test'));
    }
}
