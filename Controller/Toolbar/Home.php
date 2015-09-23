<?php
/**
 *
 *
 *
 *
 */

namespace Cotya\Debug\Controller\Toolbar;

use Cotya\Debug\Lib\Bridge\UrlGenerator;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Symfony\Bundle\WebProfilerBundle\Controller\ProfilerController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Profiler\FileProfilerStorage;
use Symfony\Component\HttpKernel\Profiler\Profiler;

class Home extends \Magento\Framework\App\Action\Action
{
    
    /** @var ScopeConfigInterface  */
    protected $scopeConfig;
    
    /** @var ProfilerController */
    protected $symfonyController;

    public function __construct(
        Context $context,
        \Twig_Environment $twig,
        \Psr\Log\LoggerInterface $logger,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);

        $urlGenerator = new UrlGenerator($context->getUrl(), 'cotya_debug/toolbar');

        $profiler = new Profiler(
            new FileProfilerStorage('file:'. BP . '/var/cotya_profile/'),
            $logger
        );
        
        $templatesCollection = array(
            array('config',    '@WebProfiler/Collector/config.html.twig'),
            array('request',   '@WebProfiler/Collector/request.html.twig'),
            array('exception', '@WebProfiler/Collector/exception.html.twig'),
            array('events',    '@WebProfiler/Collector/events.html.twig'),
            array('logger',    '@WebProfiler/Collector/logger.html.twig'),
            array('time',      '@WebProfiler/Collector/time.html.twig'),
            array('router',    '@WebProfiler/Collector/router.html.twig'),
            array('memory',    '@WebProfiler/Collector/memory.html.twig'),
            array('form',      '@WebProfiler/Collector/form.html.twig'),
        );
        if (class_exists('Symfony\Bridge\Twig\Extension\ProfilerExtension')) {
            $templates[] = array('twig', '@WebProfiler/Collector/twig.html.twig');
        }
        /*
        if (isset($app['var_dumper.cli_dumper']) && $app['profiler.templates_path.debug']) {
            $templates[] = array('dump', '@Debug/Profiler/dump.html.twig');
        }
        */


        $twig->addFunction(new \Twig_SimpleFunction('path', function ($url) use ($urlGenerator) {
            return $urlGenerator->generate($url);
        }));
        
        $this->symfonyController = new ProfilerController(
            $urlGenerator,
            $profiler,
            $twig,
            $templatesCollection,
            'bottom'
        );
        
    }
    
    public function execute()
    {
        $request = new Request();
        $result = $this->symfonyController->searchBarAction($request);
        
        echo $result->getContent();
        exit();

    }
}
