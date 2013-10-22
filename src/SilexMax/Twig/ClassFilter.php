<?php

namespace SilexMax\Twig;

class ClassFilter
{
    static public function classDefault($current, $class)
    {
        $current = self::explode($current);
        $class = self::explode($class);

        if (!empty($current)) {
            $class = array_diff($class, $current);
            $class = self::filterCols($current, $class);
        }

        return implode(' ', array_merge($current, $class));
    }

    static public function explode($class)
    {
        $classes = explode(' ', $class);
        $classes = array_filter($classes);
        $classes = array_unique($classes);

        return $classes;
    }

    static public function filterCols(array $current, array $new)
    {
        $pattern = '/(col-(xs|md|lg|xl)(-offset)?-)(\d+)/';

        return array_filter($new, function ($class) use ($current, $pattern) {
            if (preg_match($pattern, $class, $matches)) {

                $prefix = $matches[1];
                foreach ($current as $currentClass) {
                    if (preg_match($pattern, $currentClass, $currentMatches)) {
                        if ($prefix === $currentMatches[1]) {
                            return false;
                        }
                    }
                }
            }

            return true;
        });
    }
}
