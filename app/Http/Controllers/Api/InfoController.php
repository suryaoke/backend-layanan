<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Info;
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function infoAll()
    {
        $info = Info::orderBy('created_at', 'desc')->limit('10')->get();
        return response()->json(['info' => $info], 200);
    }

    public function show($imageName)
    {
        $path = public_path() . '/uploads/admin_images/' . $imageName;

        if (file_exists($path)) {
            $file = file_get_contents($path);
            $type = mime_content_type($path);

            return response($file)->header('Content-Type', $type);
        }

        return response()->json(['message' => 'Image not found.'], 404);
    }

    public function pdf($imageName)
    {
        $path = public_path() . '/pdf_files/' . $imageName;

        if (file_exists($path)) {
            $file = file_get_contents($path);
            $type = mime_content_type($path);

            return response($file)
                ->header('Content-Type', $type)
                ->header('Content-Disposition', 'inline; filename="' . $imageName . '"');
        }

        return response()->json(['message' => 'PDF not found.'], 404);
    }
}
