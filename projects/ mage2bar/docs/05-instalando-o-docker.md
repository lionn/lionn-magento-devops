# Instalando o Docker

## Mage2Bar

Este documento descreve o processo de instalação do **Docker** no Debian 13 utilizado pelo projeto Mage2Bar.

A instalação será realizada utilizando o repositório oficial do Docker.

O Docker será utilizado posteriormente para executar os serviços que compõem o ambiente Magento 2.

---

## Objetivo

Nesta etapa serão realizadas as seguintes configurações:

- remoção de pacotes que possam entrar em conflito com o Docker;
- instalação dos pacotes necessários;
- configuração da chave GPG oficial do Docker;
- configuração do repositório oficial;
- instalação do Docker Engine;
- instalação do Docker Compose Plugin;
- configuração do serviço Docker;
- configuração do usuário para executar comandos Docker sem `sudo`;
- validação da instalação.

---

# 1. Removendo pacotes conflitantes

Caso existam versões antigas ou pacotes que possam entrar em conflito com a instalação, eles podem ser removidos antes de iniciar o processo:

```bash
sudo apt remove -y docker.io docker-compose docker-doc podman-docker containerd runc
```

Essa etapa não remove os pacotes caso eles não estejam instalados.

---

# 2. Atualizando os pacotes

Atualize a lista de pacotes do sistema:

```bash
sudo apt update
```

---

# 3. Instalando os pacotes necessários

Instale os pacotes necessários para adicionar o repositório do Docker:

```bash
sudo apt install -y ca-certificates curl
```

---

# 4. Adicionando a chave GPG oficial do Docker

Crie o diretório utilizado para armazenar as chaves dos repositórios:

```bash
sudo install -m 0755 -d /etc/apt/keyrings
```

Baixe a chave GPG oficial do Docker:

```bash
sudo curl -fsSL https://download.docker.com/linux/debian/gpg -o /etc/apt/keyrings/docker.asc
```

Ajuste as permissões da chave:

```bash
sudo chmod a+r /etc/apt/keyrings/docker.asc
```

---

# 5. Adicionando o repositório oficial do Docker

Adicione o repositório oficial do Docker ao sistema:

```bash
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/debian \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
```

O repositório oficial será utilizado para obter os pacotes do Docker.

---

# 6. Atualizando os repositórios

Após adicionar o repositório, atualize novamente a lista de pacotes:

```bash
sudo apt update
```

---

# 7. Instalando o Docker Engine

Instale os componentes necessários:

```bash
sudo apt install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin
```

Os principais componentes instalados são:

- Docker Engine;
- Docker CLI;
- containerd;
- Docker Buildx;
- Docker Compose Plugin.

---

# 8. Verificando o serviço do Docker

Verifique o status do serviço:

```bash
sudo systemctl status docker
```

O serviço deverá estar ativo.

Também é possível verificar diretamente:

```bash
sudo systemctl is-active docker
```

O resultado esperado é:

```text
active
```

---

# 9. Habilitando o Docker no início do sistema

Configure o Docker para iniciar automaticamente durante o boot:

```bash
sudo systemctl enable docker
```

---

# 10. Testando a instalação

Execute o container de teste fornecido pelo Docker:

```bash
sudo docker run hello-world
```

O comando deverá baixar a imagem `hello-world`, criar um container e exibir uma mensagem confirmando que o Docker está funcionando corretamente.

---

# 11. Adicionando o usuário ao grupo Docker

Por padrão, os comandos Docker podem exigir privilégios administrativos.

Para permitir que o usuário utilizado no ambiente execute comandos Docker sem `sudo`, adicione o usuário ao grupo `docker`.

Substitua `<usuario>` pelo usuário criado durante a instalação do Debian:

```bash
sudo usermod -aG docker <usuario>
```

Após adicionar o usuário ao grupo, encerre a sessão atual e faça login novamente para que a alteração seja aplicada.

> **Atenção:** a associação ao grupo `docker` concede ao usuário privilégios elevados sobre o Docker e deve ser considerada uma decisão de segurança do ambiente.

---

# 12. Testando o Docker sem sudo

Após realizar um novo login com o usuário utilizado no ambiente, execute:

```bash
docker run hello-world
```

O comando deverá funcionar sem a utilização do `sudo`.

---

# 13. Verificando a versão do Docker

Verifique a versão instalada:

```bash
docker --version
```

---

# 14. Verificando o Docker Compose

O projeto utilizará Docker Compose para definir e executar os serviços do ambiente.

Verifique a versão instalada:

```bash
docker compose version
```

O comando deverá apresentar a versão do Docker Compose Plugin instalado no sistema.

---

# 15. Verificação final

Após concluir a instalação, os seguintes comandos podem ser utilizados para confirmar o funcionamento do ambiente:

```bash
docker --version
```

```bash
docker compose version
```

```bash
docker run hello-world
```

Também é possível verificar o serviço:

```bash
systemctl is-active docker
```

O resultado esperado é:

```text
active
```

---

# Considerações

O Docker foi instalado utilizando o repositório oficial e os componentes necessários para trabalhar com containers foram configurados.

O Docker Compose também foi instalado através do plugin oficial, permitindo que o projeto utilize arquivos `compose.yaml` ou `docker-compose.yml` para definir seus serviços.

A partir desta etapa, o Docker está disponível para receber os componentes que serão utilizados pelo ambiente Mage2Bar.

---

# Conclusão

O Docker Engine foi instalado e validado no Debian 13.

O serviço está configurado para iniciar automaticamente com o sistema e o usuário utilizado no ambiente pode executar comandos Docker sem a necessidade de utilizar `sudo`.

O ambiente está agora preparado para as próximas etapas de configuração do Mage2Bar.

---

## Próxima etapa

A próxima etapa consiste na instalação e configuração do **Composer**, que será utilizado para gerenciar as dependências do Magento 2.

A documentação continuará seguindo a estrutura:

```text
docs/
├── 01-instalando-o-debian.md
├── 02-preparando-o-debian.md
├── 03-restricao-de-acesso-ssh.md
├── 04-firewall.md
└── 05-instalando-o-docker.md
```

A próxima etapa será:

```text
06-instalando-o-composer.md
```
