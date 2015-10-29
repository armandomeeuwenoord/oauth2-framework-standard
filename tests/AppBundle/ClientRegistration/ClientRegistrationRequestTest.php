<?php

namespace Tests\AppBundle\ClientRegistration;

use Tests\AppBundle\Base;

/**
 * @group ClientRegistration
 * @group legacy
 */
class ClientRegistrationRequestTest extends Base
{
    public function testBadMethod()
    {
        $client = static::makeClient();
        $client->request('GET', '/client/management');

        $this->assertEquals(405, $client->getResponse()->getStatusCode());
    }

    public function testUnsecuredConnectionIsRedirected()
    {
        $client = static::makeClient();
        $client->request('POST', '/client/management');


        $this->assertEquals(301, $client->getResponse()->getStatusCode());
        $this->assertContains('https://localhost/client/management', $client->getResponse()->headers->get('Location'));
    }

    public function testMissingTokenEndpointAuthMethod()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $client->request('POST', '/client/management');

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"The parameter \"token_endpoint_auth_method\" is missing."}', $client->getResponse()->getContent());
    }

    public function testUnsupportedTokenEndpointAuthParameter()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'token_endpoint_auth_method' => 'code',
        ];
        $client->request('POST', '/client/management', $post_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertContains('{"error":"invalid_request","error_description":"The token endpoint authentication method \"code\" is not supported. Please use one of the following values: [\"none\",\"client_secret_basic\",\"client_secret_post\",\"client_secret_jwt\",\"private_key_jwt\"]"}', $client->getResponse()->getContent());
    }

    public function testClientCreated()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'token_endpoint_auth_method' => 'client_secret_jwt',
        ];
        $client->request('POST', '/client/management', $post_parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(is_array($content));
        $this->assertArrayHasKey('client_id', $content);
        $this->assertArrayHasKey('response_types', $content);
        $this->assertArrayHasKey('grant_types', $content);
        $this->assertArrayHasKey('client_secret', $content);
        $this->assertArrayHasKey('client_secret_expires_at', $content);
        $this->assertArrayHasKey('token_endpoint_auth_method', $content);
        $this->assertEquals('client_secret_jwt', $content['token_endpoint_auth_method']);
        $this->assertEquals([], $content['response_types']);
        $this->assertEquals([], $content['grant_types']);
    }

    public function testClientCreatedAndUnsupportedParametersAreNotComputed()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'token_endpoint_auth_method' => 'client_secret_jwt',
            'unsupported_parameter'      => ['foo', 'bar'],
        ];
        $client->request('POST', '/client/management', $post_parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(is_array($content));
        $this->assertArrayNotHasKey('unsupported_parameter', $content);
        $this->assertArrayHasKey('client_id', $content);
        $this->assertArrayHasKey('response_types', $content);
        $this->assertArrayHasKey('grant_types', $content);
        $this->assertArrayHasKey('client_secret', $content);
        $this->assertArrayHasKey('client_secret_expires_at', $content);
        $this->assertArrayHasKey('token_endpoint_auth_method', $content);
        $this->assertEquals('client_secret_jwt', $content['token_endpoint_auth_method']);
        $this->assertEquals([], $content['response_types']);
        $this->assertEquals([], $content['grant_types']);
    }

    public function testAssociatedResponseTypeMissing()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'token_endpoint_auth_method' => 'client_secret_jwt',
            'grant_types'                => ['authorization_code', 'refresh_token'],
        ];
        $client->request('POST', '/client/management', $post_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertEquals('{"error":"invalid_request","error_description":"The grant type \"authorization_code\" is associated with the response types \"[\"code\"]\" but this response type is missing."}', $client->getResponse()->getContent());
    }

    public function testAssociatedGrantTypeMissing()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'token_endpoint_auth_method' => 'client_secret_jwt',
            'response_types'             => ['code', 'refresh_token'],
            'grant_types'                => ['refresh_token'],
        ];
        $client->request('POST', '/client/management', $post_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertEquals('{"error":"invalid_request","error_description":"The response type \"code\" is associated with the grant types \"[\"authorization_code\"]\" but this response type is missing."}', $client->getResponse()->getContent());
    }

    /*public function testClientCreatedWithGrantTypes()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'token_endpoint_auth_method' => 'client_secret_jwt',
            'response_types'             => ['code'],
            'grant_types'                => ['authorization_code', 'refresh_token'],
        ];
        $client->request('POST', '/client/management', $post_parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(is_array($content));
        $this->assertArrayNotHasKey('unsupported_parameter', $content);
        $this->assertArrayHasKey('client_id', $content);
        $this->assertArrayHasKey('response_types', $content);
        $this->assertArrayHasKey('grant_types', $content);
        $this->assertArrayHasKey('client_secret', $content);
        $this->assertArrayHasKey('client_secret_expires_at', $content);
        $this->assertArrayHasKey('token_endpoint_auth_method', $content);
        $this->assertEquals('client_secret_jwt', $content['token_endpoint_auth_method']);
        $this->assertEquals(['code'], $content['response_types']);
        $this->assertEquals(['authorization_code', 'refresh_token'], $content['grant_types']);

        $client = $this->getContainer()->get('app.client_manager')->getClient($content['client_id']);
        $this->assertInstanceOf(ClientInterface::class, $client);
    }*/
}
