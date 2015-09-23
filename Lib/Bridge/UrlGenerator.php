<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Lib\Bridge;

use Magento\Framework\UrlInterface;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\MissingMandatoryParametersException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class UrlGenerator implements UrlGeneratorInterface
{

    /** @var  UrlInterface */
    protected $magentoUrl;

    /** @var  string */
    protected $pathNamePrefix;
    
    /**
     * @param UrlInterface $url
     * @param string $prefix
     */
    public function __construct(UrlInterface $url, $prefix)
    {
        $this->magentoUrl = $url;
        $this->pathNamePrefix = $prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function setContext(RequestContext $context)
    {
        // TODO: Implement setContext() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getContext()
    {
        // TODO: Implement getContext() method.
    }

    /**
     * {@inheritdoc}
     */
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $this->magentoUrl->getUrl($this->pathNamePrefix.'/'.$name, $parameters);
    }
}
