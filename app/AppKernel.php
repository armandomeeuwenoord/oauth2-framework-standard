<?php

use SpomkyLabs\OAuth2ServerBundle\Plugin\AuthCodeGrantTypePlugin\AuthCodeGrantTypePlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\AuthorizationEndpointPlugin\AuthorizationEndpointPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\BearerAccessTokenPlugin\BearerAccessTokenPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\ClientCredentialsGrantTypePlugin\ClientCredentialsGrantTypePlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\ImplicitGrantTypePlugin\ImplicitGrantTypePlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\JWTAccessTokenPlugin\JWTAccessTokenPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\JWTBearerPlugin\JWTBearerPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\JWTClientPlugin\JWTClientPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\MacAccessTokenPlugin\MacAccessTokenPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\PasswordClientPlugin\PasswordClientPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\PublicClientPlugin\PublicClientPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\RefreshTokenGrantTypePlugin\RefreshTokenGrantTypePlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\ResourceOwnerPasswordCredentialsGrantTypePlugin\ResourceOwnerPasswordCredentialsGrantTypePlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\TokenEndpointPlugin\TokenEndpointPlugin;
use\SpomkyLabs\OAuth2ServerBundle\Plugin\TokenIntrospectionEndpointPlugin\TokenIntrospectionEndpointPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\TokenRevocationEndpointPlugin\TokenRevocationEndpointPlugin;
use SpomkyLabs\OAuth2ServerBundle\Plugin\UnregisteredClientPlugin\UnregisteredClientPlugin;
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
            new AppBundle\AppBundle(),

            new Bmatzner\FoundationBundle\BmatznerFoundationBundle(),
            new Bmatzner\JQueryBundle\BmatznerJQueryBundle(),
            new Bmatzner\FontAwesomeBundle\BmatznerFontAwesomeBundle(),

            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Flob\Bundle\FoundationBundle\FlobFoundationBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Puli\SymfonyBundle\PuliBundle(),
            new SpomkyLabs\JoseBundle\SpomkyLabsJoseBundle(),
            new SpomkyLabs\OAuth2ServerBundle\SpomkyLabsOAuth2ServerBundle([
                new BearerAccessTokenPlugin(),
                new MacAccessTokenPlugin(),
                new UnregisteredClientPlugin(),
                new PublicClientPlugin(),
                new PasswordClientPlugin(),
                new JWTAccessTokenPlugin(),
                new JWTClientPlugin(),
                new JWTBearerPlugin(),
                new AuthCodeGrantTypePlugin(),
                new RefreshTokenGrantTypePlugin(),
                new ImplicitGrantTypePlugin(),
                new ResourceOwnerPasswordCredentialsGrantTypePlugin(),
                new ClientCredentialsGrantTypePlugin(),
                new AuthorizationEndpointPlugin(),
                new TokenEndpointPlugin(),
                new TokenRevocationEndpointPlugin(),
                new TokenIntrospectionEndpointPlugin(),
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

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
