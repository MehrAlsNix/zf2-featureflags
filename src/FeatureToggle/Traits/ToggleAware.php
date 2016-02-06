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

namespace MehrAlsNix\FeatureToggle\Traits;

use Qandidate\Toggle\Context;
use Qandidate\Toggle\ToggleManager;

trait ToggleAware
{
    /** @var ToggleManager $toggleManager */
    protected $toggleManager;

    /** @var Context $context */
    protected $context;

    /**
     * @param ToggleManager $toggleManager
     */
    public function setToggleManager(ToggleManager $toggleManager)
    {
        $this->toggleManager = $toggleManager;
    }

    /**
     * @param Context $context
     */
    public function setContext(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @return ToggleManager
     */
    public function getToggleManager()
    {
        return $this->toggleManager;
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }
}
