# laravel-web-site-boilerplate
[![Build Status](https://travis-ci.org/kubotak-is/laravel-web-site-boilerplate.svg?branch=master)](https://travis-ci.org/kubotak-is/laravel-web-site-boilerplate)
[![Coverage Status](https://coveralls.io/repos/github/kubotak-is/laravel-web-site-boilerplate/badge.svg)](https://coveralls.io/github/kubotak-is/laravel-web-site-boilerplate)

## WIP

## 実装パターン
- ActionDomainResponder風
- ドメイン駆動風
- NoFacade!
- あとはお好きに


## Vagrant開発
```
$ composer install
```

vagrant.yamlをお使いの環境に合わせて修正
```
$ vagrant up
```

vagrant up時に死んだら以下を試してください
```
$ vagrant ssh
$ sudo yum -y update kernel
$ sudo yum -y install kernel-devel kernel-headers dkms gcc gcc-c++
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
