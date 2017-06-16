<?php
/**
 * Created by PhpStorm.
 * User: Yuri2
 * Date: 2017/5/5
 * Time: 13:06
 */

//自动加载db相关的类
spl_autoload_register(function ($class_name){
    static $class_map=[
        'Think\Db\Custom'=>__DIR__.'/Custom.php',
        'Think\Db\Adapter'=>__DIR__.'/Adapter.php',
        'Think\Db'=>__DIR__.'/Db.class.php',
        'Think\Model'=>__DIR__.'/Model.class.php',
        'Think\Model\AdvModel'=>__DIR__.'/Model/AdvModel.class.php',
        'Think\Model\MergeModel'=>__DIR__.'/Model/MergeModel.class.php',
        'Think\Model\MongoModel'=>__DIR__.'/Model/MongoModel.class.php',
        'Think\Model\RelationModel'=>__DIR__.'/Model/RelationModel.class.php',
        'Think\Model\ViewModel'=>__DIR__.'/Model/ViewModel.class.php',
        'Think\Db\Driver'=>__DIR__.'/Driver.class.php',
        'Think\Db\Lite'=>__DIR__.'/Lite.class.php',
        'Think\Db\Driver\Firebird'=>__DIR__.'/Driver/Firebird.class.php',
        'Think\Db\Driver\Mongo'=>__DIR__.'/Driver/Mongo.class.php',
        'Think\Db\Driver\Mysql'=>__DIR__.'/Driver/Mysql.class.php',
        'Think\Db\Driver\Oracle'=>__DIR__.'/Driver/Oracle.class.php',
        'Think\Db\Driver\Pgsql'=>__DIR__.'/Driver/Pgsql.class.php',
        'Think\Db\Driver\Sqlite'=>__DIR__.'/Driver/Sqlite.class.php',
        'Think\Db\Driver\Sqlsrv'=>__DIR__.'/Driver/Sqlsrv.class.php',
    ];
    if (isset($class_map[$class_name])){
        $class_file=$class_map[$class_name];
        if (is_file($class_file)){
            require $class_file;
            return true;
        }
    }

    return false;

});
