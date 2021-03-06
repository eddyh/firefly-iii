<?php
declare(strict_types = 1);
namespace FireflyIII\Helpers\Help;

/**
 * Interface HelpInterface
 *
 * @package FireflyIII\Helpers\Help
 */
interface HelpInterface
{

    /**
     * @param string $key
     *
     * @return string
     */
    public function getFromCache(string $key): string;

    /**
     * @param string $language
     * @param string $route
     *
     * @return array
     */
    public function getFromGithub(string $language, string $route):array;

    /**
     * @param string $route
     *
     * @return bool
     */
    public function hasRoute(string $route): bool;

    /**
     * @param string $route
     *
     * @return bool
     */
    public function inCache(string $route): bool;

    /**
     * @param string $route
     * @param array  $content
     */
    public function putInCache(string $route, array $content);
}
