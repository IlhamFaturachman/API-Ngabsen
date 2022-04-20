<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class attendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $data = $this;

        $late = [];

        $onTime = [];

        foreach( $data as $key => $value){
            if($value){
                array_push($late , $value);
            }
        }
        
        return [
            "late" => $late,
            "late_num" => count($late),
            "onTime" => $onTime,
            "onTime_num" => count($onTime)
        ];
    }
}
