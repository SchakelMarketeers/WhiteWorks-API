<?php
/**
 * Part of Schakel Marketeers WhiteWorks API
 *
 * @license GPL-v3
 * @link https://github.com/SchakelMarketeers/WhiteWorks-API
 */

namespace Schakel\WhiteWorks\Api;

use Schakel\WhiteWorks\Client;

/**
 * Describes an API object, which always has the following methods.
 *
 * Optionally extra methods may exist for certain APIs, but they're limited.
 *
 * @author Roelof Roos <roelof@schakelmarketeers.nl>
 */
interface ApiNodeInterface
{

    /**
     * Creates a new API, using the given client to communicate with the
     * endpoint.
     *
     * @param Schakel\WhiteWorks\Client
     */
    public function __construct(Client $client);

    /**
     * Returns all entries, optionally filtered
     *
     * @param array $filters
     * @param array $options
     * @return array
     */
    public function get(array $filters, array $options = []);

    /**
     * Equal to get, but only returns a single object.
     *
     * @see ApiInterface::get
     * @param array $filters
     * @param array $options
     * @return array
     */
    public function getOne(array $filters, array $options = []);

    /**
     *
     *
     * @param mixed $id
     * @param array $fields
     * @return boolean
     */
    public function update($id, array $fields = []);

    /**
     * Adds an object to the API.
     *
     * @param array $fields
     * @return boolean
     */
    public function create(array $fields = []);

    /**
     * Deletes a single object using the API.
     *
     * @param mixed $id
     * @param array $options
     * @return boolean
     */
    public function delete($id);

}
