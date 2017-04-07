<?php

    use Doctrine\ORM\EntityManager;

    class PessoaRepository {

        private $em;

        public function __construct(EntityManager $em) {
            $this->em = $em;
         }

        public function create($pessoa) {
            try {
                $this->em->persist($pessoa);
                $this->em->flush();
                return $pessoa->getId();
            } catch(Exception $e) {
                throw new Exception($e->getMessage(), 500);
            }
        }

        public function update($id, $pessoa) {
            try {
                $rtn = $this->findOne($id);
                if(isset($rtn)) {
                    $pessoa->setId($id);
                    $this->em->merge($pessoa);
                    $this->em->flush();
                } else {
                    throw new Exception("Person not found", 404);
                }
            } catch(Exception $e) {
                throw new Exception($e->getMessage(), 500);
            }
        }

        public function delete($id) {
            try {
                $pessoa = $this->findOne($id);
                if(isset($pessoa)) {
                    $this->em->remove($pessoa);
                    $this->em->flush();
                } else {
                    throw new Exception("Person not found", 404);
                }
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

        public function findAllFisical() {
            try {
                $pessoas = $this->em->getRepository('Pessoa')->findAll();
                return $pessoas;
            } catch(Exception $e) {
                throw new Exception($e->getMessage(), 500);
            }
        }

        public function findAllLegal() {
            try {
                $pessoas = $this->em->getRepository('Pessoa')->findAll();
                return $pessoas;
            } catch(Exception $e) {
                throw new Exception($e->getMessage(), 500);
            }
        }

    }