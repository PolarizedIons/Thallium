<?php
namespace Thallium\Net;

use Thallium\Interfaces\IRequest;


if (!defined('THALLIUM')) exit(1);

class Request implements IRequest {
    private $protocol;
    private $host;
    private $port;

    private $httpProtocol;
    private $method;
    private $path;
    private $params;
    private $query;
    private $rawBody;
    private $body;

    private $referrer;
    private $userAgent;
    private $cookies;

    public function __construct($values)
    {
        $this->protocol = $values['protocol'] ?? 'HTTP/1.1';
        $this->host = $values['host'] ?? '';
        $this->port = $values['port'] ?? 80;

        $this->headers = $values['headers'] ?? array();
        $this->httpProtocol = $values['httpProtocol'] ?? 'http';
        $this->setMethod($values['method'] ?? 'GET');
        $this->path = $values['path'] ?? '/';
        $this->params = $values['params'] ?? array();
        $this->query = $values['query'] ?? array();
        $this->rawBody = $values['rawBody'] ?? '';

        $this->referrer = $values['referrer'] ?? '';
        $this->userAgent = $values['userAgent'] ?? '';
        $this->cookies = $values['cookies'] ?? array();
    }

    private function setMethod($method) {
        $VALID_METHODS = array(
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
            'OPTION',
        );
        if (! \in_array($method, $VALID_METHODS)) {
            throw \InvalidArgumentException("Method must be one of " . implode(', ', $VALID_METHODS));
        }

        $this->method = $method;
    }

    public static function createFromGlobals(): Request {
        $hostSplit = \explode(':', Request::getGlobal('HTTP_HOST'), 2);
        $phpInput = file_get_contents('php://input');

        return new Request(array(
            'headers' => getallheaders() ?? array(),  // getallheaders is polyfilled
            'method' => Request::getGlobal('REQUEST_METHOD'),
            'path' => \explode('?', Request::getGlobal('REQUEST_URI'), 2)[0] ?? '/',
            'httpProtocol' => Request::getGlobal('SERVER_PROTOCOL'),
            'query' => $_GET,
            'host' => $hostSplit[0],
            'port' => isset($hostSplit[1]) ? (int)$hostSplit[1] : 80,
            'referrer' => Request::getGlobal('HTTP_REFERER'),
            'userAgent' => Request::getGlobal('HTTP_USER_AGENT'),
            'protocol' => Request::getGlobal('REQUEST_SCHEME') ?: Request::getGlobal('HTTPS', 'off') === 'off' ? 'http' : 'https',
            'cookies' => $_COOKIE,
            'rawBody' => $phpInput,
        ));

    }

    private static function getGlobal($key, $default = '') {
        if (\is_array($key)) {
            $value = null;
            $keys = $key;
            foreach ($keys as $key) {
                $value = $_SERVER[$key];
                if ($value !== null) {
                    return $value;
                }
            }

            return $default;
        }
        return $_SERVER[$key] ?? $default;
    }




    public function getProtocol() {
        return $this->protocol;
    }
    public function getHost() {
        return $this->host;
    }
    public function getPort() {
        return $this->port;
    }
    public function getHttpProtocol() {
        return $this->httpProtocol;
    }
    public function getMethod() {
        return $this->method;
    }
    public function getPath() {
        return $this->path;
    }
    public function getParams() {
        return $this->params;
    }
    public function getQuery($key) {
        return $this->query[$key];
    }
    public function getReferrer() {
        return $this->referrer;
    }
    public function getUserAgent() {
        return $this->userAgent;
    }
    public function getCookies() {
        return $this->cookies;
    }
    public function getHeaders() {
        return $this->headers;
    }
    public function getRawBody() {
        return $this->rawBody;
    }

    public function addParams($params) {
        $this->params = \array_merge($this->params, $params);
    }

    public function getParam($key) {
        return $this->params[$key];
    }

    public function getHeader($key) {
        return $this->getHeaders()[$key];
    }

    public function getCookie($key) {
        return $this->getCookies()[$key];
    }

    public function getBody() {
        if ($this->body !== null) {
            return $this->body;
        }

        $contentType = $this->getHeader('Content-Type');
        switch ($contentType) {
            case 'application/json':
                $this->body = json_decode($this->rawBody, 'object') ?? array();
                break;
            case 'text/plain':
                $this->body = $this->rawBody;
                break;
            default:
                $this->body = $_POST; // TODO: This doesn't work for non POST requests
        }

        return $this->body; 
    }
}
