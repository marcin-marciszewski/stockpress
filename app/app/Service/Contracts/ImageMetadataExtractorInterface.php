<?php

namespace App\Service\Contracts;

interface ImageMetadataExtractorInterface
{
    /**
     * Extract metadata from an image file.
     *
     * @param string $imagePath The path to the image file.
     * @return array The extracted metadata.
     */
    public function extractMetadata(string $imagePath): array;
}
