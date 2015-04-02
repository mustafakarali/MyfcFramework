<?php

  /**
   * 
   *  Sabitlerin tanımlanması -> app klasörü
   *  @var unknown
   */

  define("APP_PATH", "app/");
  
  /**
   *
   *  Sabitlerin tanımlanması -> public klasörü
   *  @var unknown
   */
  
  define("PUBLIC_PATH","public/");
  
  /**
   *
   *  Sabitlerin tanımlanması -> system klasörü
   *  @var unknown
   */
  
  define("SYSTEM_PATH","system/");
  
  /**
   *
   *  Sabitlerin tanımlanması -> vendor klasörü
   *  @var unknown
   */
  
  define("VENDOR_PATH","vendor/");
  
  /**
   * Sabitlerin tanımlanması -> language(dil) klasörü
   * @var unknown
   */
  
  define("LANGUAGE_PATH", PUBLIC_PATH.'language');
  
  /**
   * Sabitlerin tanımlanması -> view dosyaları
   * @var unknown
   */
  
  define('VIEW_PATH', APP_PATH.'Views/');
  
  include SYSTEM_PATH.'bootstrap.php';