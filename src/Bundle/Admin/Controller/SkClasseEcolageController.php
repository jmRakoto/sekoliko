<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 5/23/19
 * Time: 9:16 AM
 */

namespace App\Bundle\Admin\Controller;


use App\Shared\Entity\SkClasse;
use App\Shared\Entity\SkClasseEcolage;
use App\Shared\Form\SkClasseEcolageType;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SkClasseEcolageController extends Controller
{
    /**
     * @return object|string
     */
    public function getUserConnected()
    {
        return $this->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @return \App\Shared\Repository\SkEntityManager|object
     */
    public function getEntityService()
    {
        return $this->get('sk.repository.entity');
    }

    /**
     *
     * @throws \Exception
     */
    public function indexAction()
    {
        $_ecolage_list = $this->getEntityService()->getAllListByEts(SkClasseEcolage::class);
        return $this->render('AdminBundle:SkClasseEcolage:index.html.twig', [
            'ecolage' => $_ecolage_list
        ]);
    }

    /**
     * @param SkClasse $skClasse
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listPaiementClasseAction(SkClasse $skClasse)
    {
        $_paiement_list = $this->getDoctrine()->getRepository(SkClasseEcolage::class)->findBy([
            'etsNom' => $this->getUserConnected()->getEtsNom(),
            'asName' => $this->getUserConnected()->getAsName(),
            'classe_ecolage' => $skClasse
        ]);

        return $this->render('AdminBundle:SkClasseEcolage:index.html.twig', [
            'ecolage' => $_paiement_list
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        $_ecolage = new SkClasseEcolage();
        $skClasse = $request->request->get('classe');
        $skClasse ? $_sk_classe = $this->getEntityService()->getEntityById(SkClasse::class,$skClasse) : false;
        $_form = $this->createForm(SkClasseEcolageType::class, $_ecolage);
        $_mois = $this->getEntityService()->getMonthList();
        $_class = $this->getEntityService()->getAllListByEts(SkClasse::class);
        $_form->handleRequest($request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            $_mois_eco = $request->request->get('mois');

            $skClasse ? $_class_eco = $_sk_classe : $_class_eco = $request->request->get('classe');
            $_designation = $request->request->get('designation');
            $_montant = $request->request->get('montant');
            if ($_mois_eco === 'toutes les mois') {
                $_mois_list = $this->getEntityService()->getMonthList();
                array_shift($_mois_list);

                foreach ($_mois_list as $key => $month) {
                    $_ecolage = new SkClasseEcolage();
                    $_ecolage->setMontant($_montant);
                    $_ecolage->setMois($month);
                    $_ecolage->setDesignation($_designation);
                    $_ecolage->setClasseEcolage($this->getEntityService()->getEntityById(SkClasse::class, $_class_eco));

                    for ($i = 0; $i < count($_mois_list); ++$i) {
                        try {
                            $this->getEntityService()->saveEntity($_ecolage, 'new');
                        } catch (\Exception $exception) {
                            $this->getEntityService()->setFlash('error', $exception->getMessage());
                        }
                    }
                }
            } else {
                try {
                    $_ecolage->setMois($_mois_eco);
                    $_ecolage->setMontant($_montant);
                    $_ecolage->setDesignation($_designation);
                    $_ecolage->setClasseEcolage($this->getEntityService()->getEntityById(SkClasse::class, $_class_eco));
                    $this->getEntityService()->saveEntity($_ecolage, 'new');

                    $this->getEntityService()->setFlash('success', 'Ajout ecolage avec success');
                    return $this->redirectToRoute('ecolage_list');
                } catch (\Exception $exception) {
                    $this->getEntityService()->setFlash('error', $exception->getMessage());
                    return $this->redirectToRoute('ecolage_list');
                }
            }
        }
        return $this->render('AdminBundle:SkClasseEcolage:add.html.twig', [
            'mois' => $_mois,
            'classe' => $_class,
            'form' => $_form->createView(),
            'skclasse' => $_sk_classe
        ]);
    }

    /**
     *
     * @param Request $request
     * @param SkClasseEcolage $skClasseEcolage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function editAction(Request $request, SkClasseEcolage $skClasseEcolage)
    {
        $_form = $this->createForm(SkClasseEcolageType::class, $skClasseEcolage);
        $_mois = $this->getEntityService()->getMonthList();
        $_class = $this->getEntityService()->getAllListByEts(SkClasse::class);
        $_form->handleRequest($request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            $_mois_eco = $request->request->get('mois');
            $_class_eco = $request->request->get('classe');
            $_designation = $request->request->get('designation');
            $_montant = $request->request->get('montant');
            if ($_mois_eco === 'toutes les mois') {
                $_mois_list = $this->getEntityService()->getMonthList();
                array_shift($_mois_list);

                foreach ($_mois_list as $key => $month) {
                    $skClasseEcolage->setMontant($_montant);
                    $skClasseEcolage->setMois($month);
                    $skClasseEcolage->setDesignation($_designation);
                    $skClasseEcolage->setClasseEcolage($this->getEntityService()->getEntityById(SkClasse::class, $_class_eco));

                    for ($i = 0; $i < count($_mois_list); ++$i) {
                        try {
                            $this->getEntityService()->saveEntity($skClasseEcolage, 'new');
                        } catch (\Exception $exception) {
                            $this->getEntityService()->setFlash('error', $exception->getMessage());
                        }
                    }
                }
            } else {
                try {
                    $skClasseEcolage->setMois($_mois_eco);
                    $skClasseEcolage->setMontant($_montant);
                    $skClasseEcolage->setDesignation($_designation);
                    $skClasseEcolage->setClasseEcolage($this->getEntityService()->getEntityById(SkClasse::class, $_class_eco));
                    $this->getEntityService()->saveEntity($skClasseEcolage, 'update');
                } catch (\Exception $exception) {
                    $this->getEntityService()->setFlash('error', $exception->getMessage());
                }
                $this->getEntityService()->setFlash('success', 'Modification ecolage avec success');
                return $this->redirectToRoute('ecolage_list');
            }
        }
        return $this->render('AdminBundle:SkClasseEcolage:edit.html.twig', [
            'mois' => $_mois,
            'classe' => $_class,
            'form' => $_form->createView(),
            'ecolage' => $skClasseEcolage
        ]);
    }

    /**
     * @param SkClasseEcolage $skClasseEcolage
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function deleteAction(SkClasseEcolage $skClasseEcolage)
    {
        try {
            if (true === $this->getEntityService()->deleteEntity($skClasseEcolage, '')) {
                $this->getEntityService()->setFlash('success', 'Suppression ecolage avec success');
                return $this->redirectToRoute('classe_index');
            }
        } catch (\Exception $exception) {
            $this->getEntityService()->setFlash('error', 'Une erreur se produite');
        }
    }
}