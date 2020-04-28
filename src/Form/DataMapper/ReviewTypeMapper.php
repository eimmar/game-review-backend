<?php

declare(strict_types=1);

namespace App\Form\DataMapper;

use App\Entity\Review;
use Symfony\Component\Form\DataMapperInterface;
use Symfony\Component\Form\FormInterface;
use Traversable;

class ReviewTypeMapper implements DataMapperInterface
{
    const DELIMITER = '|';

    /**
     * @param string|null $value
     * @return array
     */
    private function toArray(?string $value): array
    {
        return $value ? explode(self::DELIMITER, $value) : [];
    }

    /**
     * @param array $value
     * @return string
     */
    private function toString(array $value): string
    {
        if (!$value) {
            return '';
        }

        $value = array_map(function ($it) {
            return str_replace(self::DELIMITER, ' ', $it);
        }, $value);

        return implode(self::DELIMITER, $value);
    }

    /**
     * @param Review|null $data
     * @param FormInterface[]|Traversable $forms
     */
    public function mapDataToForms($data, $forms)
    {
        if ($data !== null) {
            $forms = iterator_to_array($forms);

            if (isset($forms['game'])) {
                $forms['game']->setData($data->getGame());
            }

            if (isset($forms['user'])) {
                $forms['user']->setData($data->getUser());
            }

            $forms['title']->setData($data->getTitle());
            $forms['comment']->setData($data->getComment());
            $forms['rating']->setData($data->getRating());

            $forms['cons']->setData($this->toArray($data->getCons()));
            $forms['pros']->setData($this->toArray($data->getPros()));
        }
    }

    /**
     * @param FormInterface[]|Traversable $forms
     * @param Review $data
     */
    public function mapFormsToData($forms, &$data)
    {
        $forms = iterator_to_array($forms);

        if (isset($forms['game'])) {
            $data->setGame($forms['game']->getData());
        }

        if (isset($forms['user'])) {
            $data->setUser($forms['user']->getData());
        }

        $data->setTitle($forms['title']->getData());
        $data->setComment($forms['comment']->getData());
        $data->setRating($forms['rating']->getData());

        $data->setPros($this->toString($forms['pros']->getData()));
        $data->setCons($this->toString($forms['cons']->getData()));
    }
}
