<?php

namespace SilexMax\Controller;

use Twig_Environment as Twig;

trait TwigTrait
{
    protected $twig;

    public function setTwig(Twig $twig)
    {
        $this->twig = $twig;

        return $this;
    }

    public function render($template, $params = [])
    {
        if (null === $this->twig) {
            throw new \RuntimeException('Twig environment is not set');
        }

        return $this->twig->render($template, $params);
    }
}
