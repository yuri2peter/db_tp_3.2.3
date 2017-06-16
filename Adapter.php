<?php
/**
 * Created by PhpStorm.
 * User: Yuri2
 * Date: 2017/5/5
 * Time: 13:17
 */

namespace Think\Db;

//适配器，修改此处内容来自定义你的db辅助操作
use src\cores\PluginManager;
use Think\Model;

class
Adapter implements Custom
{

    /**
     * 错误信息处理
     * @param $msg string 错误信息处理
     */
    public static function errorHandle($msg){
        trigger_error($msg, E_USER_ERROR);
    }

    /**
     * sql语句纪录信息处理
     * @param $msg string sql语句
     */
    public static function sqlLogHandle($msg){
        maker()->logger()->info($msg);
    }

    /**
     * 是否全局开启了debug模式
     * @return  bool
     */
    public static function isDebugMode()
    {
        return config('debug');
    }

    /**
     * 获取数据库配置（原C）
     * @param $name string
     * @param $default mixed
     * @return mixed
     */
    public static function getConfig($name, $default = null)
    {
        if (!isset($initialized)) {
            static $config = [
                /* 数据库设置 */
                'DB_TYPE' => 'mysql',          // 数据库类型
                'DB_HOST' => 'localhost',          // 服务器地址
                'DB_NAME' => 'test',          // 数据库名
                'DB_USER' => 'root',          // 用户名
                'DB_PWD' => 'root',          // 密码
                'DB_PORT' => '3306',          // 端口
                'DB_PREFIX' => '',          // 数据库表前缀
                'DB_PARAMS' => array(),     // 数据库连接参数
                'DB_DEBUG' => true,        // 数据库调试模式 开启后可以记录SQL日志
                'DB_FIELDS_CACHE' => false,       // 启用字段缓存
                'DB_CHARSET' => 'utf8',      // 数据库编码默认采用utf8
                'DB_DEPLOY_TYPE' => 0,           // 数据库部署方式:0 集中式(单一服务器),1 分布式(主从服务器)
                'DB_RW_SEPARATE' => false,       // 数据库读写是否分离 主从式有效
                'DB_MASTER_NUM' => 1,           // 读写分离后 主服务器数量
                'DB_SLAVE_NO' => '',          // 指定从服务器序号
                'DB_READ_DATA_MAP' => false,       // 返回结果自动字段映射，隐藏数据库的真实字段名
                'DB_SEQUENCE_PREFIX' => '',          // Oracle有效，序列前缀
            ];
            $configPlugin = PluginManager::getPlugin('dbThink')->get('configs');
            $config=array_merge($config,$configPlugin);
            static $initialized=true;
        }
        return isset($config[$name])?$config[$name]:$default;
    }

    /**
     * 获取缓存值
     * @param $name string
     * @return mixed
     */
    public static function getCache($name){
        return cache()->get($name);
    }

    /**
     * 设置缓存值
     * @param $name string
     * @param $value mixed
     * @param $expire int
     * @return bool
     */
    public static function setCache($name,$value=null, $expire=3600){
        return cache()->set($name, $value, $expire);
    }

    /**
     * 实例化模型类（继承自Model类）
     * User 返回一个UserModel实例
     * @param $name string
     * @return Model|false
     */
    public static function D($name='') {
        if(empty($name)) return new Model;
        if($name[0]==='\\'){
            $className=$name;
        }else{
            $moduleName=maker()->request()->getModuleName();
            $className="\apps\\$moduleName\models\\$name";
            if(!class_exists($className)){
                $className.='Model';
            }
        }
        return class_exists($className)? new $className:false;
    }

    /** ------------------------------------以上内容需要按实际情况自定义-------------------------------------------- */
    /** ------------------------------------以下内容无需改动-------------------------------------------- */

    public static function getClientIp()
    {
        $user_IP = (isset($_SERVER["HTTP_VIA"]) and $_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
        $user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"];
        return $user_IP;
    }

    /**
     * 添加和获取页面Trace记录(原trace)
     * @param string $value 变量
     * @param string $label 标签
     * @param string $level 日志级别
     * @param boolean $record 是否记录日志
     * @return void|array
     */
    public static function trace($value = '[think]', $label = '', $level = 'DEBUG', $record = false)
    {
        if ($level == 'ERR') {
            self::errorHandle($value);
        } elseif ($level == 'SQL') {
            self::sqlLogHandle($value);
        }
    }

    /**
     * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
     * @param string $name 缓存名称
     * @param mixed $value 缓存值
     * @param string $path 缓存路径
     * @return mixed
     */
    public static function F($name, $value = '', $path = '')
    {
        $name .= 'dbThink_';
        if ($value) {
            return self::setCache($name,$value);
        } else {
            return self::getCache($name);
        }

    }

    /**
     * 缓存管理
     * @param mixed $name 缓存名称，如果为数组表示进行缓存设置
     * @param mixed $value 缓存值
     * @param mixed $options 缓存参数(直接数字表示expire)
     * @return mixed
     */
    public static function S($name, $value = '', $options = null)
    {
        $name .= 'dbThink_';
        if ($options) {
            $expire = is_array($options) ? $options['expire'] : $options;
            return self::setCache($name,$value,$expire);
        } else {
            return self::getCache($name);
        }
    }

    /**
     * 抛出一个异常(原E)
     * @param $msg string
     * @throws \Exception
     */
    public static function E($msg)
    {
        throw new \Exception($msg);
    }

    /**
     * 获取数据库配置（原C）
     * @param $name string
     * @param $default mixed
     * @return mixed
     */
    public static function C($name, $default = null)
    {
        return self::getConfig($name, $default);
    }

    /**
     * 字符串命名风格转换
     * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
     * @param string $name 字符串
     * @param integer $type 转换类型
     * @return string
     */
    public static function parse_name($name, $type = 0)
    {
        if ($type) {
            return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name));
        } else {
            return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
        }
    }

    /**
     * XML编码
     * @param mixed $data 数据
     * @param string $root 根节点名
     * @param string $item 数字索引的子节点名
     * @param string $attr 根节点属性
     * @param string $id 数字索引子节点key转换的属性名
     * @param string $encoding 数据编码
     * @return string
     */
    public static function xml_encode($data, $root = 'think', $item = 'item', $attr = '', $id = 'id', $encoding = 'utf-8')
    {
        if (is_array($attr)) {
            $_attr = array();
            foreach ($attr as $key => $value) {
                $_attr[] = "{$key}=\"{$value}\"";
            }
            $attr = implode(' ', $_attr);
        }
        $attr = trim($attr);
        $attr = empty($attr) ? '' : " {$attr}";
        $xml = "<?xml version=\"1.0\" encoding=\"{$encoding}\"?>";
        $xml .= "<{$root}{$attr}>";
        $xml .= self::data_to_xml($data, $item, $id);
        $xml .= "</{$root}>";
        return $xml;
    }

    /**
     * 数据XML编码
     * @param mixed $data 数据
     * @param string $item 数字索引时的节点名称
     * @param string $id 数字索引key转换为的属性名
     * @return string
     */
    public static function data_to_xml($data, $item = 'item', $id = 'id')
    {
        $xml = $attr = '';
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $id && $attr = " {$id}=\"{$key}\"";
                $key = $item;
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= (is_array($val) || is_object($val)) ? self::data_to_xml($val, $item, $id) : $val;
            $xml .= "</{$key}>";
        }
        return $xml;
    }

    public static function getNowTime()
    {
        return $_SERVER['REQUEST_TIME'];
    }

    public static function isMagic_Quotes_GPC()
    {
        return false;
    }

    /**
     * 设置和获取统计数据
     * 使用方法:
     * <code>
     * N('db',1); // 记录数据库操作次数
     * N('read',1); // 记录读取次数
     * echo N('db'); // 获取当前页面数据库的所有操作次数
     * echo N('read'); // 获取当前页面读取次数
     * </code>
     * @param string $key 标识位置
     * @param integer $step 步进值
     * @param boolean $save 是否保存结果
     * @return mixed
     */
    public static function N($key, $step = 0, $save = false)
    {
        static $data=[];
        if(!isset($data[$key])){$data[$key]=0;}
        $data[$key]+=$step;
        return null;
    }

    /**
     * 记录和统计时间（微秒）和内存使用情况
     * 使用方法:
     * <code>
     * G('begin'); // 记录开始标记位
     * // ... 区间运行代码
     * G('end'); // 记录结束标签位
     * echo G('begin','end',6); // 统计区间运行时间 精确到小数后6位
     * echo G('begin','end','m'); // 统计区间内存使用情况
     * 如果end标记位没有定义，则会自动以当前作为标记位
     * 其中统计内存使用需要 MEMORY_LIMIT_ON 常量为true才有效
     * </code>
     * @param string $start 开始标签
     * @param string $end 结束标签
     * @param integer|string $dec 小数位或者m
     * @return mixed
     */
    public static function G($start, $end = '', $dec = 4)
    {
        static $_info = array();
        static $_mem = array();
        if (is_float($end)) { // 记录时间
            $_info[$start] = $end;
        } elseif (!empty($end)) { // 统计时间和内存使用
            if (!isset($_info[$end])) $_info[$end] = microtime(TRUE);
            if (function_exists('memory_get_usage') && $dec == 'm') {
                if (!isset($_mem[$end])) $_mem[$end] = memory_get_usage();
                return number_format(($_mem[$end] - $_mem[$start]) / 1024);
            } else {
                return number_format(($_info[$end] - $_info[$start]), $dec);
            }

        } else { // 记录时间和内存使用
            $_info[$start] = microtime(TRUE);
            if (function_exists('memory_get_usage')) $_mem[$start] = memory_get_usage();
        }
        return null;
    }

    /**
     * 实例化一个没有模型文件的Model
     * @param string $name Model名称 支持指定基础模型 例如 MongoModel:User
     * @param string $tablePrefix 表前缀
     * @param mixed $connection 数据库连接信息
     * @return Model
     */
    public static function M($name='', $tablePrefix='',$connection='') {
        static $_model  = array();
        if(strpos($name,':')) {
            list($class,$name)    =  explode(':',$name);
        }else{
            $class      =   'Think\\Model';
        }
        $guid           =   (is_array($connection)?implode('',$connection):$connection).$tablePrefix . $name . '_' . $class;
        if (!isset($_model[$guid]))
            $_model[$guid] = new $class($name,$tablePrefix,$connection);
        return $_model[$guid];
    }



}