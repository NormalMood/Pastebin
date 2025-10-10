<?php

namespace Pastebin\Kernel\Storage;

use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;

class Storage implements StorageInterface
{
    private readonly S3Client $s3;

    public function __construct()
    {
        $credentials = CredentialProvider::ini(profile: 'default', filename: APP_PATH . '/.aws/credentials');
        $this->s3 = new S3Client([
            'version' => 'latest',
            'endpoint' => 'https://storage.yandexcloud.net',
            'region' => 'ru-central1',
            'credentials' => $credentials
        ]);
    }
}
