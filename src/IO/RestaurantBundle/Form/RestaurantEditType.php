<?php

namespace IO\RestaurantBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use IO\UserBundle\Form\UserManagerType;
use IO\UserBundle\Form\PhoneNumberType;
use IO\UserBundle\Form\AddressType;

class RestaurantEditType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', 'text', array(
                    'label' => 'Nom du restaurant',
                    'attr' => array('class' => 'form-control'),
                    'required' => true,
                    'constraints' => new NotBlank(array('message' => 'Veuillez renseigner le nom du restaurant')),
                ))
                ->add('address', new AddressType(), array(
                    'label' => 'Adresse du restaurant',
                    'required' => false,
                ))
                ->add('phone', new PhoneNumberType(), array(
                    'label' => 'Téléphone du restaurant',
                    'required' => false,
                ))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'IO\RestaurantBundle\Entity\Restaurant'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'restaurant';
    }

}
