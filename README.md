# API REST de Usuários e Autenticação

## 1. Identificação
- Nome completo do aluno: Felipe Poerner dos Santos
- Curso: Desenvolvimento de Sistemas / Sistemas para Internet
- Unidade Curricular: Desenvolver Serviços Web

## 2. Como Instalar as Dependências

1. Acesse a pasta do projeto:
   ```bash
   cd api-rest-usuarios
   ```

2. Instale as dependências com Composer:
   ```bash
   composer install
   ```

3. Inicie o servidor da API:
   ```bash
   php -S localhost:8000
   ```

4. Acesse a API pela URL abaixo:
   ```text
   http://localhost:8000
   ```

5. Para testar os endpoints, utilize o Postman, Insomnia ou o comando curl:
   ```bash
   curl http://localhost:8000/status
   curl http://localhost:8000/usuarios
   ```

## 3. Decisões Técnicas

- Utilização do framework Slim para a construção da API REST em PHP.
- Estrutura simples e organizada em um único arquivo `index.php` para facilitar a execução e a entrega do projeto.
- Uso de rotas com parâmetros de rota, como `/usuarios/{id}` e `/usuarios/{id}/senha`.
- Recebimento de dados em JSON por meio do método `getParsedBody()`.
- Validação de campos obrigatórios antes de cadastrar ou autenticar um usuário.
- Retorno de status HTTP adequados, como `200 OK`, `201 Created`, `400 Bad Request`, `401 Unauthorized` e `404 Not Found`.
- Persistência em memória, com 5 usuários iniciais já cadastrados no sistema.
- Implementação do fluxo de login com validação de credenciais e alteração de senha com confirmação da senha atual.

## 4. Prints

Abaixo estão as saídas reais obtidas durante a execução da API:

### GET /status
```json
{"status":"ok","mensagem":"API de usuários funcionando."}
```

### GET /usuarios
```json
[
  {"id":1,"nome":"Ana Souza","email":"ana@email.com","login":"ana","senha":"123456"},
  {"id":2,"nome":"Bruno Costa","email":"bruno@email.com","login":"bruno","senha":"abcdef"},
  {"id":3,"nome":"Carla Mendes","email":"carla@email.com","login":"carla","senha":"carla123"},
  {"id":4,"nome":"Diego Lima","email":"diego@email.com","login":"diego","senha":"diego321"},
  {"id":5,"nome":"Eduarda Reis","email":"eduarda@email.com","login":"eduarda","senha":"edu123"}
]
```

### POST /login
```json
{"mensagem":"Login realizado com sucesso.","usuario":{"id":1,"nome":"Ana Souza","email":"ana@email.com","login":"ana"}}
```

### PUT /usuarios/1/senha
```json
{"mensagem":"Senha alterada com sucesso.","usuario":{"id":1,"nome":"Ana Souza","email":"ana@email.com","login":"ana","senha":"novaSenha123"}}
```

## 5. Endpoints Implementados

- `GET /status`
- `GET /usuarios`
- `GET /usuarios/{id}`
- `POST /usuarios`
- `PUT /usuarios/{id}`
- `DELETE /usuarios/{id}`
- `POST /login`
- `PUT /usuarios/{id}/senha`

## 6. Observações

Este projeto atende ao enunciado solicitado para a disciplina de Desenvolver Serviços Web, utilizando PHP, Slim Framework e JSON, com autenticação e gestão de usuários conforme os requisitos exigidos.
