<?php
 if (!defined('ABSPATH')) exit; class ComposerAutoloaderInite339eeab4d8d43c0a72d870fa6115199 { private static $loader; public static function loadClassLoader($class) { if ('Composer\Autoload\ClassLoader' === $class) { require __DIR__ . '/ClassLoader.php'; } } public static function getLoader() { if (null !== self::$loader) { return self::$loader; } spl_autoload_register(array('ComposerAutoloaderInite339eeab4d8d43c0a72d870fa6115199', 'loadClassLoader'), true, true); self::$loader = $loader = new \Composer\Autoload\ClassLoader(); spl_autoload_unregister(array('ComposerAutoloaderInite339eeab4d8d43c0a72d870fa6115199', 'loadClassLoader')); $useStaticLoader = PHP_VERSION_ID >= 50600 && !defined('HHVM_VERSION') && (!function_exists('zend_loader_file_encoded') || !zend_loader_file_encoded()); if ($useStaticLoader) { require_once __DIR__ . '/autoload_static.php'; call_user_func(\Composer\Autoload\ComposerStaticInite339eeab4d8d43c0a72d870fa6115199::getInitializer($loader)); } else { $map = require __DIR__ . '/autoload_namespaces.php'; foreach ($map as $namespace => $path) { $loader->set($namespace, $path); } $map = require __DIR__ . '/autoload_psr4.php'; foreach ($map as $namespace => $path) { $loader->setPsr4($namespace, $path); } $classMap = require __DIR__ . '/autoload_classmap.php'; if ($classMap) { $loader->addClassMap($classMap); } } $loader->register(true); if ($useStaticLoader) { $includeFiles = Composer\Autoload\ComposerStaticInite339eeab4d8d43c0a72d870fa6115199::$files; } else { $includeFiles = require __DIR__ . '/autoload_files.php'; } foreach ($includeFiles as $fileIdentifier => $file) { composerRequiree339eeab4d8d43c0a72d870fa6115199($fileIdentifier, $file); } return $loader; } } function composerRequiree339eeab4d8d43c0a72d870fa6115199($fileIdentifier, $file) { if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) { require $file; $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true; } } 