<?php

namespace App\Http\Controllers;

use App\Classes\Responses\InvalidResponse;
use App\Classes\Responses\ResponseStrings;
use App\Classes\Responses\ValidResponse;
use App\Models\Song;
use App\Traits\AuthTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    const ABILITY = 'music';

    public function uploadSong(Request $request)
    {
        $validateData = $request->validate([
            'title' => 'required|string|min:3|max:255|unique:song,name',
            'genre' => 'required|string',
            'album_id' => 'required',
            'artist_id' => 'required',
            'song' => 'required|file',
            'pat' => 'required|string',
        ]);

        if (AuthTrait::checkAbility(self::ABILITY, $validateData['pat']))
        {
            $path = Storage::disk('azure-file-storage')->put("" ,$request->file('song'));

            $song = new Song([
                'name' => $validateData['title'],
                'genre' => $validateData['genre'],
                'album_id' => $validateData['album_id'],
                'artist_id' => $validateData['artist_id'],
                'resourceLocation' => $path,
                'releaseDate' => now(),
            ]);

            $song->save();

            if($song)
            {
                $response = new ValidResponse($song);
                return response()->json($response, 201);
            }
            $response = new InvalidResponse(ResponseStrings::INTERNAL_ERROR);
            return response()->json($response, 500);
        }
        $response = new InvalidResponse(ResponseStrings::UNAUTHORIZED);
        return response()->json($response, 401);
    }

    public function deleteSong(Request $request)
    {
        $validateData = $request->validate([
            'song_id' => 'required|string',
            'pat' => 'required|string',
        ]);

        if (AuthTrait::checkAbility(self::ABILITY, $validateData['pat']))
        {
            $song = Song::find($validateData['song_id']);
            Storage::delete($song->resourceLocation);
            $song->delete();
            $response = new ValidResponse(ResponseStrings::DELETED);
            return response()->json($response, 200);
        }
        $response = new InvalidResponse(ResponseStrings::UNAUTHORIZED);
        return response()->json($response, 401);
    }

    public function getSong(Request $request)
    {
        $validateData = $request->validate([
            'song_id' => 'integer',
            'pat' => 'required',
        ]);

        if (AuthTrait::checkAbility(self::ABILITY, $validateData['pat']))
        {
            if (isset($validateData['song_id']))
            {
                $song = Song::find($validateData['song_id']);
                if ($song)
                {
                    $response = new ValidResponse($song);
                    return response()->json($response, 200);
                }
                $response = new InvalidResponse(ResponseStrings::NOT_FOUND);
                return response()->json($response, 404);
            }
            else
            {
                $songs = Song::all();
                if ($songs)
                {
                    $response = new ValidResponse($songs);
                    return response()->json($response, 200);
                }
                $response = new InvalidResponse(ResponseStrings::NOT_FOUND);
                return response()->json($response, 404);
            }
        }
        $response = new InvalidResponse(ResponseStrings::UNAUTHORIZED);
        return response()->json($response, 401);
    }

}
