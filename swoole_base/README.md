# Para executar rapidamento o php com swoole

Execução rápida do swoole
```sh
# Versão do PHP
docker run --rm phpswoole/swoole:5.1-php8.3-alpine php -v

# Versão do Swoole
docker run --rm phpswoole/swoole:5.1-php8.3-alpine php --ri swoole
```

Execução em container
```sh
docker compose up -d
```