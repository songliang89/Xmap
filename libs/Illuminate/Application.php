<?php namespace Libs\Illuminate;

class Application extends Container {


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
}
