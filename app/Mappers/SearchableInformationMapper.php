<?php

namespace App\Mappers;

use App\Domains\Server;

class SearchableInformationMapper
{
    protected array $servers = [];

    public function __construct(array $items)
    {
        foreach ($items as $item) {
            $server = new Server($item[0], $item[1], $item[2], $item[3], $item[4]);
            $this->servers[] = $server->toArray();
        }
    }

    public function getServers(): array
    {
        return $this->servers;
    }
}
