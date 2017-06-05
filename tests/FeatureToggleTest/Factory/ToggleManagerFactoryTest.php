<?php

namespace MehrAlsNix\FeatureToggleTest\Factory;

use MehrAlsNix\FeatureToggle\Factory\ToggleHelperFactory;
use MehrAlsNix\FeatureToggle\Factory\ToggleManagerFactory;
use MehrAlsNix\FeatureToggle\Factory\TogglePluginFactory;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleCollection;
use Qandidate\Toggle\ToggleCollection\InMemoryCollection;
use Qandidate\Toggle\ToggleManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\Mvc\Service\ConfigFactory;
use Zend\Mvc\Service\EventManagerFactory;
use Zend\Mvc\Service\ModuleManagerFactory;
use Zend\Mvc\Service\ServiceListenerFactory;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ToggleManagerFactoryTest extends AbstractHttpControllerTestCase
{
    /**
     * @var ControllerManager
     */
    protected $controllers;

    /**
     * @var ToggleManagerFactory
     */
    protected $factory;

    /**
     * @var ServiceManager
     */
    protected $services;

    protected function setUp()
    {
        $config = [
                'zf2_featureflags' => [
                    'qandidate_toggle' => [
                        'persistence' => 'ToggleFeature\InMemory', // 'ToggleFeature\Redis'
                        'context_factory' => 'ToggleFeature\UserContextFactory', // |your.context_factory.service.id
                        'redis_namespace' => null, // toggle_%kernel.environment% # default, only required when persistence = redis
                        'redis_client' => null // |your.redis_client.service.id # only required when persistence = redis
                    ],
                    'features' => [
                        'some-feature' => [
                            'name' => 'toggling',
                            'conditions' => [
                                [
                                    'name' => 'operator-condition',
                                    'key' => 'user_id',
                                    'operator' => ['name' => 'greater-than', 'value' => 41],
                                ],
                            ],
                            'status' => 'conditionally-active',
                        ]
                    ]
                ]
        ];

        $this->factory = new ToggleManagerFactory();
        $this->services = new ServiceManager();
        $this->services->setFactory('Qandidate\Toggle\Manager', $this->factory);
        $this->services->setFactory('config', function () use ($config) { return $config; });
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

        $this->controllers = new ControllerManager($this->services, $config);

        parent::setUp();
    }

    /**
     * @test
     */
    public function createService()
    {
        $context = $this->getMockBuilder('Qandidate\Toggle\Collection\InMemoryCollectionSerializer');
        $mock = $context->setMethods(['deserialize'])->getMock();

        $mock->method('deserialize')->willReturn(new InMemoryCollection());

        $this->services->setService('ToggleFeature\InMemoryCollSerializer', $mock);

        $this->assertInstanceOf(ToggleManager::class, $this->factory->__invoke($this->services));
    }

    /**
     * @test
     * @expectedException \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createServiceWithWrongCollectionType()
    {
        $context = $this->getMockBuilder('Qandidate\Toggle\Collection\InMemoryCollectionSerializer');
        $mock = $context->setMethods(['deserialize'])->getMock();

        $mock->method('deserialize')->willReturn(null);

        $this->services->setService('ToggleFeature\InMemoryCollSerializer', $mock);

        $this->assertInstanceOf(ToggleManager::class, $this->factory->__invoke($this->services));
    }
}
