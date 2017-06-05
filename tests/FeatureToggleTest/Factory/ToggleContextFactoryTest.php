<?php

namespace MehrAlsNix\FeatureToggleTest\Factory;

use MehrAlsNix\FeatureToggle\Context\UserContext;
use MehrAlsNix\FeatureToggle\Factory\ToggleContextFactory;
use MehrAlsNix\FeatureToggle\Factory\ToggleHelperFactory;
use MehrAlsNix\FeatureToggle\Factory\UserContextFactory;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleCollection\InMemoryCollection;
use Qandidate\Toggle\ToggleManager;
use Zend\Config\Config;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Service\ConfigFactory;
use Zend\Mvc\Service\EventManagerFactory;
use Zend\Mvc\Service\ModuleManagerFactory;
use Zend\Mvc\Service\ServiceListenerFactory;
use Zend\ServiceManager\ServiceManager;
use Zend\Stdlib\DispatchableInterface;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ToggleContextFactoryTest extends AbstractHttpControllerTestCase
{
    /**
     * @var ControllerManager
     */
    protected $controllers;

    /**
     * @var ToggleContextFactory
     */
    protected $factory;

    /**
     * @var ServiceManager
     */
    protected $services;

    protected function setUp()
    {
        $this->factory = new ToggleContextFactory();
        $this->services = new ServiceManager();
        $this->services->setFactory('Qandidate\Toggle\Context', $this->factory);
        $this->services->setFactory('config', ConfigFactory::class);
        $this->services->setFactory('ModuleManager', ModuleManagerFactory::class);
        $this->services->setFactory('ServiceListener', ServiceListenerFactory::class);
        $this->services->setFactory('EventManager', EventManagerFactory::class);
        $this->services->setService('ApplicationConfig', [
            'modules' => [
                'Zend\Router',
                'MehrAlsNix\FeatureToggle',
            ],
            'module_listener_options' => [
                'module_paths' => [__DIR__ . '/../../'],
                'config_glob_paths' => [],
            ],
            'service_listener_options' => [],
            'service_manager' => [],
        ]);

        $this->controllers = new ControllerManager($this->services);
        parent::setUp();
    }

    /**
     * @test
     */
    public function createService()
    {
        $toggleManager = $this->getMockBuilder(ToggleManager::class)->disableOriginalConstructor();
        $this->services->setService('ToggleManagerFactory', $toggleManager->getMock());

        $context = $this->getMockBuilder(Context::class);
        $this->services->setService('ToggleFeature\UserContextFactory', $context->getMock());

        $this->assertInstanceOf(Context::class, $this->factory->__invoke($this->services));
    }
}
