# Instalando o Debian 13

## Mage2Bar

Este documento descreve o processo de instalação do **Debian GNU/Linux 13** em uma máquina virtual destinada ao projeto Mage2Bar.

A máquina virtual será utilizada como base para a construção do ambiente de desenvolvimento do Mage2Bar.

---

## Objetivo

Instalar uma versão limpa do Debian 13 que será utilizada como base para o ambiente de desenvolvimento do Mage2Bar.

Após a instalação do sistema operacional, as demais configurações serão realizadas gradualmente através da documentação do projeto.

---

## Pré-requisitos

Antes de iniciar este procedimento, é necessário possuir uma máquina virtual configurada no **Oracle VirtualBox** e preparada para receber a instalação do Debian 13.

O projeto **lionn-virtualbox** contém um guia para criação e configuração de máquinas virtuais utilizando o Oracle VirtualBox, incluindo configuração de hardware virtual, armazenamento, rede e montagem da ISO.

Consulte:

[**lionn-virtualbox**](https://github.com/lionn/lionn-virtualbox)

Também será necessária:

- ISO do Debian 13;
- máquina virtual configurada;
- recursos de CPU definidos;
- memória RAM definida;
- disco virtual configurado;
- conexão de rede;
- ISO do Debian 13 conectada à máquina virtual.

---

# 1. Iniciando a instalação

Inicie a máquina virtual com a ISO do Debian 13 conectada.

Na tela inicial do instalador, selecione uma das opções:

```text
Install
```

ou:

```text
Graphical Install
```

O instalador gráfico pode ser utilizado para facilitar o processo de instalação.

---

# 2. Configurando o Debian

Durante a instalação, configure os seguintes componentes:

1. Idioma.
2. Localização.
3. Teclado.
4. Rede.
5. Hostname.
6. Usuário.
7. Senha.
8. Particionamento.
9. Seleção de software.
10. Carregador de inicialização.

As opções escolhidas devem ser compatíveis com a finalidade da máquina virtual e com os recursos disponíveis no computador hospedeiro.

---

# 3. Configurando o hostname

O hostname identifica a máquina na rede.

Para o ambiente Mage2Bar, pode ser utilizado um nome relacionado ao projeto, por exemplo:

```text
mage2bar
```

ou:

```text
mage2bar-dev
```

O nome utilizado deve ser registrado posteriormente na documentação caso seja relevante para a configuração do ambiente.

---

# 4. Configurando o usuário

Crie o usuário que será utilizado para administração do ambiente.

O usuário deverá possuir permissão para executar comandos administrativos através do `sudo`.

Após a instalação, confirme o acesso administrativo:

```bash
sudo whoami
```

O resultado esperado é:

```text
root
```

Caso o `sudo` ainda não esteja disponível para o usuário, essa configuração deverá ser realizada antes de continuar para as próximas etapas.

---

# 5. Configurando o particionamento

Como o Debian será instalado em uma máquina virtual dedicada ao projeto Mage2Bar, o disco virtual poderá ser utilizado para a instalação do sistema.

Para uma instalação de laboratório, o particionamento automático pode ser utilizado.

Antes de confirmar o particionamento, verifique se o disco selecionado corresponde ao disco virtual da máquina.

> **Atenção:** confirme cuidadosamente o dispositivo selecionado antes de confirmar qualquer alteração.

---

# 6. Selecionando os componentes do sistema

Durante a instalação, o Debian poderá solicitar quais componentes devem ser instalados.

A seleção deve considerar a finalidade da máquina.

Para o ambiente Mage2Bar, o sistema deve permanecer enxuto, evitando instalar softwares que não serão utilizados pelo projeto.

As ferramentas adicionais serão instaladas posteriormente conforme a necessidade do ambiente.

---

# 7. Instalando o carregador de inicialização

Durante a instalação, o Debian solicitará a configuração do carregador de inicialização.

Instale o **GRUB** no disco virtual utilizado pela máquina.

Após a instalação do GRUB, o sistema poderá inicializar diretamente pelo disco virtual.

---

# 8. Finalizando a instalação

Após concluir todas as etapas do instalador:

1. Finalize a instalação.
2. Reinicie a máquina virtual.
3. Remova ou desmonte a ISO do Debian.
4. Inicie o sistema pelo disco virtual.
5. Realize o login.

---

# 9. Primeiro boot

Após o primeiro boot, confirme que o Debian iniciou corretamente.

Verifique:

- login;
- rede;
- hostname;
- acesso ao terminal;
- acesso administrativo;
- funcionamento básico do sistema.

---

# 10. Verificação da instalação

## Versão do Debian

Execute:

```bash
cat /etc/debian_version
```

---

## Kernel

Verifique a versão do kernel:

```bash
uname -a
```

---

## Hostname

Verifique o hostname:

```bash
hostnamectl
```

---

## Rede

Verifique as interfaces de rede:

```bash
ip addr
```

Teste a conectividade:

```bash
ping -c 4 deb.debian.org
```

---

## Sudo

Confirme que o usuário possui acesso administrativo:

```bash
sudo whoami
```

Resultado esperado:

```text
root
```

---

# 11. Desmontando a ISO

Após confirmar que o Debian inicializa corretamente pelo disco virtual, a ISO não será mais necessária para o boot normal da máquina.

Remova ou desmonte a ISO das configurações da máquina virtual.

Isso evita que a VM inicialize novamente o instalador do Debian em um próximo boot.

---

# 12. Registro do ambiente

Após concluir a instalação, registre as informações básicas da máquina virtual.

Exemplo:

```text
Projeto: Mage2Bar
Sistema operacional: Debian GNU/Linux 13
Hostname: mage2bar
Virtualização: Oracle VirtualBox
CPU: [informar]
RAM: [informar]
Disco: [informar]
Rede: [informar]
```

Os valores devem ser preenchidos de acordo com a configuração real utilizada no ambiente.

---

# Conclusão

O Debian 13 foi instalado e validado na máquina virtual destinada ao projeto Mage2Bar.

Neste momento, o sistema possui apenas a configuração básica necessária para iniciar a preparação do ambiente.

As demais ferramentas e serviços serão instalados e configurados nas próximas etapas.

---

## Próxima etapa

Continuar com:

```text
docs/
├── 01-instalando-o-debian.md
└── 02-preparando-o-debian.md
```

A próxima etapa consiste em preparar a instalação do Debian para receber as ferramentas necessárias ao ambiente Mage2Bar.

As configurações de SSH, firewall, Fail2ban, Docker, Composer e Magento 2 serão realizadas posteriormente.
