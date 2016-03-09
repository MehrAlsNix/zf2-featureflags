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
    'service_manager' => [
        'aliases' => [
            'FeatureToggle\InMemory'   => 'Qandidate\Toggle\Collection\InMemory',
            'FeatureToggle\Redis'      => 'Qandidate\Toggle\Collection\Predis',
            'ToggleManagerFactory' => 'Qandidate\Toggle\Manager',
            'ToggleContextFactory' => 'Qandidate\Toggle\Context'
        ],
        'services' => [
            'Qandidate\Toggle\Collection\InMemory' => new \Qandidate\Toggle\ToggleCollection\InMemoryCollection(),
            'Qandidate\Toggle\Serializer\InMemoryCollectionSerializer' => new \Qandidate\Toggle\Serializer\InMemoryCollectionSerializer(),
        ],
        'factories' => [
            'FeatureToggle\UserContextFactory' => \MehrAlsNix\FeatureToggle\Factory\UserContextFactory::class,
            'Qandidate\Toggle\Manager' => \MehrAlsNix\FeatureToggle\Factory\ToggleManagerFactory::class,
            'Qandidate\Toggle\Context' => \MehrAlsNix\FeatureToggle\Factory\ToggleContextFactory::class
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
