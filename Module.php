<?php

namespace MehrAlsNix\FeatureToggle;

use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleCollection;
use Qandidate\Toggle\ToggleCollection\InMemoryCollection;
use Qandidate\Toggle\ToggleManager;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface
{
    /**
     * Retrieve autoloader configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            'Zend\Loader\StandardAutoloader' => [
                'namespaces' => [
                    __NAMESPACE__ => __DIR__ . '/src/',
                ]
            ]
        ];
    }

    /**
     * Retrieve module configuration
     *
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getServiceConfig()
    {
        return [
            'service_manager' => [
                'aliases' => [
                    'Toggle\Collection' => 'Qandidate\Toggle\Collection\InMemory'
                ],
                'services' => [
                    'Qandidate\Toggle\Collection\InMemory' => new InMemoryCollection()
                ],
                'factories' => [
                    'Qandidate\Toggle\Manager' => function (ServiceLocatorInterface $serviceManager) {
                        new ToggleManager($serviceManager->get('Toggle\Collection'));
                    },
                    'Qandidate\Toggle\Context' => function (ServiceLocatorInterface $serviceManager) {
                        new Context($serviceManager->get('Toggle\Collection'));
                    }
                ],
                'invokables' => [

                ]
            ]
        ];
    }

    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array|\Zend\ServiceManager\Config
     */
    public function getViewHelperConfig()
    {
        return [
            'view_helpers' => [
                'invokables' => [
                    'FeatureToggle' => View\Helper\FeatureToggle::class
                ]
            ]
        ];
    }
}
