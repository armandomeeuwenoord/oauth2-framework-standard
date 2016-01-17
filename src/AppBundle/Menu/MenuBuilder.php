<?php
namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MenuBuilder
{
    /**
     * @var \Knp\Menu\FactoryInterface
     */
    private $factory;

    /**
     * @var \Symfony\Component\HttpFoundation\RequestStack
     */
    private $request_stack;

    /**
     * AccountMenuBuilder constructor.
     *
     * @param \Knp\Menu\FactoryInterface                     $factory
     * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
     */
    public function __construct(FactoryInterface $factory, RequestStack $request_stack)
    {
        $this->factory = $factory;
        $this->request_stack = $request_stack;
    }

    /**
     * @return \Knp\Menu\ItemInterface
     */
    public function createMainMenu()
    {
        $menu = $this->factory->createItem(
            'My OAuth2 Server',
            [
                'route' => 'homepage',
                'extras' => ['menu_type' => 'topbar']
            ]
        );

        return $menu;
    }

    /**
     * @param \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface $security_token_storage
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface        $authorization_checker
     * @param \Symfony\Component\Translation\TranslatorInterface                                  $translator
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function createUserMenu(TokenStorageInterface $security_token_storage,
                                   AuthorizationCheckerInterface $authorization_checker,
                                   TranslatorInterface $translator
    ) {
        $menu = $this->factory->createItem('root', [
            'childrenAttributes' => [
                'class' => 'side-nav',
        ]]);

        $request = $this->request_stack->getCurrentRequest();
        if ($request instanceof Request) {
            $menu->setCurrent($request->getRequestUri());
        }

        $token = $security_token_storage->getToken();

        if (null !== $token) {
            if (null === $token->getUser() || $token instanceof AnonymousToken) {
                $menu->addChild(
                    $translator->trans('layout.login', [], 'FOSUserBundle'),
                    ['route' => 'fos_user_security_login']
                );
                $menu->addChild(
                    $translator->trans('layout.register', [], 'FOSUserBundle'),
                    ['route' => 'fos_user_registration_register']
                );
            } else {
                $menu->addChild(
                    $token->getUser()->getUsername(),
                    ['route' => 'fos_user_profile_show']
                );
                $menu->addChild(
                    $translator->trans('layout.logout', [], 'FOSUserBundle'),
                    ['route' => 'fos_user_security_logout']
                )->setExtras([
                    "icon"          => "fa fa-times",
                    'icon_position' => 'before',
                ]);
                $menu->addChild(
                    $translator->trans('layout.client.password.create', [], 'FOSUserBundle'),
                    ['route' => 'manager_password_client_add']
                )->setExtras([
                    "icon"          => "fa fa-times",
                    'icon_position' => 'before',
                ]);
            }
        }

        return $menu;
    }
}
