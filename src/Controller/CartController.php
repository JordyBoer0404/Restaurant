<?php
namespace App\Controller;
use App\Entity\Bestelling;
use App\Entity\Regel;
use App\Entity\Product;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
/**
 * Cart controller.
 *
 * @Route("cart")
 */
class CartController extends AbstractController {
    /**
     * @Route("/", name="cart")
     */
    public function indexAction() {
        if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
            // Haal session op
            $session = $this->get( 'request_stack' )->getCurrentRequest()->getSession();
            $cart    = $session->get( 'cart', array() );
            if ( $cart != '' ) {
                if ( isset( $cart ) ) {
                    $em      = $this->getDoctrine()->getEntityManager();
                    $product = $em->getRepository( Product::class )->findAll();
                } else {
                    return $this->render( 'cart/index.html.twig', array(
                        'empty' => true,
                    ) );
                }
                return $this->render( 'cart/index.html.twig', array(
                    'empty'   => false,
                    'product' => $product,
                ) );
            } else {
                return $this->render( 'cart/index.html.twig', array(
                    'empty' => true,
                ) );
            }
        } else {
            return $this->render( 'default/accessdenied.html.twig' );
        }
    }
    /**
     * @Route("/add/{id}", name="cart_add")
     */
    public function addAction( $id ) {
        if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
            $em      = $this->getDoctrine()->getManager();
            $product = $em->getRepository( Product::class )->find( $id );
            $session = $this->get( 'request_stack' )->getCurrentRequest()->getSession();
            $cart    = $session->get( 'cart', array() );
            // kijk of id al bestaat
            if ( $product == null ) {
                $this->get( 'session' )->setFlash( 'notice', 'Dit product is niet beschikbaar' );
                return $this->redirect( $this->generateUrl( 'cart' ) );
            } else {
                if ( isset( $cart[ $id ] ) ) {
                    ++ $cart[ $id ];
                } else {
                    $cart[ $id ] = 1;
                }
                $session->set( 'cart', $cart );
                return $this->redirect( $this->generateUrl( 'cart' ) );
            }
        } else {
            return $this->render( 'default/accessdenied.html.twig' );
        }
    }
    /**
     * @Route("/checkout", name="checkout")
     */
    public function checkoutAction() {
        if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
            $session = $this->get( 'request_stack' )->getCurrentRequest()->getSession();
            $cart    = $session->get( 'cart', array() );
            // aanmaken factuur regel.
            $em         = $this->getDoctrine()->getManager();
            $userAdress = $em->getRepository( User::class )->findOneBy( array( 'id' => $this->getUser()->getId() ) );
            // new UserAdress if no UserAdress found...
            if ( ! $userAdress ) {
                $userAdress = new User();
                $userAdress->setId( $this->getUser()->getId() );
            }
            $factuur = new Bestelling();
            $factuur->setDatum(new \DateTime('now'));
            // regels maken
            if ( isset( $cart ) ) {
                $em->persist( $factuur );
                $em->flush();
                // put basket in dbase
                foreach ( $cart as $id => $quantity ) {
                    $regel = new Regel();
                    $regel->setBestelling( $factuur );
                    $em      = $this->getDoctrine()->getManager();
                    $product = $em->getRepository( Product::class )->find( $id );
                    $regel->setAantal( $quantity );
                    $regel->setProduct( $product );
                    $em = $this->getDoctrine()->getManager();
                    $em->persist( $regel );
                    $em->flush();
                }
            }
            $session->clear();
            return $this->redirectToRoute( 'bestelling_edit', [ 'id' => $factuur->getId() ] );
        } else {
            return $this->render( 'default/accessdenied.html.twig' );
        }
    }
    /**
     * @Route("/remove/{id}", name="cart_remove")
     */
    public function removeAction( $id ) {
        if ( $this->isGranted( "ROLE_SUPER_ADMIN" ) ) {
            $session = $this->get( 'request_stack' )->getCurrentRequest()->getSession();
            $cart    = $session->get( 'cart', array() );
            // if it doesn't exist redirect to cart index page. end
            if ( ! $cart[ $id ] ) {
                $this->redirect( $this->generateUrl( 'cart' ) );
            }
            if ( isset( $cart[ $id ] ) ) {
                $cart[ $id ] = $cart[ $id ] - 1;
                if ( $cart[ $id ] < 1 ) {
                    unset( $cart[ $id ] );
                }
            } else {
                return $this->redirect( $this->generateUrl( 'cart' ) );
            }
            $session->set( 'cart', $cart );
            return $this->redirect( $this->generateUrl( 'cart' ) );
        } else {
            return $this->render( 'default/accessdenied.html.twig' );
        }
    }

}
