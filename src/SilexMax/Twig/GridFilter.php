<?php

namespace SilexMax\Twig;

class GridFilter
{
    static public function getClass($current, $default)
    {
        $current = explode(' ', $current);
        $default = explode(' ', $default);

        if (!empty($default)) {
            $default = array_filter($default, function ($class) use ($current) {
                if (preg_match('/(col-(xs|md|lg|xl)(-offset)?-)(\d+)/', $class, $matches)) {
                    $prefix = $matches[1];
                    foreach ($current as $currentClass) {
                        if (preg_match('/' . preg_quote($prefix) . '(\d+)/', $currentClass)) {
                            return false;
                        }
                    }
                }

                return true;
            });
        }

        return implode(' ', array_merge($current, $default));
    }
}
