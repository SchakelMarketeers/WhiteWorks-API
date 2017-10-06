<?php
/**
 * Part of Schakel Marketeers WhiteWorks API
 *
 * @license GPL-v3
 * @link https://github.com/SchakelMarketeers/WhiteWorks-API
 */

namespace Schakel\WhiteWorks;

use Graze\GuzzleHttp\JsonRpc\Client as RpcClient;
use GuzzleHttp\Common\Collection;
use GuzzleHttp\Service\Description\ServiceDescription;
use Schakel\WhiteWorks\Message\MessageFactory as Factory;
use Schakel\WhiteWorks\Api\ApiInterface;

/**
 * Handles creating a client using a factory. You can use getApi to get access
 * to objects in the WhiteWorks storage.
 *
 * @author Roelof Roos <roelof@schakelmarketeers.nl>
 */
class Client extends RpcClient
{
    /**
     * Returns a new instance, make sure to pass 'base_host' as a config
     * parameter, as it's required.
     *
     * @param array $config
     * @return Schakel\WhiteWorks\Client
     */
    public static function factory($config = [])
    {
        $default = array(
            'debug' => false
        );
        $required = array('api_key', 'base_path', 'base_host');
        $config = Collection::fromConfig($config, $default, $required);

        // We /always/ use SSL. We're dealing with customer data.
        $uri = sprintf('https://%s/public/api.php', $config->get('base_host'));

        return parent::factory($uri, [
            'message_factory' => new Factory($config->get('api_key'))
        ]);
    }

    protected $requestHandlers = [];

    /**
     * Returns an API, which is solely responsible for communicating with one
     * kind of object in WhiteWorks (such as a tag, file or company).
     *
     * @param string $apiName
     * @return Schakel\WhiteWorks\Api\ApiNodeInterface
     */
    public function getApi($apiName)
    {
        // Check type
        if (!is_string($apiName)) {
            throw new \InvalidArgumentException(sprintf(
                'Expected $apiName to be a string, got %s.',
                gettype($apiName)
            ));
        }

        // Check content
        if (!preg_match('/^[a-z]{2,}$/', $apiName)) {
            throw new \InvalidArgumentException(sprintf(
                'Expected $apiName to be a valid API name, but %s is not.',
                $apiName
            ));
        }

        if (array_key_exists($apiName, $this->requestHandlers)) {
            return $this->requestHandlers[$apiName];
        }

        // Check if API exists. We take advantage of the case-insensitiveness of
        // class names, which is actually quite weird.
        $className = "Schakel\\WhiteWorks\\Api\\{$apiName}";

        // Check if specs are met.
        if (class_exists($className) && is_subclass_of($className, ApiNodeInterface::class)) {
            $api = new $className($this);
            $this->requestHandlers[$apiName] = $api;
        } else {
            $this->requestHandlers[$apiName] = null;
        }

        return $this->requestHandlers[$apiName];
    }

    /**
     * Makes a request, shorthand for $client->send($client->request()).
     *
     * @param string $endpoint
     * @param array $data
     */
    public function quickRequest($endpoint, $data = [])
    {
        return $this->send($this->request(
            uniqid('', true),
            (string) $endpoint,
            is_array($data) ? $data : []
        ));
    }
}
