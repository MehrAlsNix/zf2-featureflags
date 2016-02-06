<?php

namespace MehrAlsNix\FeatureToggle\View\Helper;

use MehrAlsNix\FeatureToggle\Traits\ToggleAware;
use Zend\View\Helper\AbstractHelper;

class FeatureToggle extends AbstractHelper
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
