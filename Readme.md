# API WebinarJam

## Установка

Установить библиотеку можно с помощью интерфейса командной строки при наличии Composer:

```bash
composer require sitemd/webinarjam
```

## Использование

После установки потребуется подключить автозагрузчик Composer:

```php
require "vendor/autoload.php";
```

Создайте новый экземпляр класса WebinarJam, и укажите ключ API WebinarJam. Дополнительную информацию о получении ключа API можно найти в документации по [API WebinarJam](https://documentation.webinarjam.com/connecting-to-our-api/).

```php
use WebinarJam\WebinarJam;

$webinarjam = new WebinarJam(API key);
```

## Доступные методы

### Список всех вебинаров

```php
$return_arr = $webinarjam->getWebinars();
```

### Подробная информация об индивидуальном вебинаре

```php
/**
 * @param int $webinar_id Идентификатор вебинара
 */
$return_arr = $webinar->getWebinar($webinar_id);
```

### Регистрация человека на вебинар

```php
/**
 * @param int $webinar_id Идентификатор вебинара
 * @param array $user Данные пользователя
 */
$user = array(
  "first_name" => "",
  "last_name" => "", // необязательно
  "email" => "",
  "phone_country_code" => "", // необязательно
  "phone" => "" // необязательно
);
$webinarjam->registration($webinar_id, $user);
```