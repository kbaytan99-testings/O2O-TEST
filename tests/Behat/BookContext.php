<?php

declare(strict_types=1);

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * BookContext - Behat context for API functional tests
 */
class BookContext implements Context
{
    private ?Response $response = null;

    /**
     * @When I send a GET request to :url
     */
    public function iSendAGetRequestTo(string $url): void
    {
        // Load environment variables for test environment
        if (file_exists(dirname(__DIR__, 2) . '/.env.test')) {
            $dotenv = new \Symfony\Component\Dotenv\Dotenv();
            $dotenv->load(dirname(__DIR__, 2) . '/.env.test');
        }
        
        $kernel = new \App\Kernel('test', true);
        $kernel->boot();
        
        $request = Request::create($url, 'GET');
        $this->response = $kernel->handle($request);
        
        $kernel->shutdown();
    }

    /**
     * @Then the response status code should be :statusCode
     */
    public function theResponseStatusCodeShouldBe(int $statusCode): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }

        if ($this->response->getStatusCode() !== $statusCode) {
            throw new \RuntimeException(
                sprintf(
                    'Expected status code %d, got %d',
                    $statusCode,
                    $this->response->getStatusCode()
                )
            );
        }
    }

    /**
     * @Then the response should be in JSON
     */
    public function theResponseShouldBeInJson(): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }

        $contentType = $this->response->headers->get('Content-Type');
        if ($contentType === null || strpos($contentType, 'application/json') === false) {
            throw new \RuntimeException('Response is not in JSON format');
        }
    }

    /**
     * @Then the JSON response should contain :field
     */
    public function theJsonResponseShouldContain(string $field): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }

        $content = $this->response->getContent();
        if ($content === false) {
            throw new \RuntimeException('Response has no content');
        }

        $data = json_decode($content, true);
        if ($data === null) {
            throw new \RuntimeException('Response is not valid JSON');
        }

        // Check if field exists in the first element if response is an array
        if (is_array($data) && count($data) > 0 && isset($data[0][$field])) {
            return;
        }

        // Check if field exists directly
        if (isset($data[$field])) {
            return;
        }

        throw new \RuntimeException(sprintf('Field "%s" not found in JSON response', $field));
    }

    /**
     * @Then the JSON response should have a field :field with value :value
     */
    public function theJsonResponseShouldHaveAFieldWithValue(string $field, string $value): void
    {
        if ($this->response === null) {
            throw new \RuntimeException('No response received');
        }

        $content = $this->response->getContent();
        if ($content === false) {
            throw new \RuntimeException('Response has no content');
        }

        $data = json_decode($content, true);
        if ($data === null) {
            throw new \RuntimeException('Response is not valid JSON');
        }

        if (!isset($data[$field])) {
            throw new \RuntimeException(sprintf('Field "%s" not found in JSON response', $field));
        }

        if ((string) $data[$field] !== $value) {
            throw new \RuntimeException(
                sprintf(
                    'Expected field "%s" to have value "%s", got "%s"',
                    $field,
                    $value,
                    $data[$field]
                )
            );
        }
    }
}
