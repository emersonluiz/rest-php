<?php

    require 'vendor/autoload.php';
    require 'src/repository/PessoaRepository.php';
    require 'src/repository/AuthenticationRepository.php';
    require 'src/repository/TokenRepository.php';
    require 'src/model/Pessoa.php';
    require 'src/model/User.php';
    require 'src/model/Token.php';
    require 'src/exception/Failure.php';
    require 'bootstrap.php';

    $repository = new PessoaRepository($entityManager);
    $repositoryAuth = new AuthenticationRepository($entityManager);
    $repositoryToken = new TokenRepository($entityManager);

    $app = new \Slim\Slim();

    $app->get('/', function () {
       echo "Hello";
    });

    $app->post('/login', function () use($app, $repositoryAuth, $repositoryToken) {
      try {

          $auth = $app->request->headers->get('Authorization');

          list( $username, $password ) = explode( ':', base64_decode( substr( $auth, 6 ) ) );

          $user = $repositoryAuth->login($username, $password);

          if (empty($user)) {
                $failure = new Failure("User not found!");
                $app->response()->status(401);
                echo json_encode($failure);
          } else {
                $user = $user[0];
            $token = new Token($user);
                $tk = $repositoryToken->create($token);
                $app->response()->status(201);
                echo json_encode($tk);
          }

      } catch(Exception $e) {
          $failure = new Failure($e->getMessage());
      $code = $e->getCode();
      if (($e->getCode() != 500) || ($e->getCode() != 400) || ($e->getCode() != 404)) {
        $code = 500;
      }
      $app->response()->status($code);
          echo json_encode($failure);
      }

    });

    $app->get('/pessoa/fisica', function () use($app, $repository) {
      try {
        $pessoas = $repository->findAllFisical();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
        echo json_encode($pessoas);
      } catch(Exception $e) {
          $failure = new Failure($e->getMessage());
          $app->response()->status($e->getCode());
          echo json_encode($failure);
      }
    });

    $app->get('/pessoa/juridica', function () use($app, $repository)  {
      try {
        $pessoas = $repository->findAllFisical();
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
        echo json_encode($pessoas);
      } catch(Exception $e) {
          $failure = new Failure($e->getMessage());
          $app->response()->status($e->getCode());
          echo json_encode($failure);
      }
    });

    $app->get('/pessoa/:id', function ($id) use($app, $repository) {
      try {
        $pessoa = $repository->findOne($id);
        $app->response()->status(200);
        $app->response()->header('Content-Type', 'application/json;charset=utf-8');
        echo json_encode($pessoa);
      } catch(Exception $e) {
          $failure = new Failure($e->getMessage());
          $app->response()->status($e->getCode());
          echo json_encode($failure);
      }
    });

    $app->post('/pessoa', function () use($app, $repository) {
      try {
          $json = $app->request->getBody();
          $data = json_decode($json);
          $pessoa = new Pessoa($data);
          $id = $repository->create($pessoa);
          $app->response()->status(201);
          $app->response()->header('location', $app->request->getHostWithPort() . $app->request->getRootUri() . $app->request->getResourceUri() . "/" . $id);
      } catch(Exception $e) {
          $failure = new Failure($e->getMessage());
          $app->response()->status($e->getCode());
          echo json_encode($failure);
      }

    });

    $app->put('/pessoa/:id', function ($id) use($app, $repository) {
      try {
          $json = $app->request->getBody();
          $data = json_decode($json);
          $pessoa = new Pessoa($data);
          $repository->update($id, $pessoa);
          $app->response()->status(204);
       } catch(Exception $e) {
          $failure = new Failure($e->getMessage());
          $app->response()->status($e->getCode());
          echo json_encode($failure);
      }
    });

    $app->delete('/pessoa/:id', function ($id) use($app, $repository) {
       try {
          echo $repository->delete($id);
          $app->response()->status(204);
       } catch(Exception $e) {
          $failure = new Failure($e->getMessage());
          $app->response()->status($e->getCode());
          echo json_encode($failure);
       }

    });

    $app->run();

?>
