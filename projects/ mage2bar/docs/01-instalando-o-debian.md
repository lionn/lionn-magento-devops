# Instalando o Debian 13

## Mage2Bar

Este documento descreve o processo de instalação do
Debian GNU/Linux 13 em uma máquina virtual destinada
ao projeto Mage2Bar.

---

## Objetivo

Instalar uma versão limpa do Debian 13 que será utilizada
como base para o ambiente de desenvolvimento do Mage2Bar.

---

## Pré-requisitos

- Máquina virtual configurada
- ISO do Debian 13
- VirtualBox
- Recursos de CPU, RAM e armazenamento definidos para a VM

---

## 1. Criando a máquina virtual

Criar uma nova máquina virtual no VirtualBox e definir:

- Nome da máquina virtual
- Tipo: Linux
- Distribuição: Debian
- Arquitetura: 64-bit
- Memória RAM
- Processadores
- Disco virtual

---

## 2. Configurando a ISO

Adicionar a ISO do Debian 13 à unidade óptica virtual da máquina.

---

## 3. Iniciando a instalação

Iniciar a máquina virtual e selecionar:

- Install
- Graphical Install

---

## 4. Configurando o Debian

Durante a instalação:

1. Selecionar o idioma.
2. Selecionar a localização.
3. Configurar o teclado.
4. Configurar a rede.
5. Definir o hostname.
6. Configurar o usuário.
7. Configurar a senha.
8. Configurar o particionamento do disco.
9. Selecionar os componentes necessários.
10. Instalar o carregador de inicialização.

---

## 5. Primeiro boot

Após finalizar a instalação:

1. Reiniciar a máquina virtual.
2. Remover/desmontar a ISO do Debian.
3. Iniciar o Debian pelo disco virtual.
4. Realizar o login.
5. Confirmar o funcionamento básico do sistema.

---

## 6. Verificação

Confirmar a versão instalada:

    cat /etc/debian_version

Verificar o kernel:

    uname -a

Verificar a rede:

    ip addr

---

## Conclusão

O Debian 13 foi instalado com sucesso na máquina virtual
destinada ao projeto Mage2Bar.

A próxima etapa consiste em preparar o sistema para receber
as ferramentas e serviços do projeto.

---

## Próxima etapa

Continuar com:

    docs/
    ├── 01-instalando-o-debian.md
    └── 02-preparando-o-debian.md
