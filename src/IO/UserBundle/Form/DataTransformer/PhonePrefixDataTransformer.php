<?php

namespace IO\UserBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use IO\UserBundle\Enum\PhonePrefixEnum;

/**
 * Description of PhonePrefixDataTransformer
 *
 * @author vincent
 */
class PhonePrefixDataTransformer implements DataTransformerInterface
{

    public function transform($code)
    {
        return PhonePrefixEnum::getId($code);
    }
    
    public function reverseTransform($id)
    {
        return PhonePrefixEnum::getCode($id);
    }

}
