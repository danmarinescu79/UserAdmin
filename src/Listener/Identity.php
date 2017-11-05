<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 06:56:48
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 06:57:03
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin\Listener;

use Zend\Session\Container;

class Identity
{
    public static function identity()
    {
        $container = new Container('Zend_Auth');
        if ($container->storage && !empty($container->storage)) {
            return $container->storage;
        }
        return false;
    }
}
