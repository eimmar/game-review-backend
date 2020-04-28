<?php

namespace App\Form;

use Symfony\Component\Form\FormBuilderInterface;

class ReviewEditType extends ReviewType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder
            ->remove('game')
            ->remove('user');
    }
}
