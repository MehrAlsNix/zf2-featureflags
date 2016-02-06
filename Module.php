<?php
/**
 * zf2-featureflags.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 * @copyright 2016 MehrAlsNix (http://www.mehralsnix.de)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 *
 * @link      http://github.com/MehrAlsNix/zf2-featureflags
 */

namespace MehrAlsNix\FeatureToggle;

use MehrAlsNix\FeatureToggle\Context\UserContextFactory;
use Qandidate\Toggle\ToggleCollection;
use Qandidate\Toggle\ToggleCollection\InMemoryCollection;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;

/**
 * Class Module
 *
 * @package MehrAlsNix\FeatureToggle
 */
class Module implements ConfigProviderInterface,
    AutoloaderProviderInterface,
    ServiceProviderInterface,
    ViewHelperProviderInterface,
    ControllerPluginProviderInterface
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
                    'FeatureToggle\InMemory' => 'Qandidate\Toggle\Collection\InMemory',
                    'FeatureToggle\Redis'    => 'Qandidate\Toggle\Collection\Predis'
                ],
                'services' => [
                    'Qandidate\Toggle\Collection\InMemory' => new InMemoryCollection()
                ],
                'factories' => [
                    'ToggleFeature\UserContextFactory' => function ($serviceManager) {
                        $storage = $serviceManager->get('Storage');
                        return new UserContextFactory($storage);
                    },
                    'Qandidate\Toggle\Manager' => Factory\ToggleManagerFactory::class,
                    'Qandidate\Toggle\Context' => Factory\ToggleContextFactory::class
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
                'factories' => [
                    'FeatureToggle' => Factory\ToggleHelperFactory::class
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
    public function getControllerPluginConfig()
    {
        return [
            'controller_plugins' => [
                'factories' => [
                    'FeatureToggle' => Factory\TogglePluginFactory::class
                ]
            ]
        ];
    }
}
