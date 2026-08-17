# Preparando o Debian 13 para o Projeto

## Mage2Bar

Este documento descreve o processo de preparação inicial do **GNU/Linux Debian 13** para execução do projeto **Mage2Bar** em máquina virtual.

Nesta etapa serão realizadas as configurações básicas do sistema antes da instalação e configuração dos serviços que compõem o ambiente Mage2Bar.

---

## Objetivo

Preparar uma instalação limpa do Debian 13 para receber posteriormente as ferramentas e serviços necessários para o projeto Mage2Bar.

Esta etapa contempla:

- atualização do sistema;
- instalação de pacotes básicos;
- configuração do timezone;
- criação dos diretórios base do projeto.

As configurações de SSH, firewall, Fail2ban e Docker serão realizadas em etapas específicas da documentação.

---

# 1. Atualizando o sistema

Após a instalação do Debian 13, atualize os pacotes do sistema:

```bash
sudo apt update && sudo apt upgrade -y
```

---

# 2. Instalando os pacotes básicos

Instale os pacotes necessários para a preparação inicial do ambiente:

```bash
sudo apt install -y \
    curl \
    wget \
    git \
    ca-certificates \
    gnupg \
    lsb-release
```

Esses pacotes fornecem ferramentas utilizadas nas etapas posteriores da configuração do Mage2Bar.

---

# 3. Configurando o Timezone

O projeto utiliza o timezone de São Paulo:

```bash
sudo timedatectl set-timezone America/Sao_Paulo
```

Verifique a configuração:

```bash
timedatectl
```

O sistema deverá apresentar o timezone configurado como:

```text
Time zone: America/Sao_Paulo
```

---

# 4. Criando os diretórios base

O projeto utiliza o diretório `/srv` para armazenar dados relacionados à infraestrutura do servidor.

Crie os diretórios:

```bash
sudo mkdir -p /srv/docker
sudo mkdir -p /srv/backups
```

Verifique:

```bash
ls -la /srv
```

Os diretórios deverão estar disponíveis:

```text
/srv/docker
/srv/backups
```

---

# 5. Verificação da preparação

Após concluir as etapas anteriores, confirme as principais configurações.

## Sistema

```bash
cat /etc/debian_version
```

## Timezone

```bash
timedatectl
```

## Git

```bash
git --version
```

## Curl

```bash
curl --version
```

## Diretórios

```bash
ls -la /srv
```

---

# Conclusão

O Debian 13 está preparado para receber as próximas etapas de configuração do ambiente Mage2Bar.

Nesta etapa ainda não foram configurados o acesso SSH, firewall, Fail2ban ou Docker.

Esses componentes serão configurados separadamente para manter o processo organizado e facilitar a validação de cada etapa.

---

## Próxima etapa

Continuar com:

```text
docs/
├── 01-instalando-o-debian.md
├── 02-preparando-o-debian.md
└── 03-restricao-de-acesso-ssh.md
```

A próxima etapa consiste em configurar e restringir o acesso SSH ao servidor.
