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

namespace App\Form\Admin;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;

class IGDBRequestBodyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('where', null, ['label' => 'igdb.request.where', 'empty_data' => ''])
            ->add('sort', null, ['label' => 'igdb.request.sort', 'empty_data' => ''])
            ->add('search', null, ['label' => 'igdb.request.search', 'empty_data' => ''])
            ->add('limit', NumberType::class, [
                'constraints' => [new Range(['min' => 0, 'max' => 500])],
                'required' => true,
                'label' => 'igdb.request.limit',
                'empty_data' => 10,
                'data' => 10
            ])
            ->add('offset', NumberType::class, [
                'constraints' => [new Range(['min' => 0, 'max' => 5000])],
                'required' => true,
                'label' => 'igdb.request.offset',
                'empty_data' => 0,
                'data' => 0
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => RequestBody::class]);
    }
}
