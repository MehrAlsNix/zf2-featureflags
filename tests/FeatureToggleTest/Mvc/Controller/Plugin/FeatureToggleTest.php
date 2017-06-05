<?php

namespace MehrAlsNix\FeatureToggleTest\Mvc\Controller\Plugin;

use MehrAlsNix\FeatureToggle\Mvc\Controller\Plugin\FeatureToggle as Plugin;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleManager;

class FeatureToggleTest extends \PHPUnit_Framework_TestCase
{
    protected $plugin;
    protected $toggleManager;
    protected $context;
    public function setUp()
    {
        $plugin = new Plugin();
        $this->plugin = $plugin;
        $toggleManager = $this->createMock(ToggleManager::class);
        $this->toggleManager = $toggleManager;
        $context = $this->createMock(Context::class);
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
        $this->assertInstanceOf(Plugin::class, $result);
    }

    /**
     * @test
     */
    public function getterSetter()
    {
        $this->assertInstanceOf(ToggleManager::class, $this->plugin->getToggleManager());
        $this->assertInstanceOf(Context::class, $this->plugin->getContext());
        $this->assertNull($this->plugin->isActive('test'));
    }
}
