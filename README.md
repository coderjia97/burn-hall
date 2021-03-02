BurnHall2.0 框架
========================

# 简介
`BurnHall2` 是基于`laravel7`开发的一套后台基础功能集成框架

# 功能
-[ ] 注册登陆 用户管理 权限管理  
-[x] 三层架构 + redis表级缓存  
-[x] sql日志 sql慢查询日志 api请求日志  
-[x] 自动匹配 `Restful API` 路由  
-[x] 定时任务  
-[ ] 消息队列  
-[ ] 微信封装  
-[x] 日志封装  
-[x] 注释过滤`Api`返回参数  

# Composer
`barryvdh/laravel-ide-helper` 支持`idea`提示
* 生成idea支持 `php artisan ide-helper:meta`

`binarytorch/larecipe` `Markdown`
* [文档支持](https://larecipe.binarytorch.com.my/)
* 生成文档 `php artisan larecipe:docs`
* url: `/docs`

`L5-Swagger` swagger
* [文档支持](https://zircote.github.io/swagger-php/Getting-started.html)
* 自动生成json `php artisan l5-swagger:generate`
* url: `/api/documentation`

