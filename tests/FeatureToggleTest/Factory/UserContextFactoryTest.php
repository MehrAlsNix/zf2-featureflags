<?php

namespace MehrAlsNix\FeatureToggleTest\Factory;

use MehrAlsNix\FeatureToggle\Factory\UserContextFactory;
use Zend\Mvc\Controller\ControllerManager;
use Zend\ServiceManager\ServiceManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Qandidate\Toggle\Context;
use Zend\Authentication\AuthenticationServiceInterface;

class UserContextFactoryTest extends AbstractHttpControllerTestCase
{
    /**
     * @var ControllerManager
     */
    protected $controllers;

    /**
     * @var UserContextFactory
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

        $this->factory = new UserContextFactory();
        $this->services = new ServiceManager();
        $this->services->setFactory('FeatureToggle\UserContextFactory', $this->factory);

        $this->controllers = new ControllerManager($this->services, $config);
        $this->setApplicationConfig([
            'modules' => [
                'MehrAlsNix\FeatureToggle',
            ],
            'module_listener_options' => [
                'module_paths' => [__DIR__ . '/../../../'],
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
        $toggleManager = $this->getMockBuilder(AuthenticationServiceInterface::class)->disableOriginalConstructor();
        $this->services->setService('FeatureToggle\Storage', $toggleManager->getMock());

        $this->assertInstanceOf(Context::class, $this->factory->__invoke($this->services));
    }
}
