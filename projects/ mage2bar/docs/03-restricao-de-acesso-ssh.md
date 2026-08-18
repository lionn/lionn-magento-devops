# Restrição de Acesso (Hardening) SSH

## Mage2Bar

Este documento descreve o processo de configuração e hardening do serviço **SSH** no Debian 13 utilizado pelo projeto Mage2Bar.

Essa etapa é realizada após a preparação inicial do sistema e tem como objetivo restringir o acesso remoto ao servidor.

A autenticação será realizada através de chave pública. O acesso por senha e o login direto do usuário `root` serão desabilitados.

---

## Objetivo

Nesta etapa serão realizadas as seguintes configurações:

- criação do diretório `.ssh` do usuário `lionnman`;
- configuração da chave pública;
- ajuste das permissões dos arquivos SSH;
- teste do acesso utilizando a chave pública;
- desativação da autenticação por senha;
- bloqueio do acesso SSH direto do usuário `root`;
- validação da configuração do SSH;
- validação do serviço SSH.

> **Atenção:** antes de desabilitar a autenticação por senha, confirme que o acesso utilizando a chave pública está funcionando corretamente.

---

# 1. Criando o diretório SSH

Primeiro, será criado o diretório `.ssh` para o usuário `lionnman`.

```bash
sudo mkdir -p /home/lionnman/.ssh
```

Ajuste as permissões do diretório:

```bash
sudo chmod 700 /home/lionnman/.ssh
```

Defina o usuário `lionnman` como proprietário:

```bash
sudo chown lionnman:lionnman /home/lionnman/.ssh
```

---

# 2. Configurando a chave pública

A chave pública será adicionada ao arquivo `authorized_keys` do usuário `lionnman`.

Edite o arquivo:

```bash
sudo vi /home/lionnman/.ssh/authorized_keys
```

Adicione a chave pública correspondente ao usuário.

Exemplo:

```text
ssh-ed25519 AAAA...<CHAVE_PUBLICA_EXEMPLO>ABC... lionnman
```

A chave acima é apenas um exemplo.

A chave privada deve permanecer no computador utilizado para realizar o acesso SSH e não deve ser armazenada no servidor ou adicionada ao repositório do projeto.

---

# 3. Ajustando as permissões

O arquivo `authorized_keys` deve possuir permissões restritas.

Execute:

```bash
sudo chmod 600 /home/lionnman/.ssh/authorized_keys
```

Defina o usuário `lionnman` como proprietário:

```bash
sudo chown lionnman:lionnman /home/lionnman/.ssh/authorized_keys
```

Verifique as permissões:

```bash
ls -la /home/lionnman/.ssh
```

---

# 4. Testando o acesso por chave

Antes de alterar a configuração do SSH, o acesso utilizando a chave pública deve ser testado.

Abra uma nova sessão SSH utilizando o usuário `lionnman` e a chave privada correspondente.

O acesso deverá funcionar sem solicitar a senha do usuário.

Essa validação é importante porque, depois que a autenticação por senha for desabilitada, a chave pública será o método utilizado para acessar o servidor.

> **Não desabilite a autenticação por senha antes de confirmar que o acesso por chave está funcionando.**

---

# 5. Configurando o SSH

Com o acesso por chave validado, edite o arquivo de configuração do servidor SSH:

```bash
sudo vi /etc/ssh/sshd_config
```

Configure os seguintes parâmetros:

```text
PubkeyAuthentication yes
PasswordAuthentication no
PermitRootLogin no
AuthorizedKeysFile .ssh/authorized_keys
```

### PubkeyAuthentication

Mantém habilitada a autenticação utilizando chaves públicas.

```text
PubkeyAuthentication yes
```

### PasswordAuthentication

Desabilita a autenticação utilizando senha através do SSH.

```text
PasswordAuthentication no
```

### PermitRootLogin

Impede o login direto do usuário `root` através do SSH.

```text
PermitRootLogin no
```

### AuthorizedKeysFile

Define o arquivo utilizado para armazenar as chaves públicas autorizadas.

```text
AuthorizedKeysFile .ssh/authorized_keys
```

---

# 6. Validando a configuração

Antes de reiniciar o serviço SSH, valide a configuração:

```bash
sudo sshd -t
```

Se nenhum erro for apresentado, a configuração passou pela validação.

Essa etapa é importante para evitar reiniciar o serviço com uma configuração inválida.

---

# 7. Reiniciando o serviço SSH

Depois de validar a configuração, reinicie o serviço:

```bash
sudo systemctl restart ssh
```

Verifique o status:

```bash
systemctl status ssh
```

O serviço deverá estar em execução.

---

# 8. Validando o acesso

Após reiniciar o serviço, realize novamente os testes de acesso.

### Login utilizando chave pública

O usuário `lionnman` deverá conseguir acessar o servidor utilizando a chave privada correspondente.

```text
lionnman + chave pública
        ↓
     permitido
```

### Login utilizando senha

A autenticação utilizando senha deverá ser recusada.

```text
lionnman + senha
        ↓
     bloqueado
```

### Login direto como root

O acesso SSH direto utilizando o usuário `root` deverá ser recusado.

```text
root + SSH
   ↓
bloqueado
```

O acesso administrativo deverá ser realizado através do usuário autorizado e, quando necessário, utilizando `sudo`.

---

# 9. Considerações de segurança

Após essa configuração, o serviço SSH passa a utilizar uma política de acesso mais restritiva.

As principais alterações realizadas foram:

- autenticação por chave pública habilitada;
- autenticação por senha desabilitada;
- acesso SSH direto do usuário `root` desabilitado;
- diretório `.ssh` com permissões restritas;
- arquivo `authorized_keys` com permissões restritas.

Essas configurações reduzem a superfície de ataque do serviço SSH.

O hardening do SSH é apenas uma das etapas de segurança do Mage2Bar. Outras medidas serão aplicadas posteriormente, incluindo a configuração do firewall.

---

# Conclusão

O acesso SSH do ambiente Mage2Bar foi configurado para utilizar autenticação por chave pública.

O acesso por senha foi desabilitado e o login direto do usuário `root` foi bloqueado.

A configuração foi validada antes da reinicialização do serviço e o acesso por chave pública foi utilizado para confirmar que o servidor continua acessível.

Com essa etapa concluída, o ambiente está preparado para a próxima configuração de segurança.

---

## Próxima etapa

A próxima etapa consiste em configurar o firewall do Debian.

A documentação continuará seguindo a estrutura:

```text
docs/
├── 01-instalando-o-debian.md
├── 02-preparando-o-debian.md
├── 03-restricao-de-acesso-ssh.md
└── 04-firewall.md
```

O firewall será utilizado para controlar as conexões permitidas ao servidor.
