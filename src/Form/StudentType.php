<?php

namespace App\Form;

use App\Entity\Student;
use App\Entity\Classroom; 
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nsc')
            ->add('email', EmailType::class)
            ->add('classroom', EntityType::class, [
                'class'=>Classroom::class, 'choice_label'=>'name'
            ]) // on met le type de l entite a laquelle on lie soit classroom 
            // et on met le champ qu on veut qu il apparaisse dans le formulaire soit name 
            ->add('submit', SubmitType::class)// boutton 
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
