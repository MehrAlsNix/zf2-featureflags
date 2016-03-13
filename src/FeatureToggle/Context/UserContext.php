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
 * Context factory is implemented in an application to provide the context for
 * feature flipping.
 *
 * To abstract away the business object from the feature library, the
 * application is responsible for mapping the business objects into a context
 * based for feature flipping. For example:
 *
 *     $request = ...;
 *     $user    = $repository->findBy(..);
 *     $context = new Context();
 *     $context->set('user_id', $user->getId());
 *     $context->set('company_id', $user->getCompanyId());
 *     $context->set('ip', $request->getClientIp());
 */
class UserContext extends ContextFactory
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
