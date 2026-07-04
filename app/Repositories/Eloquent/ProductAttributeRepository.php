<?php

namespace App\Repositories\Eloquent;

use App\Models\ProductAttribute;
use App\Repositories\Interfaces\ProductAttributeRepositoryInterface;

class ProductAttributeRepository implements ProductAttributeRepositoryInterface
{
    public function getByProductId(int $productId)
    {
        return ProductAttribute::where('product_id', $productId)->get();
    }

    public function deleteByProductId(int $productId)
    {
        ProductAttribute::where('product_id', $productId)->delete();
    }

    public function bulkCreate(int $productId, array $attributes)
    {
        $records = [];
        foreach ($attributes as $attr) {
            if (!empty($attr['name']) && !empty($attr['value'])) {
                $records[] = [
                    'product_id' => $productId,
                    'name'       => $attr['name'],
                    'value'      => $attr['value'],
                ];
            }
        }

        if (!empty($records)) {
            ProductAttribute::insert($records);
        }
    }
}