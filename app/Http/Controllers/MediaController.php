<?php

namespace App\Http\Controllers;

use App\Models\Media;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Helpers\SettingHelper;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManager;

class MediaController extends Controller
{
    public function index()
    {
        $medias = Media::get();
        return $medias;
    }

    public function getPreviewFiles(Request $request)
    {
        $ids = explode(',', $request->ids);
        $files = Media::whereIn('id', $ids)->get();
        $new_file_array = [];
        foreach ($files as $file) {

            $file['file_name'] =url('storage/'. $file->file_name);
            $new_file_array[] = $file;

        }

        return $new_file_array;
    }

    // public function store(Request $request)
    // {
    //     if ( !empty($request->image) ) {

    //         $media = new Media();

    //         $image = $request->image;
    //         $ext = strtolower($image->getClientOriginalExtension() );

    //         $media->file_original_name = null;

    //         $arr = explode('.', $request->file('image')->getClientOriginalName());
    //         for ($i = 0; $i < count($arr) - 1; $i++) {
    //                 if ($i == 0) {
    //                     $media->file_original_name .= $arr[$i];
    //                 } else {
    //                     $media->file_original_name .= "." . $arr[$i];
    //                 }
    //         }

    //         $path = $request->file('image')->store('', 'public');

    //         // add watermark
    //         if ( SettingHelper::get_field('make_upload_image_watermark') ) {
    //             $manager = ImageManager::gd();
    //             $readImage = $manager->read(public_path('/storage/'.$path));
    //             $readImage->place(
    //                 public_path('images/cs.png'),
    //                 'bottom-left',
    //                 10,
    //                 10,
    //                 25
    //             );
    //             $storagePath = storage_path('app/public/'.$path);
    //             $readImage->save($storagePath);
    //         }

    //         // $size = $request->file('image')->getSize();
    //         $media->extension = $ext;
    //         $media->file_name = $path;
    //         $media->user_id = Auth::user()->id;
    //         $media->type = $image->getClientMimeType();
    //         $media->file_size = $image->getSize();
    //         $media->alt = NULL;
    //         $media->caption = NULL;
    //         $media->description = NULL;
    //         $media->save();

    //         return response()->json([
    //             'status' => true,
    //             'image_id' => $media->id,
    //             'name' => $path,
    //             'imagePath' => asset('storage/'.$path)
    //         ]);

    //     }
    // }

    public function store(Request $request)
{
    if (!empty($request->image)) {

        $media = new Media();

        $image = $request->image;
        $ext = strtolower($image->getClientOriginalExtension());

        // Extract the original name for SEO purposes
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $seoFriendlyName = Str::slug($originalName) . '-' . time() . '.' . $ext;
        // $seoFriendlyName = Str::slug($originalName) . '-' . time() . '-' . uniqid() . '.' . $ext;

        // Define the storage path with year and month structure
        $year = date('Y');
        $month = date('m');
        $path = $request->file('image')->storeAs("uploads/{$year}/{$month}", $seoFriendlyName, 'public');

        // Set media properties
        $media->file_original_name = $originalName;
        $media->extension = $ext;
        $media->file_name = $path;
        $media->user_id = Auth::user()->id;
        $media->type = $image->getClientMimeType();
        $media->file_size = $image->getSize();
        $media->alt = NULL;
        $media->caption = NULL;
        $media->description = NULL;
        $media->save();

        return response()->json([
            'status' => true,
            'image_id' => $media->id,
            'name' => $seoFriendlyName,
            'imagePath' => asset('storage/' . $path)
        ]);
    }
}

    // loadmore media
    public function loadMoreMedia(Request $request)
    {
        $offset = $request->offset; // Offset to determine which records to load
        $limit = $request->limit; // Number of records to load each time

        $media = Media::latest()->offset($offset)->limit($limit)->get();

        return response()->json($media);
    }
}
