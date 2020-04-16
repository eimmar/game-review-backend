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

use App\Entity\User;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

final class UserAdmin extends AbstractAdmin
{
    /**
     * @param User $object
     */
    public function prePersist($object)
    {
        if ($object->hasRole('ROLE_SUPER_ADMIN')) {
            $object->setSuperAdmin(true);
        }

        $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager')->updateUser($object);
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('firstName', TextType::class, ['label' => 'user.first_name'])
            ->add('lastName', TextType::class, ['required' => false, 'label' => 'user.last_name'])
            ->add('email', EmailType::class, ['label' => 'user.email'])
            ->add('enabled', CheckboxType::class, ['required' => false, 'label' => 'user.enabled'])
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'label' => 'user.roles',
                    'choices' => [
                        'user.role.user' => 'ROLE_USER',
                        'user.role.admin' => 'ROLE_ADMIN',
                        'user.role.super_admin' => 'ROLE_SUPER_ADMIN',
                    ],
                    'multiple'=>true
                ]
            );

        if ($this->getSubject()->getId() === null) {
            $formMapper->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'user.password'],
                'second_options' => ['label' => 'user.repeat_password']
            ]);
        }
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('enabled', null, ['label' => 'user.enabled'])
            ->add('firstName', null, ['label' => 'user.first_name'])
            ->add('lastName', null, ['label' => 'user.last_name'])
            ->add('email', null, ['label' => 'user.email']);
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('enabled', null, ['label' => 'user.enabled'])
            ->addIdentifier('firstName', null, ['label' => 'user.first_name'])
            ->addIdentifier('lastName', null, ['label' => 'user.last_name'])
            ->addIdentifier('email', null, ['label' => 'user.email']);
    }
}
