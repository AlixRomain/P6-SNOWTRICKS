<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TricksRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Tricks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $author_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=0, minMessage="Vous devez donner un nom à votre tricks", allowEmptyString="false")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $update_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     *
     */
    private $main_image;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="tricks")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Media::class, mappedBy="tricks",cascade={"persist","remove"})
     */
    private $media;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="tricks", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="tricks",cascade={"persist","remove"})
     */
    private $videos;

    private $path;


    /**
     * @Assert\Image(
     *      maxSize = "1M",
     *      maxSizeMessage = "L'image principal ne doit pas dépasser 1 Mo",
     *      minWidth="600",
     *      minWidthMessage="L'image principal doit faire plus de 600 px",
     *      mimeTypes={"image/jpeg","image/jpg"},
     *      mimeTypesMessage="L'extension ({{ type }}) est invalide. Seul l'extension {{ types }} est acceptée."
     * )
     */
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
    public function __construct()
    {
        $this->category = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->videos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorId(): ?User
    {
        return $this->author_id;
    }

    public function setAuthorId(?User $author_id): self
    {
        $this->author_id = $author_id;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(?\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->main_image;
    }

    public function setMainImage(string $main_image): self
    {
        $this->main_image = $main_image;

        return $this;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategory(): Collection
    {
        return $this->category;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->category->contains($category)) {
            $this->category[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->category->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Media[]
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): self
    {
        if (!$this->media->contains($medium)) {
            $this->media[] = $medium;
            $medium->setTricks($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): self
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getTricks() === $this) {
                $medium->setTricks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTricks($this);
        }
        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTricks() === $this) {
                $comment->setTricks(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTricks($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getTricks() === $this) {
                $video->setTricks(null);
            }
        }
        return $this;
    }


    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * @ORM\PreFlush()
     */
    public function handleFile()
    {
        if ($this->file === null) {
            return;
        }
        // Delete image from the server if update
        if ($this->id && $this->main_image !== 'default-image.jpg' && file_exists($this->path.$this->old_path)) {
            unlink( $this->path.$this->old_path);
        }
        // Moving image into the image repository
        $this->file->move($this->path, $this->main_image);
    }

    /**
     * @ORM\PreRemove()
     */
    public function handleFileDelete()
    {
        // Delete image from the server if delete the trick && if file with this name exist
        if ($this->id && $this->main_image !== 'default-image.jpg' && file_exists($this->path.$this->old_path)) {
            unlink( $this->path.$this->old_path);
        }
    }
}

