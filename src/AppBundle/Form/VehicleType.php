<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehicleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $vehicleTypes = $options['vehicle_types'];

        $builder
            ->add('name', 'Symfony\Component\Form\Extension\Core\Type\ChoiceType', array(
                'multiple' => false,
                'expanded' => false,
                'choices' => $vehicleTypes,
                'placeholder' => 'Select an option',
            ))
        ;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) {
                $form = $event->getForm();
                $vehicle = $event->getData();
                $vehicleName = $vehicle->getName();

                if (in_array($vehicleName, array('Car', 'Truck')))
                {
                    $form->add('gas');
                } else {
                    $form->remove('gas');
                }
            }
        );

        $builder->get('name')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();

                // It's important here to fetch $event->getForm()->getData(), as
                // $event->getData() will get you the client data (that is, the ID)
                $vehicleName = $form->getData();

                if (in_array($vehicleName, array('Car', 'Truck')))
                {
                    $form->getParent()->add('gas');
                } else {
                    $form->getParent()->remove('gas');
                }
            }
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Vehicle',
            'vehicle_types' => null
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_vehicle';
    }


}
