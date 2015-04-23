<?php namespace Libs\Illuminate;

class Application {


    /**  
     * The JLink framework version.
     *
     * @var string
     */
    const VERSION = '5.0.27';     

    /**
     * Get the version number of the application.
     *
     * @return string
     */
    public function version()
    {
        return static::VERSION;
    }

    /**
     * The environment to load during bootstrapping.
     *
     * @var string
     */
    protected $environment = 'env';


    /**
     * Framework init function .
     *
     * @return object
     *
     */
    public static function init(){

        self::bootstrap();
 
        return new Router(); 
    }

    /**
     * Call bootstrap's all methods
     *
     * @return void
     */
    public static function bootstrap(){
        $methods = get_class_methods('Libs\Illuminate\Bootstrap');
        foreach($methods as $method) {
            call_user_func(array('Libs\Illuminate\Bootstrap', $method));
        }
    }
}
