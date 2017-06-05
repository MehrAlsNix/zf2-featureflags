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

namespace MehrAlsNix\FeatureToggle\Factory;

use Interop\Container\ContainerInterface;
use Qandidate\Toggle\Context;
use MehrAlsNix\FeatureToggle\Context\UserContext;
use Zend\Authentication\AuthenticationServiceInterface;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class UserContextFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param array|null $options
     *
     * @return Context
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    public function __invoke(ContainerInterface $container, $requestedName = '', array $options = null)
    {
        /** @var AuthenticationServiceInterface $storage */
        $storage = $container->get('FeatureToggle\Storage');

        $userContext = new UserContext($storage);

        return $userContext->createContext();
    }
}
