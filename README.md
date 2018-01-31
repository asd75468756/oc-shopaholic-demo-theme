# Installation guide

1. Use the composer update command
```bash
composer install
```
2. Create clear database
3. Copy file .env.example => .env
```bash
cp .env.exemple .env
```
4. Change settings in .env file
5. Run database migrations
```bash
php artisan october:up
```
6. Install plugins:
  * [Static Pages](http://octobercms.com/plugin/rainlab-pages) - required
  * [Twig Extensions](http://octobercms.com/plugin/vojtasvoboda-twigextensions) - required
  * [Toolbox](http://octobercms.com/plugin/lovata-toolbox) - required
  * [Shopaholic](http://octobercms.com/plugin/lovata-shopaholic) - required
  * [Orders for Shopaholic](http://octobercms.com/plugin/lovata-ordersshopaholic) - required
  * [Buddies](http://octobercms.com/plugin/lovata-buddies) - required
7. Run database migrations
```bash
php artisan october:up
```
8. Reinstall Lovata.OrdersShopaholic and Lovata.BaseCode plugins
```bash
php artisan plugin:refresh Lovata.OrdersShopaholic
php artisan plugin:refresh Lovata.BaseCode
php artisan cache:clear
```

**If you add new extensions of [Shopaholic](http://octobercms.com/plugin/lovata-shopaholic) plugin, you can reinstall Lovata.OrdersShopaholic and Lovata.BaseCode plugins.
Database will be automatically filled with test data**
