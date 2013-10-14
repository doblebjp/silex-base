<?php

namespace SilexMax\Controller;

use Twig_Environment as Twig;

interface TwigInterface
{
    public function setTwig(Twig $twig);
    public function render($template, $params = []);
}
