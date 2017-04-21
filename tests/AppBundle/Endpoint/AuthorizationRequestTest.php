<?php

namespace Tests\AppBundle\Endpoint;

use Tests\AppBundle\Base;

/**
 * @group AuthorizationRequest
 * @group legacy
 */
class AuthorizationRequestTest extends Base
{
    public function testClientIdParameterIsMissing()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $client->request('GET', '/oauth/v2/authorize');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"Parameter \"client_id\" missing or invalid."}', $client->getResponse()->getContent());
    }

    public function testUnknownClientId()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id' => 'BAD_CLIENT_ID',
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"Parameter \"client_id\" missing or invalid."}', $client->getResponse()->getContent());
    }

    /*public function testResponseTypeParameterIsMissing()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id' => $oauth2_client->getPublicId(),
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"The parameter \"response_type\" is mandatory."}', $client->getResponse()->getContent());
    }*/

    /*public function testStateParameterIsMissing()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'foo',
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"The parameter \"state\" is mandatory."}', $client->getResponse()->getContent());
    }*/

    /*public function testRedirectUriParameterIsMissing()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'foo',
            'state'         => '0123456789',
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"The parameter \"redirect_uri\" is mandatory."}', $client->getResponse()->getContent());
    }*/

    /*public function testResponseTypeIsNotValid()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'foo',
            'state'         => '0123456789',
            'redirect_uri'  => 'https://www.example.com/bad_callback',
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('https://www.example.com/bad_callback?error=invalid_request&error_description=Response+type+%22foo%22+is+not+supported+by+this+server&state=0123456789#', $client->getResponse()->headers->get('Location'));
    }*/

    /*public function testRedirectUriIsNotValid()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'code',
            'state'         => '0123456789',
            'redirect_uri'  => 'https://www.example.com/bad_callback',
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('https://www.example.com/bad_callback?error=invalid_request&error_description=The+specified+redirect+URI+is+not+valid.&state=0123456789#', $client->getResponse()->headers->get('Location'));
    }*/

    /*public function testRedirectUriIsNotSecured()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'code',
            'state'         => '0123456789',
            'redirect_uri'  => 'http://example.com/test?good=false',
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('http://example.com/test?good=false&error=invalid_request&error_description=The+parameter+%22redirect_uri%22+must+be+a+secured+URI.&state=0123456789#', $client->getResponse()->headers->get('Location'));
    }*/

    /*public function testClientIsRedirectedToLoginPage()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-jwt');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $query_parameters = [
            'client_id'     => $oauth2_client->getPublicId(),
            'response_type' => 'code',
            'state'         => '0123456789',
            'redirect_uri'  => 'https://example.com/test?good=false',
        ];
        $client->request('GET', '/oauth/v2/authorize', $query_parameters);

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
        $this->assertContains('/login', $client->getResponse()->headers->get('Location'));
    }*/

    /*public function testAuthorizationFormShownToTheLoggedInUser()
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

        $form = $crawler->filter('form');
        $this->assertEquals(1, $form->count());
    }*/

    /*public function testAuthorizationDeniedByTheResourceOwner()
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

        $form = $crawler->filter('#oauth2_server_authorization_form_reject')->form();
        $client->submit($form);

        $location = $client->getResponse()->headers->get('Location');
        $this->assertContains('error=access_denied&error_description=The+resource+owner+denied+access+to+your+client', $location);
        $this->assertContains('state=0123456789', $location);
    }*/
}
