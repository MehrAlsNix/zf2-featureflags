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

use Zend\Console\Adapter\AdapterInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ControllerPluginProviderInterface;
use Zend\ModuleManager\Feature\ViewHelperProviderInterface;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Loader\StandardAutoloader;

/**
 * Class Module
 *
 * @package MehrAlsNix\FeatureToggle
 */
class Module implements ConfigProviderInterface,
    AutoloaderProviderInterface,
    ViewHelperProviderInterface,
    ControllerPluginProviderInterface,
    ConsoleUsageProviderInterface
{
    /**
     * @param ModuleManagerInterface $moduleManager
    /
     * public function init(ModuleManagerInterface $moduleManager)
     * {
     * $eventManager = $moduleManager->getEventManager();
     * $eventManager->attach(ModuleEvent::EVENT_MERGE_CONFIG, [$this, 'onMergeConfig']);
     * }
     *
     * /**
     * @param ModuleEvent $event
    /
     * public function onMergeConfig(ModuleEvent $event)
     * {
     * $config = $event->getConfigListener()->getMergedConfig(false);
     *
     * $event->
     * $serializer = new InMemoryCollectionSerializer();
     * $collection = $serializer->deserialize($data);
     * $manager    = new ToggleManager($collection);
     * }
     *
     * /**
     * Retrieve autoloader configuration
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return [
            StandardAutoloader::class => [
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
    public function getViewHelperConfig()
    {
        return [
            'aliases' => [
                'featureToggle' => 'FeatureToggle',
            ],
            'factories' => [
                'FeatureToggle' => Factory\FeatureToggleViewHelperFactory::class
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
            'aliases' => [
                'featureToggle' => 'FeatureToggle',
            ],
            'factories' => [
                'FeatureToggle' => Factory\FeatureToggleControllerPluginFactory::class
            ]
        ];
    }

    /**
     * Returns an array or a string containing usage information for this module's Console commands.
     * The method is called with active Zend\Console\Adapter\AdapterInterface that can be used to directly access
     * Console and send output.
     *
     * If the result is a string it will be shown directly in the console window.
     * If the result is an array, its contents will be formatted to console window width. The array must
     * have the following format:
     *
     *     return array(
     *                'Usage information line that should be shown as-is',
     *                'Another line of usage info',
     *
     *                '--parameter'        =>   'A short description of that parameter',
     *                '-another-parameter' =>   'A short description of another parameter',
     *                ...
     *            )
     *
     * @param AdapterInterface $console
     * @return array|string|null
     */
    public function getConsoleUsage(AdapterInterface $console)
    {
        return array(
            'config dump' => 'Compiles config and dump into cache file.',
        );
    }
}
