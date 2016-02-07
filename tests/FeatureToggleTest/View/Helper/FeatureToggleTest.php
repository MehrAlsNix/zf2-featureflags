<?php

namespace MehrAlsNix\FeatureToggleTest\View\Helper;

use MehrAlsNix\FeatureToggle\View\Helper\FeatureToggle as ViewHelper;

class FeatureToggleTest extends \PHPUnit_Framework_TestCase
{
    protected $helper;
    protected $toggleManager;
    protected $context;
    public function setUp()
    {
        $helper = new ViewHelper;
        $this->helper = $helper;
        $toggleManager = $this->getMock('Qandidate\Toggle\ToggleManager', [], [], '', false);
        $this->toggleManager = $toggleManager;
        $context = $this->getMock('Qandidate\Toggle\Context');
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
        $this->assertInstanceOf('MehrAlsNix\FeatureToggle\View\Helper\FeatureToggle', $result);
    }
}
