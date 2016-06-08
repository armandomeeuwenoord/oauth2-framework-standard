<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

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
            new AppBundle\AppBundle(),

            new Bmatzner\FoundationBundle\BmatznerFoundationBundle(),
            new Bmatzner\JQueryBundle\BmatznerJQueryBundle(),
            new Bmatzner\FontAwesomeBundle\BmatznerFontAwesomeBundle(),

            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Flob\Bundle\FoundationBundle\FlobFoundationBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new SpomkyLabs\JoseBundle\SpomkyLabsJoseBundle(),
            new \SpomkyLabs\OAuth2ServerBundle\SpomkyLabsOAuth2ServerBundle([
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\JWTBearerPlugin\JWTBearerPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\JWTAccessTokenPlugin\JWTAccessTokenPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\BearerTokenPlugin\BearerTokenPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\MacTokenPlugin\MacTokenPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\AuthCodeGrantTypePlugin\AuthCodeGrantTypePlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\RefreshTokenGrantTypePlugin\RefreshTokenGrantTypePlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\ImplicitGrantTypePlugin\ImplicitGrantTypePlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\ResourceOwnerPasswordCredentialsGrantTypePlugin\ResourceOwnerPasswordCredentialsGrantTypePlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\ClientCredentialsGrantTypePlugin\ClientCredentialsGrantTypePlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\AuthorizationEndpointPlugin\AuthorizationEndpointPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\TokenEndpointPlugin\TokenEndpointPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\TokenRevocationEndpointPlugin\TokenRevocationEndpointPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\TokenIntrospectionEndpointPlugin\TokenIntrospectionEndpointPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\OpenIdConnectPlugin\OpenIdConnectPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\SecurityPlugin\SecurityPlugin(),
                new \SpomkyLabs\OAuth2ServerBundle\Plugin\CleanerPlugin\CleanerPlugin(),
            ]),
        ];

        if (in_array($this->getEnvironment(), ['dev', 'test'], true)) {
            $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function getRootDir()
    {
        return __DIR__;
    }

    public function getCacheDir()
    {
        return dirname(__DIR__).'/var/cache/'.$this->getEnvironment();
    }

    public function getLogDir()
    {
        return dirname(__DIR__).'/var/logs';
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
