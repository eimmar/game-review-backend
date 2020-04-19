<?php

namespace App\Form;

use App\Entity\Review;
use App\Form\DataMapper\ReviewTypeMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;

class ReviewType extends AbstractType
{
    private ReviewTypeMapper $reviewTypeMapper;

    /**
     * @param ReviewTypeMapper $reviewTypeMapper
     */
    public function __construct(ReviewTypeMapper $reviewTypeMapper)
    {
        $this->reviewTypeMapper = $reviewTypeMapper;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('game')
            ->add('user')
            ->add('title')
            ->add('comment')
            ->add('rating')
            ->add('cons', CollectionType::class, [
                'entry_options' => ['constraints' => [new Length(['max' => 99])]],
                'constraints' => [new Count(['max' => 10])],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->add('pros', CollectionType::class, [
                'entry_options' => ['constraints' => [new Length(['max' => 99])]],
                'constraints' => [new Count(['max' => 10])],
                'allow_add' => true,
                'allow_delete' => true,
            ])
            ->setDataMapper($this->reviewTypeMapper);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Review::class]);
    }
}
