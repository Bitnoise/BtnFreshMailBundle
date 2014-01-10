<?php

/**
 * FreshMail service based on https://github.com/FreshMail/REST-API
 * @docs http://freshmail.pl/wp-content/uploads/2013/04/REST_API_v1.0.17.pdf
 */
namespace Btn\FreshMailBundle\Service;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use FreshMail\RestApi as FmRestApi;

/**
 *
 */
class FreshMailService extends FmRestApi
{
    /**
     * @var array
     */
    protected $methodToRequestMap = array(
                  'subscriberAdd'         => 'subscriber/add',
              );

    /**
     * @var Symfony\Component\HttpKernel\Log\LoggerInterface
     */
    protected $logger;

    /**
     * @var string
     */
    protected $logPrefix = 'Btn\\FreshMailBundle\\Service\\FreshMailService::';

    /**
     *
     */
    public function __construct($apiSecret, $apiKey, LoggerInterface $logger)
    {
        $this->setApiSecret($apiSecret);
        $this->setApiKey($apiKey);
        $this->logger = $logger;
    }

    /**
     *
     */
    protected function getRequestUrlForMethod($method)
    {
        return !empty($this->methodToRequestMap[$method]) ? $this->methodToRequestMap[$method] : $method;
    }

    /**
     *
     */
    public function __call($method, $args)
    {
        $result = null;

        try {
            if (method_exists($this, $method)) {
                $result = call_user_func_array(array($this, $method), $args);
            } else {
                array_unshift($args, $this->getRequestUrlForMethod($method));
                $result = call_user_func_array(array($this, 'doRequest'), $args);
            }
            $this->logger->info($this->logPrefix.$method, array('args' => $args, 'result' => $result));
        } catch (\Exception $e) {
            $this->logger->error($this->logPrefix.$method.' message:'.$e->getMessage().' ['.$e->getCode().']', $args);
            $result = false;
        }

        return $result;
    }
}
