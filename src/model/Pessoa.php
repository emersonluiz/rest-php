<?php
//src/model/Pessoa.php
/**
 *
 * @Entity
 * @Table(name="pessoa")
 */
class Pessoa {

    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", name="id")
     */
    public $id;

    /**
     * @Column(type="string", name="name")
     */
    public $name;

    /**
     * @Column(type="string", name="legal_name")
     */
    public $legalName;

    public function __construct($data) {
        $this->name = $data->name;
        $this->legalName = $data->legalName;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLegalName() {
        return $this->legalName;
    }

    public function setLegalName($legalName) {
        $this->legalName = $legalName;
    }

}