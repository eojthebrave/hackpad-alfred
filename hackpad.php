<?php

/**
 * @file
 */

/**
 * Class HackPadAPI.
 */
class HackPadAPI {

  var $base_url = '';
  var $api_url = '';
  var $client_id = '';
  var $secret = '';

  /**
   * Constructor.
   *
   * @param string $client_id
   *   Unique Client ID from HackPad.com
   * @param string $secret
   *   Unique API Secret from HackPad.com
   * @param $uri
   *  Base URL for accessing hackpad, can be used to set to a specific domain*   Base URL for accessing hackpad, can be used to set to a specific domain
   *  like https://example.hackpad.com
   *
   * @return \HackPadAPI
   */
  public function __construct($client_id, $secret, $uri) {
    $this->client_id = $client_id;
    $this->secret = $secret;
    $this->base_url = $uri;
    $this->api_url = $uri . '/api/1.0';
    return TRUE;
  }

  /**
   * @param $query
   * @return string
   */
  public function searchURI($query) {
    $url = $this->api_url . '/search';
    $oauth = $this->signRequest($url, 'GET', array('q' => $query));
    return $url . '?' . $this->buildQuery($oauth);
  }

  /**
   * Sign a request to the Hackpad API using oauth 1.0. The Hackpad API doesn't
   * use tokens or anything beyond a very basic oauth request.
   *
   * @params string $uri
   *   The URI to make the request to.
   * @param string $method
   *   The HTTP method used for the request.
   * @param array $query
   *   An optional array of query parameters to add to the URI.
   *
   * @return array
   *   An array of URL parameters suitable for appending to a request made to
   *   $uri.
   */
  protected function signRequest($uri, $method, $query = array()) {
    $oauth = $query;
    $oauth['oauth_consumer_key'] = $this->client_id;
    $oauth['oauth_nonce'] = $this->nonce();
    $oauth['oauth_signature_method'] = 'HMAC-SHA1';
    $oauth['oauth_timestamp'] = time();
    $oauth['oauth_version'] = '1.0';

    // All parameters must be in alphabetical order for oauth hashing.
    ksort($oauth);

    // The most complicated part of the request - generating the signature.
    // The string to sign contains the HTTP method, the URL we are loading,
    // and all of our query parameters each URL encoded. Then, we concatenate
    // them with ampersands into a single string to hash.
    $http_verb = urlencode($method);
    $resource_url = urlencode($uri);

    $url_parameters = urlencode($this->buildQuery($oauth));
    $sig_string = $http_verb . '&' . $resource_url . '&' . $url_parameters;

    // Since we only have one oauth token (our shared secret) we only have to
    // use it as our hmac key. However, we still have to append an & to it as
    // if we were using it with additional tokens.
    $secret = urlencode($this->secret) . '&';

    // This is a hash of the consumer key and the "base string". Note that we
    // have to get the raw_output from hash_hmac but then base64 encode the
    // binary data result.
    $oauth['oauth_signature'] = base64_encode(hash_hmac('sha1', $sig_string, $secret, TRUE));

    return $oauth;
  }

  /**
   * Generate a unique string for use with oauth requests.
   *
   * @return string
   *   A unique string suitable to use with an oauth nonce parameter.
   */
  protected static function nonce() {
    $mt = microtime();
    $rand = mt_rand();

    return md5($mt . $rand);
  }

  protected function buildQuery(array $query, $parent = '') {
    $params = array();

    foreach ($query as $key => $value) {
      $key = ($parent ? $parent . '[' . rawurlencode($key) . ']' : rawurlencode($key));

      // Recurse into children.
      if (is_array($value)) {
        $params[] = $this->buildQuery($value, $key);
      }
      // If a query parameter value is NULL, only append its key.
      elseif (!isset($value)) {
        $params[] = $key;
      }
      else {
        // For better readability of paths in query strings, we decode slashes.
        $params[] = $key . '=' . str_replace('%2F', '/', rawurlencode($value));
      }
    }

    return implode('&', $params);
  }

}
