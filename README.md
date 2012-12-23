# ci-scaffold
> 自己设计的一个基于[codeigniter](http://ellislab.com/codeigniter/user-guide/ "codeigniter")的脚手架，能生成原始模型文件与模块目录，你只需要扩展与完善功能即可，减少编写重复模式的代码
> 在CI的基础上也做了一些扩展 包括一些开源的扩展与自己编写的扩展

## 开源的扩展

* 前端使用了[bootstrap](http://twitter.github.com/bootstrap/ "bootstrap")
* 同时对CI扩展了[HMVC](https://github.com/CodeIgniter/HMVC "HMVC")

## 自己加入的功能与概念

### core
* Hooks 允许动态注册
* Loader 在hex的基础上可以继承CI_Module同时加入layout概念
* Model 所有模型将会继承MY_Model 包含一些基本的操作方法
* MY_Module 中通过魔法方法_call实现对CI原生调用模型的写法进行了改进 变为
* 调用即加载的模式、

### helpers
* 增加了app_helper用来放置该应用扩展或者新增的函数

### language
* 创建了中文语言包（暂时可以符合大部分描述，当然有必要的话要根据您的应用作出增加或者修改）

### libraries
* 增加Debug调试助手类 页面执行完后会在底部输出页面执行参数与SQL
* Form_validation 表单验证类的扩展 增加令牌的概念
* Pagination 分页类改进
* Querycache 查询缓存

### modules
* common 公共模块（header、footer、sidebar、messagebox）可以根据实际情况自我增加与修改
* scaffold 脚手架主要部分文件 主要是用来生成模块与模型的 在发布时请去掉

### views
* layout 放置布局视图文件


## 要注意的地方
* 此使用的CI版本为2.1.3
* 使用scaffold来生成模型与模块请确保application/models与modules目录的可写入
* 理论上升级CI不会影响该扩展，只需将system替换即可
* autoload中默认自动加载的libraries有database、querycache、form_validation；helpers有url、app；config有app
* 已经开启了rewrite
* 请对数据表字段都加上注释（因为生成时需要读取字段的注释）这也是个好习惯

## 如何帮助开发项目搭建起始平台
* 将该压缩包解压后放到www目录下并改名为你的应用
* 有需要地选择CI版本 若需要降级或者升级需要将system目录替换掉
* 设置config/database.php中数据库的参数
* 访问[scaffold](http://localhost/appname/module/scaffold/index "scaffold")
* 勾选要生成的模型与模块然后生成

> 希望有助你的开发
> 如有问题欢迎提出
> [paperen](http://iamlze.cn "paperen")
