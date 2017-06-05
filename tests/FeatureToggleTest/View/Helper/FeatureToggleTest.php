<?php

namespace MehrAlsNix\FeatureToggleTest\View\Helper;

use MehrAlsNix\FeatureToggle\View\Helper\FeatureToggle as ViewHelper;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleManager;

class FeatureToggleTest extends \PHPUnit_Framework_TestCase
{
    protected $helper;
    protected $toggleManager;
    protected $context;
    public function setUp()
    {
        $helper = new ViewHelper;
        $this->helper = $helper;
        $toggleManager = $this->createMock(ToggleManager::class);
        $this->toggleManager = $toggleManager;
        $context = $this->createMock(Context::class);
        $this->context = $context;
        $helper->setToggleManager($toggleManager);
        $helper->setContext($context);
    }

    /**
     * @test
     */
    public function invoke()
    {
        $result = $this->helper->__invoke();
        $this->assertInstanceOf(ViewHelper::class, $result);
    }

    /**
     * @test
     */
    public function getterSetter()
    {
        $this->assertInstanceOf(ToggleManager::class, $this->helper->getToggleManager());
        $this->assertInstanceOf(Context::class, $this->helper->getContext());
        $this->assertNull($this->helper->isActive('test'));
    }
}
