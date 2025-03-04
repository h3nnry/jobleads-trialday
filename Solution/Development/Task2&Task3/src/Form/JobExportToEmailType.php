<?php

namespace App\Form;

use App\Enum\JobExportFormat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class JobExportToEmailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $formats = array_column(JobExportFormat::cases(), 'value');
        $builder->add('format', ChoiceType::class, [
            'placeholder' => 'Select export format',
            'required' => true,
            'choices'  => array_combine($formats, $formats),
            'attr' => ['class' => 'form-select'],
        ]);

        $builder->add('email', EmailType::class, [
            'required' => true,
            'attr' => ['class' => 'form-control'],
        ]);

        $builder->add('save', SubmitType::class, [
            'attr' => ['class' => 'btn btn-primary'],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
