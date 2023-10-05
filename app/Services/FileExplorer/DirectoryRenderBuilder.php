<?php

namespace App\Services\FileExplorer;

use Illuminate\Support\Facades\Storage;

class DirectoryRenderBuilder
{
    private ?string $render = null;

    private string $targetPath;

    public function setTargetPath(string $targetPath): self
    {
        $this->targetPath = $targetPath;
        return $this;
    }

    public function build(): self
    {
        $this->targetPath = $this->targetPath === storage_path()
            ? '/'
            : str_replace(storage_path(), '', $this->targetPath);

        $this->render = '';

        foreach (Storage::directories($this->targetPath) as $path) {
            $directoryName = $this->getShortEntityName($path);
            $sourcePath = $this->targetPath . '/' . $directoryName;

            $this->render .= view('file_explorer.partials.folder', [
                'url' => route('api.file_explorer.open', ['path' => $sourcePath]),
                'directoryName' => $directoryName,
            ])->render();
        }

        foreach (Storage::files($this->targetPath) as $path) {
            $fileName = $this->getShortEntityName($path);

            $this->render .= view('file_explorer.partials.file', [
                'file' => $fileName,
                'filePath' => $this->targetPath . '/' . $fileName
            ])->render();
        }

        if ($this->render === '') {
            $this->render = view('file_explorer.partials.empty-folder')->render();
        }

        return $this;
    }

    public function getRenderedDirectory(): ?string
    {
        return $this->render;
    }

    private function getShortEntityName(string $path): string
    {
        $pathItems = explode('/', $path);
        $lastItem = end($pathItems);
        return str_replace('/', '', (string) $lastItem);
    }
}
