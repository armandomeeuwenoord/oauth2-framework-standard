<?php

namespace Tests\AppBundle\GrantType;

use Tests\AppBundle\Base;

/**
 * @group AuthorizationCodeGrantType
 * @group legacy
 */
class AuthorizationCodeGrantTypeTest extends Base
{
    /*public function testAuthorizationCodeIssued()
    {
        $user = $this->getFixtures()->getReference('user-john');
        $this->loginAs($user, 'main');

        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'code',
            'state'         => '0123456789',
            'redirect_uri'  => 'https://example.com/test?good=false',
        ];

        $crawler = $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('#oauth2_server_authorization_form_accept')->form();
        $client->submit($form);

        $location = $client->getResponse()->headers->get('Location');

        $url = parse_url($location);
        $this->assertArrayHasKey('query', $url);
        parse_str($url['query'], $query);
        $this->assertTrue(is_array($query));
        $this->assertArrayHasKey('code', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertEquals('0123456789', $query['state']);

        $code = $this->getContainer()->get('app.auth_code_manager')->getAuthCode($query['code']);
        $this->assertInstanceOf(AuthCodeInterface::class, $code);
    }*/

    /*public function testAuthorizationCodeNotIssuedForPublicClient()
    {
        $user = $this->getFixtures()->getReference('user-john');
        $this->loginAs($user, 'main');

        $oauth2_client = $this->getFixtures()->getReference('client-client_secret_basic');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'code',
            'state'         => '0123456789',
            'redirect_uri'  => 'https://example.com/redirection/callback',
        ];
        $crawler = $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $form = $crawler->filter('#oauth2_server_authorization_form_accept')->form();
        $client->submit($form);

        $location = $client->getResponse()->headers->get('Location');

        $url = parse_url($location);
        $this->assertArrayHasKey('query', $url);
        parse_str($url['query'], $query);
        $this->assertTrue(is_array($query));
        $this->assertArrayHasKey('code', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertEquals('0123456789', $query['state']);

        $code = $this->getContainer()->get('app.auth_code_manager')->getAuthCode($query['code']);
        $this->assertInstanceOf(AuthCodeInterface::class, $code);
    }*/
}
