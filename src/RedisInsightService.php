<?php

namespace Yourivw\SailorServices;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Yourivw\Sailor\Contracts\Serviceable;

class RedisInsightService implements Serviceable
{
    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return 'redisinsight';
    }

    /**
     * {@inheritDoc}
     */
    public function stubFilePath(): string
    {
        return __DIR__.'/../stubs/redisinsight.stub';
    }

    /**
     * {@inheritDoc}
     */
    public function needsVolume(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isUsedDefault(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function publishes(): ?array
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function afterAdding(Command $command, array &$compose): void
    {
        File::ensureDirectoryExists(base_path('.docker/redisinsight/'));
        File::copy(__DIR__.'/../redisinsight/redisinsight.db', base_path('.docker/redisinsight/redisinsight.db'));
    }

    /**
     * {@inheritDoc}
     */
    public function afterPublishing(Command $command): void
    {
        //
    }
}
