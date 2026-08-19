# Instalando o Composer

## Mage2Bar

Este documento descreve o processo de instalação do **Composer** no Debian 13 para utilização no projeto Mage2Bar.

O Composer será utilizado posteriormente para gerenciar as dependências do Magento 2 e dos componentes utilizados pelo projeto.

---

## Objetivo

Nesta etapa serão realizadas as seguintes configurações:

- verificar a instalação do PHP;
- baixar o instalador do Composer;
- validar o instalador;
- instalar o Composer;
- disponibilizar o Composer globalmente no sistema;
- verificar a instalação;
- realizar um teste básico do Composer.

---

# 1. Verificando a instalação do PHP

O Composer necessita do PHP para funcionar.

Antes de iniciar a instalação, verifique se o PHP está disponível no sistema:

```bash
php -v
```

O comando deverá apresentar a versão do PHP instalada.

Caso o PHP ainda não esteja instalado, a instalação deverá ser realizada antes de continuar.

---

# 2. Baixando o instalador do Composer

O instalador oficial do Composer será baixado utilizando o `curl`:

```bash
curl -sS https://getcomposer.org/installer -o composer-setup.php
```

O arquivo `composer-setup.php` será criado no diretório atual.

---

# 3. Validando o instalador

Antes de executar o instalador, será realizada uma validação da assinatura do arquivo.

Obtenha a assinatura atual disponibilizada pelo Composer:

```bash
EXPECTED_SIGNATURE="$(curl -sS https://composer.github.io/installer.sig)"
```

Calcule a assinatura do arquivo baixado:

```bash
ACTUAL_SIGNATURE="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"
```

Compare as duas assinaturas:

```bash
if [ "$EXPECTED_SIGNATURE" != "$ACTUAL_SIGNATURE" ]; then
    echo 'ERRO: assinatura do instalador do Composer inválida'
    rm composer-setup.php
    exit 1
else
    echo 'Assinatura do instalador válida'
fi
```

Se a assinatura for válida, o instalador poderá ser executado.

> **Atenção:** não execute um instalador cuja assinatura não corresponda à assinatura disponibilizada pelo Composer.

---

# 4. Instalando o Composer

Execute o instalador:

```bash
php composer-setup.php
```

Após a execução, o instalador criará o arquivo:

```text
composer.phar
```

no diretório atual.

---

# 5. Instalando o Composer globalmente

Para disponibilizar o comando `composer` para todos os usuários do sistema, mova o arquivo para `/usr/local/bin`:

```bash
sudo mv composer.phar /usr/local/bin/composer
```

Verifique se o arquivo foi instalado corretamente:

```bash
ls -l /usr/local/bin/composer
```

---

# 6. Removendo o instalador

Depois da instalação, o arquivo utilizado para realizar a instalação do Composer não será mais necessário.

Remova o instalador:

```bash
rm composer-setup.php
```

---

# 7. Verificando a instalação

Verifique a versão do Composer:

```bash
composer --version
```

O comando deverá apresentar a versão instalada.

Também é possível verificar o caminho utilizado pelo sistema:

```bash
which composer
```

O resultado esperado será semelhante a:

```text
/usr/local/bin/composer
```

---

# 8. Testando o Composer

Para realizar uma verificação básica da instalação e do ambiente, execute:

```bash
composer diagnose
```

O comando realizará algumas verificações relacionadas ao Composer e ao ambiente PHP.

Eventuais avisos apresentados devem ser analisados de acordo com a configuração do sistema.

---

# Considerações

O Composer foi instalado utilizando o instalador oficial e a assinatura do arquivo foi validada antes da execução.

A instalação global permite utilizar o comando:

```bash
composer
```

diretamente pelo terminal, independentemente do diretório atual.

O Composer será utilizado posteriormente para instalar e gerenciar as dependências necessárias para o Magento 2.

---

# Conclusão

O Composer foi instalado e validado no Debian 13 utilizado pelo ambiente Mage2Bar.

O sistema está agora preparado para as próximas etapas relacionadas à instalação e configuração do Magento 2.

---

## Próxima etapa

A próxima etapa consiste em obter as **Magento Access Keys**, necessárias para acessar os repositórios do Magento e instalar suas dependências através do Composer.

A documentação continuará seguindo a estrutura:

```text
docs/
├── 01-instalando-o-debian.md
├── 02-preparando-o-debian.md
├── 03-restricao-de-acesso-ssh.md
├── 04-firewall.md
├── 05-instalando-o-docker.md
└── 06-instalando-o-composer.md
```

A próxima etapa será:

```text
07-obtendo-as-magento-access-keys.md
```
