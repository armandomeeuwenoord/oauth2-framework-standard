<?php

namespace Tests\AppBundle\GrantType;

use Tests\AppBundle\Base;

/**
 * @group RefreshTokenGrantType
 * @group legacy
 */
class RefreshTokenGrantTypeTest extends Base
{
    public function testUnauthenticatedClient()
    {
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'grant_type' => 'refresh_token',
        ];
        $client->request('POST', '/oauth/v2/token', $post_parameters);

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
        $this->assertContains('Basic realm="OAuth2 Server - Client Authentication"', $client->getResponse()->headers->get('WWW-Authenticate'));
    }

    /*public function testClientAuthenticatedButRefreshTokenIsMissing()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-client_secret_basic');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'grant_type' => 'refresh_token',
        ];
        $header_parameters = [
            'HTTP_AUTHORIZATION' => 'Basic ' . base64_encode(sprintf('%s:%s', $oauth2_client->getPublicId(), $oauth2_client->get('client_secret'))),
        ];
        $client->request('POST', '/oauth/v2/token', $post_parameters, [], $header_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertEquals('{"error":"invalid_request","error_description":"No \"refresh_token\" parameter found"}', $client->getResponse()->getContent());
    }*/

    /*public function testRefreshTokenNotForTheClient()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-client_secret_basic');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $this->getFixtures()->getReference('refresh_token-REFRESH_TOKEN_EXPIRED')->getToken(),
        ];
        $header_parameters = [
            'HTTP_AUTHORIZATION' => 'Basic ' . base64_encode(sprintf('%s:%s', $oauth2_client->getPublicId(), $oauth2_client->get('client_secret'))),
        ];
        $client->request('POST', '/oauth/v2/token', $post_parameters, [], $header_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertEquals('{"error":"invalid_grant","error_description":"Invalid refresh token"}', $client->getResponse()->getContent());
    }*/

    /*public function testRefreshTokenExpired()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-client_secret_post');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $this->getFixtures()->getReference('refresh_token-REFRESH_TOKEN_EXPIRED')->getToken(),
            'client_id'     => $oauth2_client->getPublicId(),
            'client_secret' => $oauth2_client->get('client_secret'),
        ];
        $client->request('POST', '/oauth/v2/token', $post_parameters);

        $this->assertEquals(400, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $this->assertEquals('{"error":"invalid_grant","error_description":"Refresh token has expired"}', $client->getResponse()->getContent());
    }*/

    /*public function testAccessTokenIssued()
    {
        $oauth2_client = $this->getFixtures()->getReference('client-client_secret_post');
        $client = static::makeClient(false, ['HTTPS' => true]);
        $post_parameters = [
            'grant_type'    => 'refresh_token',
            'refresh_token' => $this->getFixtures()->getReference('refresh_token-REFRESH_TOKEN_VALID')->getToken(),
            'client_id'     => $oauth2_client->getPublicId(),
            'client_secret' => $oauth2_client->get('client_secret'),
        ];
        $client->request('POST', '/oauth/v2/token', $post_parameters);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('application/json', $client->getResponse()->headers->get('Content-Type'));
        $content = json_decode($client->getResponse()->getContent(), true);
        $this->assertTrue(is_array($content));
        $this->assertArrayHasKey('access_token', $content);
        $this->assertArrayHasKey('token_type', $content);
        $this->assertArrayHasKey('expires_in', $content);
        $this->assertEquals('Bearer', $content['token_type']);
        $this->assertTrue($content['expires_in'] <= 3600);

        $access_token = $this->getContainer()->get('app.access_token_manager')->getAccessToken($content['access_token']);
        $this->assertInstanceOf(AccessTokenInterface::class, $access_token);
    }*/
}
