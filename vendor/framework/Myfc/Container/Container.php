<?php  

  namespace Myfc;
  
  use Myfc\Facade;
  
  use Myfc\Facade\Route;
  
  use Myfc\Router;
  
  use Myfc\Http\Server;
  
  use ReflectionClass;
  
  use Closure;
  
  class Container{
      
      
      public $server;
      
      public $ayarlar;
      
      public $get;
      
      protected $bind;
      
      public $maked = array();
      
      /**
       * S�n�f� ba�lat�r
       * @param \Myfc\Http\Server $server
       * @param array $ayarlar
       * @param array $get
       */
      
      public function __construct( Server $server, array $ayarlar, array $get){
          
          
          
          $this->server = $server;
          
          $this->ayarlar = $ayarlar;
          
          $this->get = $get;
         
          $this->facedeRegister( $ayarlar['alias'] );
          
          $this->adapter->assests->returnGet();
          
          $this->runRoute();
      }
      
      /**
       * Facadeleri kaydeder
       * @param array $alias
       */
      private function facedeRegister( array $alias )
      {
          
 
          
          Facade::$instance = $alias;          
          
       
      }
      
      /**
       * S�n�fa yeni fonksiyon eklemekte kullan�l�r
       * @param string $name
       * @param callable $function
       * @return \Myfc\Container
       */
      
      public function bind($name = '', callable $function)
      {
          
          $this->bind[$name] = Closure::bind($function, null, get_class());
          
          return $this;
          
      }
      
      /**
       * 
       * @param string $name
       * @param array $parametres
       * @return mixed
       */
      
      public function call($name, array $parametres)
      {
          
          if($this->isBinded($name))
          {
              
              return $this->callBind($name, $parametres);
              
          }
          
      }
      
      /**
       * Bind edilip edilmedi�ine bakar
       * @param string $name
       * @return boolean
       */
      private function isBinded($name = '')
      {
          
          return isset($this->bind[$name]);
          
      }
      
      /**
       * Bind �a��r�r
       * @param string $name
       * @param array $parametres
       * @return mixed
       */
      private function callBind($name,array $parametres)
      {
          
         if(is_callable($this->bind[$name]))
         {
             
             return call_user_func_array($this->bind[$name], $parametres);
             
         }
          
      }
      
      
      /**
       *
       * Modal, Controller yada herhangi bir s�n�f �a��rmak i�in kullan�l�r
       *  
       *   $className = "controller@asdsad" : asdsad  controlleri �a�r�l�r
       *   
       *   $className = "modal@asdads"  : asdads modal� �a�r�l�r ( sadece include edilir )
       * 
       * @param string $className
       * @param array $parametres
       */
      
      public function make($className = '', array $parametres = array())
      {
          
          if(strstr($className, "@"))
          {
              
              $class = explode("@", $className);
              
              if($class[0] == "controller")
              {
                  
                 return $this->makeController($class[1], $parametres);
                  
              }elseif($class[0] == "modal")
              {
                  
                  return $this->makeModal($classs[1], $parametres );
                  
              }
              
          }else{
              
              
              return $this->makeClass($className, $parametres);
              
          }
          
          
          
      }
      
      /**
       * Contoller �a��r�r, yeni bir instance olu�tururu
       * @param string $controller
       * @param array $parametres
       * @return unknown|boolean
       */
      
      public function makeController($controller,$parametres = array())
      {
          
          $controllerPath = APP_PATH."Controller/$controller.php";
          
          $this->maked[] = $controller;
          
          if(file_exists($controllerPath))
          {
              
              include $controllerPath;
              
              return (new ReflectionClass($controller))->newInstanceArgs($parametres);
              
          }else{
              
              return false;
          }
          
      }
      
      /**
       * Modal �a��r�r , instance olu�turmaz.
       * @param string $modalName
       * @param array $parametres
       * @return boolean
       */
      
      public function makeModal($modalName = '', array $parametres = array() )
      {
          
          $modalPath = APP_PATH.'Modals/'.$modalName.'.php';
          
          $this->maked[] = $modalName;
          
          if(file_exists($modalPath))
          {
              
              include $modalPath;
              
              return true;
              
          }else{
              
              return false;
              
          }
          
      }
      
      /**
       * girilen parametrelere g�re yeni bir s�n�f �a�r�l�r
       * @param string $className
       * @param array $parametres
       * @return object
       */
      public function makeClass($className = '', array $parametres = array() )
      {
          
          $this->maked[] = $className;
          
          return (new ReflectionClass($controller))->newInstanceArgs($parametres);
          
      }
      
      private function runRoute()
      {
          
          include APP_PATH.'Route.php';
          
          $router = new Router;
          
          $router->run($this, Route::getCollection());
          
      }
      
      /**
       * Singleton s�n�f�yla ileti�ime ge�erek yeni bir tekil s�n�f olu�turur
       * @param string $className
       * @param array $parametres
       * @return object
       */
      public function singleton($className, $parametres = array() )
      {
          
          $this->maked[] = $className;
          
          if(!is_array($parametres)) $parametres = array($parametres);
          
          return Singleton::make($className, $parametres);
      }
      
      /**
       * Dinamik olarak method �a��rma i�lemi
       * @param string $name
       * @param array $parametres
       * @return \Myfc\mixed
       */
      
      public function __call($name, array $parametres = [])
      {
          
          return $this->call($name, $parametres);
          
      }
   
      
  }

  

  
  
  
  
   

?>