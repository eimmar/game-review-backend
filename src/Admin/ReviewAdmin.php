<?php

declare(strict_types=1);

namespace App\Admin;

use App\Entity\Game;
use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Range;

final class ReviewAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('approved', CheckboxType::class, ['required' => false, 'label' => 'review.approved'])
            ->add('game', EntityType::class, ['class' => Game::class, 'label' => 'review.game'])
            ->add('user', EntityType::class, ['class' => User::class, 'label' => 'review.user'])
            ->add('title', TextType::class, ['label' => 'review.title'])
            ->add(
                'rating',
                NumberType::class,
                [
                    'constraints' => [new Range(['min' => 1, 'max' => 10])],
                    'label' => 'review.rating'
                ]
            )
            ->add('comment', TextareaType::class, ['required' => false, 'label' => 'review.comment'])
            ->add('pros', TextareaType::class, ['required' => false, 'label' => 'review.pros'])
            ->add('cons', TextareaType::class, ['required' => false, 'label' => 'review.cons']);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('approved', null, ['label' => 'review.approved'])
            ->add('game', null, ['label' => 'review.game'])
            ->add('user', null, ['label' => 'review.user'])
            ->add('title', null, ['label' => 'review.title'])
            ->add('rating', null, ['label' => 'review.rating']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('approved', null, ['label' => 'review.approved'])
            ->addIdentifier('game', null, ['label' => 'review.game'])
            ->addIdentifier('user', null, ['label' => 'review.user'])
            ->addIdentifier('title', null, ['label' => 'review.title'])
            ->addIdentifier('rating', null, ['label' => 'review.rating']);
    }
}
