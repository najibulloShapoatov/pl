<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class SiteProperty extends Model
{
    protected $fillable =[
        'prop_name',
        'prop_value',
    ];
    public function getByPropName($propName)
    {
        return $this->where('prop_name', $propName)->get()->first();
    }

    public function setByPropName($propName, $propVal)
    {
        $prop = $this->getByPropName($propName);
        $prop->prop_value = $propVal;
        $prop->save();

        return $prop->prop_value;
    }

    public function checkPropName($propName){
        return $this->where('prop_name', $propName)->exists();
    }

    public function createProp($propName, $propValue = null){
        $st = new SiteProperty();
        $st->prop_name = $propName;
        $st->prop_value = $propValue;
        $st->save();
        return $st;
    }
}
