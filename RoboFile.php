<?php

require 'vendor/autoload.php';

use Aws\CloudFront\CloudFrontClient;
use Aws\Exception\AwsException;
use Symfony\Component\Yaml\Yaml;
use Robo\Tasks;

class RoboFile extends Tasks {

  protected $cf_config;

  /* @var \Aws\CloudFront\CloudFrontClient $cf_client */
  protected $cf_client;

  public function __construct() {
    $this->cf_config = Yaml::parseFile('./config.yml');

    $this->cf_client = new CloudFrontClient([
      'region' => 'us-east-1',
      'version' => '2019-03-26',
      'credentials' => [
        'key' => $this->cf_config['credentials']['key'],
        'secret' => $this->cf_config['credentials']['secret'],
      ]
    ]);
  }

  /**
   * @description List CloudFront distributions.
   *
   * @command cf:list
   */
  public function listDistributions() {
    try {
      $result = $this->cf_client->listDistributions();

      $this->say(print_r($result, TRUE));
    }
    catch (AwsException $e) {
      $this->say('An error occurred.');

      $this->say($e->getMessage());
    }
  }

  /**
   * @description Test CloudFront cache invalidation.
   *
   * @command cf:test
   */
  public function testInvalidation() {
    $this->say('----------- Starting invalidation. -----------');

    $invalidation = [
      'DistributionId' => 'd13hsqs9n2i72z',
      'InvalidationBatch' => [
        'CallerReference' => 'STRING',
        'Paths' => [
          'Items' => [
            '/sites/anesthesia/files/styles/staff_thumbnail/public/images/2019-06/bouie.png'
          ],
          'Quantity' => 1,
        ]
      ]
    ];

    try {
      $result = $this->cf_client->createInvalidation($invalidation);

      $this->say(print_r($result, TRUE));
    }
    catch (AwsException $e) {
      $this->say('An error occurred.');

      $this->say($e->getMessage());
    }

    $this->say('----------- Invalidation finished. -----------');
  }

}