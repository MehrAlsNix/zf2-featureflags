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

use MehrAlsNix\FeatureToggle\Listener\ToggleListener;

return [
    'view_helpers' => [
        'factories' => [
            'FeatureToggle' => \MehrAlsNix\FeatureToggle\Factory\ToggleHelperFactory::class
        ]
    ],
    'controller_plugins' => [
        'factories' => [
            'FeatureToggle' => \MehrAlsNix\FeatureToggle\Factory\TogglePluginFactory::class
        ]
    ],
    'service_manager' => [
        'aliases' => [
            'ToggleFeature\InMemory' => 'Qandidate\Toggle\Collection\InMemory',
            'ToggleFeature\Redis' => 'Qandidate\Toggle\Collection\Predis',
            'ToggleManagerFactory' => 'Qandidate\Toggle\Manager',
            'ToggleContextFactory' => 'Qandidate\Toggle\Context'
        ],
        'factories' => [
            'FeatureToggle\UserContextFactory' => \MehrAlsNix\FeatureToggle\Factory\UserContextFactory::class,
            'Qandidate\Toggle\Manager' => \MehrAlsNix\FeatureToggle\Factory\ToggleManagerFactory::class,
            'Qandidate\Toggle\Context' => \MehrAlsNix\FeatureToggle\Factory\ToggleContextFactory::class
        ],
        'invokables' => [
            'Qandidate\Toggle\Collection\InMemory' => Qandidate\Toggle\ToggleCollection\InMemoryCollection::class,
            'Qandidate\Toggle\Serializer\InMemoryCollectionSerializer' => Qandidate\Toggle\Serializer\InMemoryCollectionSerializer::class,
        ]
    ],
    'zf_annotation' => [
        'annotations' => [
            'Toggle'
        ],
        'event_listeners' => [
            ToggleListener::class
        ]
    ]
];
