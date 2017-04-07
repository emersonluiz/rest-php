<?php

    use Doctrine\ORM\EntityManager;

    class TokenRepository {

        private $em;

        public function __construct(EntityManager $em) {
            $this->em = $em;
        }

        public function create($token) {
            try {
                $this->em->persist($token);
                $this->em->flush();
                return $token;
            } catch(Exception $e) {
                throw new Exception($e->getMessage(), 500);
            }
        }

        public function findOne($id) {
            try {
                $pessoa = $this->em->find('Pessoa', $id);
                return $pessoa;
            } catch(Exception $e) {
                throw new Exception($e->getMessage(), 500);
            }
        }

    }
