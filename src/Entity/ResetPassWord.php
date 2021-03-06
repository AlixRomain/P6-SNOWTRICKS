<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class ResetPassWord
{
    /**
     * @Assert\Email()
     */
    private $email;

    private $password;


    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
}

