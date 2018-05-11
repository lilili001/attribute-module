<?php

namespace Modules\Attribute\Repositories\Eloquent;

use Modules\Attribute\Repositories\AttributeRepository;
use Modules\Core\Repositories\Eloquent\EloquentBaseRepository;
use Modules\Product\Entities\Attrset;

class EloquentAttributeRepository extends EloquentBaseRepository implements AttributeRepository
{
    public function create($data)
    {
        $this->normalise($data);
        $attribute = $this->model->create($data);

        if(!empty( $data['attrset_id'] )){
            $attrset = Attrset::find($data['attrset_id']);
            $attribute->attrset()->sync( [$data['attrset_id']] );
            //$attrset->attrs()->sync( [$attribute->id] );
        }

        return $attribute;
    }
    
    public function update($attribute, $data)
    {
        $this->normalise($data);

        if(!empty( $data['attrset_id'] )){
            $attrset = Attrset::find($data['attrset_id']);
           // $attrset->attrs()->sync( [$attribute->id]  );
            $attribute->attrset()->sync( [$data['attrset_id']] );
        }

        $attribute->update($data);

        return $attribute;
    }

    /**
     * Find all enabled attributes by the given namespace
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findByNamespace($namespace)
    {
        return $this->model
            ->where('is_enabled', true)
            ->where('namespace', $namespace)
            ->where('has_translatable_values', false)
            ->with('translations')->get();
    }

    public function findByCondition( $key,$val )
    {
        return $this->model
            ->where($key,$val)
            ->with('translations')
            ->get();
    }
    /**
     * Find all enabled attributes by the given namespace that have translatable values
     * @param string $namespace
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findTranslatableByNamespace($namespace)
    {
        return $this->model
            ->where('is_enabled', true)
            ->where('namespace', $namespace)
            ->where('has_translatable_values', true)
            ->with('translations')->get();
    }

    private function normalise(array &$data)
    {
        $data['key'] = str_slug($data['key']);

        unset($data['options']['count']);

        $data['options'] = $this->formatOptions(array_get($data, 'options'));
    }

    private function formatOptions(array $options)
    {
        $cleaned = [];

        foreach ($options as $key => $option) {
            $value = $option['value'];
            unset($option['value']);
            foreach ($option as $locale => $item) {
                $cleaned[$value][$locale] = $item['label'];
            }
        }

        return $cleaned;
    }
    public function destroy($model)
    {
        $model->attrset()->detach();
        return $model->delete();
    }
}
