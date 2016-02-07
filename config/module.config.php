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
    'zf_annotation' => [
        'annotations' => [
            'Toggle'
        ],
        'event_listeners' => [
            ToggleListener::class
        ]
    ],
    'qandidate_toggle' => [
        'persistence' => 'ToggleFeature\InMemory', // 'ToggleFeature\Redis'
        'context_factory' => 'ToggleFeature\UserContextFactory', // |your.context_factory.service.id
        'redis_namespace' => null, // toggle_%kernel.environment% # default, only required when persistence = redis
        'redis_client' => null // |your.redis_client.service.id # only required when persistence = redis
    ]
];
