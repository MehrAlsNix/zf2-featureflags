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

namespace MehrAlsNix\FeatureToggle\Context;

use Qandidate\Toggle\Context;
use Qandidate\Toggle\ContextFactory;
use Zend\Http\PhpEnvironment\Request;

/**
 * Context factory is implemented in an application to provide the context for
 * feature flipping.
 */
class EnvContext extends ContextFactory
{
    /** @var string $name */
    private $name = '';

    /** @var Request $request */
    private $request;

    public function __construct($name, Request $request)
    {
        $this->name = $name;
        $this->request = $request;
    }

    /**
     * @return Context
     */
    public function createContext()
    {
        $context = new Context();
        $env = $this->request->getEnv($this->name);
        if ($env !== null) {
            $context->set('env', $env);
        }
        return $context;
    }
}
