<?php

/**
 * @Author: Dan Marinescu
 * @Date:   2017-11-05 05:35:03
 * @Email:  dan.marinescu79@icloud.com
 * @Last Modified by:   Dan Marinescu
 * @Last Modified time: 2017-11-05 06:28:26
 * @Last Modified email: dan.marinescu79@icloud.com
 */

namespace UserAdmin;

class Module
{
    const VERSION = '0.1';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
