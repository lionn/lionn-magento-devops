# Instalando o Magento 2

## Mage2Bar

Este documento descreve o processo de obtenção e instalação do **Magento Open Source 2** no ambiente Debian 13 utilizado pelo projeto Mage2Bar.

A instalação será realizada utilizando o **Composer** e o repositório oficial de pacotes do Magento.

As credenciais necessárias para autenticação no repositório do Magento foram obtidas na etapa anterior, através das **Magento Access Keys**.

Neste momento, o objetivo é obter o código-fonte do Magento e preparar sua estrutura inicial. A configuração dos serviços necessários para executar a aplicação será realizada nas etapas posteriores do projeto.

---

## Objetivo

Nesta etapa serão realizadas as seguintes configurações:

* verificar o ambiente utilizado pelo projeto;
* verificar a instalação do PHP;
* verificar as extensões necessárias do PHP;
* verificar a instalação do Composer;
* verificar as Magento Access Keys;
* configurar a autenticação do Composer;
* criar o diretório do projeto;
* obter o Magento Open Source através do Composer;
* verificar a estrutura inicial da aplicação;
* validar a instalação;
* verificar as dependências do projeto.

---

## Pré-requisitos

Antes de iniciar este procedimento, é necessário possuir uma máquina virtual configurada no **Oracle VirtualBox** e preparada para executar o Debian 13.

O projeto **lionn-virtualbox** contém um guia para criação e configuração de máquinas virtuais utilizando o Oracle VirtualBox, incluindo configuração de hardware virtual, armazenamento, rede e instalação do sistema operacional.

Consulte:

**lionn-virtualbox**

Também será necessário possuir:

* Debian 13 instalado;
* usuário com acesso ao terminal;
* conexão de rede funcional;
* PHP instalado;
* Composer instalado;
* Magento Access Keys obtidas;
* espaço disponível em disco.

A documentação anterior do projeto deve ter sido concluída até a etapa de obtenção das Magento Access Keys.

---

# 1. Verificando o sistema operacional

Antes de iniciar a instalação do Magento, confirme a versão do sistema operacional:

```bash
cat /etc/os-release
```

O ambiente utilizado pelo projeto deverá apresentar o Debian 13.

Também é possível verificar a versão do kernel:

```bash
uname -r
```

A verificação permite confirmar que o procedimento está sendo executado no ambiente definido para o laboratório.

---

# 2. Verificando o PHP

O Magento 2 utiliza o PHP como ambiente de execução.

Verifique a versão instalada:

```bash
php -v
```

Também é possível verificar o caminho utilizado pelo sistema:

```bash
which php
```

A versão do PHP deverá ser compatível com a versão do Magento que será instalada.

Para a linha Magento Open Source 2.4.8, os requisitos de PHP variam de acordo com a versão de patch. A documentação atual da Adobe lista PHP 8.3 e 8.4 para as versões 2.4.8 atualmente suportadas.

---

# 3. Verificando as extensões do PHP

Além do interpretador PHP, o Magento necessita de diversas extensões para funcionar corretamente.

Verifique as extensões instaladas:

```bash
php -m
```

Entre as extensões utilizadas pelo Magento estão:

* bcmath;
* ctype;
* curl;
* dom;
* fileinfo;
* gd;
* intl;
* mbstring;
* openssl;
* pdo_mysql;
* soap;
* sodium;
* xml;
* xsl;
* zip.

A relação exata de extensões deve ser conferida de acordo com a versão do Magento instalada. A documentação oficial da Adobe mantém a lista de requisitos de PHP para as versões suportadas.

Para verificar uma extensão específica:

```bash
php -m | grep -i intl
```

Outro exemplo:

```bash
php -m | grep -i mbstring
```

Caso alguma extensão necessária esteja ausente, ela deverá ser instalada antes de continuar.

---

# 4. Verificando o Composer

O Composer será utilizado para obter o Magento Open Source e gerenciar suas dependências.

Verifique a instalação:

```bash
composer --version
```

Também é possível verificar o caminho do executável:

```bash
which composer
```

O resultado esperado será semelhante a:

```text
/usr/local/bin/composer
```

O Magento Open Source utiliza o Composer para gerenciamento dos pacotes PHP e de suas dependências.

---

# 5. Verificando as Magento Access Keys

As **Magento Access Keys** são utilizadas para autenticar o Composer no repositório oficial de pacotes do Magento.

As credenciais possuem dois componentes:

```text
Public Key
Private Key
```

A Public Key funciona como identificador.

A Private Key funciona como credencial de autenticação.

As chaves foram obtidas na etapa anterior:

```text
07-obtendo-as-magento-access-keys.md
```

> A Private Key deve ser tratada como uma informação sensível e não deve ser publicada no repositório do projeto.

---

# 6. Configurando a autenticação do Composer

O Composer permite configurar as credenciais utilizadas para acessar o repositório do Magento.

Execute:

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

Exemplo:

```bash
composer config --global http-basic.repo.magento.com xxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxx
```

Os valores apresentados são apenas exemplos.

Nunca adicione credenciais reais aos arquivos de documentação ou ao repositório Git.

---

# 7. Verificando a configuração do Composer

Após configurar a autenticação, é possível verificar as configurações globais do Composer:

```bash
composer config --global --list
```

A configuração relacionada ao repositório do Magento deverá estar disponível no ambiente do usuário.

> Evite compartilhar a saída completa desse comando caso ela contenha informações relacionadas às credenciais configuradas.

---

# 8. Criando o diretório do projeto

Crie o diretório que será utilizado para armazenar a aplicação:

```bash
mkdir -p ~/mage2bar
```

Entre no diretório:

```bash
cd ~/mage2bar
```

Verifique o diretório atual:

```bash
pwd
```

O resultado será semelhante a:

```text
/home/<usuario>/mage2bar
```

A localização do projeto pode ser alterada posteriormente de acordo com a arquitetura definitiva do ambiente.

---

# 9. Obtendo o Magento Open Source através do Composer

Com o Composer configurado e as Magento Access Keys disponíveis, o código do Magento Open Source poderá ser obtido através do repositório oficial.

Para instalar a versão 2.4.8:

```bash
composer create-project --repository-url=https://repo.magento.com/ magento/project-community-edition=2.4.8 .
```

O caractere:

```text
.
```

indica que o projeto será criado no diretório atual.

O Composer realizará o download do projeto e das dependências necessárias.

A Adobe atualmente distribui o código do Magento Open Source através do Composer, e não mais como um pacote disponibilizado na seção tradicional de downloads.

---

# 10. Acompanhando o processo de instalação

Durante a execução do Composer, diversas operações serão realizadas.

Entre elas:

* obtenção do projeto;
* autenticação no repositório;
* resolução das dependências;
* download dos pacotes;
* instalação das dependências;
* criação do arquivo `composer.lock`;
* criação da estrutura de diretórios do Magento.

O tempo necessário poderá variar de acordo com:

* velocidade da conexão;
* desempenho da máquina virtual;
* quantidade de dependências;
* desempenho do armazenamento.

Não interrompa o processo enquanto o Composer estiver trabalhando.

---

# 11. Verificando a estrutura do projeto

Após a conclusão da instalação, liste o conteúdo do diretório:

```bash
ls -la
```

A estrutura deverá conter diretórios semelhantes a:

```text
app/
bin/
dev/
generated/
lib/
pub/
setup/
var/
vendor/
```

Também deverão existir arquivos como:

```text
composer.json
composer.lock
```

A estrutura poderá apresentar pequenas diferenças dependendo da versão instalada.

---

# 12. Verificando o diretório vendor

O diretório `vendor/` contém as bibliotecas e dependências instaladas pelo Composer.

Verifique sua existência:

```bash
ls -la vendor/
```

Também é possível verificar seu tamanho:

```bash
du -sh vendor/
```

Esse diretório é criado e administrado pelo Composer.

---

# 13. Verificando o composer.json

O arquivo `composer.json` contém informações relacionadas ao projeto e suas dependências.

Verifique o arquivo:

```bash
cat composer.json
```

Também é possível utilizar o Composer para validar sua estrutura:

```bash
composer validate
```

O Composer deverá informar se o arquivo está válido.

---

# 14. Verificando o composer.lock

O arquivo `composer.lock` registra as versões específicas das dependências utilizadas na instalação.

Verifique sua existência:

```bash
ls -lh composer.lock
```

O arquivo é importante para manter um conjunto de dependências reproduzível.

Enquanto o `composer.json` define as dependências do projeto, o `composer.lock` registra as versões efetivamente utilizadas.

---

# 15. Verificando a versão do Magento

O Magento possui uma interface de linha de comando através do arquivo:

```text
bin/magento
```

Verifique a versão instalada:

```bash
php bin/magento --version
```

Para este laboratório, o resultado deverá identificar a versão 2.4.8.

---

# 16. Verificando o Magento CLI

Execute:

```bash
php bin/magento
```

O comando deverá apresentar a lista de comandos disponíveis na interface de linha de comando do Magento.

A existência e execução do `bin/magento` confirma que a estrutura básica da aplicação foi obtida corretamente.

Neste momento, entretanto, a aplicação ainda não está configurada para operação completa.

---

# 17. Verificando os requisitos da plataforma

O Composer disponibiliza o comando `check-platform-reqs` para verificar os requisitos das dependências instaladas em relação ao ambiente atual.

Execute:

```bash
composer check-platform-reqs
```

O comando realizará verificações relacionadas à plataforma utilizada.

Eventuais erros deverão ser analisados antes de prosseguir.

---

# 18. Verificando o diretório pub

O Magento utiliza o diretório `pub/` como ponto de entrada público da aplicação.

Verifique seu conteúdo:

```bash
ls -la pub/
```

Entre os arquivos deverá existir:

```text
pub/index.php
```

A utilização do diretório `pub/` será importante posteriormente durante a configuração do servidor web.

> O diretório raiz completo do projeto não deverá ser utilizado como document root do servidor web.

---

# 19. Verificando o espaço disponível

O Magento possui diversas dependências e poderá utilizar uma quantidade significativa de armazenamento.

Verifique o espaço disponível:

```bash
df -h
```

Também é possível verificar o espaço ocupado pelo projeto:

```bash
du -sh .
```

Essa verificação será útil durante as próximas etapas, principalmente quando outros serviços forem adicionados ao laboratório.

---

# 20. Verificação final

Após concluir a instalação, execute os seguintes comandos:

```bash
php -v
```

```bash
composer --version
```

```bash
php bin/magento --version
```

```bash
composer validate
```

```bash
composer check-platform-reqs
```

```bash
ls -la
```

```bash
df -h
```

Os comandos permitem confirmar:

* versão do PHP;
* versão do Composer;
* versão do Magento;
* validade do projeto Composer;
* requisitos da plataforma;
* estrutura da aplicação;
* espaço disponível em disco.

---

# Considerações

O Magento Open Source foi obtido utilizando o Composer e o repositório oficial de pacotes.

As Magento Access Keys foram utilizadas para autenticação durante o processo de obtenção do código e das dependências.

Neste momento, a estrutura básica da aplicação Magento está disponível no ambiente Debian 13.

Entretanto, a instalação do código-fonte não representa a conclusão da configuração do Magento.

A aplicação ainda depende de serviços e configurações adicionais para funcionar corretamente, incluindo:

* banco de dados;
* servidor web;
* mecanismo de busca;
* cache;
* PHP-FPM;
* permissões do sistema de arquivos;
* configuração da aplicação.

Esses componentes serão adicionados progressivamente ao laboratório nas próximas etapas.

---

# Conclusão

O Magento Open Source 2 foi obtido através do Composer e sua estrutura inicial foi instalada no ambiente Debian 13 utilizado pelo projeto Mage2Bar.

A instalação foi validada através do Magento CLI e das ferramentas de verificação disponibilizadas pelo Composer.

O ambiente possui agora a base necessária para iniciar a configuração dos serviços que irão compor a arquitetura do Magento 2.

---

## Próxima etapa

A próxima etapa será dedicada à configuração dos componentes necessários para executar o Magento 2 no ambiente de laboratório.

A documentação continuará seguindo a estrutura:

```text
docs/
├── 01-instalando-o-debian.md
├── 02-preparando-o-debian.md
├── 03-restricao-de-acesso-ssh.md
├── 04-firewall.md
├── 05-instalando-o-docker.md
├── 06-instalando-o-composer.md
├── 07-obtendo-as-magento-access-keys.md
└── 08-instalando-o-magento-2.md
```

A partir desta etapa, o projeto passa da preparação do sistema e obtenção do código para a construção efetiva do ambiente Magento 2.
