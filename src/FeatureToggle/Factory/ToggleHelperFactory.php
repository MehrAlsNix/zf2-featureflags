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

use MehrAlsNix\FeatureToggle\View;
use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleManager;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\HelperPluginManager;

class ToggleHelperFactory implements FactoryInterface
{
    /**
     * Create service
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return View\Helper\FeatureToggle
     *
     * @throws ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        if ($serviceLocator instanceof HelperPluginManager) {
            $parentLocator = $serviceLocator->getServiceLocator();
        } else {
            $parentLocator = $serviceLocator;
        }
        /** @var ToggleManager $toggleManager */
        $toggleManager = $parentLocator->get('ToggleManagerFactory');

        /** @var Context $toggleContext */
        $toggleContext = $parentLocator->get('ToggleContextFactory');

        $featureToggle = new View\Helper\FeatureToggle();
        $featureToggle->setToggleManager($toggleManager);
        $featureToggle->setContext($toggleContext);

        return $featureToggle;
    }
}
