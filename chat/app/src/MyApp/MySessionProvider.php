<?php
namespace MyApp;

use Ratchet\Session\SessionProvider;

use Ratchet\ConnectionInterface;
use Ratchet\Http\HttpServerInterface;
use Psr\Http\Message\RequestInterface;
use Ratchet\Session\Storage\VirtualSessionStorage;
use Ratchet\Session\Serialize\HandlerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\NullSessionHandler;

use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;

class MySessionProvider extends SessionProvider {

    /**
     * Taken from Guzzle3
     */
    private static $cookieParts = array(
        'domain'      => 'Domain',
        'path'        => 'Path',
        'max_age'     => 'Max-Age',
        'expires'     => 'Expires',
        'version'     => 'Version',
        'secure'      => 'Secure',
        'port'        => 'Port',
        'discard'     => 'Discard',
        'comment'     => 'Comment',
        'comment_url' => 'Comment-Url',
        'http_only'   => 'HttpOnly'
    );

    /**
     * {@inheritdoc}
     */
    public function onOpen(ConnectionInterface $conn, RequestInterface $request = null) {
        $sessionName = ini_get('session.name');

        $id = array_reduce($request->getHeader('Cookie'), function($accumulator, $cookie) use ($sessionName) {
            if ($accumulator) {
                return $accumulator;
            }

            $crumbs = $this->parseCookie($cookie);

            return isset($crumbs['cookies'][$sessionName]) ? $crumbs['cookies'][$sessionName] : false;
        }, false);

        $a = @unserialize(urldecode($id));
        $id = $a[0];

        if (null === $request || false === $id) {
            $saveHandler = $this->_null;
            $id = '';
        } else {

            $saveHandler = $this->_handler;
        }

        $storage = new VirtualSessionStorage($saveHandler, $id, $this->_serializer);

        $conn->Session = new Session($storage, new AttributeBag(1));

        if (ini_get('session.auto_start')) {
            $conn->Session->start();
        }

        return $this->_app->onOpen($conn, $request);
    }

    /**
     * Taken from Guzzle3
     */
    private function parseCookie($cookie, $host = null, $path = null, $decode = false) {
        // Explode the cookie string using a series of semicolons
        $pieces = array_filter(array_map('trim', explode(';', $cookie)));

        // The name of the cookie (first kvp) must include an equal sign.
        if (empty($pieces) || !strpos($pieces[0], '=')) {
            return false;
        }

        // Create the default return array
        $data = array_merge(array_fill_keys(array_keys(self::$cookieParts), null), array(
            'cookies'   => array(),
            'data'      => array(),
            'path'      => $path ?: '/',
            'http_only' => false,
            'discard'   => false,
            'domain'    => $host
        ));
        $foundNonCookies = 0;

        // Add the cookie pieces into the parsed data array
        foreach ($pieces as $part) {

            $cookieParts = explode('=', $part, 2);
            $key = trim($cookieParts[0]);

            if (count($cookieParts) == 1) {
                // Can be a single value (e.g. secure, httpOnly)
                $value = true;
            } else {
                // Be sure to strip wrapping quotes
                $value = trim($cookieParts[1], " \n\r\t\0\x0B\"");
                if ($decode) {
                    $value = urldecode($value);
                }
            }

            // Only check for non-cookies when cookies have been found
            if (!empty($data['cookies'])) {
                foreach (self::$cookieParts as $mapValue => $search) {
                    if (!strcasecmp($search, $key)) {
                        $data[$mapValue] = $mapValue == 'port' ? array_map('trim', explode(',', $value)) : $value;
                        $foundNonCookies++;
                        continue 2;
                    }
                }
            }

            // If cookies have not yet been retrieved, or this value was not found in the pieces array, treat it as a
            // cookie. IF non-cookies have been parsed, then this isn't a cookie, it's cookie data. Cookies then data.
            $data[$foundNonCookies ? 'data' : 'cookies'][$key] = $value;
        }

        // Calculate the expires date
        if (!$data['expires'] && $data['max_age']) {
            $data['expires'] = time() + (int) $data['max_age'];
        }

        return $data;
    }
}