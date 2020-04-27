<?php


namespace App\Form\DataTransformer;


use App\Entity\Tag;
use App\Repository\TagRepository;
use Symfony\Component\Form\DataTransformerInterface;
use function Symfony\Component\String\u;

class TagArrayToStringTransformer implements DataTransformerInterface
{
    private $tags;

    public function __construct(TagRepository $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @inheritDocN
     */
    public function transform($tags): string
    {
        return implode(',', $tags);
    }

    /**
     * @inheritDoc
     */
    public function reverseTransform($string): array
    {
        if ($string === null || u($string)->isEmpty()) {
            return [];
        }

        $names = array_filter(array_unique(array_map('trim', u($string)->split(','))));

        $tags = $this->tags->findBy(['name' => $names]);

        $new_names = array_values(array_diff($names, $tags));

        foreach($new_names as $name) {
            $tag = new Tag();
            $tag->setName($name);
            $tags[] = $tag;
        }

        return $tags;
    }
}