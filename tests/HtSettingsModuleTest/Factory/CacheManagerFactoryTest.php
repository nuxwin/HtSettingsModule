<?php
namespace HtSettingsModule\Factory;

use Zend\ServiceManager\ServiceManager;
use HtSettingsModule\Options\ModuleOptions;

class CacheManagerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new CacheManagerFactory;
        $serviceManager->setService('HtSettingsModule\Options\ModuleOptions', new ModuleOptions);
        $this->assertInstanceOf('HtSettingsModule\Service\CacheManager', $factory->createService($serviceManager));
    }
}
