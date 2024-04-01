<?php

namespace Yourivw\SailorServices;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Yourivw\Sailor\Contracts\Serviceable;

class HttpsService implements Serviceable
{
    /**
     * {@inheritDoc}
     */
    public function name(): string
    {
        return 'https';
    }

    /**
     * {@inheritDoc}
     */
    public function stubFilePath(): string
    {
        return __DIR__.'/../stubs/https.stub';
    }

    /**
     * {@inheritDoc}
     */
    public function needsVolume(): bool
    {
        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function isUsedDefault(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function publishes(): ?array
    {
        return [__DIR__.'/../https' => base_path('.docker/https')];
    }

    /**
     * {@inheritDoc}
     */
    public function afterAdding(Command $command, array &$compose): void
    {
        //
    }

    /**
     * {@inheritDoc}
     */
    public function afterPublishing(Command $command): void
    {
        $composePath = base_path('docker-compose.yml');
        $compose = File::get($composePath);

        $compose = Str::of($compose)
            ->replace('./vendor/yourivw/sailor-services/https/templates', './.docker/https/templates')
            ->replace('./vendor/yourivw/sailor-services/https/generate-templates.sh', './.docker/https/generate-templates.sh')
            ->replace('./vendor/yourivw/sailor-services/https/generate-cert.sh', './.docker/https/generate-cert.sh')
            ->toString();

        File::put($composePath, $compose);

        exec('chmod +x '.base_path('/.docker/https/generate-templates.sh'));
        exec('chmod +x '.base_path('/.docker/https/generate-cert.sh'));
    }
}
