<?php
/**
 * Created by PhpStorm.
 * User: Yuri2
 * Date: 2017/5/7
 * Time: 22:30
 */

namespace Think\Db;


use Think\Model;

interface Custom
{
    /**
     * 错误信息处理
     * @param $msg string 错误信息处理
     */
    public static function errorHandle($msg);

    /**
     * sql语句纪录信息处理
     * @param $msg string sql语句
     */
    public static function sqlLogHandle($msg);

    /**
     * 是否全局开启了debug模式
     * @return  bool
     */
    public static function isDebugMode();

    /**
     * 获取数据库配置（原C）
     * @param $name string
     * @param $default mixed
     * @return mixed
     */
    public static function getConfig($name, $default = null);

    /**
     * 获取缓存值
     * @param $name string
     * @return mixed
     */
    public static function getCache($name);

    /**
     * 设置缓存值
     * @param $name string
     * @param $value mixed
     * @param $expire int
     * @return bool
     */
    public static function setCache($name,$value=null, $expire=3600);

    /**
     * 实例化模型类（继承自Model类）
     * User 返回一个UserModel实例
     * @param $name string
     * @return Model
     */
    public static function D($name='') ;


    }