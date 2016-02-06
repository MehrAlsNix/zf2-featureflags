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

namespace MehrAlsNix\FeatureToggle\Mvc\Controller\Plugin;

use MehrAlsNix\FeatureToggle\Traits\ToggleAware;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class FeatureToggle extends AbstractPlugin
{
    use ToggleAware;

    /**
     * @param string $name
     * @return boolean
     */
    public function isActive($name)
    {
        return $this->toggleManager->active($name, $this->getContext());
    }

    /**
     * @return $this
     */
    public function __invoke()
    {
        return $this;
    }
}
