<?php

use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new SiteBundle\SiteBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Ivory\CKEditorBundle\IvoryCKEditorBundle(),
            new Viweb\BaseBundle\ViwebBaseBundle(),
            new Viweb\UserBundle\ViwebUserBundle(),
            new Viweb\ArticleBundle\ViwebArticleBundle(),
            new Viweb\SeoBundle\ViwebSeoBundle(),
            new Viweb\CarouselBundle\ViwebCarouselBundle(),
            new Viweb\SoumissionBundle\ViwebSoumissionBundle(),
            new Viweb\RealisationBundle\ViwebRealisationBundle(),
            new Viweb\MailchimpBundle\ViwebMailchimpBundle(),
            new Welp\MailchimpBundle\WelpMailchimpBundle(),
            new Viweb\EcoleBundle\ViwebEcoleBundle(),
            new Viweb\BlogueuseBundle\ViwebBlogueuseBundle(),
            new Viweb\TemoignageBundle\ViwebTemoignageBundle(),
            new Viweb\MediaBundle\ViwebMediaBundle(),
            new Viweb\InscriptionBundle\ViwebInscriptionBundle(),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();

            if ('dev' === $this->getEnvironment()) {
                $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
                $bundles[] = new Symfony\Bundle\WebServerBundle\WebServerBundle();
                $bundles[] = new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle();
            }
        }

        return $bundles;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__) . '/var/cache/' . $this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__) . '/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir() . '/config/config_' . $this->getEnvironment() . '.yml');
    }

    public function getRootDir()
    {
        return __DIR__;
    }
}
