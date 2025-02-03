<?php

namespace App\Form;

use App\DTO\StoreDto;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StoreFromType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file', FileType::class, ['required' => true])
            ->add('arrival_date', TextType::class, ['required' => true])
            ->add('custom', TextType::class, ['required' => true])
            ->add('vehicle_number', TextType::class, ['required' => true])
            ->add('vehicle_country', TextType::class, ['required' => true ])
            ->add('vehicle_type', TextType::class, ['required' => true ])
            ->add('vehicle_vin_type', TextType::class, ['required' => true ])
            ->add('vehicle_vin', TextType::class, ['required' => true ])
            ->add('vehicle_brand', TextType::class, ['required' => true ])
            ->add('vehicle_model', TextType::class, ['required' => true ])
            ->add('last_name', TextType::class, ['required' => true ])
            ->add('first_name', TextType::class, ['required' => true ])
            ->add('middle_name', TextType::class, ['required' => true ])
            ->add('personal_number', TextType::class, ['required' => true ])
            ->add('driver_country', TextType::class, ['required' => true ])
            ->add('identity_card_kind', TextType::class, ['required' => true ])
            ->add('doc_series', TextType::class, ['required' => true ])
            ->add('doc_number', TextType::class, ['required' => true ])
            ->add('active_tab', TextType::class, ['required' => true ])
            ->add('input_option', TextType::class, ['required' => true ])
            ->add('trailer', TextType::class, ['required' => true ])
            ->add('container', TextType::class, ['required' => true ])
            ->add('trailer_number', TextType::class, ['required' => false ])
            ->add('trailer_country', TextType::class, ['required' => false ])
            ->add('trailer_type', TextType::class, ['required' => false ])
            ->add('trailer_vin_type', TextType::class, ['required' => false ])
            ->add('trailer_vin', TextType::class, ['required' => false ])
            ->add('trailer_brand', TextType::class, ['required' => false ])
            ->add('trailer_model', TextType::class, ['required' => false ])
            ->add('container_number', TextType::class, ['required' => false ])
            ->add('container_country', TextType::class, ['required' => false ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StoreDto::class,
        ]);
    }
}
