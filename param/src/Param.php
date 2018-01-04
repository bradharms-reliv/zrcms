<?php

namespace Zrcms\Param;

use Zrcms\Debug\IsDebug;
use Zrcms\Param\Exception\IllegalParam;
use Zrcms\Param\Exception\ParamException;
use Zrcms\Param\Exception\ParamMissing;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class Param
{
    /**
     * @return bool
     */
    protected static function isDebug(): bool
    {
        return IsDebug::invoke();
    }

    /**
     * @param array  $params
     * @param string $key
     * @param        $value
     *
     * @return array
     */
    public static function set(
        array $params,
        string $key,
        $value
    ) {
        $params[$key] = $value;

        return $params;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public static function get(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return $params[$key];
        }

        return $default;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return int|null
     */
    public static function getInt(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (int)$params[$key];
        }

        return $default;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return bool|null
     */
    public static function getBool(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (bool)$params[$key];
        }

        return $default;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return string|null
     */
    public static function getString(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (string)$params[$key];
        }

        return $default;
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return array|null
     */
    public static function getArray(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::has($params, $key)) {
            return (array)$params[$key];
        }

        return $default;
    }

    /**
     * @param array              $params
     * @param string             $key
     * @param null|string|object $context
     *
     * @return mixed
     * @throws \Throwable
     */
    public static function getRequired(
        array $params,
        string $key,
        $context = null
    ) {
        self::assertHas($params, $key, $context);

        return $params[$key];
    }

    /**
     * @param array  $params
     * @param string $key
     *
     * @return bool
     */
    public static function has(
        array $params,
        string $key
    ) {
        return array_key_exists($key, $params);
    }

    /**
     * @param array  $params
     * @param string $key
     *
     * @return bool
     */
    public static function isEmpty(
        array $params,
        string $key
    ) {
        return empty(self::get($params, $key, null));
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public static function getDefaultIfEmpty(
        array $params,
        string $key,
        $default = null
    ) {
        if (self::isEmpty($params, $key)) {
            return $default;
        }

        return self::get(
            $params,
            $key,
            $default
        );
    }

    /**
     * @param array  $params
     * @param string $key
     * @param null   $default
     *
     * @return mixed|null
     */
    public static function getAndRemove(
        array &$params,
        string $key,
        $default = null
    ) {
        $value = self::get(
            $params,
            $key,
            $default
        );

        self::remove(
            $params,
            $key
        );

        return $value;
    }

    /**
     * @param array              $params
     * @param string             $key
     * @param null|string|object $context
     *
     * @return mixed
     * @throws \Throwable
     */
    public static function getAndRemoveRequired(
        array &$params,
        string $key,
        $context = null
    ) {
        $value = self::getRequired(
            $params,
            $key,
            $context
        );

        self::remove(
            $params,
            $key
        );

        return $value;
    }

    /**
     * @param array  $params
     * @param string $key
     *
     * @return void
     */
    public static function remove(
        array &$params,
        string $key
    ) {
        unset($params[$key]);
    }

    /**
     * @param array              $params
     * @param string             $key
     * @param null|string|object $context
     *
     * @return void
     * @throws \Throwable
     */
    public static function assertNotEmpty(
        array $params,
        string $key,
        $context = null
    ) {
        self::assertHas(
            $params,
            $key,
            $context
        );

        $value = self::get(
            $params,
            $key,
            null
        );

        if (empty($value)) {
            self::throwParamException(
                $params,
                $key,
                $context,
                new ParamMissing("Property ({$key}) is missing and is required and can not be empty")
            );
        }
    }

    /**
     * @param array              $params
     * @param string             $key
     * @param null|string|object $context
     *
     * @return void
     * @throws \Throwable
     */
    public static function assertHas(
        array $params,
        string $key,
        $context = null
    ) {
        if (self::has($params, $key)) {
            return;
        }

        self::throwParamException(
            $params,
            $key,
            $context,
            new ParamMissing("Property ({$key}) is missing and is required")
        );
    }

    /**
     * @param array              $params
     * @param string             $key
     * @param null|string|object $context
     *
     * @return void
     * @throws ParamException
     * @throws \Throwable
     */
    public static function assertNotHas(
        array $params,
        string $key,
        $context = null
    ) {
        if (!self::has($params, $key)) {
            return;
        }

        self::throwParamException(
            $params,
            $key,
            $context,
            new IllegalParam("Illegal property ({$key}) is was found")
        );
    }

    /**
     * @param array              $params
     * @param string             $key
     * @param null|string|object $context
     * @param \Throwable|null    $exception
     *
     * @return void
     * @throws \Throwable|ParamException
     */
    public static function throwParamException(
        array $params,
        string $key,
        $context = null,
        \Throwable $exception = null
    ) {
        $message = '';

        if (!empty($exception)) {
            $message = $exception->getMessage();
        }

        $message = self::buildErrorMessage(
            $params,
            $key,
            $message,
            $context
        );

        if (self::isDebug()) {
            echo(
                "\n<pre>\n"
                . "Param Error: " . $message
                . "\n key: {$key}"
                . "\n params: " . json_encode($params, JSON_PRETTY_PRINT, 3)
                . "\n</pre>\n"
            );
        }

        if (!empty($exception)) {
            throw $exception;
        }

        throw new ParamException($message);
    }

    /**
     * @param array              $params
     * @param string             $key
     * @param null               $message
     * @param null|string|object $context
     *
     * @return null|string
     */
    protected static function buildErrorMessage(
        array $params,
        string $key,
        $message = null,
        $context = null
    ): string {
        if (empty($message)) {
            $message = 'There was an error with a key: (' . $key . ')'
                . ' in params: (' . json_encode($params, 0, 3) . ')';
        }

        if (is_object($context)) {
            $context = get_class($context);
        }

        if (empty($context)) {
            return $message;
        }

        return $message . ' Context: ' . $context;
    }
}
