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

use Graze\GuzzleHttp\JsonRpc\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response as HttpResponse;

class Response extends HttpResponse implements ResponseInterface
{
    /**
     * @var array Cache entry for the response data.
     */
    protected $data;

    /**
     * Get a key from the request body, in a cached manner.
     *
     * @param string $key
     * @return mixed
     */
    protected function getFromBody($key)
    {
        // JSON decoding failed once, don't do it again.
        if ($this->data === false) {
            return null;
        }

        // Decode data if we haven't done that already
        if (!is_array($this->data)) {
            $this->data = json_decode($this->data, true);

            if (json_last_error() !== \JSON_ERROR_NONE) {
                $this->data = false;
                return null;
            }
        }

        // Make sure null values are returned too.
        return array_key_exists($key, $this->data) ? $this->data[$key] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcErrorCode()
    {
        $error = $this->getFromBody('error');
        return array_key_exists('code', $error) ? $error['code'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcErrorMessage()
    {
        $error = $this->getFromBody('error');
        return array_key_exists('message', $error) ? $error['message'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcErrorData()
    {
        $error = $this->getFromBody('error');
        return array_key_exists('data', $error) ? $error['data'] : null;
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcId()
    {
        return $this->getFromBody('id');
    }

    /**
     * @return mixed
     */
    public function getRpcResult()
    {
        return $this->getFromBody('result');
    }

    /**
     * {@inheritdoc}
     */
    public function getRpcVersion()
    {
        return $this->getFromBody('jsonrpc');
    }
}
