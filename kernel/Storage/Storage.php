<?php

namespace Pastebin\Kernel\Storage;

use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client;
use Pastebin\Kernel\Config\ConfigInterface;
use Pastebin\Kernel\Upload\UploadedFileInterface;

class Storage implements StorageInterface
{
    private readonly S3Client $s3;

    private readonly string $picturesBucket;

    private readonly string $postsBucket;

    public function __construct(
        private readonly ConfigInterface $config
    ) {
        $credentials = CredentialProvider::ini(profile: 'default', filename: APP_PATH . '/.aws/credentials');
        $this->s3 = new S3Client([
            'version' => 'latest',
            'endpoint' => 'https://storage.yandexcloud.net',
            'region' => 'ru-central1',
            'credentials' => $credentials
        ]);
        $this->setBucketsFromConfig();
    }

    public function uploadPicture(UploadedFileInterface $picture, string $pictureName): string|false
    {
        try {
            $result = $this->s3->putObject([
                'Bucket' => $this->picturesBucket,
                'Key' => $pictureName,
                'SourceFile' => $picture->tmpName(),
                'ContentType' => $picture->type()
            ]);
            return $result['ObjectURL'];
        } catch (\Exception $e) {
            return false;
        }
    }

    public function setBucketsFromConfig(): void
    {
        $this->picturesBucket = $this->config->get('storage.pictures_bucket');
        $this->postsBucket = $this->config->get('storage.posts_bucket');
    }
}
