
db_tp_3.2.3
-----------

该项目是从ThinkPHP_v3.2.3中提取出的数据库操作辅助类。

[项目地址](https://github.com/yuri2peter/db_tp_3.2.3.git "点击访问") 

使用价值
-----------
 * 个人认为tp3的数据库操作写的相当经典。
 * tp3的文档非常齐全。
 * 与tp框架完全解耦，你只需要配置一下就可以用在你自己的项目上，无须学习使用完整的tp框架。

使用方法
-----------
 1. 将本项目的所有文件置于你项目的某个文件夹下。
 2. 手动加载文件 autoloader.php 。使相关类库可以自动加载。
 3. 修改文件Adapter.php。这是因为数据库操作过程中可能会需要你作为开发者，去指定你自己的缓存存取方法、错误纪录方法等。本人已经尽量简化了api。
 4. 原tp3的全局方法M()改为Think\Db\Adapter::M()。
 5. 有关数据库辅助类的使用方法请参阅[tp3文档](http://www.kancloud.cn/manual/thinkphp/1727 "tp3文档：模型") 

小广告
-----------
 GearPHP，作者自用的php框架
 
 项目地址: [coding(经常更新)](https://git.coding.net/yuri2/gear_php.git)   [github(看心情更新)](https://github.com/yuri2peter/gear_php.git)
 
 最后的话
 ----------
 代码拿走，星星留下！