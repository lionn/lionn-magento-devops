# Instalando o Magento 2 no ambiente Docker

## Mage2Bar

O Mage2Bar é um projeto prático para implantação de um ambiente Magento 2 utilizando Docker e serviços complementares necessários para a execução da aplicação.

Nesta etapa, o código-fonte do Magento será obtido através do Composer e o ambiente Docker será construído utilizando os arquivos de configuração do próprio projeto.

A arquitetura utiliza containers independentes para o PHP-FPM, Nginx, MariaDB, Redis e OpenSearch.

Ao final desta etapa, o Magento deverá estar instalado e acessível através do Nginx, incluindo a loja e o painel administrativo.

---

## Objetivo

Nesta etapa serão realizados os seguintes procedimentos:

1. Verificar Docker e Docker Compose.
2. Preparar a estrutura do projeto.
3. Configurar as Magento Access Keys.
4. Obter o código-fonte do Magento Open Source.
5. Configurar as variáveis de ambiente.
6. Construir a imagem PHP-FPM.
7. Inicializar os containers.
8. Validar MariaDB, Redis e OpenSearch.
9. Validar a comunicação entre os containers.
10. Configurar as permissões da aplicação.
11. Executar a instalação do Magento.
12. Validar os serviços.
13. Acessar a loja.
14. Acessar o painel administrativo.

Ao final da etapa, o ambiente Mage2Bar deverá possuir uma instalação funcional do Magento 2 executando sobre Docker.

---

# 1. Verificando o Docker

O Docker foi instalado na etapa anterior.

Verifique a versão instalada:

```bash
docker --version
```

Verifique também o Docker Compose:

```bash
docker compose version
```

Verifique o estado do serviço Docker:

```bash
sudo systemctl status docker
```

Caso o serviço não esteja em execução:

```bash
sudo systemctl start docker
```

Habilite a inicialização automática:

```bash
sudo systemctl enable docker
```

---

# 2. Verificando a execução do Docker

Execute o container de teste fornecido pelo próprio Docker:

```bash
docker run hello-world
```

Se o comando for executado corretamente, o mecanismo Docker está funcionando.

Também é possível verificar os containers existentes:

```bash
docker ps -a
```

---

# 3. Estrutura do projeto

Entre no diretório principal do Mage2Bar:

```bash
cd ~/mage2bar
```

Verifique seu conteúdo:

```bash
ls -lah
```

A estrutura utilizada pelo projeto deverá ser semelhante a:

```text
mage2bar/
├── docker/
│   ├── Dockerfile
│   ├── docker-compose.yml
│   ├── .env.example
│   └── nginx/
│       ├── default.conf
│       └── ssl/
│
└── magento2/
```

O diretório `magento2` contém o código-fonte da aplicação.

O diretório `docker` contém os arquivos utilizados para construir e executar a infraestrutura.

---

# 4. Obtendo as Magento Access Keys

O Magento utiliza um repositório oficial de pacotes acessível através do Composer.

Para obter o código-fonte, é necessário utilizar as Magento Access Keys obtidas na etapa anterior.

As credenciais são compostas por:

```text
Public Key
Private Key
```

A Public Key funciona como identificador.

A Private Key funciona como credencial secreta.

A Private Key não deve ser publicada no GitHub, adicionada ao código-fonte ou armazenada em arquivos versionados.

---

# 5. Configurando a autenticação do Composer

Configure as credenciais do repositório Magento:

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

O Composer armazenará essas informações na configuração global do usuário.

---

# 6. Criando o diretório do Magento

Entre no diretório principal do projeto:

```bash
cd ~/mage2bar
```

Caso o diretório da aplicação ainda não exista:

```bash
mkdir -p magento2
```

Entre no diretório:

```bash
cd magento2
```

---

# 7. Obtendo o código-fonte do Magento

O código-fonte do Magento Open Source será obtido através do Composer.

Execute:

```bash
composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=2.4.8 .
```

O ponto final indica que o projeto deverá ser instalado no diretório atual.

Durante o processo, o Composer realizará o download do código-fonte e das dependências necessárias.

O procedimento pode levar alguns minutos, dependendo da velocidade da conexão e do desempenho do ambiente.

---

# 8. Verificando o código-fonte

Após o término da instalação:

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

Verifique o diretório de dependências:

```bash
ls -ld vendor
```

---

# 9. Verificando a versão do Magento

A versão instalada pode ser verificada através do CLI:

```bash
php bin/magento --version
```

Também é possível consultar o pacote através do Composer:

```bash
composer show magento/product-community-edition
```

---

# 10. Validando o Composer

Valide a estrutura do projeto:

```bash
composer validate
```

Também é possível verificar as dependências instaladas:

```bash
composer show --direct
```

---

# 11. Verificando os requisitos da plataforma

Antes de iniciar os containers, verifique os requisitos das dependências:

```bash
composer check-platform-reqs
```

Esse comando verifica se a versão do PHP e as extensões disponíveis são compatíveis com os pacotes instalados.

O resultado deve ser analisado antes de continuar.

O `Dockerfile` utilizado pelo Mage2Bar atualmente utiliza a imagem:

```text
php:8.2-fpm
```

Portanto, caso o Composer indique alguma incompatibilidade entre a versão do Magento instalada e o PHP utilizado pelo projeto, o `Dockerfile` deverá ser revisado antes da continuidade da instalação.

As versões do Magento e de suas dependências devem ser sempre avaliadas de acordo com os requisitos da versão exata instalada.

---

# 12. Entrando no diretório Docker

Entre no diretório responsável pela infraestrutura:

```bash
cd ~/mage2bar/docker
```

Verifique os arquivos:

```bash
ls -lah
```

Os arquivos principais são:

```text
Dockerfile
docker-compose.yml
.env.example
nginx/
```

---

# 13. Criando o arquivo .env

O projeto possui um arquivo de exemplo para as variáveis de ambiente:

```text
.env.example
```

Crie o arquivo utilizado pelo Docker Compose:

```bash
cp .env.example .env
```

Verifique:

```bash
ls -lah .env
```

---

# 14. Configurando o .env

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

# 15. Protegendo o arquivo .env

Como o arquivo `.env` contém credenciais, suas permissões devem ser restritas.

Execute:

```bash
chmod 600 .env
```

Verifique:

```bash
ls -l .env
```

O arquivo deverá estar acessível somente pelo usuário proprietário.

Também confirme que o `.env` está incluído no `.gitignore`:

```bash
cat ../.gitignore
```

O arquivo `.env.example` pode permanecer versionado, pois serve como modelo de configuração.

---

# 16. Validando o Docker Compose

Antes de iniciar os serviços, valide a configuração:

```bash
docker compose config
```

Esse comando processa o `docker-compose.yml` juntamente com as variáveis presentes no `.env`.

Caso exista algum problema de sintaxe ou variável ausente, o Docker Compose deverá apresentar uma mensagem de erro.

Somente prossiga após uma validação bem-sucedida.

---

# 17. Construindo a imagem PHP-FPM

O serviço `magento_server` utiliza o `Dockerfile` existente no diretório:

```text
docker/
```

Construa a imagem:

```bash
docker compose build magento_server
```

O Docker irá construir a imagem PHP-FPM utilizada pela aplicação.

O `Dockerfile` instala as extensões PHP necessárias para o Magento e também instala o Composer dentro da imagem.

Entre as extensões utilizadas pelo projeto estão:

```text
bcmath
pdo_mysql
mysqli
intl
zip
gd
soap
xsl
opcache
sockets
sodium
exif
pcntl
gmp
```

O container também utiliza o usuário:

```text
magento
```

com UID e GID:

```text
1001
```

---

# 18. Verificando a imagem

Após a construção:

```bash
docker compose images
```

Também é possível consultar as imagens existentes:

```bash
docker images
```

---

# 19. Iniciando os containers

Inicie o ambiente:

```bash
docker compose up -d
```

O parâmetro `-d` executa os containers em segundo plano.

Verifique os serviços:

```bash
docker compose ps
```

O projeto utiliza os seguintes containers:

```text
magento_db
magento_redis
magento_opensearch
magento_server
magento_nginx
```

---

# 20. Verificando os containers

Também é possível verificar diretamente:

```bash
docker ps
```

Todos os serviços necessários deverão estar em execução.

Caso algum container apresente problemas, consulte seus logs.

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

# 21. Verificando o PHP dentro do container

O PHP utilizado pelo Magento é o PHP instalado na imagem Docker.

Verifique:

```bash
docker compose exec magento_server php -v
```

Verifique o Composer:

```bash
docker compose exec magento_server composer --version
```

Verifique o Magento:

```bash
docker compose exec magento_server php bin/magento --version
```

---

# 22. Verificando as extensões PHP

Execute:

```bash
docker compose exec magento_server php -m
```

Para consultar algumas extensões importantes:

```bash
docker compose exec magento_server php -m | grep -E 'bcmath|curl|dom|gd|intl|mbstring|openssl|pdo_mysql|soap|sockets|xml|xsl|zip'
```

As extensões necessárias devem estar disponíveis.

---

# 23. Verificando o MariaDB

O serviço de banco de dados utiliza o container:

```text
magento_db
```

Dentro da rede Docker, o nome do serviço é utilizado como hostname.

Portanto, a aplicação deverá utilizar:

```text
magento_db
```

e não:

```text
localhost
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

Dentro do MariaDB:

```sql
SHOW DATABASES;
```

Para sair:

```sql
exit;
```

---

# 24. Verificando o Redis

O Redis utiliza o serviço:

```text
magento_redis
```

Verifique:

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

# 25. Verificando o OpenSearch

O serviço de busca utiliza o container:

```text
magento_opensearch
```

Verifique:

```bash
docker compose ps magento_opensearch
```

O ambiente atual utiliza:

```text
discovery.type=single-node
```

e:

```text
plugins.security.disabled=true
```

Portanto, o OpenSearch está configurado para uso simplificado no ambiente de desenvolvimento.

O hostname interno utilizado pelo Magento é:

```text
magento_opensearch
```

Teste a comunicação:

```bash
docker compose exec magento_server curl http://magento_opensearch:9200
```

Também é possível consultar a saúde do cluster:

```bash
docker compose exec magento_server curl http://magento_opensearch:9200/_cluster/health
```

---

# 26. Verificando a rede Docker

Os serviços do projeto estão conectados através da rede:

```text
magento_net
```

Verifique as redes existentes:

```bash
docker network ls
```

Os containers poderão se comunicar utilizando seus nomes de serviço.

Exemplo:

```text
magento_db
magento_redis
magento_opensearch
magento_server
magento_nginx
```

---

# 27. Testando a resolução dos serviços

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

Se os nomes forem resolvidos corretamente, a comunicação básica entre os serviços está funcionando.

---

# 28. Verificando o Nginx

O Nginx utiliza o container:

```text
magento_nginx
```

As portas configuradas pelo projeto são:

```text
80:80
443:443
```

Verifique:

```bash
docker compose ps magento_nginx
```

Teste a configuração do Nginx:

```bash
docker compose exec magento_nginx nginx -t
```

O resultado deverá indicar que a configuração está correta.

---

# 29. Verificando o diretório público

O Magento utiliza:

```text
pub/
```

como diretório público da aplicação.

O Nginx está configurado para utilizar:

```text
/var/www/html/pub
```

como raiz pública.

Verifique no host:

```bash
ls -lah ~/mage2bar/magento2/pub
```

O arquivo de configuração utilizado pelo Nginx está localizado em:

```text
docker/nginx/default.conf
```

---

# 30. Verificando os diretórios graváveis

Alguns diretórios do Magento precisam permitir escrita durante a instalação e execução da aplicação.

Entre eles:

```text
var/
generated/
pub/static/
pub/media/
app/etc/
```

No ambiente Mage2Bar, o container PHP utiliza o usuário:

```text
magento
```

com UID e GID:

```text
1001
```

Como o projeto utiliza um bind mount:

```yaml
- ../magento2:/var/www/html
```

as permissões existentes no sistema de arquivos do host também são utilizadas dentro do container.

Por esse motivo, antes de modificar qualquer permissão, verifique o proprietário e as permissões atuais:

```bash
ls -ldn ~/mage2bar/magento2/var
ls -ldn ~/mage2bar/magento2/generated
ls -ldn ~/mage2bar/magento2/pub/static
ls -ldn ~/mage2bar/magento2/pub/media
ls -ldn ~/mage2bar/magento2/app/etc
```

O proprietário esperado para o ambiente atual é:

```text
UID 1001
GID 1001
```

Esse valor corresponde ao usuário `magento` utilizado pelo container PHP-FPM.

Caso os diretórios já pertençam ao usuário utilizado pelo container e possuam permissões adequadas, nenhuma alteração deverá ser realizada.

Não é recomendado utilizar permissões excessivamente abertas como:

```bash
chmod -R 777 ~/mage2bar/magento2
```

Essa configuração permitiria leitura, escrita e execução para todos os usuários do sistema e não é necessária para o funcionamento do Magento.

O diretório `pub/media` merece atenção especial porque é uma área gravável da aplicação.

Arquivos enviados ou armazenados nessa área não devem ser tratados pelo servidor web como código executável.

A configuração do Nginx deve impedir a execução de scripts PHP dentro de `pub/media`, inclusive em subdiretórios como:

```text
pub/media/customer_address/
```

A proteção dessa área deve ser realizada através da configuração do servidor web e não simplesmente através da remoção da permissão de escrita necessária ao Magento.

---

# 31. Verificando a proteção do pub/media

A configuração do Nginx utilizada pelo projeto possui uma regra específica para impedir a execução de PHP dentro da área de mídia.

O objetivo é impedir requisições como:

```text
/media/arquivo.php
/media/customer_address/arquivo.php
/media/qualquer/subdiretorio/arquivo.php
```

de serem encaminhadas para o PHP-FPM.

Verifique a configuração:

```bash
grep -n -A8 -B2 'media' ~/mage2bar/docker/nginx/default.conf
```

Também valide a configuração completa:

```bash
docker compose exec magento_nginx nginx -t
```

Essa proteção é uma camada importante de segurança para diretórios graváveis.

---

# 32. Verificando os arquivos sensíveis

O Nginx utilizado pelo Mage2Bar possui regras para bloquear o acesso direto a determinados arquivos e diretórios sensíveis.

Entre eles estão:

```text
.env
.log
.sql
.lock
.bak
.gz
```

Também são protegidos diretórios internos do Magento, como:

```text
app/
var/
vendor/
setup/
dev/
```

O objetivo é impedir que arquivos internos da aplicação sejam disponibilizados diretamente através do servidor web.

---

# 33. Executando a instalação do Magento

Antes de iniciar a instalação, confirme:

```bash
docker compose ps
```

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

Com os serviços disponíveis, execute:

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

# 34. Verificando a instalação

Após o término do processo:

```bash
docker compose exec magento_server php bin/magento --version
```

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

Confirme que o banco foi criado:

```bash
docker compose exec magento_db mariadb \
-u"${MYSQL_USER}" \
-p"${MYSQL_PASSWORD}" \
"${MYSQL_DATABASE}" \
-e "SHOW TABLES;"
```

O resultado deverá apresentar as tabelas utilizadas pelo Magento.

---

# 36. Verificando o OpenSearch após a instalação

Depois da instalação, consulte os índices:

```bash
docker compose exec magento_server curl \
http://magento_opensearch:9200/_cat/indices?v
```

Verifique também os indexadores:

```bash
docker compose exec magento_server php bin/magento indexer:status
```

Caso algum indexador esteja inválido ou desatualizado:

```bash
docker compose exec magento_server php bin/magento indexer:reindex
```

Depois:

```bash
docker compose exec magento_server php bin/magento indexer:status
```

---

# 37. Limpando o cache

Execute:

```bash
docker compose exec magento_server php bin/magento cache:flush
```

Verifique novamente:

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

Caso seja necessário utilizar o modo Developer:

```bash
docker compose exec magento_server php bin/magento deploy:mode:set developer
```

Depois:

```bash
docker compose exec magento_server php bin/magento cache:flush
```

O modo utilizado deverá ser definido de acordo com a finalidade do ambiente.

---

# 39. Reiniciando os serviços

Após concluir as configurações:

```bash
docker compose restart
```

Verifique novamente:

```bash
docker compose ps
```

---

# 40. Acessando a loja

Com os containers funcionando e o Nginx configurado, a loja poderá ser acessada através do navegador.

Em um ambiente local:

```text
http://localhost/
```

Caso o ambiente esteja configurado com domínio e certificado:

```text
https://lionn.net/
```

A página inicial do Magento deverá ser apresentada.

---

# 41. Acessando o painel administrativo

O painel administrativo utiliza o caminho definido durante a instalação.

Neste exemplo:

```text
admin
```

O acesso será:

```text
http://localhost/admin
```

ou, utilizando o domínio configurado:

```text
https://lionn.net/admin
```

O endereço poderá ser diferente caso outro valor tenha sido definido através de:

```text
--backend-frontname
```

---

# 42. Verificação final

Execute os principais testes do ambiente.

Containers:

```bash
docker compose ps
```

Versão do Magento:

```bash
docker compose exec magento_server php bin/magento --version
```

Modo da aplicação:

```bash
docker compose exec magento_server php bin/magento deploy:mode:show
```

Status do cache:

```bash
docker compose exec magento_server php bin/magento cache:status
```

Status dos indexadores:

```bash
docker compose exec magento_server php bin/magento indexer:status
```

MariaDB:

```bash
docker compose exec magento_server getent hosts magento_db
```

Redis:

```bash
docker compose exec magento_server getent hosts magento_redis
```

OpenSearch:

```bash
docker compose exec magento_server curl http://magento_opensearch:9200
```

Nginx:

```bash
docker compose exec magento_nginx nginx -t
```

---

# 43. Consultando os logs

Os logs podem ser consultados individualmente.

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

Para acompanhar os logs do PHP-FPM em tempo real:

```bash
docker compose logs -f magento_server
```

Para interromper:

```text
Ctrl + C
```

---

# 44. Persistência dos dados

O projeto utiliza diretórios persistentes para os serviços que armazenam dados.

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

Esses diretórios permitem preservar os dados mesmo quando os containers são recriados.

Por esse motivo, os diretórios de dados devem ser tratados como parte importante do ambiente.

---

# 45. Parando o ambiente

Para interromper os containers:

```bash
docker compose stop
```

Os containers serão parados, mas permanecerão disponíveis para serem iniciados novamente.

Para iniciar:

```bash
docker compose start
```

---

# 46. Recriando o ambiente

Para remover os containers e a rede criada pelo Compose:

```bash
docker compose down
```

Para iniciar novamente:

```bash
docker compose up -d
```

Os diretórios utilizados como bind mounts e os diretórios persistentes permanecem no sistema de arquivos.

---

# 47. Cuidado com a remoção dos dados

Não utilize comandos destrutivos sem verificar previamente o que será removido.

Por exemplo:

```bash
docker compose down -v
```

pode remover volumes Docker associados ao ambiente.

Além disso, os diretórios utilizados pelo projeto para persistência devem ser tratados com cuidado.

Antes de remover:

```text
data/db/
data/redis/
data/opensearch/
```

confirme se os dados possuem backup ou se podem ser descartados.

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
└── magento2/
    ├── app/
    ├── bin/
    ├── composer.json
    ├── composer.lock
    ├── generated/
    ├── pub/
    ├── setup/
    ├── var/
    └── vendor/
```

O ambiente Docker deverá possuir os seguintes serviços:

```text
magento_db
magento_redis
magento_opensearch
magento_server
magento_nginx
```

Os serviços estarão conectados através da rede:

```text
magento_net
```

---

# Considerações

A partir desta etapa, o Mage2Bar passa a possuir uma infraestrutura composta por múltiplos containers.

O Debian permanece como sistema operacional base, enquanto o Docker fornece o isolamento dos serviços utilizados pela aplicação.

A arquitetura separa as principais responsabilidades:

```text
                    Nginx
                      |
                      v
                  PHP-FPM
                 /   |   \
                /    |    \
               v     v     v
          MariaDB   Redis  OpenSearch
```

Essa separação facilita a manutenção, reprodução e evolução do ambiente.

A configuração atual do projeto utiliza:

```text
PHP-FPM 8.2
MariaDB 10.6
Redis 7
OpenSearch 2.11.1
Nginx
Docker Compose
```

As versões das dependências devem ser avaliadas de acordo com a versão exata do Magento utilizada.

O ambiente atual possui características de desenvolvimento e laboratório.

O OpenSearch está configurado com:

```text
discovery.type=single-node
```

e:

```text
plugins.security.disabled=true
```

Essa configuração simplifica a utilização do serviço no ambiente de desenvolvimento, mas não deve ser considerada automaticamente uma configuração adequada para produção.

Da mesma forma, a configuração de segurança do Magento não depende exclusivamente das permissões dos arquivos.

A proteção da aplicação envolve várias camadas:

```text
Sistema operacional
        +
Firewall
        +
Docker
        +
Permissões
        +
Nginx
        +
PHP-FPM
        +
Magento atualizado
        +
Patches de segurança
        +
HTTPS
        +
Credenciais protegidas
```

Diretórios graváveis, especialmente `pub/media`, devem receber atenção especial.

O fato de um diretório possuir permissão de escrita não significa que seu conteúdo deva ser tratado como código executável pelo servidor web.

Por esse motivo, a configuração do Nginx deve impedir a execução de PHP dentro de áreas destinadas ao armazenamento de arquivos enviados ou gerados pela aplicação.

---

# Conclusão

Nesta etapa foi construído o ambiente Docker do Mage2Bar e realizada a instalação inicial do Magento 2.

Foram configurados e validados:

```text
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

Também foram configuradas as comunicações entre os containers, a persistência dos dados e as permissões necessárias para execução da aplicação.

Ao final desta etapa, o Magento deverá estar disponível através do Nginx, permitindo acesso à loja e ao painel administrativo.

O ambiente criado servirá como base para as próximas etapas do projeto Mage2Bar.

---

## Próxima etapa

Com o Magento instalado e o ambiente Docker funcionando, a próxima etapa poderá abordar configurações adicionais da aplicação, otimizações e procedimentos de segurança.

```text
09-configurando-o-magento-2.md
```
