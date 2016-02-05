<?php

namespace MehrAlsNix\FeatureToggle\Annotation;

use Zend\Code\Annotation\AnnotationInterface;

class Toggle implements AnnotationInterface
{
    public $name;

    /**
     * Initialize
     *
     * @param  string $content
     * @return void
     */
    public function initialize($content)
    {
        // Do nothing.
    }

    /**
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
}
