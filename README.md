# ci-scaffold
> 自己设计的一个基于[codeigniter](http://ellislab.com/codeigniter/user-guide/ "codeigniter")的脚手架，能生成原始模型文件与模块目录，你只需要扩展与完善功能即可，减少编写重复模式的代码
> 在CI的基础上也做了一些扩展 包括一些开源的扩展与自己编写的扩展
> 带截图的说明 [ci-scaffold](http://iamlze.cn/post/ci-scaffold "ci-scaffold")
![生成的模块列表](http://iamlze.cn/file/168)

## 开源的扩展

* 前端使用了[bootstrap](http://twitter.github.com/bootstrap/ "bootstrap")
* 同时对CI扩展了[HMVC](https://github.com/CodeIgniter/HMVC "HMVC")

## 自己加入的功能与概念

### core
* Hooks 允许动态注册
* Loader 在hex的基础上可以继承CI_Module同时加入layout概念
* Model 所有模型将会继承MY_Model 包含一些基本的操作方法
* MY_Module 中通过魔法方法_call实现对CI原生调用模型的写法进行了改进变为调用即加载的模式

### helpers
* 增加了app_helper用来放置该应用扩展或者新增的函数

### language
* 创建了中文语言包（暂时可以符合大部分描述，当然有必要的话要根据您的应用作出增加或者修改）

### libraries
* Debug调试助手 其实
* 就是调用了output的profiler 要关闭它只需要将ENVIRONMENT修改为不是development即可
* Form_validation 表单验证类的扩展 增加令牌的概念 （在development状态下是永远验证成功的）
* Pagination 分页类改进
* Querycache 查询缓存（对于我们来说是透明的，不需要单独调用）主要用来支持查询缓存

### modules
* common 公共模块（header、footer、sidebar、messagebox）可以根据实际情况自我增加与修改
* scaffold 脚手架主要部分文件 主要是用来生成模块与模型的 在发布时请去掉

### views
* layout 放置布局视图文件

### theme
* common公共css目录 放置一些公用的样式表文件
* default默认主题 通过修改config/app.php中的theme可以实现调用不同的主题（注意引入css时请使用封装好的css函数，js也是）

## 要注意的地方
* 此使用的CI版本为2.1.3
* 使用scaffold来生成模型与模块请确保application/models与modules目录的可写入
* 理论上升级CI不会影响该扩展，只需将system替换即可
* autoload中默认自动加载的libraries有database、querycache、form_validation；helpers有url、app；config有app
* 已经开启了rewrite
* 请对数据表字段都加上注释（因为生成时需要读取字段的注释）这也是个好习惯

## 如何使用
* 将该压缩包解压后放到www目录下并改名为你的应用
* 有需要地选择CI版本 若需要降级或者升级需要将system目录替换掉
* 设置config/database.php中数据库的参数
* 访问 *http://localhost/appname/module/scaffold/index*
* 勾选要生成的模型与模块然后生成

> 希望有助你的开发
> 如有问题欢迎提出
> [paperen](http://iamlze.cn "paperen")

## 例子
* 将该项目解压到www目录
* 在本地随便建立一个数据库比如叫test
* 将test.sql导入 会产生两个新表user与admin_group
* 访问 *http://localhost/appname/module/scaffold/index* 点击生成
* 如无意外会生成两个模型（models）与两个模块（modules）分别叫 user与admin_group
* 分别访问 *http://localhost/appname/module/user/main/index* 与 *http://localhost/appname/module/admin_group/main/index*


最后祝圣诞愉快~by paperen
