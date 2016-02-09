<?php

namespace MehrAlsNix\FeatureToggleTest\View\Helper;

use MehrAlsNix\FeatureToggle\Factory\ToggleHelperFactory;
use MehrAlsNix\FeatureToggle\Factory\ToggleManagerFactory;
use MehrAlsNix\FeatureToggle\Factory\TogglePluginFactory;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleCollection\InMemoryCollection;
use Qandidate\Toggle\ToggleManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ToggleManagerFactoryTest extends AbstractHttpControllerTestCase
{
    /**
     * @var ControllerManager
     */
    protected $controllers;

    /**
     * @var ToggleHelperFactory
     */
    protected $factory;

    /**
     * @var ServiceManager
     */
    protected $services;

    protected function setUp()
    {
        $this->factory = new ToggleManagerFactory();
        $this->services = $services = new ServiceManager();
        $this->services->setService('Config', [
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
        ]);
        $this->controllers = $controllers = new ControllerManager();
        $controllers->setServiceLocator(new ServiceManager());
        $controllers->getServiceLocator()->setService('ServiceManager', $services);
        $this->setApplicationConfig([
            'modules' => [
                'MehrAlsNix\FeatureToggle',
            ],
            'module_listener_options' => [
                'module_paths' => [__DIR__ . '/../../'],
                'config_glob_paths' => [],
            ],
            'service_listener_options' => [],
            'service_manager' => [],
        ]);
        parent::setUp();
    }

    /**
     * @test
     */
    public function createService()
    {
        $context = $this->getMockBuilder('Qandidate\Toggle\ToggleCollection')->disableOriginalConstructor();
        $this->services->setService('ToggleFeature\InMemory', $context->getMock());

        $this->assertInstanceOf('Qandidate\Toggle\ToggleManager', $this->factory->createService($this->services));
    }
}
