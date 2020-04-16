<?php

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */

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
            ->add('approved', CheckboxType::class, ['required' => false])
            ->add('game', EntityType::class, ['class' => Game::class])
            ->add('user', EntityType::class, ['class' => User::class])
            ->add('title', TextType::class)
            ->add(
                'rating',
                NumberType::class,
                [
                    'constraints' => [new Range(['min' => 1, 'max' => 10])]
                ]
            )
            ->add('comment', TextareaType::class, ['required' => false])
            ->add('pros', TextareaType::class, ['required' => false])
            ->add('cons', TextareaType::class, ['required' => false]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('approved')
            ->add('game')
            ->add('user')
            ->add('title')
            ->add('rating');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('approved')
            ->addIdentifier('game')
            ->addIdentifier('user')
            ->addIdentifier('title')
            ->addIdentifier('rating');
    }
}
