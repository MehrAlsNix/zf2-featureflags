<?php

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
    public function setToggleMAnager(ToggleManager $toggleManager)
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
    public function getToggleMAnager()
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
