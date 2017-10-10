<?php
/**
 * Part of Schakel Marketeers WhiteWorks API.
 *
 * Foundations via graze/guzzle-jsonrpc, which is licensed under MIT.
 *
 * @license GPL-v3
 * @link https://github.com/SchakelMarketeers/WhiteWorks-API
 * @link http://github.com/graze/guzzle-jsonrpc
 */

namespace Schakel\WhiteWorks\Message;

// Extend MessageFactoryInterface
use Graze\GuzzleHttp\JsonRpc\Message\MessageFactory as GrazeMessageFactory;
use Graze\GuzzleHttp\JsonRpc;

class MessageFactory extends GrazeMessageFactory
{
    /**
     * @var string JSON-RPC API key
     */
    protected $apiKey;

    /**
     * Creates a new message factory, setting the API key to use.
     * @param string $apiKey
     */
    public function __construct($apiKey)
    {
        $this->apiKey = (string) $apiKey;
    }

    /**
     * {@inheritdoc}
     */
    public function createRequest($method, $uri, array $headers = [], array $options = [])
    {
        if (!array_key_exists('apitoken', $options)) {
            $options['apitoken'] = $this->apiKey;
        }

        return parent::createRequest($method, $uri, $headers, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function createResponse($statusCode, array $headers = [], array $options = [])
    {
        $body = JsonRpc\json_encode($options);

        return new Response($statusCode, $headers, $body);
    }
}
