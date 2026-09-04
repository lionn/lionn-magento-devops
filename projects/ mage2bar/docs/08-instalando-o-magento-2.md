# Instalando o Magento 2 no ambiente Docker

## Mage2Bar

O Mage2Bar é um projeto prático para implantação de um ambiente Magento 2 utilizando tecnologias amplamente utilizadas em ambientes de desenvolvimento e infraestrutura.

A partir desta etapa, o projeto deixa de utilizar somente o sistema operacional base e passa a utilizar uma arquitetura composta por containers Docker.

O ambiente será formado por containers responsáveis pelo PHP-FPM, Nginx, MariaDB, Redis e OpenSearch.

O objetivo desta etapa é construir o ambiente, obter o código-fonte do Magento 2, configurar os serviços necessários e realizar a instalação inicial da aplicação.

---

## Objetivo

Nesta etapa serão realizados os seguintes procedimentos:

1. Verificar o ambiente Debian.
2. Verificar Docker e Docker Compose.
3. Preparar a estrutura do projeto.
4. Configurar as variáveis de ambiente.
5. Obter o código-fonte do Magento Open Source.
6. Construir a imagem PHP-FPM personalizada.
7. Inicializar os containers.
8. Validar MariaDB, Redis e OpenSearch.
9. Validar a comunicação entre os serviços.
10. Executar a instalação do Magento.
11. Configurar as permissões da aplicação.
12. Validar o funcionamento do Magento.
13. Acessar a loja.
14. Acessar o painel administrativo.

Ao final desta etapa, o ambiente Mage2Bar deverá possuir o Magento 2 instalado e executando sobre Docker.

---

# 1. Estrutura do projeto

Antes de iniciar a instalação, é importante compreender a estrutura utilizada pelo Mage2Bar.

A estrutura utilizada pelo projeto é semelhante a:

```text
mage2bar/
├── docker/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   ├── .env
│   ├── .env.example
│   └── nginx/
│       ├── default.conf
│       └── ssl/
│
├── magento2/
│   ├── app/
│   ├── bin/
│   ├── composer.json
│   ├── composer.lock
│   ├── generated/
│   ├── pub/
│   ├── setup/
│   ├── var/
│   └── vendor/
│
└── data/
```

O diretório `magento2` contém o código-fonte da aplicação.

O diretório `docker` contém os arquivos responsáveis pela construção e execução do ambiente.

O arquivo `Dockerfile` define a imagem PHP utilizada pelo Magento.

O arquivo `docker-compose.yml` define os containers e a comunicação entre os serviços.

O arquivo `.env` armazena as variáveis utilizadas pelo Docker Compose.

O arquivo `.env.example` funciona como modelo para criação do `.env`.

---

# 2. Verificando o Docker

O Docker foi instalado na etapa anterior.

Verifique a instalação:

```bash
docker --version
```

Verifique também o Docker Compose:

```bash
docker compose version
```

Também é possível verificar o serviço Docker:

```bash
sudo systemctl status docker
```

O serviço deverá estar em execução.

Caso seja necessário iniciar o serviço:

```bash
sudo systemctl start docker
```

Para habilitar a inicialização automática:

```bash
sudo systemctl enable docker
```

---

# 3. Verificando o acesso ao Docker

Teste a execução de um container:

```bash
docker run hello-world
```

Caso o comando seja executado sem a necessidade de `sudo`, o usuário atual já possui permissão para utilizar o Docker.

Caso seja necessário utilizar `sudo`, verifique a configuração realizada na etapa de instalação do Docker.

---

# 4. Verificando a estrutura do projeto

Entre no diretório do projeto:

```bash
cd ~/mage2bar
```

Verifique seu conteúdo:

```bash
ls -lah
```

A estrutura deverá possuir os diretórios utilizados pelo projeto:

```text
docker/
magento2/
```

Caso o diretório da aplicação ainda não exista:

```bash
mkdir -p ~/mage2bar/magento2
```

---

# 5. Verificando o Composer

O Composer foi instalado na etapa anterior.

Verifique a versão:

```bash
composer --version
```

Também é possível verificar sua localização:

```bash
which composer
```

O Composer será utilizado para obter o código-fonte do Magento e instalar suas dependências.

---

# 6. Configurando as Magento Access Keys

O Composer precisa acessar o repositório oficial de pacotes do Magento.

As credenciais são compostas por:

```text
Public Key
Private Key
```

A Public Key funciona como identificador.

A Private Key funciona como senha e deve ser tratada como informação confidencial.

As credenciais não devem ser adicionadas ao Git, publicadas no GitHub ou inseridas diretamente em arquivos versionados.

Configure a autenticação do Composer:

```bash
composer config --global http-basic.repo.magento.com <PUBLIC_KEY> <PRIVATE_KEY>
```

Substitua:

```text
<PUBLIC_KEY>
```

pela Public Key obtida anteriormente.

Substitua:

```text
<PRIVATE_KEY>
```

pela Private Key.

---

# 7. Obtendo o código-fonte do Magento

Entre no diretório da aplicação:

```bash
cd ~/mage2bar/magento2
```

Obtenha o Magento Open Source:

```bash
composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=2.4.8 .
```

O ponto final `.` indica que o Composer deverá instalar o projeto no diretório atual.

Durante o processo, o Composer realizará o download do código-fonte e das dependências necessárias.

Esse procedimento pode levar alguns minutos.

---

# 8. Verificando o código-fonte

Após o término da instalação, verifique o conteúdo do diretório:

```bash
ls -lah
```

Entre os arquivos e diretórios esperados estão:

```text
app/
bin/
composer.json
composer.lock
generated/
pub/
setup/
var/
vendor/
```

Verifique o arquivo principal do Composer:

```bash
ls -l composer.json
```

Confirme a existência do diretório de dependências:

```bash
ls -ld vendor
```

---

# 9. Verificando a versão do Magento

Verifique a versão instalada:

```bash
php bin/magento --version
```

Também é possível verificar através do Composer:

```bash
composer show magento/product-community-edition
```

Esses comandos permitem confirmar a versão do Magento instalada no projeto.

---

# 10. Validando o Composer

Execute:

```bash
composer validate
```

O Composer deverá informar se o arquivo `composer.json` possui uma estrutura válida.

Também é possível verificar as dependências instaladas:

```bash
composer show --direct
```

---

# 11. Preparando o ambiente Docker

Entre no diretório Docker:

```bash
cd ~/mage2bar/docker
```

Verifique os arquivos:

```bash
ls -lah
```

Os arquivos principais esperados são:

```text
Dockerfile
docker-compose.yml
.env.example
nginx/
```

A estrutura poderá ser semelhante a:

```text
docker/
├── Dockerfile
├── docker-compose.yml
├── .env.example
└── nginx/
    ├── default.conf
    └── ssl/
```

---

# 12. Criando o arquivo .env

O arquivo `.env.example` funciona como modelo de configuração.

Crie uma cópia:

```bash
cp .env.example .env
```

Verifique:

```bash
ls -lah .env
```

Abra o arquivo:

```bash
vim .env
```

A configuração utilizada pelo projeto possui variáveis para MariaDB, Redis e OpenSearch.

Um exemplo é:

```dotenv
MYSQL_ROOT_PASSWORD=suasenhadomysqlroot
MYSQL_DATABASE=magento_db
MYSQL_USER=magento_user
MYSQL_PASSWORD=suasenhadabancodedados

REDIS_PASSWORD=suasenharedis

OPENSEARCH_USER=admin
OPENSEARCH_PASSWORD=suasenhaopensearch

MYSQL_PORT=3306
REDIS_PORT=6379
OPENSEARCH_PORT=9200
```

Utilize senhas próprias para o ambiente.

As credenciais reais não devem ser publicadas no repositório.

---

# 13. Protegendo o arquivo .env

O arquivo `.env` contém informações sensíveis.

Ajuste suas permissões:

```bash
chmod 600 .env
```

Verifique:

```bash
ls -l .env
```

O arquivo deverá estar acessível somente pelo usuário proprietário.

Também é importante confirmar que `.env` não será versionado pelo Git.

Verifique o arquivo `.gitignore`:

```bash
cat ../.gitignore
```

Caso necessário, adicione:

```text
.env
```

O arquivo `.env.example`, por outro lado, pode permanecer versionado, pois serve como modelo de configuração.

---

# 14. Validando o Docker Compose

Antes de iniciar os containers, valide a configuração do Docker Compose:

```bash
docker compose config
```

Esse comando processa o arquivo `docker-compose.yml` e as variáveis existentes no `.env`.

Caso exista algum problema de sintaxe ou variável ausente, o Docker Compose deverá informar o erro.

Somente após a validação bem-sucedida prossiga para a construção das imagens.

---

# 15. Construindo a imagem do Magento

O serviço `magento_server` utiliza o `Dockerfile` existente no diretório Docker.

Execute:

```bash
docker compose build magento_server
```

Durante o processo, o Docker irá:

1. Obter a imagem base PHP-FPM.
2. Instalar os pacotes necessários.
3. Instalar as extensões PHP.
4. Criar o usuário `magento`.
5. Configurar o PHP.
6. Instalar o Composer.
7. Preparar o diretório `/var/www/html`.

A construção pode levar alguns minutos.

---

# 16. Verificando a imagem construída

Após a construção:

```bash
docker images
```

Também é possível verificar a imagem criada pelo Compose:

```bash
docker compose images
```

---

# 17. Iniciando os serviços

Com a imagem construída, inicie o ambiente:

```bash
docker compose up -d
```

O parâmetro `-d` executa os containers em segundo plano.

Verifique o estado dos serviços:

```bash
docker compose ps
```

Os serviços definidos pelo projeto são:

```text
magento_db
magento_redis
magento_opensearch
magento_server
magento_nginx
```

---

# 18. Verificando os containers

Também é possível verificar diretamente os containers:

```bash
docker ps
```

Caso algum container não esteja funcionando corretamente, consulte os logs.

MariaDB:

```bash
docker compose logs magento_db
```

Redis:

```bash
docker compose logs magento_redis
```

OpenSearch:

```bash
docker compose logs magento_opensearch
```

PHP-FPM:

```bash
docker compose logs magento_server
```

Nginx:

```bash
docker compose logs magento_nginx
```

---

# 19. Verificando o PHP dentro do container

O PHP utilizado pela aplicação é o PHP existente na imagem Docker.

Verifique a versão:

```bash
docker compose exec magento_server php -v
```

Verifique o Composer:

```bash
docker compose exec magento_server composer --version
```

Verifique a versão do Magento:

```bash
docker compose exec magento_server php bin/magento --version
```

---

# 20. Verificando as extensões PHP

Execute:

```bash
docker compose exec magento_server php -m
```

Também é possível verificar as principais extensões:

```bash
docker compose exec magento_server php -m | grep -E 'bcmath|curl|dom|gd|intl|mbstring|openssl|pdo_mysql|soap|sockets|xml|xsl|zip'
```

As extensões necessárias para o Magento deverão estar disponíveis.

---

# 21. Verificando o MariaDB

O Magento utiliza o serviço:

```text
magento_db
```

Dentro da rede Docker, o nome do serviço funciona como hostname.

Portanto, o Magento não deverá utilizar `localhost` para acessar o banco de dados.

O hostname utilizado será:

```text
magento_db
```

Verifique o container:

```bash
docker compose ps magento_db
```

Também é possível acessar o MariaDB:

```bash
docker compose exec magento_db mariadb -u root -p
```

Digite a senha definida em:

```text
MYSQL_ROOT_PASSWORD
```

Dentro do MariaDB, verifique os bancos:

```sql
SHOW DATABASES;
```

Saia:

```sql
exit;
```

---

# 22. Verificando o Redis

O Redis utiliza o serviço:

```text
magento_redis
```

Verifique o container:

```bash
docker compose ps magento_redis
```

O Redis está configurado com autenticação através da variável:

```text
REDIS_PASSWORD
```

Teste a conexão:

```bash
docker compose exec magento_redis redis-cli -a '<REDIS_PASSWORD>' ping
```

O resultado esperado é:

```text
PONG
```

Substitua `<REDIS_PASSWORD>` pela senha configurada no `.env`.

---

# 23. Verificando o OpenSearch

O serviço de busca utilizado pelo Magento é:

```text
magento_opensearch
```

Verifique o container:

```bash
docker compose ps magento_opensearch
```

A configuração atual utiliza um único nó:

```text
discovery.type=single-node
```

O acesso interno ao serviço utiliza:

```text
http://magento_opensearch:9200
```

Teste a comunicação a partir do container Magento:

```bash
docker compose exec magento_server curl http://magento_opensearch:9200
```

Também é possível consultar a saúde do cluster:

```bash
docker compose exec magento_server curl http://magento_opensearch:9200/_cluster/health
```

---

# 24. Verificando a rede Docker

Todos os serviços estão conectados à mesma rede definida pelo projeto:

```text
magento_net
```

Verifique as redes:

```bash
docker network ls
```

Também é possível consultar a rede criada pelo Compose:

```bash
docker network inspect docker_magento_net
```

O nome exato poderá variar conforme o nome do projeto utilizado pelo Docker Compose.

Dentro da rede, os serviços podem utilizar seus respectivos nomes como hostnames:

```text
magento_db
magento_redis
magento_opensearch
magento_server
magento_nginx
```

---

# 25. Verificando a resolução dos serviços

A partir do container Magento, teste o MariaDB:

```bash
docker compose exec magento_server getent hosts magento_db
```

Teste o Redis:

```bash
docker compose exec magento_server getent hosts magento_redis
```

Teste o OpenSearch:

```bash
docker compose exec magento_server getent hosts magento_opensearch
```

Se os nomes forem resolvidos corretamente, a comunicação básica entre os containers está funcionando.

---

# 26. Verificando o Nginx

O Nginx utiliza o serviço:

```text
magento_nginx
```

As portas configuradas no `docker-compose.yml` são:

```text
80:80
443:443
```

Verifique:

```bash
docker compose ps magento_nginx
```

Consulte os logs:

```bash
docker compose logs magento_nginx
```

Teste a configuração:

```bash
docker compose exec magento_nginx nginx -t
```

O resultado esperado deverá indicar que a configuração está correta.

---

# 27. Verificando o diretório público do Magento

O Magento utiliza o diretório:

```text
pub/
```

como raiz pública da aplicação.

Verifique:

```bash
ls -lah ~/mage2bar/magento2/pub
```

O Nginx deverá utilizar esse diretório como `document root`.

A configuração do Nginx é definida no arquivo:

```text
docker/nginx/default.conf
```

Esse arquivo é responsável por direcionar as requisições da aplicação para o PHP-FPM.

---

# 28. Verificando as permissões da aplicação

O container PHP utiliza o usuário:

```text
magento
```

com UID e GID:

```text
1001
```

Como o Docker Compose utiliza um bind mount:

```text
../magento2:/var/www/html
```

os arquivos do host são montados diretamente dentro do container.

Por esse motivo, as permissões existentes no host devem ser compatíveis com o usuário utilizado pelo container.

Verifique:

```bash
ls -ld ~/mage2bar/magento2
```

Também verifique:

```bash
ls -lah ~/mage2bar/magento2
```

---

# 29. Ajustando o proprietário dos arquivos

Caso seja necessário ajustar o proprietário para o usuário utilizado pelo container:

```bash
sudo chown -R 1001:1001 ~/mage2bar/magento2
```

Depois verifique:

```bash
ls -ld ~/mage2bar/magento2
```

Evite utilizar permissões excessivamente abertas.

ATENÇÃO: Nunca utilize o comando abaixo como solução padrão para problemas de permissão.

```bash
chmod -R 777 #Nunca utilize esse comando!
```



---

# 30. Preparando os diretórios graváveis

Alguns diretórios do Magento precisam permitir escrita durante a instalação e execução da aplicação.

Entre eles:

```text
var/
generated/
pub/static/
pub/media/
app/etc/
```

Caso seja necessário ajustar as permissões:

```bash
sudo chmod -R u+rwX ~/mage2bar/magento2/var
sudo chmod -R u+rwX ~/mage2bar/magento2/generated
sudo chmod -R u+rwX ~/mage2bar/magento2/pub/static
sudo chmod -R u+rwX ~/mage2bar/magento2/pub/media
sudo chmod -R u+rwX ~/mage2bar/magento2/app/etc
```

---

# 31. Verificando a disponibilidade dos serviços

Antes de executar a instalação do Magento, verifique novamente:

```bash
docker compose ps
```

Todos os containers necessários deverão estar em execução.

Verifique o PHP:

```bash
docker compose exec magento_server php -v
```

Verifique o banco:

```bash
docker compose exec magento_server getent hosts magento_db
```

Verifique o Redis:

```bash
docker compose exec magento_server getent hosts magento_redis
```

Verifique o OpenSearch:

```bash
docker compose exec magento_server curl http://magento_opensearch:9200
```

---

# 32. Executando a instalação do Magento

Com os serviços disponíveis, a instalação poderá ser executada pelo comando:

```bash
docker compose exec magento_server php bin/magento setup:install
```

O comando deverá receber as informações necessárias para conexão com o banco de dados, configuração da aplicação, usuário administrativo e mecanismo de busca.

Um exemplo de instalação é:

```bash
docker compose exec magento_server php bin/magento setup:install \
--base-url=http://localhost/ \
--db-host=magento_db \
--db-name=magento_db \
--db-user=magento_user \
--db-password='<MYSQL_PASSWORD>' \
--backend-frontname=admin \
--admin-firstname=Admin \
--admin-lastname=Magento \
--admin-email=admin@example.com \
--admin-user=admin \
--admin-password='<ADMIN_PASSWORD>' \
--language=pt_BR \
--currency=BRL \
--timezone=America/Sao_Paulo \
--use-rewrites=1 \
--search-engine=opensearch \
--opensearch-host=magento_opensearch \
--opensearch-port=9200 \
--opensearch-index-prefix=magento2 \
--opensearch-timeout=15
```

Substitua:

```text
<MYSQL_PASSWORD>
```

pela senha definida em:

```text
MYSQL_PASSWORD
```

Substitua:

```text
<ADMIN_PASSWORD>
```

pela senha que será utilizada pelo usuário administrativo.

A senha administrativa deve atender aos requisitos de segurança do Magento.

---

# 33. Configurando o Redis

Após a instalação, o Redis poderá ser utilizado para cache e sessões.

O hostname utilizado dentro da rede Docker é:

```text
magento_redis
```

A porta padrão utilizada internamente é:

```text
6379
```

A autenticação utiliza a variável:

```text
REDIS_PASSWORD
```

A configuração deverá ser realizada de acordo com os parâmetros disponíveis na versão específica do Magento instalada.

Após configurar o Redis, limpe o cache:

```bash
docker compose exec magento_server php bin/magento cache:flush
```

---

# 34. Verificando o estado da aplicação

Verifique o modo de execução:

```bash
docker compose exec magento_server php bin/magento deploy:mode:show
```

Verifique o cache:

```bash
docker compose exec magento_server php bin/magento cache:status
```

Verifique os indexadores:

```bash
docker compose exec magento_server php bin/magento indexer:status
```

---

# 35. Verificando o banco de dados

Confirme que o Magento criou as tabelas:

```bash
docker compose exec magento_db mariadb \
-u"${MYSQL_USER}" \
-p"${MYSQL_PASSWORD}" \
"${MYSQL_DATABASE}" \
-e "SHOW TABLES;"
```

O resultado deverá apresentar as tabelas utilizadas pelo Magento.

---

# 36. Verificando os índices do OpenSearch

Depois da instalação, consulte os índices:

```bash
docker compose exec magento_server curl \
http://magento_opensearch:9200/_cat/indices?v
```

O Magento deverá criar os índices utilizados pela busca do catálogo.

Verifique também os indexadores:

```bash
docker compose exec magento_server php bin/magento indexer:status
```

---

# 37. Limpando o cache

Execute:

```bash
docker compose exec magento_server php bin/magento cache:flush
```

Verifique:

```bash
docker compose exec magento_server php bin/magento cache:status
```

---

# 38. Configurando o modo Developer

Para um ambiente de desenvolvimento, o modo Developer pode ser utilizado.

Verifique o modo atual:

```bash
docker compose exec magento_server php bin/magento deploy:mode:show
```

Caso seja necessário alterar para Developer:

```bash
docker compose exec magento_server php bin/magento deploy:mode:set developer
```

Depois limpe o cache:

```bash
docker compose exec magento_server php bin/magento cache:flush
```

---

# 39. Reiniciando o ambiente

Após finalizar as configurações:

```bash
docker compose restart
```

Verifique novamente:

```bash
docker compose ps
```

Todos os serviços necessários deverão estar em execução.

---

# 40. Acessando a loja

Com os containers funcionando e o Nginx configurado, a aplicação poderá ser acessada pelo navegador.

Em um ambiente local:

```text
http://localhost/
```

A página inicial do Magento deverá ser apresentada.

---

# 41. Acessando o painel administrativo

O painel administrativo utiliza o caminho definido durante a instalação.

Neste exemplo:

```text
admin
```

Portanto:

```text
http://localhost/admin
```

O endereço exato dependerá do valor utilizado em:

```text
--backend-frontname
```

Informe o usuário administrativo e a senha configurada durante a instalação.

---

# 42. Verificação final

Execute os principais testes.

Verifique os containers:

```bash
docker compose ps
```

Verifique a versão do Magento:

```bash
docker compose exec magento_server php bin/magento --version
```

Verifique o modo de aplicação:

```bash
docker compose exec magento_server php bin/magento deploy:mode:show
```

Verifique o cache:

```bash
docker compose exec magento_server php bin/magento cache:status
```

Verifique os indexadores:

```bash
docker compose exec magento_server php bin/magento indexer:status
```

Teste o banco:

```bash
docker compose exec magento_server getent hosts magento_db
```

Teste o Redis:

```bash
docker compose exec magento_server getent hosts magento_redis
```

Teste o OpenSearch:

```bash
docker compose exec magento_server curl http://magento_opensearch:9200
```

Teste o Nginx:

```bash
docker compose exec magento_nginx nginx -t
```

---

# 43. Consultando os logs

Caso a aplicação apresente algum erro, os logs dos serviços podem ser consultados individualmente.

PHP-FPM:

```bash
docker compose logs magento_server
```

Nginx:

```bash
docker compose logs magento_nginx
```

MariaDB:

```bash
docker compose logs magento_db
```

Redis:

```bash
docker compose logs magento_redis
```

OpenSearch:

```bash
docker compose logs magento_opensearch
```

Também é possível acompanhar os logs em tempo real:

```bash
docker compose logs -f magento_server
```

Para interromper o acompanhamento:

```text
Ctrl + C
```

---

# 44. Persistência dos dados

O ambiente utiliza diretórios persistentes para os serviços que armazenam dados.

MariaDB:

```text
./data/db
```

Redis:

```text
./data/redis
```

OpenSearch:

```text
./data/opensearch
```

Esses diretórios permitem que os dados permaneçam armazenados mesmo quando os containers são recriados.

Por esse motivo, os diretórios `data/` devem ser tratados como parte importante do ambiente.

---

# 45. Parando o ambiente

Para parar os containers:

```bash
docker compose stop
```

Os containers serão interrompidos, mas permanecerão disponíveis para serem iniciados novamente.

Para iniciar novamente:

```bash
docker compose start
```

---

# 46. Recriando o ambiente

Caso seja necessário recriar os containers:

```bash
docker compose down
```

Depois:

```bash
docker compose up -d
```

O comando `down` remove os containers e a rede criada pelo Compose.

Os diretórios utilizados como bind mounts para persistência permanecem no sistema de arquivos.

---

# 47. Cuidado com a remoção dos dados

Não utilize comandos destrutivos sem verificar o que será removido.

Por exemplo:

```bash
docker compose down -v
```

pode remover volumes Docker associados ao ambiente.

Como o Mage2Bar utiliza diretórios persistentes para MariaDB, Redis e OpenSearch, é importante compreender a diferença entre:

```text
container
```

e:

```text
dados persistentes
```

Antes de remover qualquer diretório em:

```text
data/
```

confirme se existe um backup.

---

# 48. Estado final do ambiente

Ao final desta etapa, a estrutura deverá estar organizada aproximadamente da seguinte maneira:

```text
mage2bar/
├── docker/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   ├── .env
│   ├── .env.example
│   └── nginx/
│       ├── default.conf
│       └── ssl/
│
├── magento2/
│   ├── app/
│   ├── bin/
│   ├── composer.json
│   ├── composer.lock
│   ├── generated/
│   ├── pub/
│   ├── setup/
│   ├── var/
│   └── vendor/
│
└── data/
```

O ambiente Docker deverá possuir os seguintes serviços:

```text
magento_db
magento_redis
magento_opensearch
magento_server
magento_nginx
```

A comunicação entre os serviços ocorrerá através da rede:

```text
magento_net
```

---

# Considerações

A partir desta etapa, o Mage2Bar passa a possuir uma infraestrutura composta por múltiplos containers.

O Debian permanece como sistema operacional base, enquanto o Docker fornece o isolamento dos serviços da aplicação.

A arquitetura utilizada separa responsabilidades:

```text
Nginx
   |
   v
PHP-FPM
   |
   +---- MariaDB
   |
   +---- Redis
   |
   +---- OpenSearch
```

Essa separação facilita o desenvolvimento, a manutenção e a reprodução do ambiente.

A configuração atual do projeto possui características de laboratório e desenvolvimento.

O `Dockerfile` utiliza PHP 8.2-FPM.

O `docker-compose.yml` utiliza MariaDB 10.6, Redis 7 e OpenSearch 2.11.1.

Antes de utilizar essa mesma composição em produção, as versões das dependências deverão ser validadas de acordo com os requisitos oficiais da versão exata do Magento instalada.

Também é importante observar que o OpenSearch está configurado com:

```text
discovery.type=single-node
```

e:

```text
plugins.security.disabled=true
```

Essa configuração simplifica a utilização do serviço em um ambiente de desenvolvimento, mas não deve ser considerada automaticamente uma configuração de segurança para produção.

---

# Conclusão

Nesta etapa foi construído o ambiente Docker do Mage2Bar e realizada a instalação inicial do Magento 2.

Foram configurados:

```text
Debian
Docker
Docker Compose
PHP-FPM
Nginx
MariaDB
Redis
OpenSearch
Composer
Magento Open Source
```

Também foram configuradas as comunicações entre os containers, a persistência dos dados e o acesso à aplicação.

Ao final desta etapa, o Magento deverá estar disponível através do Nginx, com acesso à loja e ao painel administrativo.

O ambiente criado nesta etapa servirá como base para as próximas configurações do projeto.

---

## Próxima etapa

Com o Magento instalado e o ambiente Docker funcionando, a próxima etapa poderá abordar as configurações complementares da aplicação e da infraestrutura.

```text
09-configurando-o-magento-2.md
```
