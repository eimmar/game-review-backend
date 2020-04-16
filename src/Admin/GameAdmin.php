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
            ->add('name', TextType::class)
            ->add('gameSpotAssociation', TextType::class, ['required' => false])
            ->add('summary', TextareaType::class, ['required' => false])
            ->add('storyline', TextareaType::class, ['required' => false])
            ->add('releaseDate', DateTimeType::class, ['years' => range(1958, date('Y') + 10), 'required' => false]);
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('coverImage')
            ->add('name')
            ->add('category')
            ->add('rating')
            ->add('ratingCount')
            ->add('releaseDate')
            ->add('gameSpotAssociation');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('coverImage', null, ['template' => 'Admin/list_image.html.twig'])
            ->addIdentifier('name')
            ->addIdentifier('category', 'trans')
            ->addIdentifier('rating')
            ->addIdentifier('ratingCount')
            ->addIdentifier('releaseDate')
            ->addIdentifier('gameSpotAssociation');
    }
}
