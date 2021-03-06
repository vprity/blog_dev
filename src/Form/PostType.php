<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Заголовок',
                'required' => true,

            ])
            ->add('content', TextareaType::class, [
                'label' => 'Основной текст',
                'required' => false,
            ])
            ->add('category', EntityType::class, [
                'label' => 'Категория',
                'required' => true,
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('img_path', FileType::class, [
                'label' => 'Загрузить картинку',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png'
                        ],
                        'mimeTypesMessage' => 'Только {{ types }}',
                    ])
                ]
            ])
            ->add('tags', TagType::class, [
                'label' => 'Теги',
                'required' => true,
            ])
            ->add('post', SubmitType::class, [
                'label' => 'Опубликовать'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
