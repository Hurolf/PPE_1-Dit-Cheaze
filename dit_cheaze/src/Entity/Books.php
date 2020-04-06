<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * @UniqueEntity("Titles")
 * @ORM\Entity(repositoryClass="App\Repository\BooksRepository")
 */
class Books
{


    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length(min="5", max="50")
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "^[a-zA-Z]+$"
     * )
     *
     */
    private $Titles;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\Length(min="5", max="150")
     * @Assert\Regex(
     *     pattern     = "/^[a-zA-Z]/"
     * )
     *
     */
    private $Descriptions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $BackImage;


    /**
     * @ORM\Column(type="integer")
     */
    private $CountImages;


    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitles(): ?string
    {
        return $this->Titles;
    }

    public function setTitles(string $Titles): self
    {
        $this->Titles = $Titles;

        return $this;
    }

    public function getDescriptions(): ?string
    {
        return $this->Descriptions;
    }

    public function setDescriptions(string $Descriptions): self
    {
        $this->Descriptions = $Descriptions;

        return $this;
    }

    public function getSlug(): ?string
    {
        return (new Slugify())->slugify($this->Titles);

    }

    public function getBackImage()
    {
        return $this->BackImage;
    }


    public function setBackImage($BackImage)
    {
        if($BackImage instanceof UploadedFile){
            $this->updated_at= new \DateTime('now');
        }

        $this->BackImage = $BackImage;

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountImages()
    {
        return $this->CountImages;
    }

    /**
     * @param mixed $CountImages
     */
    public function setCountImages($CountImages): void
    {
        $this->CountImages = $CountImages;
    }

}
