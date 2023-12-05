# BetterStack Logs for WordPress and WooCommerce

Better Stack lets you see inside any stack, debug any issue, and resolve any incident.

![image](https://github.com/uptimizt/bsp/assets/1852897/e9a7bf93-54ef-4378-8b61-d48da307a8a4)


# install
```
wp plugin install https://github.com/uptimizt/bsp/archive/master.zip --force --activate
```

1. get token from https://logs.betterstack.com/
2. add source to BS Logs and get token (choose PHP as platform)
3. add const `define('BETTERSTACK_LOGS_SOURCE_TOKEN', "token");` to wp-config.php


# todo
- add filter for extend log
- add setting page to save token in options
- add other settings
- improve other features
