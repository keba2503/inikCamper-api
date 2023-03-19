<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Repository\GuideUserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: GuideUserRepository::class)]
#[ApiResource(
    operations: [
        new Get(normalizationContext: ['groups' => 'guideuser:item']),
        new GetCollection(normalizationContext: ['groups' => 'guideuser:list'])
    ],
    paginationEnabled: false,
)]
class GuideUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['guideuser:list', 'guideuser:item'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['guideuser:list', 'guideuser:item'])]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['guideuser:list', 'guideuser:item'])]
    private ?string $texto_inicial = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['guideuser:list', 'guideuser:item'])]
    private ?string $texto_adicional = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['guideuser:list', 'guideuser:item'])]
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
