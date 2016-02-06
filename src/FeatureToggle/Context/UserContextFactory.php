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
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * {@inheritDoc}
 */
class UserContextFactory extends ContextFactory
{
    /** @var AuthenticationServiceInterface $tokenStorage */
    private $tokenStorage;

    public function __construct(AuthenticationServiceInterface $storage)
    {
        $this->tokenStorage = $storage;
    }

    /**
     * @return Context
     */
    public function createContext()
    {
        $context = new Context();
        $token = $this->tokenStorage->getIdentity();
        if (null !== $token) {
            $context->set('username', $this->tokenStorage->getIdentity());
        }
        return $context;
    }
}
