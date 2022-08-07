<?php
// src/Form/Type/TaskType.php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;

class EmployeeSignUpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('Name', TextType::class,[
            // set it to FALSE to not display the label for this field
            'attr' => ['class'  => 'col-sm-12',]
        ])
        ->add('Dept', TextType::class, [
            // set it to FALSE to not display the label for this field
            'attr' => ['class'  => 'col-sm-12',]
        ])
        ->add('Salary', IntegerType::class, [
            // set it to FALSE to not display the label for this field
            'attr' => ['class'  => 'col-sm-12',]
        ])
        ->add('Designation', TextType::class, [
            // set it to FALSE to not display the label for this field
            'attr' => ['class'  => 'col-sm-12',]
        ])
        ->add('save', SubmitType::class)
    ;
    }
}
