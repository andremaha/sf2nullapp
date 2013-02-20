<?php

namespace SFScreenCasts\NullappBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('imageName')
            ->add('time')
            ->add('location')
            ->add('details')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SFScreenCasts\NullappBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'sfscreencasts_nullappbundle_eventtype';
    }
}
