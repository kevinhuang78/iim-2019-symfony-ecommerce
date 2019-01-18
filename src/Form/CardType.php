<?php

namespace App\Form;

use App\Model\Card;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Luhn;
use Symfony\Component\Validator\Constraints\Regex;

class CardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $months = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = $i < 10 ? ('0' . $i) : $i;
            $months[$month] = $month;
        }

        $years = [];
        for ($i = date('Y'); $i <= (date('Y') + 10); $i++) {
            $years[$i] = $i;
        }

        $builder->add('number', TextType::class, [
            'constraints' => new Luhn()
        ]);
        $builder->add('month', ChoiceType::class, [
            'choices' => $months
        ]);
        $builder->add('year', ChoiceType::class, [
            'choices' => $years
        ]);
        $builder->add('cvv', TextType::class, [
            'constraints' => new Regex('/[0-9]{3}/')
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Card::class
        ]);
    }
}
