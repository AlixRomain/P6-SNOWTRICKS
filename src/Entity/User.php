<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"email"},
 *     message="Cette adresse mail est déjà utilisé sur la plateforme"
 * )
 */
class User implements UserInterface
{
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_USER = 'ROLE_USER';
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email
     */
    private $email;

    /**
     * @ORM\Column(type="string" , length=60)
     */
    private $roles = self::ROLE_USER;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     * @Assert\Length(
     *      min = 8,
     *      max = 254,
     *      minMessage = "Votre mot de passe doit contenir au moins 8 caractères.",
     *      maxMessage = "Votre mot de passe ne peut pas contenir plus que {{ limit }} caractères !"
     * )
     * @Assert\Regex(
     *     pattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W)^",
     *     match = true,
     *     message = "Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre et un caractère spécial !"
     * )
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $fname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar = 'avatar_default.jpg';

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $devise;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_create;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rgpd;

    /**
     * @ORM\Column(type="boolean")
     */
    private $actif = 0 ;

    /**
     * @return mixed
     */
    public function getActif()
    {
        return $this->actif;
    }

    /**
     * @param mixed $actif
     */
    public function setActif($actif): void
    {
        $this->actif = $actif;
    }

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_expir_token;

    private $path_directory;

    /**
     * @return mixed
     */
    public function getPathDirectory()
    {
        return $this->path_directory;
    }

    /**
     * @param mixed $path_directory
     */
    public function setPathDirectory($path_directory): void
    {
        $this->path_directory = $path_directory;
    }

    private $file;

    private $old_avatar;

    /**
     * @return mixed
     */
    public function getOldAvatar()
    {
        return $this->old_avatar;
    }

    /**
     * @param mixed $old_avatar
     */
    public function setOldAvatar($old_avatar): void
    {
        $this->old_avatar = $old_avatar;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {

        return [$this->roles];
    }
  /**
     * @see UserInterface
     */
    public function getRole(): string
    {

        return $this->roles;
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): self
    {
        $this->fname = $fname;

        return $this;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): self
    {
        $this->lname = $lname;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getDevise(): ?string
    {
        return $this->devise;
    }

    public function setDevise(?string $devise): self
    {
        $this->devise = $devise;

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

    public function getDateCreate(): ?\DateTimeInterface
    {
        return $this->date_create;
    }

    public function setDateCreate(\DateTimeInterface $date_create): self
    {
        $this->date_create = $date_create;

        return $this;
    }

    public function getRgpd(): ?bool
    {
        return $this->rgpd;
    }

    public function setRgpd(bool $rgpd): self
    {
        $this->rgpd = $rgpd;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getDateExpirToken(): ?\DateTimeInterface
    {
        return $this->date_expir_token;
    }

    public function setDateExpirToken(?\DateTimeInterface $date_expir_token): self
    {
        $this->date_expir_token = $date_expir_token;

        return $this;
    }
    public function getFile()
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file = null)
    {
        $this->file= $file;

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
        // Delete avatar from the server if update
        if ($this->id && $this->avatar !== 'avatar_default.jpg' && file_exists($this->path_directory.$this->old_avatar)) {
            unlink( $this->path_directory.$this->old_avatar);
        }
        // Moving image into the image repository
        $this->file->move($this->path_directory, $this->avatar);
    }

    /**
     * @ORM\PreRemove()
     */
    public function handleFileDelete()
    {
        // Delete image from the server if delete the trick && if file with this name exist
        if ($this->id && $this->avatar !== 'avatar.jpg' && file_exists($this->path_directory.$this->old_avatar)) {
            unlink( $this->path_directory.$this->old_avatar);
        }
    }


}
