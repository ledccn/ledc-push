<?php

namespace Ledc\Push;

use support\Redis;

/**
 * 唯一值的私有频道
 */
class UniqidChannel
{
    /**
     * 存储在Session的键名
     */
    public const SESSION_KEY = 'private-uniqid-channel';

    /**
     * 私有频道的前缀
     */
    public const PREFIX = 'private-uniqid-';

    /**
     * 私有频道的完整名称
     * @var string
     */
    protected string $channel_name = '';

    /**
     * 构造函数
     * @param string $channel_name 私有频道的完整名称
     */
    public function __construct(string $channel_name = '')
    {
        if (static::when($channel_name)) {
            $this->channel_name = $channel_name;
        }
    }

    /**
     * 前缀符合要求
     * @param string $channel_name
     * @return bool
     */
    public static function when(string $channel_name): bool
    {
        return str_starts_with($channel_name, self::PREFIX);
    }

    /**
     * 判断频道名是否有效
     * @return bool
     */
    public function valid(): bool
    {
        $session = request()->session();
        if ($session->has(static::SESSION_KEY)) {
            return $session->get(static::SESSION_KEY) === $this->channel_name;
        }
        return false;
    }

    /**
     * 生成并重置channel_name
     * @return string
     */
    public function generate(): string
    {
        $this->channel_name = self::PREFIX . uniqid(mt_rand(100000, 999999));
        request()->session()->set(static::SESSION_KEY, $this->channel_name);
        //Redis::setEx(UniqidChannel::SESSION_KEY . ':' . $this->channel_name, 86400, $this->channel_name);
        return $this->channel_name;
    }
}
