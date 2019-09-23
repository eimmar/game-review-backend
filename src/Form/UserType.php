<?php


namespace App\Form;

use App\Entity\Model;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'constraints' => [new NotBlank(), new Length(array('min' => 4))]
            ])
            ->add('email', null, [
                'constraints' => [new NotBlank(), new Email()]
            ])
            ->add('password', null, [
                'constraints' => [new NotBlank(), new Length(array('min' => 4))]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true
        ]);
    }
}
