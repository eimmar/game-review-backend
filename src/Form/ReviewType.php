<?php

namespace App\Form;

use App\Entity\Review;
use App\Form\DataMapper\ReviewTypeMapper;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

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
            ->add('title', TextType::class, ['constraints' => [new NotBlank(), new Length(['max' => 255])]])
            ->add('comment', TextType::class, ['constraints' => [new NotBlank(), new Length(['max' => 10000])]])
            ->add('rating', IntegerType::class, ['constraints' => [new NotBlank(), new Range(['max' => 10, 'min' => 1])]])
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
