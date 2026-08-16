# Preparando o Debian 13 para o Projeto
## Mage2Bar

Este documento descreve o processo de preparação do GNU/Linux Debian 13 para execução do projeto Mage2Bar em máquina virtual.

A preparação contempla a atualização do sistema, instalação dos pacotes básicos, configuração do timezone, firewall, Fail2ban e instalação do Docker.

---

# Atualizando o sistema

Após a instalação do Debian 13, atualize os pacotes do sistema:

    sudo apt update && sudo apt upgrade -y

---

# Instalando os pacotes básicos

Instale os pacotes necessários para a preparação do ambiente:

    sudo apt install -y \
        curl \
        wget \
        git \
        ufw \
        fail2ban \
        ca-certificates \
        gnupg \
        lsb-release

---

# Configurando o Timezone

O projeto utiliza o timezone de São Paulo:

    sudo timedatectl set-timezone America/Sao_Paulo

Verifique a configuração:

    timedatectl

---

# Configurando o Firewall

O firewall permite somente os serviços necessários para o servidor:

    sudo ufw allow OpenSSH
    sudo ufw allow 80
    sudo ufw allow 443

Habilite o firewall:

    sudo ufw --force enable

Verifique o status:

    sudo ufw status

---

# Instalando o Fail2ban

O Fail2ban será utilizado como uma camada adicional de proteção contra tentativas repetidas de acesso aos serviços do servidor.

    sudo systemctl enable fail2ban
    sudo systemctl start fail2ban

Verifique o serviço:

    sudo systemctl status fail2ban

---

# Instalando o Docker

O Docker é utilizado como base para execução dos componentes do Mage2Bar.

Adicione a chave oficial do repositório:

    sudo install -m 0755 -d /etc/apt/keyrings

    curl -fsSL https://download.docker.com/linux/debian/gpg \
        | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg

Configure o repositório:

    echo \
      "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/debian \
      $(lsb_release -cs) stable" \
      | sudo tee /etc/apt/sources.list.d/docker.list > /dev/null

Atualize os repositórios:

    sudo apt update

Instale o Docker:

    sudo apt install -y \
        docker-ce \
        docker-ce-cli \
        containerd.io \
        docker-buildx-plugin \
        docker-compose-plugin

Habilite e inicie o serviço:

    sudo systemctl enable docker
    sudo systemctl start docker

Verifique a instalação:

    docker --version

Verifique o Docker Compose:

    docker compose version

---

# Criando os diretórios base

O projeto utiliza `/srv` para armazenar os dados relacionados à infraestrutura do servidor.

Crie os diretórios:

    sudo mkdir -p /srv/docker
    sudo mkdir -p /srv/backups

---

# Script de preparação automatizada

As etapas de preparação do servidor também estão reunidas no script:

    scripts/setup-base-servidor.sh

O script automatiza:

- atualização do sistema;
- instalação dos pacotes básicos;
- configuração do timezone;
- configuração do UFW;
- instalação do Docker;
- configuração do Fail2ban;
- criação dos diretórios base do servidor.

Para executar o script:

    sudo ./scripts/setup-base-servidor.sh

---

# Verificação final

Após a execução, confirme os principais serviços:

    systemctl status docker

    systemctl status fail2ban

    ufw status

    docker --version

    docker compose version

---

# Conclusão

O Debian 13 está preparado para receber o ambiente Docker do Mage2Bar.

A próxima etapa consiste em configurar e executar o ambiente Docker do projeto.
