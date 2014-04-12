<?php
namespace HtSettingsModule\Options;

use Zend\Stdlib\AbstractOptions;
use HtSettingsModule\Exception;

class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface, DbOptionsInterface
{
    /**
     * @var CacheOptionsInterface
     */
    protected $cacheOptions;

    /**
     * @var array
     */
    protected $namespaces = [];

    /**
     * @var string|\Zend\Db\Sql\TableIdentifier
     */
    protected $settingsTable = 'settings';

    /**
     * @var string
     */
    protected $parameterEntityClass = 'HtSettingsModule\Entity\Parameter';

    /**
     * Sets options of cache
     *
     * @param  array|CacheOptionsInterface $cacheOptions
     * @return self
     */
    public function setCacheOptions($cacheOptions)
    {
        if ($cacheOptions instanceof CacheOptionsInterface) {
            $this->cacheOptions = $cacheOptions;
        } elseif (is_array($cacheOptions)) {
            $this->cacheOptions = new CacheOptions($cacheOptions);
        } else {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be array or an instance of HtSettingsModule\Options\CacheOptionsInterface, %s provided instead',
                    __METHOD__,
                    is_object($cacheOptions) ? get_class($cacheOptions) : gettype($cacheOptions)
                )
            );
        }

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getCacheOptions()
    {
        if (!$this->cacheOptions instanceof CacheOptionsInterface) {
            $this->cacheOptions = new CacheOptions;
        }

        return $this->cacheOptions;
    }

    /**
     * Sets namespaces
     *
     * @param  array $namespaces
     * @return void
     */
    public function setNamespaces(array $namespaces)
    {
        $this->namespaces = [];
        foreach ($namespaces as $namespace => $namespaceOptions) {
            $namespaceOptions = new NamespaceOptions($namespaceOptions);
            $namespaceOptions->setName($namespace);
            $this->namespaces[$namespace] = $namespaceOptions;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespaces()
    {
        return $this->namespaces;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespaceOptions($namespace)
    {
        if (!isset($this->namespaces[$namespace])) {
            throw new Exception\InvalidArgumentException(
                sprintf('Options Namespace, "%s" does not exist!', $namespace)
            );
        }

        return $this->namespaces[$namespace];
    }

    /**
     * Sets table name of settings
     *
     * @param  string|\Zend\Db\Sql\TableIdentifier $settingsTable
     * @return self
     */
    public function setSettingsTable($settingsTable)
    {
        $this->settingsTable = $settingsTable;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getSettingsTable()
    {
        return $this->settingsTable;
    }

    /**
     * {@inheritDoc}
     */
    public function getParameterEntityClass()
    {
        return $this->parameterEntityClass;
    }

    /**
     * Sets parameter entity class
     *
     * @param  string $parameterEntityClass
     * @return self
     */
    public function setParameterEntityClass($parameterEntityClass)
    {
        $this->parameterEntityClass = $parameterEntityClass;

        return $this;
    }
}
