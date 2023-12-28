<?php

namespace App\Services\FileExplorer;

use App\Services\Helpers\FileHelper;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileRenderBuilder
{
    public const FILE_TYPE_TEXT = 'text';

    public const FILE_TYPE_BINARY = 'binary';

    public const FILE_TYPE_IMAGE = 'image';

    public const FILE_TYPE_VIDEO = 'video';

    private ?string $render = null;

    private string $fileName;

    private string $storageFilePath;

    private ?string $fileType = null;

    /**
     * @throws NotFoundHttpException
     */
    public function setStoragePath(string $storageFilePath): self
    {
        if (!Storage::exists($storageFilePath)) {
            throw new NotFoundHttpException('File not found, on path: ' . $storageFilePath);
        }

        $this->storageFilePath = $storageFilePath;
        $pathItems = explode('/', $storageFilePath);
        $this->fileName = end($pathItems);
        // @todo - what if someone would not set path?

        return $this;
    }

    public function build(): self
    {
        $fileContent = Storage::get($this->storageFilePath);

        // @todo - REALLY? REFACTOR THIS IFOLOGY
        if (FileHelper::isBinaryText($fileContent)) {
            if (FileHelper::isImageByExtension($this->fileName)) {
                $this->render = $this->renderAsImageFile();
                return $this;
            }

            if (FileHelper::isVideoByExtension($this->fileName)) {
                $this->render = $this->renderAsVideoFile();
                return $this;
            }

            $this->render = $this->renderAsBinaryFile();
            return $this;
        }

        $this->render = $this->renderAsTextFile($fileContent);
        return $this;
    }

    public function getRenderedFile(): ?string
    {
        // @todo - what if not rendered/built?
        return $this->render;
    }

    protected function renderAsBinaryFile(): string
    {
        $this->fileType = self::FILE_TYPE_BINARY;
        return view(
            'file_explorer.partials.binary-file', [
            'fileName' => $this->fileName
            ]
        )->render();
    }

    protected function renderAsVideoFile(): string
    {
        $this->fileType = self::FILE_TYPE_VIDEO;
        $extension = FileHelper::extractExtension($this->fileName);

        return view(
            'file_explorer.partials.video-file', [
            'fileName' => $this->fileName,
            'fileExtension' => $extension,
            'src' => route('api.file_explorer.get', ['path' => $this->storageFilePath])
            ]
        )->render();
    }

    protected function renderAsTextFile(string $content): string
    {
        return view(
            'file_explorer.partials.text-file', [
            'fileName' => $this->fileName,
            'content' => $content
            ]
        )->render();
    }

    protected function renderAsImageFile(): string
    {
        $this->fileType = self::FILE_TYPE_IMAGE;
        return view(
            'file_explorer.partials.image-file', [
            'fileName' => $this->fileName,
            'src' => route('api.file_explorer.get', ['path' => $this->storageFilePath])
            ]
        )->render();
    }

    public function getFileType(): ?string
    {
        return $this->fileType;
    }
}
