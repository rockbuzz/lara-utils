<?php

namespace Rockbuzz\LaraUtils;

use Throwable;
use Illuminate\Log\LogManager;

class Logging
{
    /** @var string|Throwable */
    private $logable;
    private array $context;
    private string $channel;
    private LogManager $logger;

    public function __construct($logable, array $context = [])
    {
        $this->logable = $logable;
        $this->context = $context;
        $this->logger = app('log');
        $this->channel = config('logging.default');

        if ($this->logable instanceof Throwable && config('utils.logging.channels.errors')) {
            $this->logger->channel(config('utils.logging.channels.errors'))->error($this->logable);
        }
    }

    public function channel(string $channel): self
    {
        if (config("logging.channels.{$channel}")) {
            $this->channel = $channel;
        }

        return $this;
    }

    public function debug(): void
    {
        $this->logger->channel($this->channel)
            ->debug($this->prepareMessage(), $this->context);
    }

    public function info(): void
    {
        $this->logger->channel($this->channel)
            ->info($this->prepareMessage(), $this->context);
    }

    public function error(): void
    {
        $this->logger->channel($this->channel)
            ->error($this->prepareMessage(), $this->context);
    }

    public function structured(int $step): void
    {
        $this->logger->channel($this->channel)
            ->info("{$step} - {$this->prepareMessage()}", $this->context);
    }

    private function prepareMessage(): string
    {
        switch (true) {
            case is_string($this->logable):
                return $this->logable;
            case $this->logable instanceof Throwable:
                return sprintf(
                    "\"%s in file %s on line %s",
                    $this->logable->getMessage() ?? 'new app error',
                    $this->logable->getFile(),
                    $this->logable->getLine()
                );
            default:
                return 'new log entry with invalid logable';
        }
    }
}
