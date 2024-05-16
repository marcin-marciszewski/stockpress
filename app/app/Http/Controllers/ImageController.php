<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use App\Service\ImageMetadataExtractor;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageStoreRequest;
use Intervention\Image\Drivers\Gd\Driver;
use App\Service\Contracts\GetTempInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $images = Image::paginate(10);

        return response()->json(['images' => $images], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        ImageStoreRequest $request,
        ImageMetadataExtractor $extractor,
        GetTempInterface $temp
    ): JsonResponse {
        try {
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            [$exifIptcData, $fileSize, $resolution, $extension] = $extractor->extractMetadata($request->image);
            $tempKatowice = $temp->getTempKatowice();

            Image::create([
                'image' => $imageName,
                'uploaderName' => $request->uploaderName,
                'uploaderEmail' => $request->uploaderEmail,
                'metadata' => mb_convert_encoding($exifIptcData, 'UTF-8', 'UTF-8') ?? null,
                'tempKatowice' => $tempKatowice ?? null,
                'size' => $fileSize ?? null,
                'resolution' => $resolution ?? null,
                'extension' => $extension ?? null,
            ]);

            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            $manager = new ImageManager(new Driver());
            $miniature = $manager->read(file_get_contents($request->image));
            $miniature->resize(50, 90);
            $miniature->save(storage_path('app/public').'/miniatures/' . $imageName);

            return response()->json([
                'message' => "Image successfully added."
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => "Something went really wrong, with message " . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        $imageItem = Image::find($id);
        if(!$imageItem) {
            return response()->json([
               'message' => 'Image Not Found.'
            ], 404);
        }

        $storage = Storage::disk('public');

        if($storage->exists($imageItem->image)) {
            $storage->delete($imageItem->image);
            $storage->delete('/miniatures/'. $imageItem->image);
        }

        $imageItem->delete();

        return response()->json([
            'message' => "Image successfully deleted."
        ], 200);
    }
}
