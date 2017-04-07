<?php

    use Doctrine\ORM\EntityManager;

    class AuthenticationRepository {

        private $em;

        public function __construct(EntityManager $em) {
            $this->em = $em;
        }

        public function login($username, $password) {
            try {
                $user = $this->em->getRepository('User')->findBy(array('username' => $username, 'password' => $password));
                return $user;
            } catch(Exception $e) {
                throw new Exception($e->getMessage(), 500);
            }
        }
    }
