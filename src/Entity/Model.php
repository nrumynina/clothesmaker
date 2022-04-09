<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ModelRepository;

/**
 * @ORM\Entity(repositoryClass=ModelRepository::class)
 */
class Model
{
    public const SIZES = [
        'm-man' => 'M Мужчины',
        'xl-man' => 'XL Мужчины',
        'l-man' => 'L Мужчины',
    ];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, options={"default": ""})
     */
    private $SKU = '';

    /**
     * @var string|null
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @var ArrayCollection<Image>
     *
     * @ORM\OneToMany(targetEntity="Image", mappedBy="model", cascade={"persist"}, orphanRemoval=true)
     */
    private $images;

    /**
     * @var string[]|null
     *
     * @ORM\Column(type="simple_array", nullable=true)
     */
    private $sizes = null;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSKU(): string
    {
        return $this->SKU;
    }

    public function setSKU(string $SKU): self
    {
        $this->SKU = $SKU;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return ArrayCollection<Image>
     */
    public function getImages()
    {
        return $this->images;
    }

    public function addImage(Image $image): self
    {
        $image->setModel($this);
        $this->images->add($image);

        return $this;
    }

    public function removeImage(Image $image): self
    {
        $this->images->removeElement($image);

        return $this;
    }

    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    public function setSizes(?array $sizes): self
    {
        $this->sizes = $sizes;
        return $this;
    }
}
