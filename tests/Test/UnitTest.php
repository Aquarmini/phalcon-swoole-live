<?php
// +----------------------------------------------------------------------
// | UnitTest [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.lmx0536.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: limx <715557344@qq.com> <http://www.lmx0536.cn>
// +----------------------------------------------------------------------
// | Date: 2016/11/26 Time: 16:46
// +----------------------------------------------------------------------
namespace Test;

use \UnitTestCase;
use limx\phalcon\Utils\Str;

/**
 * Class UnitTest
 */
class UnitTest extends UnitTestCase
{
    /**
     * @desc   Session测试
     * @author limx
     */
    public function testSessionCase()
    {
        $value = uniqid();
        $key = 'test:case:session';
        $session = di('session');
        // 保存session
        $session->set($key, $value);
        // 是否存在session
        $this->assertTrue($session->has($key));
        // 获取session
        $this->assertEquals(
            $value,
            $session->get($key)
        );
        // 删除某个session
        $session->remove($key);
        $this->assertTrue(false === $session->has($key));
        // 销毁所有session
        // $session->destroy();
        // $this->assertTrue(false === $session->has($key), "会话销毁是相对于下次访问而言");
    }

    /**
     * @desc   cache 测试
     * @author limx
     */
    public function testCacheCase()
    {
        $key = 'test-case-cache';
        $data = [
            'time' => time(),
            'str' => Str::random(12),
        ];
        $lifetime = 3600;
        $cache = di('cache');
        // 保存缓存 文件存储lifetime无效
        $cache->save($key, $data, $lifetime);
        // 读取缓存
        $this->assertEquals(
            $data,
            $cache->get($key, $lifetime)
        );
        // 读取所有缓存key
        $this->assertTrue(in_array($key, $cache->queryKeys()));
        // 删除缓存
        $cache->delete($key);
        // 是否存在缓存
        $this->assertTrue(false === $cache->exists($key));
        // 销毁所有缓存
        $cache->save($key, $data, $lifetime);
        $cache->flush();
        $this->assertEmpty($cache->queryKeys());
    }

    /**
     * @desc   cookies 测试
     * @author limx
     */
    public function testCookiesCase()
    {
        $key = 'test-case-cookies';
        $data = uniqid();
        $lifetime = 3600;
        $cookies = di('cookies');
        // 验证是否加密
        $this->assertTrue($cookies->isUsingEncryption(), "Cookies服务没有默认加密！");
        // 保存cookies
        $cookies->set($key, $data, $lifetime);
        // 读取cookies
        $this->assertEquals($data, $cookies->get($key));
        // 是否存在cookies
        $this->assertTrue($cookies->has($key));
        // 删除cookies
        // $cookies->delete($key);
        // $this->assertTrue(false === $cookies->has($key));
    }
}