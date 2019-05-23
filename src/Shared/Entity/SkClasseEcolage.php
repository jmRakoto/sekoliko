<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 5/23/19
 * Time: 8:58 AM
 */

namespace App\Shared\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Class SkClasseEcolage
 * @package App\Shared\Entity
 * @ORM\Table(name="sk_classe_ecolage")
 * @ORM\Entity
 */
class SkClasseEcolage
{
    use SkAnneScolaire;
    use SkEtablissement;

    /**
     * @var
     * @ORM\Column(name="id",type="integer",nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var
     * @ORM\Column(name="designation",type="string",length=100,nullable=true)
     */
    private $designation;

    /**
     * @var
     * @ORM\Column(name="mois",type="string",length=100,nullable=true)
     */
    private $mois;


    /**
     * @var
     * @ORM\Column(name="montant",type="string",length=100,nullable=false)
     */
    private $montant;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="App\Shared\Entity\SkClasse")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="classe_ecolage", referencedColumnName="id", onDelete="CASCADE",nullable=true)
     * })
     */
    private $classe_ecolage;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * @param mixed $mois
     */
    public function setMois($mois)
    {
        $this->mois = $mois;
    }

    /**
     * @return mixed
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * @param mixed $montant
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
    }

    /**
     * @return mixed
     */
    public function getClasseEcolage()
    {
        return $this->classe_ecolage;
    }

    /**
     * @param mixed $classe_ecolage
     */
    public function setClasseEcolage($classe_ecolage)
    {
        $this->classe_ecolage = $classe_ecolage;
    }

    /**
     * @return mixed
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param mixed $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }

}