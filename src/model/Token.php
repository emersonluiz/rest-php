<?php
//src/model/Token.php
/**
 *
 * @Entity
 * @Table(name="token")
 */
class Token {

    /**
     * @Id
     * @GeneratedValue(strategy="AUTO")
     * @Column(type="integer", name="id")
     */
    private $id;

    /**
     * @Column(type="string", name="token")
     */
    public $token;

   /**
     * @ManyToOne(targetEntity="user")
     * @JoinColumn(name="id_user", referencedColumnName="id")
     **/
    public $user;

    public function __construct($user) {
        $this->user = $user;
        $this->token = $this->getGUID();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getToken() {
        return $this->token;
    }

    public function setToken($token) {
        $this->token = $token;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    function getGUID() {
        if (function_exists('com_create_guid')) {
            return com_create_guid();
        }else {
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"
            return $uuid;
        }
     }

}
