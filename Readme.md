# API WebinarJam

## Использование

Подключите файл `WebinarJam.php`, чтобы его можно было использовать.

```php
use WebinarJam\WebinarJam;

include "WebinarJam.php";
```

Создайте новый экземпляр класса WebinarJam, и укажите ключ API WebinarJam. Дополнительную информацию о получении ключа API можно найти в документации по [API WebinarJam](https://documentation.webinarjam.com/connecting-to-our-api/).

```php
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
 * @param string $webinar_id Идентификатор вебинара
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