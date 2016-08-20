# PHPSP + IMA

Demo apresentada na palestra "Escalando uma Aplicação PHP com Docker - do monolito aos microserviços" no evento PHPSP + IMA em Campinas - SP no dia 20/08/2016. 

http://phpspima.com.br


## Como testar:

Temos 4 tags disponíveis:


| Tag | Descrição                |
|-----|----------------------------------------|
| V1  | laravel + mysql rodando                |
| V2  | contagem de cadastrados agora no cache |
| V3  | trabalhando queues                     |
| V4  | quebrando em serviços com Docker       |


### VM - monolito

Nas tags V1, V2 e V3 usamos vagrant baseado no homestead para subir um ambiente monolítico, todos os serviços como Redis, MySQL, RabbitMQ, PHP, etc, estão todos na mesma VM.

Para levantar a VM:

```
cd homestead
vagrant up
(senha de admin para shared folder)
```

É necessário apontar o domínio testado para o IP da VM. No Linux e no Mac OS o seguinte comando resolve:

```
echo "5.5.5.5 phpsp-ima.dev" | sudo tee -a /etc/hosts
```

Também é necessário usar o arquivo de environment que criamos para o vagrant

```
cp src/.env.vagrant src/.env
```

#### Migration

Ao executar pela primeira vez podemos receber exceptions relacionadas ao banco de dados onde as tabelas não foram criadas, para criar use os seguintes passos:

```
vagrant ssh 
cd demo-phpsp-ima/src/ 
php artisan migrate
exit
```

#### Acessando da máquina host

O banco de dados podemos acessar com o comando:

```
mysql -h5.5.5.5 -uhomestead -psecret phpsp-ima
```

O Redis podemos acessar com:

```
redis-cli -h phpsp-ima.dev
```

#### Rodando um consumer 

Para rodar um consumer de filas usamos os passos:

```
vagrant ssh
python demo-phpsp-ima/consumer.py
```


### E os microserviços no Docker?

Na tag V4 temos os serviços separados e descritos no `docker-compose.yml`.
É necessário apontar o domínio testado para o IP local No Linux e no Mac OS o arquivo /etc/hosts deve ter a linha ...

```
5.5.5.5 phpsp-ima.dev
```

... trocada por:

```
127.0.0.1 phpsp-ima.dev
```

É necessário também alterar o arquivo de environment para o exemplo do Docker:

```
cp src/.env.docker src/.env
```

Para construir as images e subir os serviços basta rodarmos:

```
docker-compose up -d
```

#### Migration

Ao executar pela primeira vez podemos receber exceptions relacionadas ao banco de dados onde as tabelas não foram criadas, para criar use o seguinte comando:

```
docker-compose exec web sh -c 'php /app/artisan migrate'
```

#### Acessando da máquina host

O banco de dados podemos acessar com o comando:

```
mysql -h127.0.0.1 -uuser -ppass phpsp-ima
```

O Redis podemos acessar com:

```
redis-cli -h 127.0.0.1
```

#### Rodando um consumer 

No Docker ele já roda como um dos serviços podemos consultar o output através dos logs:

```
docker-compose logs -f consumer
```

Se desejar ver todos os logs:

```
docker-compose logs -f 
```

### No browser

Tanto usando Vagrant quanto usando Docker podemos testar no browser através da url 
http://phpsp-ima.dev, de maneira análoga podemos acessar o dashboard do rabbitmq pelo http://phpsp-ima.dev:15672, porém no Vagrant utilizamos guest/guest em nossas credenciais, No Docker utilizamos user/pass para acessar.

### Teste de scale

Podemos testar o scale da aplicação com o comando:

```
docker-compose scale web=7 consumer=4
```

