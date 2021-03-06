<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\MenuAddController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use PhpParser\Node\Expr\Cast;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\Cascade;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
        "status" => Response::HTTP_OK,
        "normalization_context" =>['groups' => ['menu:read:simple']]
    ],
    "post"=>[
        "denormalization_context" =>['groups' => ['write']], 
    ]
],
     itemOperations:[
        "put"=>[
            "security"=>"is_granted('ROLE_GESTIONAIRE')",
            "security_message"=>"Access denied in this ressource"
        ],
        "get" =>[
                "status" => Response::HTTP_OK,
                "normalization_context" =>['groups' => ['menu:read:all']],
        ]
        ]
    )]

class Menu extends Produit
{
    #[Groups(['write','menu:read:simple'])]
    protected $nom;

    #[Groups(['write','menu:read:simple'])]
    protected $image;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBoisson::class,cascade:['persist'])]
    #[Groups(['write','menu:read:simple'])]
        #[SerializedName('Boissons')]
    
    private $menuBoissons;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:['persist'])]
    #[Groups(['write','menu:read:simple'])]
        #[SerializedName('Burgers')]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuFrite::class,cascade:['persist'])]
    #[Groups(['write','menu:read:simple'])]
        #[SerializedName('Frites')]
    private $menuFrites;

    public function __construct()
    {
        parent::__construct();
        $this->menuBoissons = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuFrites = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuBoisson>
     */
    public function getMenuBoissons(): Collection
    {
        return $this->menuBoissons;
    }

    public function addMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if (!$this->menuBoissons->contains($menuBoisson)) {
            $this->menuBoissons[] = $menuBoisson;
            $menuBoisson->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBoisson(MenuBoisson $menuBoisson): self
    {
        if ($this->menuBoissons->removeElement($menuBoisson)) {
            // set the owning side to null (unless already changed)
            if ($menuBoisson->getMenu() === $this) {
                $menuBoisson->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuFrite>
     */
    public function getMenuFrites(): Collection
    {
        return $this->menuFrites;
    }

    public function addMenuFrite(MenuFrite $menuFrite): self
    {
        if (!$this->menuFrites->contains($menuFrite)) {
            $this->menuFrites[] = $menuFrite;
            $menuFrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenuFrite(MenuFrite $menuFrite): self
    {
        if ($this->menuFrites->removeElement($menuFrite)) {
            // set the owning side to null (unless already changed)
            if ($menuFrite->getMenu() === $this) {
                $menuFrite->setMenu(null);
            }
        }

        return $this;
    }
    //**METHODE PERMETTANT D AJOUTER UN BURGER**
    public function addBurger(Burger $burger,int $qt=1){
        $Mburg= new MenuBurger();
        $Mburg->setBurger($burger);
        $Mburg->setQuantiteBurger($qt);
        $Mburg->setMenu($this);
        $this->addMenuBurger($Mburg);
    }
    //**METHODE PERMETTANT D AJOUTER UN FRITE**
    public function addFrite(Frite $frite,int $qt=1){
        $Mfrit= new MenuFrite();
        $Mfrit->setFrite($frite);
        $Mfrit->setQuantiteFrite($qt);
        $Mfrit->setMenu($this);
        $this->addMenuFrite($Mfrit);
    }
    //**METHODE PERMETTANT D AJOUTER UN BOISSON**
    public function addBoisson(Boisson $boisson,int $qt=1){
        $Mboisson= new MenuBoisson();
        $Mboisson->setBoisson($boisson);
        $Mboisson->setQuantiteBoisson($qt);
        $Mboisson->setMenu($this);
        $this->addMenuBoisson($Mboisson);
    }
   
}
