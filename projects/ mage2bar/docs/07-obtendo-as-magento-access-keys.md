# Obtendo as Magento Access Keys

## Mage2Bar

Este documento descreve o processo para obter as **Magento Access Keys**, utilizadas para autenticar o Composer no repositório oficial de pacotes do Magento.

As Access Keys serão utilizadas posteriormente durante a instalação do Magento 2 e no gerenciamento de suas dependências através do Composer.

---

## Objetivo

Nesta etapa serão realizadas as seguintes ações:

- acessar a área de Magento Access Keys;
- autenticar com uma conta Adobe/Magento;
- obter a Public Key;
- obter a Private Key;
- entender a finalidade de cada chave;
- proteger as credenciais para evitar exposição.

> **Atenção:** as Access Keys são credenciais de acesso e devem ser tratadas como informações sensíveis.

---

# 1. Acessando as Magento Access Keys

As Access Keys podem ser obtidas através da área de gerenciamento de credenciais do Adobe Commerce Marketplace.

Acesse:

https://commercemarketplace.adobe.com/customer/accessKeys/

Faça login utilizando a conta Adobe/Magento utilizada para o ambiente.

Após o login, acesse a área de **Access Keys**.

---

# 2. Obtendo as chaves

Na página de Access Keys serão disponibilizadas duas credenciais:

```text
Public Key
Private Key
```

A **Public Key** será utilizada como identificador durante a autenticação.

A **Private Key** funciona como a credencial secreta utilizada juntamente com a Public Key.

As duas informações serão necessárias posteriormente para configurar a autenticação do Composer.

---

# 3. Public Key

A Public Key não possui o mesmo nível de sensibilidade que a Private Key.

Ela será utilizada pelo Composer como identificação da conta durante a autenticação no repositório do Magento.

Exemplo:

```text
Public Key:
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

O valor acima é apenas um exemplo.

---

# 4. Private Key

A Private Key deve ser tratada como uma credencial secreta.

Ela não deve ser:

- publicada no GitHub;
- adicionada ao código-fonte;
- colocada em arquivos versionados;
- enviada em mensagens públicas;
- compartilhada desnecessariamente.

Exemplo:

```text
Private Key:
xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
```

O valor acima é apenas um exemplo.

> **Nunca utilize uma chave real nos arquivos de documentação do projeto.**

---

# 5. Utilização pelo Composer

As Access Keys serão utilizadas posteriormente para autenticar o Composer no repositório de pacotes do Magento:

```text
repo.magento.com
```

Durante a instalação das dependências do Magento 2, o Composer poderá solicitar as credenciais de autenticação.

A Public Key será utilizada como usuário:

```text
Public Key
```

A Private Key será utilizada como senha:

```text
Private Key
```

Essas credenciais permitem que o Composer tenha acesso aos pacotes necessários para a instalação do Magento.

---

# 6. Protegendo as credenciais

As Access Keys não devem ser armazenadas diretamente no repositório Git do Mage2Bar.

Por exemplo, não devem ser adicionadas ao:

```text
README.md
```

ou a arquivos de configuração versionados que contenham as credenciais.

Também é importante verificar os arquivos antes de realizar um commit:

```bash
git status
```

E, quando necessário, verificar o conteúdo que será enviado:

```bash
git diff
```

A regra principal é simples:

```text
Credencial privada
        ↓
Não colocar no Git
        ↓
Não publicar
        ↓
Não compartilhar
```

---

# 7. Próxima utilização das Access Keys

As Access Keys obtidas nesta etapa serão utilizadas posteriormente durante a configuração do Composer para o Magento 2.

Nesse momento, nenhuma chave real será adicionada à documentação.

As credenciais deverão ser configuradas diretamente no ambiente onde o Magento será instalado.

---

# Considerações de segurança

As Magento Access Keys permitem autenticar o Composer no repositório do Magento.

Por esse motivo, a Private Key deve ser protegida da mesma forma que outras credenciais utilizadas no ambiente.

Caso uma Private Key seja exposta publicamente, ela deverá ser considerada comprometida e substituída através da área de gerenciamento das Access Keys.

---

# Conclusão

As Magento Access Keys foram obtidas e estão disponíveis para utilização durante a configuração do Composer.

As credenciais não serão armazenadas no repositório público do Mage2Bar.

A próxima etapa utilizará essas credenciais para realizar a instalação do Magento 2 através do Composer.

---

## Próxima etapa

A documentação continuará seguindo a estrutura:

```text
docs/
├── 01-instalando-o-debian.md
├── 02-preparando-o-debian.md
├── 03-restricao-de-acesso-ssh.md
├── 04-firewall.md
├── 05-instalando-o-docker.md
├── 06-instalando-o-composer.md
└── 07-obtendo-as-magento-access-keys.md
```

A próxima etapa será:

```text
08-instalando-o-magento-2.md
```

Nessa etapa será realizada a instalação do Magento 2 utilizando o Composer e as credenciais obtidas anteriormente.
