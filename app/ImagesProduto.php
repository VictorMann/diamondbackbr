<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Http\CustomerCollection\OrderImages;

class ImagesProduto extends Model
{
    public $timestamps = false;

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }

    public function newCollection(array $models = [])
    {
        $orderImages = new OrderImages($models);
		return $orderImages->ordena();
	}
}
