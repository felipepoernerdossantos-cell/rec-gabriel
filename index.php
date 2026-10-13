<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();

$usuarios = [
    [
        'id' => 1,
        'nome' => 'Ana Souza',
        'email' => 'ana@email.com',
        'login' => 'ana',
        'senha' => '123456'
    ],
    [
        'id' => 2,
        'nome' => 'Bruno Costa',
        'email' => 'bruno@email.com',
        'login' => 'bruno',
        'senha' => 'abcdef'
    ],
    [
        'id' => 3,
        'nome' => 'Carla Mendes',
        'email' => 'carla@email.com',
        'login' => 'carla',
        'senha' => 'carla123'
    ],
    [
        'id' => 4,
        'nome' => 'Diego Lima',
        'email' => 'diego@email.com',
        'login' => 'diego',
        'senha' => 'diego321'
    ],
    [
        'id' => 5,
        'nome' => 'Eduarda Reis',
        'email' => 'eduarda@email.com',
        'login' => 'eduarda',
        'senha' => 'edu123'
    ]
];

$app->get('/status', function (Request $request, Response $response) {
    $response->getBody()->write(json_encode([
        'status' => 'ok',
        'mensagem' => 'API de usuários funcionando.'
    ]));

    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->get('/usuarios', function (Request $request, Response $response) use ($usuarios) {
    $response->getBody()->write(json_encode($usuarios));

    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->get('/usuarios/{id}', function (Request $request, Response $response, array $args) use ($usuarios) {
    $id = (int) $args['id'];
    $usuario = null;

    foreach ($usuarios as $u) {
        if ((int) $u['id'] === $id) {
            $usuario = $u;
            break;
        }
    }

    if (!$usuario) {
        $response->getBody()->write(json_encode(['erro' => 'Usuário não encontrado.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
    }

    $response->getBody()->write(json_encode($usuario));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
});

$app->post('/usuarios', function (Request $request, Response $response) use ($usuarios) {
    $dados = $request->getParsedBody();

    if (!isset($dados['nome'], $dados['email'], $dados['login'], $dados['senha'])) {
        $response->getBody()->write(json_encode(['erro' => 'Todos os campos são obrigatórios.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    $novoUsuario = [
        'id' => count($usuarios) + 1,
        'nome' => $dados['nome'],
        'email' => $dados['email'],
        'login' => $dados['login'],
        'senha' => $dados['senha']
    ];

    $usuarios[] = $novoUsuario;

    $response->getBody()->write(json_encode($novoUsuario));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});

$app->put('/usuarios/{id}', function (Request $request, Response $response, array $args) use ($usuarios) {
    $id = (int) $args['id'];
    $dados = $request->getParsedBody();

    foreach ($usuarios as $index => $usuario) {
        if ((int) $usuario['id'] === $id) {
            $usuarios[$index]['nome'] = $dados['nome'] ?? $usuario['nome'];
            $usuarios[$index]['email'] = $dados['email'] ?? $usuario['email'];
            $usuarios[$index]['login'] = $dados['login'] ?? $usuario['login'];
            $usuarios[$index]['senha'] = $dados['senha'] ?? $usuario['senha'];

            $response->getBody()->write(json_encode($usuarios[$index]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }

    $response->getBody()->write(json_encode(['erro' => 'Usuário não encontrado.']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->delete('/usuarios/{id}', function (Request $request, Response $response, array $args) use ($usuarios) {
    $id = (int) $args['id'];

    foreach ($usuarios as $index => $usuario) {
        if ((int) $usuario['id'] === $id) {
            unset($usuarios[$index]);
            $response->getBody()->write(json_encode(['mensagem' => 'Usuário removido com sucesso.']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }

    $response->getBody()->write(json_encode(['erro' => 'Usuário não encontrado.']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->post('/login', function (Request $request, Response $response) use ($usuarios) {
    $dados = $request->getParsedBody();

    if (!isset($dados['login'], $dados['senha'])) {
        $response->getBody()->write(json_encode(['erro' => 'Login e senha são obrigatórios.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    foreach ($usuarios as $usuario) {
        if ($usuario['login'] === $dados['login'] && $usuario['senha'] === $dados['senha']) {
            $response->getBody()->write(json_encode([
                'mensagem' => 'Login realizado com sucesso.',
                'usuario' => [
                    'id' => $usuario['id'],
                    'nome' => $usuario['nome'],
                    'email' => $usuario['email'],
                    'login' => $usuario['login']
                ]
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }

    $response->getBody()->write(json_encode(['erro' => 'Credenciais inválidas.']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
});

$app->put('/usuarios/{id}/senha', function (Request $request, Response $response, array $args) use ($usuarios) {
    $id = (int) $args['id'];
    $dados = $request->getParsedBody();

    if (!isset($dados['senha_atual'], $dados['nova_senha'])) {
        $response->getBody()->write(json_encode(['erro' => 'Senha atual e nova senha são obrigatórias.']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }

    foreach ($usuarios as $index => $usuario) {
        if ((int) $usuario['id'] === $id) {
            if ($usuario['senha'] !== $dados['senha_atual']) {
                $response->getBody()->write(json_encode(['erro' => 'Senha atual incorreta.']));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
            }

            $usuarios[$index]['senha'] = $dados['nova_senha'];

            $response->getBody()->write(json_encode([
                'mensagem' => 'Senha alterada com sucesso.',
                'usuario' => $usuarios[$index]
            ]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }
    }

    $response->getBody()->write(json_encode(['erro' => 'Usuário não encontrado.']));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
});

$app->run();
