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
$webinarjam->getWebinars();
```

### Подробная информация об индивидуальном вебинаре

```php
$webinar->getWebinar($webinar_id);
```

| Параметр    | Тип  | Описание               |
| :---------- | :--- | :--------------------- |
| $webinar_id | int  | Идентификатор вебинара |

### Регистрация человека на вебинар

При успешного выполнения будет возвращен массив, содержащий информацию о пользователе и вебинаре, в противном случае null.

```php
$webinarjam->registration($webinar_id, $user);
```

| Параметр    | Тип   | Описание               |
| :---------- | :---- | :--------------------- |
| $webinar_id | int   | Идентификатор вебинара |
| $user       | array | Данные пользователя    |

В качестве параметра `$user` необходимо отправить массив с ниже указанными ключами.

| Ключ               | Тип    | Описание                                                                                       |
| :----------------- | :----- | :--------------------------------------------------------------------------------------------- |
| first_name         | string | Имя                                                                                            |
| last_name          | string | Фамилия (может быть обязательным в зависимости от настроенных параметров для каждого вебинара) |
| email"             | string | Email                                                                                          |
| phone_country_code | string | Код страны с "+"                                                                               |
| phone              | string | Номер телефона (только цифры)                                                                  |

## Пример

```php
use WebinarJam\WebinarJam;
// Подключение автозагрузчика
require "vendor/autoload.php";
$webinarjam = new WebinarJam(API key);
// Идентификатор вебинара
$webinar_id = 2;
// Данные пользователя
$user = array(
   "first_name" => "FirstName",
   "last_name" => "LastName",
   "email" => "test@email.com",
   "phone_country_code" => "+1",
   "phone" => "1234567890"
);
// Проверяем, не закончился ли вебинар
if (empty($webinarjam->getWebinar($webinar_id)["webinar"]["schedules"])) {
   echo "Регистрация на вебинар завершена";
} else{
   // Регистрация человека на вебинар
   $webinarjam->registration($webinar_id, $user);
}
```