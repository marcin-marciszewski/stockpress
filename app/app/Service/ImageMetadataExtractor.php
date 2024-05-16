<?php

namespace App\Service;

use App\Service\Contracts\ImageMetadataExtractorInterface;

class ImageMetadataExtractor implements ImageMetadataExtractorInterface
{
    public function extractMetadata(string $image): array
    {
        $imageInfo = getimagesize($image, $info);
        $fileSize = filesize($image);
        $exifIptcData = '';

        if (isset($info["APP13"])) {
            $iptc = iptcparse($info["APP13"]);

            foreach ($iptc as $key => $value) {
                $exifIptcData .= $key . ': ' . implode(', ', $value) . PHP_EOL;
            }
        }

        if (function_exists('exif_read_data')) {
            try {
                $exif = exif_read_data($image, 0, true);
            } catch (\Exception $e) {
                $exif = false;
            }
            if ($exif) {
                foreach ($exif as $key => $value) {
                    $exifIptcData .= $key . ': ' . implode(', ', $value) . PHP_EOL;
                }
            }
        }

        return [$exifIptcData, round($fileSize / 1048576, 2), $imageInfo[3], explode("/", $imageInfo['mime'])[1]];
    }
}
