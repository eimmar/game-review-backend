<?php

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
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
        $object->setAvatarFile($this->getForm()->get('avatarFile')->getData());

        $this->getConfigurationPool()->getContainer()->get('fos_user.user_manager')->updateUser($object);
    }

    /**
     * @param User $object
     */
    public function preUpdate($object)
    {
        $object->setAvatarFile($this->getForm()->get('avatarFile')->getData());
    }

    public function configureActionButtons($action, $object = null)
    {
        $actions = parent::configureActionButtons($action, $object);
        if ($action === 'edit' && $this->canAccessObject('edit', $object) && $this->hasRoute('edit')) {
            $actions['resetPassword'] = ['template' => 'admin/user/reseting_button.html.twig'];
        }

        return $actions;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', TextType::class, [
                'label' => 'user.username',
                'constraints' => [
                    new NotBlank(),
                    new Regex(['pattern' => '/^[a-zA-Z0-9_]+$/']),
                    new Length(['min' => 4])
                ]
            ])
            ->add('email', EmailType::class, ['label' => 'user.email'])
            ->add('firstName', TextType::class, ['label' => 'user.first_name'])
            ->add('lastName', TextType::class, ['required' => false, 'label' => 'user.last_name'])
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
            )
            ->add('avatarFile', VichImageType::class, [
                'label' => 'user.avatar',
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2500k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/jpeg',
                            'image/png',
                        ],
                    ])
                ],
            ]);

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
            ->add('username', null, ['label' => 'user.username'])
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
            ->addIdentifier('username', null, ['label' => 'user.username'])
            ->addIdentifier('firstName', null, ['label' => 'user.first_name'])
            ->addIdentifier('lastName', null, ['label' => 'user.last_name'])
            ->addIdentifier('email', null, ['label' => 'user.email']);
    }
}
