<?php

namespace Tests\AppBundle\Endpoint;

use Tests\AppBundle\Base;
use Tests\AppBundle\DataFixtures\ORM as Fixture;

/**
 * Please note that other tests are performed by grant types that need the token endpoint
 * (e.g. Refresh Token, Authorization Code...
 *
 * @group TokenEndpoint
 * @group legacy
 */
class TokenEndpointRequestTest extends Base
{
    public function testBadMethod()
    {
        $client = static::makeClient();
        $client->request('GET', '/oauth/v2/token');

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    public function testUnsecuredConnectionIsRedirected()
    {
        $client = static::makeClient();
        $client->request('POST', '/oauth/v2/token');


        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertContains('https://localhost/oauth/v2/token', $client->getResponse()->headers->get('Location'));
    }

    public function testMissingGrantType()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $client->request('POST', '/oauth/v2/token');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"The \"grant_type\" parameter is missing."}', $client->getResponse()->getContent());
    }

    public function testUnsupportedGrantType()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'grant_type' => 'hello',
        ];
        $client->request('POST', '/oauth/v2/token', $post_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"The grant type \"hello\" is not supported by this server."}', $client->getResponse()->getContent());
    }
}
