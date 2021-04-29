<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;


class PasswordForgot
{
    /**
     * @Assert\NotBlank(
     *      message = "Ce champ est requis !"
     * )
     */
    private $email;


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
}


