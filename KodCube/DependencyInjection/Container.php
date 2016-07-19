<?php
namespace KodCube\DependencyInjection;

use Interop\Container\ContainerInterface AS InteropInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class Container implements InteropInterface,ContainerInterface
{
    /**
    * Cached Aliases 
    * @var array
    **/
    protected $cache = [];
    
    protected $config = [];
    
    public function __construct(array $config=null,LoggerInterface $logger=null)
    {
        $this->logger = $logger ? $logger : new NullLogger();
        
        if ($config !== null) $this->config = $config;

        // Inject container into cache for use
        $this->cache[InteropInterface::class] = $this;
        $this->cache[ContainerInterface::class] = $this;
        $this->cache[__CLASS__] = $this;

    }

    /**
     * Dynamic Alias call for __invoke
     *
     * $di->router() = $di->get('router) = $di('router') ;
     *
     * @param $id
     * @param $args
     * @return mixed
     * @throws NotFoundException
     */
    public function __call(string $id,array $args)
    {
        return $this($id,...$args);
    }

    /**
     * Alias for get method
     * @param string $id
     * @param array ...$args
     * @return mixed
     * @throws NotFoundException
     */
    public function __invoke(string $id,...$args)
    {
        // Check if we have already instantiated
        if ( empty($args) && isset($this->cache[$id]) ) {

            if ( $this->cache[$id] instanceof Closure && is_callable($this->cache[$id]) ) {

                return $this->cache[$id]($this);
            }


            return $this->cache[$id];
        }

        // Check if there is a config for this factory item
        $cfg = $this->getConfig($id);

        if (is_callable($cfg)) {
            return $this->cache[$id] = $cfg($this);
        }

        // Check if config is a builder config
        if ( ! is_null($cfg) && isset($cfg['class']) ) {
            $className = $cfg['class'];
            unset($cfg['class']);
            if (self::isAssoc($cfg)) {
                return $this->cache[$id] = $this->make($className,$cfg);
            }
            return $this->cache[$id] = $this->make($className,...$cfg);
        }
        // Aliased to Another Class
        if ( is_string($cfg) ) {

            if ($value = $this->getConfig($cfg) ) {
                if (is_array($value) ) {
                    $className = $value['class'];
                    unset($value['class']);
                    if (self::isAssoc($value)) {
                        return $this($className,$value);
                    }
                    return $this($className,...$value);
                }
                return $this($value,...$args);
            } else {
                return $this($cfg,...$args);
            }
        }

        // $id is a class name check if it exists
        if ( ! class_exists($id,true) ) throw new NotFoundException('Class '.$id.' Not Found');

        // Additional Arguments have been passed so don't cache result
        if ( ! empty($args) ) {

            return $this->make($id,...$args);
        }

        // Check for class arguments in $cfg
        if ( ! empty($cfg)  && is_array($cfg)) {
            if (self::isAssoc($cfg)) {

                return $this->cache[$id] = $this->make($id,$cfg);
            }
            return $this->cache[$id] = $this->make($id,...$cfg);
        }
        return $this->cache[$id] = $this->make($id);
    }


    /**
     * @imheritdoc
     * @throws TypeError
     */
    public function get($id)
    {
        return $this($id);
    }


    /**
     * Build Object and Inject Dependencies
     * 
     * @param string $className Class Name
     * @param array $args Arguments to constructor
     */

    public function make($className,...$args)
    {
        if ( ! method_exists($className,'__construct') ) return new $className();

        $reflector = new \ReflectionMethod($className,'__construct');
        $methodParams = $reflector->getParameters();
        foreach($methodParams as $i=>$param)
        {
            if ( $param->getClass() ) {

                $paramClass = $param->getClass()->name;
                $parameter = null;

                if ( isset($this->cache[$paramClass]) ) {
                    $args[$i] = $this->cache[$paramClass];
                    continue;
                }

                if ($value = $this->getConfig($className,$paramClass) ) {

                    $parameter = $value;

                } elseif ( $value = $this->getConfig($paramClass) ) {

                    $parameter = $value;

                } elseif (class_exists($paramClass,true)) {
                     $parameter = $paramClass;
                }

                

                if ( is_null($parameter) ) {


                    continue;
                }
                // Check for Alias
                if ( is_string($parameter) && ($this->hasConfig($parameter) || class_exists($parameter,true) ) ) { 

                    $args[$i] = $this($parameter);
                    continue;
                } 

                // Check for Builder Config
                if ( is_array($parameter) && isset($parameter['class']) ) {
                    $class = $parameter['class'];
                    unset($parameter['class']);
                    $args[$i] = $this->make($class,$parameter);
                    continue;
                } elseif (is_array($parameter) && ! self::isAssoc($parameter)) {
                    $args[$i] = $this->make($paramClass,...$parameter);
                } elseif (is_array($parameter)) {
                    $args[$i] = $this->make($paramClass,$parameter);
                }
                
                
                if ( is_callable($parameter) ) {
                    $args[$i] = $parameter($this);
                }

            } elseif ( ! isset($args[$i]) ) {
                if ($value = $this->getConfig($className,$param->getName())) {
                     $args[$i] = $value;
                } elseif ($param->isDefaultValueAvailable() ) {
                    $args[$i] = $param->getDefaultValue();
                }
            }
        }

        //print_r($args);
        return new $className(...$args);
    }


    /**
     * @inheritdoc
     */
    
    public function has($id)
    {
    
        // Check it we have already created it
        if ( isset($this->cache[$id]) ) return true;
        
        // Check for a alias in the config
        if ( isset($this->config[$id]) ) return true;
        
        // Check for a alias in the config
        if ( class_exists($id) ) return true;

        return false;

    }
    

   /**
    * Check if a configuration key exists
    *  
    * @return bool
    */
   
    public function hasConfig(...$args):bool 
    {
        $cfg = $this->config;

        foreach ($args AS $name) {

            if ( ! isset( $cfg[$name] ) ) return false;

            $cfg = &$cfg[$name];
        }

        return true;
    }
    
   /**
    * Get Config Key
    *  
    * @return mixed|null
    */
    
    public function getConfig(...$args) 
    {
        $cfg = $this->config;

        foreach ($args AS $name) {

            if ( ! isset( $cfg[$name] ) ) return null;

            $cfg = $cfg[$name];
        }

        return $cfg;
    }
    /**
     * Checks if the passed array is an associative array
     * @param array $arr
     * @return bool
     */
    static protected function isAssoc(array $arr):bool
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }
}
