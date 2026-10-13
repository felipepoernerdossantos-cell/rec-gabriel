# Prints da API REST de Usuários e Autenticação

## GET /status
```json
{"status":"ok","mensagem":"API de usuários funcionando."}
```

## GET /usuarios
```json
[
  {"id":1,"nome":"Ana Souza","email":"ana@email.com","login":"ana","senha":"123456"},
  {"id":2,"nome":"Bruno Costa","email":"bruno@email.com","login":"bruno","senha":"abcdef"},
  {"id":3,"nome":"Carla Mendes","email":"carla@email.com","login":"carla","senha":"carla123"},
  {"id":4,"nome":"Diego Lima","email":"diego@email.com","login":"diego","senha":"diego321"},
  {"id":5,"nome":"Eduarda Reis","email":"eduarda@email.com","login":"eduarda","senha":"edu123"}
]
```

## POST /login
```json
{"mensagem":"Login realizado com sucesso.","usuario":{"id":1,"nome":"Ana Souza","email":"ana@email.com","login":"ana"}}
```

## PUT /usuarios/1/senha
```json
{"mensagem":"Senha alterada com sucesso.","usuario":{"id":1,"nome":"Ana Souza","email":"ana@email.com","login":"ana","senha":"novaSenha123"}}
```
