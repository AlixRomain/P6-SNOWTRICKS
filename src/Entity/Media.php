<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Media
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tricks::class, inversedBy="media")
     */
    private $tricks;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;


    private $file;

    private $old_path;

    /**
     * @return mixed
     */
    public function getOldPath()
    {
        return $this->old_path;
    }

    /**
     * @param mixed $old_path
     */
    public function setOldPath($old_path): void
    {
        $this->old_path = $old_path;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    private $pathDirectory;

    public function getPathDirectory()
    {
        return $this->pathDirectory;
    }

    public function setPathDirectory($pathDirectory)
    {
        $this->pathDirectory = $pathDirectory;

        return $this;
    }

    /**
     * @return Tricks|null
     */
    public function getTricks(): ?Tricks
    {
        return $this->tricks;
    }

    public function setTricks(?Tricks $tricks): self
    {
        $this->tricks = $tricks;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @param string|null $path
     *
     * @return Media
     */
    public function setPath( ?string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile|null $file
     *
     * @return $this
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }
    /**
     * @ORM\PreFlush()
     */
    public function handleImage()
    {
        if ($this->file === null) {
            return;
        }

        // If update
        if ($this->id) {
            unlink($this->pathDirectory.$this->old_path);
        }
        // Moving image into the image repository
        $this->file->move($this->pathDirectory, $this->path);

    }
    private  $tempFilename;
    /**
     * @ORM\PreRemove()
     */
    public function preRemoveUpload()
    {
        // Saving image name (after removing from database, the image name doesn't exist anymore)
        $this->tempFilename = $this->path . '/' . $this->name;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        // We doesn't have the id, we use the image name
        if (file_exists($this->tempFilename)) {
            // Deleting the file
            unlink($this->tempFilename);
        }
    }

}
