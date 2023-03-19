<?php

namespace App\Entity;

use App\Repository\GuideUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GuideUserRepository::class)]
class GuideUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $texto_inicial = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $texto_adicional = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $url_img = null;

    public function __toString(): string
    {
        return (string)$this->getNombre();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getTextoInicial(): ?string
    {
        return $this->texto_inicial;
    }

    public function setTextoInicial(string $texto_inicial): self
    {
        $this->texto_inicial = $texto_inicial;

        return $this;
    }

    public function getTextoAdicional(): ?string
    {
        return $this->texto_adicional;
    }

    public function setTextoAdicional(?string $texto_adicional): self
    {
        $this->texto_adicional = $texto_adicional;

        return $this;
    }

    public function getUrlImg(): ?string
    {
        return $this->url_img;
    }

    public function setUrlImg(?string $url_img): self
    {
        $this->url_img = $url_img;

        return $this;
    }
}
