<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Indicates if the resource's collection keys should be preserved.
     *
     * @var bool
     */
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if (isset($this->id))
            $data = [
                'id' => $this->id,
                'date' => $this->date,
                'title' => $this->title,
                'amount' => round($this->amount, 2),
            ];

        if (isset($this->summary))
            $data['summary'] = $this->summary;

        return $data;
    }
}
