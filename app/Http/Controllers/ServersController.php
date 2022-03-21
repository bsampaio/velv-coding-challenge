<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateServersDataResource;
use App\Mappers\SearchableInformationMapper;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Shuchkin\SimpleXLSX;

class ServersController extends Controller
{
    const SOURCE_PATH = 'data-sources\\';

    //Upload file
    public function updateDataSource(UpdateServersDataResource $request)
    {
        $file = $request->file;

        if(!$this->storeDataSource($file)) {
            return response()->json([
                'The file can\'t be saved',
            ], 400);
        }
    }

    //Saves in storage
    private function storeDataSource(UploadedFile $file): bool
    {
        $uri = null;

        return Storage::putFileAs(self::SOURCE_PATH, $file, 'source.xlsx');
    }

    //Transform in rows
    public function readDataSource()
    {
        return Cache::remember('server-data-transformed', 360, function() {
            $data = $this->getTransformedData();
            return $data;
        });
    }

    /**
     * @throws Exception
     */
    public function getTransformedData()
    {
        $file = $this->getSourceFile();

        $data = SimpleXLSX::parse($file, true);
        $rows = $data->rows();
        if(is_array($rows) && count($rows) > 0) {
            $rows = array_slice($rows, 1);
            $mapper = new SearchableInformationMapper($rows);
            return $mapper->getServers();
        }

        return null;
    }

    public function getLocations()
    {
        return Cache::remember('server-locations-unique', 360, function() {
            $servers = collect($this->readDataSource());
            return $servers->pluck('location')->unique()->values();
        });
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getSourceFile(): string
    {
        $path = self::SOURCE_PATH . 'source.xlsx';

        if (!Storage::exists($path)) {
            throw new Exception();
        }

        $file = Storage::get($path);
        return $file;
    }
}
