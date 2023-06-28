<?php

namespace Simplemvc\Config;

class Config
{
    public static string $defaultController = 'Home';
    public static string $defaultActionMethod = 'index';
    public static string $defaultControllerNamespace = 'Simplemvc\\Controllers';
    public static string $termForControllers = 'controller';
    public static string $termForActions = 'action';
    public static string $defaultModelNamespace = 'Simplemvc\\Models';
    /**
     * @var bool
     * !!Warning: Dynamic routing guesses the controller and action based on the generic uri format: www.site.com/controller/method.
     * Try setting this to true and then navigate to /private-controller/private-method
     */
    public static bool $allowDynamicRouting = false;

}