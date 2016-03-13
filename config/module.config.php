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

use MehrAlsNix\FeatureToggle\Factory;
use MehrAlsNix\FeatureToggle\Listener;
use Qandidate\Toggle;

return [
    'view_helpers' => [
        'factories' => [
            'FeatureToggle' => function ($serviceManager) {
                $toggleManager = $serviceManager->get('ToggleManagerFactory');
                $toggleContext = $serviceManager->get('ToggleContextFactory');

                $helper = new \MehrAlsNix\FeatureToggle\View\Helper\FeatureToggle();
                $helper->setToggleManager($toggleManager);
                $helper->setContext($toggleContext);
            }
        ]
    ],
    'controller_plugins' => [
        'factories' => [
            'FeatureToggle' => function ($serviceManager) {
                $toggleManager = $serviceManager->get('ToggleManagerFactory');
                $toggleContext = $serviceManager->get('ToggleContextFactory');

                $helper = new \MehrAlsNix\FeatureToggle\Mvc\Controller\Plugin\FeatureToggle();
                $helper->setToggleManager($toggleManager);
                $helper->setContext($toggleContext);
            }
        ]
    ],
    'service_manager' => [
        'aliases' => [
            'ToggleFeature\InMemory' => Toggle\ToggleCollection\InMemoryCollection::class,
            'ToggleFeature\InMemoryCollSerializer' => Toggle\Serializer\InMemoryCollectionSerializer::class,
            'ToggleFeature\Redis' => 'Qandidate\Toggle\Collection\Predis',
            'ToggleManagerFactory' => 'Qandidate\Toggle\Manager',
            'ToggleContextFactory' => 'Qandidate\Toggle\Context'
        ],
        'factories' => [
            'FeatureToggle\UserContextFactory' => Factory\UserContextFactory::class,
            'Qandidate\Toggle\Manager' => Factory\ToggleManagerFactory::class,
            'Qandidate\Toggle\Context' => Factory\ToggleContextFactory::class
        ]
    ],
    'zf_annotation' => [
        'annotations' => [
            'Toggle'
        ],
        'event_listeners' => [
            Listener\ToggleListener::class
        ]
    ]
];
