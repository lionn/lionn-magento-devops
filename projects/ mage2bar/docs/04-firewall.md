# Configuração do Firewall

## Mage2Bar

Este documento descreve a configuração inicial do firewall utilizando o **UFW (Uncomplicated Firewall)** no Debian 13 utilizado pelo projeto Mage2Bar.

O firewall será utilizado para controlar o tráfego de entrada e saída do servidor, permitindo somente os serviços necessários para o ambiente.

A configuração foi realizada após a validação do acesso SSH por chave pública, evitando o risco de perder o acesso remoto ao servidor.

---

## Objetivo

Nesta etapa serão realizadas as seguintes configurações:

- instalação do UFW;
- definição das políticas padrão;
- bloqueio do tráfego de entrada;
- permissão para o tráfego de saída;
- liberação do acesso SSH;
- ativação do firewall;
- validação das regras configuradas.

O objetivo é reduzir a superfície de exposição do servidor antes da instalação dos demais componentes do ambiente Mage2Bar.

> **Atenção:** antes de ativar o firewall, confirme que o acesso SSH está funcionando corretamente e que existe uma regra permitindo a conexão SSH.

---

# 1. Instalando o UFW

O UFW não está necessariamente instalado em uma instalação mínima do Debian.

Instale o pacote:

```bash
sudo apt install -y ufw
```

Após a instalação, verifique se o comando está disponível:

```bash
sudo ufw version
```

---

# 2. Configurando as políticas padrão

As políticas padrão serão configuradas para bloquear conexões de entrada e permitir conexões de saída.

Bloqueie o tráfego de entrada:

```bash
sudo ufw default deny incoming
```

Permita o tráfego de saída:

```bash
sudo ufw default allow outgoing
```

Com essa configuração, novas conexões de entrada serão bloqueadas por padrão.

As regras específicas serão adicionadas posteriormente para permitir os serviços necessários.

---

# 3. Liberando o acesso SSH

Antes de ativar o firewall, é necessário permitir o acesso SSH.

Essa etapa é importante porque a ativação do firewall sem uma regra permitindo SSH pode interromper o acesso remoto ao servidor.

O acesso SSH pode ser liberado utilizando o perfil do serviço:

```bash
sudo ufw allow ssh
```

Também é possível liberar explicitamente a porta utilizada pelo SSH:

```bash
sudo ufw allow 22/tcp
```

Para o ambiente Mage2Bar, a porta padrão do SSH é a `22/TCP`.

Verifique a regra adicionada:

```bash
sudo ufw status
```

---

# 4. Ativando o firewall

Depois de confirmar que o acesso SSH está liberado, ative o UFW:

```bash
sudo ufw enable
```

Durante a ativação, o sistema poderá apresentar um aviso informando que essa operação pode interromper conexões SSH existentes.

Confirme a ativação somente depois de verificar que a regra do SSH foi configurada corretamente.

---

# 5. Verificando o status

Após ativar o firewall, verifique o status:

```bash
sudo ufw status
```

O resultado deverá indicar que o firewall está ativo.

Exemplo:

```text
Status: active
```

Para visualizar as regras configuradas:

```bash
sudo ufw status verbose
```

Um exemplo de configuração poderá apresentar:

```text
Status: active

To                         Action      From
--                         ------      ----
22/tcp                     ALLOW       Anywhere
22/tcp (v6)                ALLOW       Anywhere (v6)
```

A saída pode variar dependendo da configuração de rede e das regras existentes no sistema.

---

# 6. Verificando as regras numeradas

O UFW também permite visualizar as regras utilizando numeração:

```bash
sudo ufw status numbered
```

Exemplo:

```text
[ 1] 22/tcp                     ALLOW IN    Anywhere
[ 2] 22/tcp (v6)                ALLOW IN    Anywhere (v6)
```

Essa visualização facilita a identificação das regras caso seja necessário removê-las posteriormente.

---

# 7. Funcionamento do firewall

Após a configuração, o comportamento esperado do firewall é:

```text
Tráfego de entrada
        ↓
   Bloqueado por padrão
        ↓
   Regras específicas
        ↓
   Serviços autorizados
```

Enquanto o tráfego de saída segue a política padrão:

```text
Tráfego de saída
        ↓
      Permitido
```

No momento, o acesso SSH é o serviço necessário para administração remota do servidor.

Outras portas serão liberadas somente quando forem necessárias para o funcionamento do ambiente Mage2Bar.

---

# 8. Considerações sobre o Docker

O projeto Mage2Bar utilizará Docker para executar os serviços da aplicação.

A configuração do firewall deve ser considerada em conjunto com a configuração de rede dos containers Docker.

A publicação de portas de containers pode alterar a forma como o tráfego é encaminhado pelo sistema, portanto as regras do firewall deverão ser avaliadas novamente conforme os serviços do projeto forem adicionados.

Neste momento, o firewall possui apenas as regras necessárias para a etapa atual do ambiente.

---

# 9. Integração com Fail2Ban

O **Fail2Ban** poderá ser utilizado posteriormente em conjunto com o firewall para auxiliar na proteção contra tentativas repetidas de autenticação inválida no serviço SSH.

O Fail2Ban monitora determinados eventos registrados pelo sistema e pode aplicar regras de bloqueio para endereços IP que apresentem comportamento considerado abusivo.

A configuração do Fail2Ban será realizada em uma etapa específica do projeto, caso seja necessária para o ambiente.

---

# 10. Considerações de segurança

Após esta configuração:

- o tráfego de entrada é bloqueado por padrão;
- o tráfego de saída é permitido por padrão;
- o acesso SSH está explicitamente liberado;
- o firewall inicia automaticamente durante o boot;
- novas portas não são abertas sem necessidade;
- a superfície de exposição do servidor é reduzida.

A liberação de novas portas deve ser realizada somente quando houver uma necessidade específica do projeto.

---

# Conclusão

O UFW foi instalado e configurado no Debian 13 utilizado pelo Mage2Bar.

O tráfego de entrada passou a ser bloqueado por padrão e o acesso SSH foi liberado para permitir a administração remota do servidor.

O firewall está ativo e preparado para receber novas regras conforme os serviços do ambiente forem configurados.

As próximas etapas do projeto irão adicionar os componentes necessários para executar o Magento 2 através do Docker.

---

## Próxima etapa

A próxima etapa consiste na instalação do Docker.

A documentação continuará seguindo a estrutura:

```text
docs/
├── 01-instalando-o-debian.md
├── 02-preparando-o-debian.md
├── 03-restricao-de-acesso-ssh.md
└── 04-firewall.md
```

Depois desta etapa, será iniciado o processo de instalação e configuração do Docker para o ambiente Mage2Bar.
