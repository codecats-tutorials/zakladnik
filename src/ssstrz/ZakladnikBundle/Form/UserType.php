<?php

namespace ssstrz\ZakladnikBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
           // ->add('password')
            ->add('email')
           // ->add('isActive')
        ;
        $builder->add('password', 'repeated', array(
            'first_name'    => 'password',
            'second_name'   => 'confirm',
            'type'          => 'password'
        ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ssstrz\ZakladnikBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ssstrz_zakladnikbundle_user';
    }
}
