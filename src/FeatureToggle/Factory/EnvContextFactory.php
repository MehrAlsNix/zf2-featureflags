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

use MehrAlsNix\FeatureToggle\Context\EnvContext;
use Qandidate\Toggle\Context;
use Zend\Http\PhpEnvironment\Request;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class EnvContextFactory implements FactoryInterface
{
    private $name = '';

    public function __construct($name = '')
    {
        $this->name = $name;
    }

    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return Context
     *
     * @throws ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $name = $this->name;

        if ($name === '') {
            $name = $serviceLocator->get('Config')['zf2_featureflags']['envContext'];
        }

        /** @var Request $request */
        $request = $serviceLocator->get('Request');

        $envContext = new EnvContext($name, $request);

        return $envContext->createContext();
    }
}
