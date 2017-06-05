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

namespace MehrAlsNix\FeatureToggle\Listener;

use MehrAlsNix\FeatureToggle\Annotation\Toggle;
use MehrAlsNix\FeatureToggle\Traits\ToggleAware;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use ZfAnnotation\Event\ParseEvent;

/**
 * Abstract aggregate listener
 */
class ToggleListener extends AbstractListenerAggregate
{
    use ToggleAware;

    /**
     * @param EventManagerInterface $events
     */
    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(ParseEvent::EVENT_CLASS_PARSED, [$this, 'onClassParsed']);
    }

    public function onClassParsed(ParseEvent $event)
    {
        $classHolder = $event->getTarget();
        $classAnnotations = $classHolder->getAnnotations();
        foreach ($classAnnotations as $annotation) {
            if ($annotation instanceof Toggle && !$this->isActive($annotation->getName())) {
                throw new \RuntimeException();
            }
        }

        $methodHolders = $classHolder->getMethods();
        foreach ($methodHolders as $methodHolder) {
            foreach ($methodHolder->getAnnotations() as $annotation) {
                if ($annotation instanceof Toggle && !$this->isActive($annotation->getName())) {
                    throw new \RuntimeException();
                }
            }
        }
    }
}
