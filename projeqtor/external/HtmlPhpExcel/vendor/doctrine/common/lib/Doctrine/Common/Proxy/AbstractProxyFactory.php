<?php
namespace Doctrine\Common\Proxy;

use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\Mapping\ClassMetadataFactory;
use Doctrine\Common\Proxy\Exception\InvalidArgumentException;
use Doctrine\Common\Proxy\Exception\OutOfBoundsException;
use Doctrine\Common\Util\ClassUtils;

/**
 * Abstract factory for proxy objects.
 *
 * @author Benjamin Eberlei <kontakt@beberlei.de>
 */
abstract class AbstractProxyFactory
{
    /**
     * Never autogenerate a proxy and rely that it was generated by some
     * process before deployment.
     *
     * @var integer
     */
    const AUTOGENERATE_NEVER = 0;

    /**
     * Always generates a new proxy in every request.
     *
     * This is only sane during development.
     *
     * @var integer
     */
    const AUTOGENERATE_ALWAYS = 1;

    /**
     * Autogenerate the proxy class when the proxy file does not exist.
     *
     * This strategy causes a file exists call whenever any proxy is used the
     * first time in a request.
     *
     * @var integer
     */
    const AUTOGENERATE_FILE_NOT_EXISTS = 2;

    /**
     * Generate the proxy classes using eval().
     *
     * This strategy is only sane for development, and even then it gives me
     * the creeps a little.
     *
     * @var integer
     */
    const AUTOGENERATE_EVAL = 3;

    private const AUTOGENERATE_MODES = [
        self::AUTOGENERATE_NEVER,
        self::AUTOGENERATE_ALWAYS,
        self::AUTOGENERATE_FILE_NOT_EXISTS,
        self::AUTOGENERATE_EVAL,
    ];

    /**
     * @var \Doctrine\Persistence\Mapping\ClassMetadataFactory
     */
    private $metadataFactory;

    /**
     * @var \Doctrine\Common\Proxy\ProxyGenerator the proxy generator responsible for creating the proxy classes/files.
     */
    private $proxyGenerator;

    /**
     * @var int Whether to automatically (re)generate proxy classes.
     */
    private $autoGenerate;

    /**
     * @var \Doctrine\Common\Proxy\ProxyDefinition[]
     */
    private $definitions = [];

    /**
     * @param \Doctrine\Common\Proxy\ProxyGenerator              $proxyGenerator
     * @param \Doctrine\Persistence\Mapping\ClassMetadataFactory $metadataFactory
     * @param bool|int                                           $autoGenerate
     *
     * @throws \Doctrine\Common\Proxy\Exception\InvalidArgumentException When auto generate mode is not valid.
     */
    public function __construct(ProxyGenerator $proxyGenerator, ClassMetadataFactory $metadataFactory, $autoGenerate)
    {
        $this->proxyGenerator  = $proxyGenerator;
        $this->metadataFactory = $metadataFactory;
        $this->autoGenerate    = (int) $autoGenerate;

        if ( ! in_array($this->autoGenerate, self::AUTOGENERATE_MODES, true)) {
            throw InvalidArgumentException::invalidAutoGenerateMode($autoGenerate);
        }
    }

    /**
     * Gets a reference proxy instance for the entity of the given type and identified by
     * the given identifier.
     *
     * @param  string $className
     * @param  array  $identifier
     *
     * @return \Doctrine\Common\Proxy\Proxy
     *
     * @throws \Doctrine\Common\Proxy\Exception\OutOfBoundsException
     */
    public function getProxy($className, array $identifier)
    {
        $definition = isset($this->definitions[$className])
            ? $this->definitions[$className]
            : $this->getProxyDefinition($className);
        $fqcn       = $definition->proxyClassName;
        $proxy      = new $fqcn($definition->initializer, $definition->cloner);

        foreach ($definition->identifierFields as $idField) {
            if ( ! isset($identifier[$idField])) {
                throw OutOfBoundsException::missingPrimaryKeyValue($className, $idField);
            }

            $definition->reflectionFields[$idField]->setValue($proxy, $identifier[$idField]);
        }

        return $proxy;
    }

    /**
     * Generates proxy classes for all given classes.
     *
     * @param \Doctrine\Persistence\Mapping\ClassMetadata[] $classes The classes (ClassMetadata instances)
     *                                                               for which to generate proxies.
     * @param string $proxyDir The target directory of the proxy classes. If not specified, the
     *                         directory configured on the Configuration of the EntityManager used
     *                         by this factory is used.
     * @return int Number of generated proxies.
     */
    public function generateProxyClasses(array $classes, $proxyDir = null)
    {
        $generated = 0;

        foreach ($classes as $class) {
            if ($this->skipClass($class)) {
                continue;
            }

            $proxyFileName = $this->proxyGenerator->getProxyFileName($class->getName(), $proxyDir);

            $this->proxyGenerator->generateProxyClass($class, $proxyFileName);

            $generated += 1;
        }

        return $generated;
    }

    /**
     * Reset initialization/cloning logic for an un-initialized proxy
     *
     * @param \Doctrine\Common\Proxy\Proxy $proxy
     *
     * @return \Doctrine\Common\Proxy\Proxy
     *
     * @throws \Doctrine\Common\Proxy\Exception\InvalidArgumentException
     */
    public function resetUninitializedProxy(Proxy $proxy)
    {
        if ($proxy->__isInitialized()) {
            throw InvalidArgumentException::unitializedProxyExpected($proxy);
        }

        $className  = ClassUtils::getClass($proxy);
        $definition = isset($this->definitions[$className])
            ? $this->definitions[$className]
            : $this->getProxyDefinition($className);

        $proxy->__setInitializer($definition->initializer);
        $proxy->__setCloner($definition->cloner);

        return $proxy;
    }

    /**
     * Get a proxy definition for the given class name.
     *
     * @param string $className
     *
     * @return ProxyDefinition
     */
    private function getProxyDefinition($className)
    {
        $classMetadata = $this->metadataFactory->getMetadataFor($className);
        $className     = $classMetadata->getName(); // aliases and case sensitivity

        $this->definitions[$className] = $this->createProxyDefinition($className);
        $proxyClassName                = $this->definitions[$className]->proxyClassName;

        if ( ! class_exists($proxyClassName, false)) {
            $fileName = $this->proxyGenerator->getProxyFileName($className);

            switch ($this->autoGenerate) {
                case self::AUTOGENERATE_NEVER:
                    require $fileName;
                    break;

                case self::AUTOGENERATE_FILE_NOT_EXISTS:
                    if ( ! file_exists($fileName)) {
                        $this->proxyGenerator->generateProxyClass($classMetadata, $fileName);
                    }
                    require $fileName;
                    break;

                case self::AUTOGENERATE_ALWAYS:
                    $this->proxyGenerator->generateProxyClass($classMetadata, $fileName);
                    require $fileName;
                    break;

                case self::AUTOGENERATE_EVAL:
                    $this->proxyGenerator->generateProxyClass($classMetadata, false);
                    break;
            }
        }

        return $this->definitions[$className];
    }

    /**
     * Determine if this class should be skipped during proxy generation.
     *
     * @param \Doctrine\Persistence\Mapping\ClassMetadata $metadata
     *
     * @return bool
     */
    abstract protected function skipClass(ClassMetadata $metadata);

    /**
     * @param string $className
     *
     * @return ProxyDefinition
     */
    abstract protected function createProxyDefinition($className);
}

interface_exists(ClassMetadata::class);
interface_exists(ClassMetadataFactory::class);
