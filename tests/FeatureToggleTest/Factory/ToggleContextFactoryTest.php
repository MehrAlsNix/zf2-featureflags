<?php

namespace MehrAlsNix\FeatureToggleTest\View\Helper;

use MehrAlsNix\FeatureToggle\Factory\ToggleContextFactory;
use MehrAlsNix\FeatureToggle\Factory\ToggleHelperFactory;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleCollection\InMemoryCollection;
use Qandidate\Toggle\ToggleManager;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

class ToggleContextFactoryTest extends AbstractHttpControllerTestCase
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
        $this->factory = new ToggleContextFactory();
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
        $toggleManager = $this->getMockBuilder('Qandidate\Toggle\ToggleManager')->disableOriginalConstructor();
        $this->services->setService('ToggleManagerFactory', $toggleManager->getMock());

        $context = $this->getMockBuilder('Qandidate\Toggle\Context');
        $this->services->setService('ToggleContextFactory', $context->getMock());

        $this->assertInstanceOf('Qandidate\Toggle\Context', $this->factory->createService($this->services));
    }
}
