<?php
/**
 * Created by PhpStorm.
 * User: julkwel
 * Date: 3/27/19
 * Time: 10:13 AM.
 */

namespace App\Bundle\Admin\Controller;

use App\Bundle\User\Entity\User;
use App\Shared\Entity\SkClasse;
use App\Shared\Entity\SkClasseMatiere;
use App\Shared\Entity\SkEtudiant;
use App\Shared\Entity\SkMatiere;
use App\Shared\Form\SkMatiereType;
use App\Shared\Services\Utils\RoleName;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SkMatiereController extends Controller
{
    /**
     * @return \App\Shared\Repository\SkEntityManager|object
     */
    public function getEntityService()
    {
        return $this->get('sk.repository.entity');
    }

    /**
     * @return mixed
     */
    public function getUserConnected()
    {
        return $this->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @throws \Exception
     */
    public function indexAction()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_PROFS')) {
            $_profs = $this->getUserConnected();
            $_matier_liste = $this->getDoctrine()->getRepository(SkClasseMatiere::class)->findBy(array(
                'matProf' => $_profs,
                'etsNom' => $this->getUserConnected()->getEtsNom(),
                'asName' => $this->getUserConnected()->getAsName(),
            ));

            return $this->render('AdminBundle:SkMatiere:index.html.twig', array(
                'matiere_liste' => $_matier_liste,
            ));
        }

        $_matier_liste = $this->getEntityService()->getAllListByEts(SkMatiere::class);

        return $this->render('AdminBundle:SkMatiere:index.html.twig', array(
            'matiere_liste' => $_matier_liste,
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function matiereEtudiantAction()
    {
        $_user_classe = $this->getDoctrine()->getRepository(SkEtudiant::class)->findBy(array(
            'etsNom' => $this->getUserConnected()->getEtsNom(),
            'asName' => $this->getUserConnected()->getAsName(),
            'etudiant' => $this->getUserConnected(),
        ));

        $_matiere_list = $this->getDoctrine()->getRepository(SkClasseMatiere::class)->findBy(array(
            'etsNom' => $this->getUserConnected()->getEtsNom(),
            'asName' => $this->getUserConnected()->getAsName(),
            'matClasse' => $_user_classe[0]->getClasse(),
        ));

        return $this->render('@Admin/SkMatiere/etudiant.matiere.html.twig', array(
            'classe' => $_user_classe[0]->getClasse(),
            'matiere_liste' => $_matiere_list,
        ));
    }

    /**
     * @return mixed
     */
    public function getUserConected()
    {
        return $this->container->get('security.token_storage')->getToken()->getUser();
    }

    /**
     * @return User[]|SkClasse[]|SkEtudiant[]|SkMatiere[]|\App\Shared\Entity\SkNiveau[]|array
     */
    public function getProfs()
    {
        $_user_ets = $this->getUserConected()->getEtsNom();
        $_user_as = $this->getUserConected()->getAsName();

        $_array_type = array(
            'skRole' => array(
                RoleName::ID_ROLE_PROFS,
            ),
            'etsNom' => $_user_ets,
            'asName' => $_user_as,
        );

        return $this->getDoctrine()->getRepository(User::class)->findBy($_array_type, array('id' => 'DESC'));
    }

    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function newAction(Request $request)
    {
        /*
         * Secure to etudiant connected
         */
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            return $this->redirectToRoute('sk_login');
        }

        $_user_ets = $this->getUserConected()->getEtsNom();
        $_profs_list = $this->getProfs();
        $_classe_list = $this->getDoctrine()->getRepository(SkClasse::class)->findBy(array(
            'etsNom' => $_user_ets,
            'asName' => $this->getUserConnected()->getAsName(),
        ));

        $_matiere = new SkMatiere();
        $_form = $this->createForm(SkMatiereType::class, $_matiere);
        $_form->handleRequest($request);
        if ($_form->isSubmitted() && $_form->isValid()) {
            $this->getEntityService()->saveEntity($_matiere, 'new');
            $this->getEntityService()->setFlash('success', 'Ajout du matière effectuée');

            return $this->redirectToRoute('matiere_index');
        } else {
            $this->redirectToRoute('matiere_new');
        }

        return $this->render('@Admin/SkMatiere/add.html.twig', array(
            'form' => $_form->createView(),
            'profs' => $_profs_list,
            'matiere' => $_matiere,
            'classe' => $_classe_list,
        ));
    }

    /**
     * @param Request $request
     * @param null    $id_matiere
     * @param null    $id_class
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function addMatClassAction(Request $request, $id_matiere = null, $id_class = null)
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            return $this->redirectToRoute('sk_login');
        }

        $_user_ets = $this->getUserConected()->getEtsNom();
        $_profs_list = $this->getProfs();
        $_classe_list = $this->getDoctrine()->getRepository(SkClasse::class)->findBy(array(
            'etsNom' => $_user_ets,
            'asName' => $this->getUserConnected()->getAsName(),
        ));

        $_matiere = new SkClasseMatiere();
        $_form = $this->createFormBuilder($_matiere)
            ->add('matiere', EntityType::class, [
                'label' => 'selectionner le matiere',
                'class' => SkMatiere::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->andWhere('m.etsNom = :etsnom')
                        ->andWhere('m.asName = :asname')
                        ->setParameter('etsnom', $this->getUserConected()->getEtsNom())
                        ->setParameter('asname', $this->getUserConected()->getAsName())
                        ->orderBy('m.id', 'ASC');
                },
                'choice_label' => 'matNom',
                'multiple' => false,
            ])
            ->add('matCoeff')
            ->add('matClasse', EntityType::class, [
                'class' => SkClasse::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.etsNom = :etsnom')
                        ->andWhere('c.asName = :asname')
                        ->setParameter('etsnom', $this->getUserConected()->getEtsNom())
                        ->setParameter('asname', $this->getUserConected()->getAsName())
                        ->orderBy('c.id', 'ASC');
                },
                'choice_label' => 'classeNom',
            ])
            ->add('matProf', EntityType::class, [
                'class' => User::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.etsNom = :etsnom')
                        ->andWhere('u.asName = :asname')
                        ->andWhere('u.skRole = 4')
                        ->setParameter('etsnom', $this->getUserConected()->getEtsNom())
                        ->setParameter('asname', $this->getUserConected()->getAsName())
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'usrFirstName',
            ])->getForm();

        $_form->handleRequest($request);
        if ($_form->isSubmitted() && $_form->isValid()) {
            $this->getEntityService()->saveEntity($_matiere, 'new');
            $this->getEntityService()->setFlash('success', 'Ajout du matière effectuée');

            return $this->redirectToRoute('matiere_index');
        } else {
            $this->redirectToRoute('matiere_new');
        }

        return $this->render('@Admin/SkMatiere/add.classmat.html.twig', array(
            'form' => $_form->createView(),
            'profs' => $_profs_list,
            'matiere' => $_matiere,
            'classe' => $_classe_list,
        ));
    }

    /**
     * @param Request   $request
     * @param SkMatiere $skMatiere
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function updateAction(Request $request, SkMatiere $skMatiere)
    {
        /*
         * Secure to etudiant connected
         */
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            return $this->redirectToRoute('sk_login');
        }

        $_profs_liste = $this->getProfs();
        $_user_ets = $this->getUserConected()->getEtsNom();
        $_classe_list = $this->getDoctrine()->getRepository(SkClasse::class)->findBy(array(
            'etsNom' => $_user_ets,
            'asName' => $this->getUserConnected()->getAsName(),
        ));

        $_form = $this->createForm(SkMatiereType::class, $skMatiere);
        $_form->handleRequest($request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            $this->getEntityService()->saveEntity($skMatiere, 'update');
            $this->getEntityService()->setFlash('success', 'Matière mis à jour');

            return $this->redirectToRoute('matiere_index');
        } else {
            $this->redirectToRoute('matiere_new');
        }

        return $this->render('@Admin/SkMatiere/add.html.twig', array(
            'form' => $_form->createView(),
            'profs' => $_profs_liste,
            'matiere' => $skMatiere,
            'classe' => $_classe_list,
        ));
    }

    /**
     * @param SkMatiere $skMatiere
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function deleteAction(SkMatiere $skMatiere)
    {
        /*
         * Secure to etudiant connected
         */
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ETUDIANT')) {
            return $this->redirectToRoute('sk_login');
        }

        $_del_matiere = $this->getEntityService()->deleteEntity($skMatiere, '');

        if (true === $_del_matiere) {
            $this->getEntityService()->setFlash('success', 'Suppression du matière effectuée');

            return $this->redirectToRoute('matiere_index');
        } else {
            $this->getEntityService()->setFlash('error', 'Une erreur s\'est produite, veuiller réessayez ultérieurement');
        }
    }
}
