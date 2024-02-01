<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Objective extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $attributes = parent::toArray($request);

        $current_team =  auth()->user()->currentTeam;
        $attributes['isAdmin'] = auth()->user()->hasTeamPermission($current_team, 'objectives:read-all');
        return $attributes;
    }
}
