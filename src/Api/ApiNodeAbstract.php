<?php
/**
 * Part of Schakel Marketeers WhiteWorks API
 *
 * @license GPL-v3
 * @link https://github.com/SchakelMarketeers/WhiteWorks-API
 */

namespace Schakel\WhiteWorks\Api;

use Schakel\WhiteWorks\Client;
use Schakel\WhiteWorks\ApiFilter;

/**
 * Describes an API object, which always has the following methods.
 *
 * Optionally extra methods may exist for certain APIs, but they're limited.
 *
 * @author Roelof Roos <roelof@schakelmarketeers.nl>
 */
abstract class ApiNodeAbstract implements ApiNodeInterface
{
    /**
     * Returns a safe list for filters
     *
     * @param array $data
     * @return Schakel\WhiteWorks\ApiFilter[]
     */
    protected static function buildFilter($data)
    {
        // Only arrays please, thanks.
        if (!is_array($data)) {
            return [];
        }

        foreach ($data as $v) {
            if (!is_object($v) || !($v instanceof ApiFilter)) {
                throw new \InvalidArgumentException(sprintf(
                    'Was expecting a filter of type ApiFilter, got %s.',
                    is_object($v) ? get_class($v) : gettype($v)
                ));
            }
        }

        return array_values($data);
    }

    /**
     * @var Schakel\WhiteWorks\Client
     */
    protected $client;

    /**
     * {@inheritdoc}
     */
    public function __construct(Client $client)
    {
        if (empty($client) || !($client instanceof Client)) {
            throw new \InvalidArgumentException(sprintf(
                'Expected a client of type Schakel\WhiteWorks\Client, got %s.',
                is_object($client) ? get_class($client) : gettype($client)
            ));
        }

        $this->client = $client;
    }

    /**
     * Quick method to call something with the internal client.
     *
     * @param string $endpoint
     * @param array $args
     * @return Schakel\WhiteWorks\Message\Response
     */
    protected function apiCall($endpoint, $args = [])
    {
        return $this->client->quickRequest($endpoint, $args);
    }

    /**
     * {@inheritdoc}
     */
    public abstract function get(array $filters, array $options = []);

    /**
     * {@inheritdoc}
     */
    public abstract function getOne(array $filters, array $options = []);

    /**
     * {@inheritdoc}
     */
    public abstract function update($id, array $fields = []);

    /**
     * {@inheritdoc}
     */
    public abstract function create(array $fields = []);

    /**
     * {@inheritdoc}
     */
    public abstract function delete($id);

}
