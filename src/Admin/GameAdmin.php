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

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class GameAdmin extends AbstractAdmin
{
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->remove('create');
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', TextType::class, ['label' => 'game.name'])
            ->add('gameSpotAssociation', TextType::class, ['required' => false, 'label' => 'game.game_spot_association'])
            ->add('summary', TextareaType::class, ['required' => false, 'label' => 'game.summary'])
            ->add('storyline', TextareaType::class, ['required' => false, 'label' => 'game.storyline'])
            ->add('releaseDate', DateTimeType::class, [
                'years' => range(1958, date('Y') + 10),
                'required' => false,
                'label' => 'game.release_date'
            ]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name', null, ['label' => 'game.name'])
            ->add('rating', null, ['label' => 'game.rating'])
            ->add('ratingCount', null, ['label' => 'game.rating_count'])
            ->add('releaseDate', null, ['label' => 'game.release_date'])
            ->add('gameSpotAssociation', null, ['label' => 'game.game_spot_association']);
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('coverImage', null, ['template' => 'Admin/list_image.html.twig', 'label' => 'game.cover_image'])
            ->addIdentifier('name', null, ['label' => 'game.name'])
            ->addIdentifier('rating', null, ['label' => 'game.rating'])
            ->addIdentifier('ratingCount', null, ['label' => 'game.rating_count'])
            ->addIdentifier('releaseDate', null, ['label' => 'game.release_date'])
            ->addIdentifier('gameSpotAssociation', null, ['label' => 'game.game_spot_association']);
    }
}
