<?php
/**
 * Created by PhpStorm.
 * User: miyaye
 * Date: 18/2/5
 * Time: 下午6:18
 */

namespace Modules\Attribute\Namespaces;


use Modules\Attribute\Contracts\AttributesInterface;

class BaseNamespace implements AttributesInterface
{
    public static function getEntityNamespace()
    {
        return 'BaseNamespace';
    }
}