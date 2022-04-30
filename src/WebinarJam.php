<?php

/**
 * @author Iulian Ceapa <info@sitemd.net>
 * @copyright 2021-2022 Iulian Ceapa
 */

namespace WebinarJam;

use WebinarJam\Exceptions\WebinarJamException;

class WebinarJam
{
   const API_URL = "https://api.webinarjam.com/webinarjam";

   /**
    * API ключ.
    *
    * @var string
    */
   private $api_key;

   function __construct($api_key)
   {
      $this->api_key = $api_key;
   }

   /**
    * Вызов API.
    *
    * @param string $path Доп. адрес
    * @param string $method Метод подключения [POST|GET]
    * @param array $params Параметры при отправке
    * @return void
    */
   private function callApi($path, $method, $params = array())
   {
      $curl = curl_init();
      curl_setopt($curl, CURLOPT_URL, self::API_URL . $path);
      curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
      curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
      curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
      curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
      $out = curl_exec($curl);
      if ($out === false) {
         throw new WebinarJamException("Ошибка соединения с сервером api.webinarjam.com.");
      }
      curl_close($curl);
      return json_decode($out, true);
   }

   /**
    * Список всех вебинаров.
    *
    * @return array
    * @link https://documentation.webinarjam.com/retrieve-a-full-list-of-all-webinars-published-in-your-account/
    */
   public function getWebinars()
   {
      $path = "/webinars";
      $params = [
         'api_key' => $this->api_key
      ];
      $result = $this->callApi($path, "POST", $params);
      return $result;
   }

   /**
    * Подробная информация об индивидуальном вебинаре.
    *
    * @param int $webinar_id Идентификатор вебинара
    * @return array
    * @link https://documentation.webinarjam.com/get-details-about-one-particular-webinar-from-your-account/
    */
   public function getWebinar($webinar_id)
   {
      $path = "/webinar";
      $params = [
         'api_key'   => $this->api_key,
         'webinar_id' => $webinar_id
      ];
      $result = $this->callApi($path, "POST", $params);
      return $result;
   }

   /**
    * Регистрация человека на вебинар.
    *
    * @param string $webinar_id Идентификатор вебинара
    * @param array $user Данные пользователя
    *
    * Пример:
    * ```
    * $user = array(
    *    "first_name" => "",
    *    "last_name" => "", // Optional
    *    "email" => "",
    *    "phone_country_code" => "", // Optional
    *    "phone" => "", // Optional
    * );
    * ```
    * @return array
    * @link https://documentation.webinarjam.com/register-a-person-to-a-specific-webinar/
    */
   public function registration($webinar_id, $user)
   {
      $webinar_info = $this->getWebinar($webinar_id);

      $path = "/register";
      $params = [
         'api_key'            => $this->api_key,
         'webinar_id'         => $webinar_id,
         'first_name'         => $user["first_name"],
         'last_name'          => @$user["last_name"],
         'email'              => $user["email"],
         'schedule'           => $webinar_info['webinar']['schedules']['0']['schedule'],
         'ip_address'         => $_SERVER['REMOTE_ADDR'],
         'phone_country_code' => @$user["phone_country_code"],
         'phone'              => @$user["phone"]
      ];
      $result = $this->callApi($path, "POST", $params);
      return $result;
   }
}
