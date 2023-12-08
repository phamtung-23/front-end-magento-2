<?php

use Magento\Framework\Component\ComponentRegistrar;

ComponentRegistrar::register(
    ComponentRegistrar::MODULE,
    'MyModule_ModuleAdminAllowSecret',
    __DIR__
);