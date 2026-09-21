# Lionn

**Infraestrutura e DevOps para o projeto Lionn.**

---

## Sobre o projeto

Lionn é um projeto de infraestrutura e DevOps voltado para uma plataforma de conhecimento multi-idioma construída sobre o Magento 2. Este repositório reúne o ambiente de execução, a configuração do servidor, os scripts de automação e a documentação técnica necessária para implantar e manter a aplicação.

A proposta do repositório é oferecer uma base reproduzível para ambientes de desenvolvimento, homologação e produção, priorizando segurança, isolamento de serviços e automação de tarefas repetitivas. O conteúdo aqui disponibilizado não inclui a aplicação Magento em si que é instalada via Composer, mas sim toda a camada de infraestrutura que a sustenta.

Este repositório também **não inclui módulos comerciais de terceiros** utilizados em produção. O ambiente entregue é funcional, porém **simplificado** em relação ao original, especialmente nos recursos de ocultação de preço e busca, que dependem de licenças pagas.

### Contexto

Projetos de e-commerce e plataformas de conteúdo baseados em Magento 2 exigem uma configuração cuidadosa de serviços auxiliares: banco de dados relacional, cache em memória, mecanismo de busca, servidor web e gerenciamento de sessões. A orquestração desses componentes em containers Docker permite padronizar o ambiente, reduzir divergências entre máquinas e facilitar a implantação em servidores distintos.

O projeto Lionn parte dessa necessidade e a estende para um cenário específico: uma plataforma de conhecimento com múltiplos idiomas e múltiplos sites, operando sobre uma única instalação Magento. O resultado é uma configuração que combina práticas consolidadas de DevOps com uma arquitetura de conteúdo pouco convencional.

---

> **⚠️ Versão Limitada / Limited Version**
>
> Este repositório disponibiliza a **camada de infraestrutura** do projeto Lionn, mas **não inclui módulos comerciais de terceiros** utilizados em produção por questões de licenciamento.
>
> Consequências para quem clona:
>
> - O **preço não fica oculto** (em produção usamos Amasty Hide Price)
> - A **busca é a nativa do Magento** (em produção usamos Amasty Search)
> - Outros ajustes visuais e comportamentais podem diferir
>
> **Site em Produção:** https://www.lionn.net - A melhor forma de ver o projeto exatamente como ele é. ;)

---

## Estrutura do repositório

```
lionn/
├── Dockerfile                  # Imagem PHP-FPM 8.2 com extensões para Magento 2
├── docker-compose.yml          # Orquestração dos serviços
├── .env.example                # Modelo de variáveis do ambiente
├── .editorconfig               # Padronização de formatação entre editores
├── .gitignore                  # Arquivos e diretórios não versionados
├── LICENSE.md                  # Licença MIT
├── CONTRIBUTING.md             # Diretrizes de contribuição
├── CHANGELOG.md                # Histórico de alterações
├── CODE_OF_CONDUCT.md          # Código de Conduta
├── SECURITY.md                 # Política de Segurança
├── README.md                   # Este documento...
├── data/                       # Volumes persistentes dos containers (não versionado)
├── html/                       # Aplicação Magento 2 (não versionada)
├── nginx/
│   ├── default.conf            # Configuração do servidor web
│   └── ssl/                    # Certificados SSL (não versionados)
├── scripts/
│   ├── setup-base.sh           # Preparação inicial do servidor
│   ├── install-magento.sh      # Instalação automatizada do Magento 2
│   └── deploy-magento.sh       # Rotina de deploy
└── docs/
    └── pt_BR/
        ├── 01-instalando-o-debian.md
        ├── 02-preparando-o-debian.md
        ├── 03-restricao-de-acesso-ssh.md
        ├── 04-firewall.md
        ├── 05-instalando-o-docker.md
        ├── 06-instalando-o-composer.md
        ├── 07-obtendo-as-magento-access-keys.md
        ├── 08-instalando-o-magento-2.md
        ├── 09-configurando-o-magento-2.md
        ├── 10-configurando-o-multi-store.md
        ├── 11-configurando-o-multi-idioma.md
        ├── 12-configurando-o-ssl.md
        ├── 13-configurando-o-redis.md
        ├── 14-configurando-o-opensearch.md
        ├── 15-configurando-o-csp.md
        ├── 16-instalando-o-tema-lionn.md
        ├── 17-instalando-os-modulos-lionn.md
        └── 18-deploy-em-producao.md
```

---

## Requisitos

| Item | Requisito |
|---|---|
| Sistema operacional | Debian 13 (recomendado) ou equivalente |
| Docker | Versão 24 ou superior |
| Docker Compose | Versão 2 ou superior |
| Memória RAM | 4 GB (mínimo) |
| Espaço em disco | 20 GB (mínimo) |
| Magento Access Keys | Obrigatório para instalação via Composer |
| Licenças Amasty | (Opcional) / necessário apenas para recursos completos (ocultar preço, busca avançada entre outro módulos que usamos) |

As chaves de acesso ao repositório Magento são obtidas na plataforma da Adobe e são necessárias para o download das dependências. O procedimento está descrito em [`docs/pt_BR/07-obtendo-as-magento-access-keys.md`](docs/pt_BR/07-obtendo-as-magento-access-keys.md).

---

## Dependências de terceiros (não inclusas)

O projeto original em produção utiliza módulos comerciais de terceiros que **não podem ser redistribuídos** por questões de licença. Por isso, **não estão inclusos neste repositório**:

| Módulo | Fornecedor | Finalidade |
|---|---|---|
| Hide Price | Amasty | Ocultação de preços por grupo de cliente |
| Search / Improved Layered Navigation | Amasty | Busca e filtros avançados |
| Blog | Amasty | Módulo que controla o Blog no projeto Lionn |
| Cookies e LGPD | Amasty | Módulo destinado as configurações de Cookies e LGPD |
| Anexos | Amasty | Módulo que disponibiliza anexos |
| Outros módulos Amasty | Amasty | Ajustes diversos de UX e catálogo |

**Consequência para quem clona:** o comportamento de ocultar preços e a busca avançada **não funcionarão** sem que você adquira as mesmas licenças na Amasty e configure suas próprias chaves Composer.

Para replicar 100% do ambiente, é necessário:

1. Adquirir os módulos diretamente em [amasty.com](https://amasty.com)
2. Gerar suas chaves Composer na conta Amasty
3. Configurar a autenticação:

```bash
composer config --auth http-basic.composer.amasty.com <PUBLIC_KEY> <PRIVATE_KEY>
```

---

## Instalação

O processo de instalação segue uma sequência definida de etapas, descritas individualmente na documentação técnica. O resumo abaixo pressupõe que o servidor já está preparado conforme os documentos 01 a 06.

### 1. Clonar o repositório

```bash
git clone https://github.com/lionn-magento-devops/lionn.git
cd lionn
```

### 2. Configurar as variáveis de ambiente

```bash
cp .env.example .env
```

Edite o arquivo `.env` com os valores adequados ao seu ambiente.

### 3. Subir os containers

```bash
docker compose up -d
```

### 4. Instalar o Magento 2

```bash
bash scripts/install-magento.sh
```

### 5. Acessar a aplicação

- **Frontend:** `https://seusite.com.br`
- **Painel administrativo:** `https://seusite.com.br/<ADMIN_FRONTNAME>`

O `<ADMIN_FRONTNAME>` é definido durante a instalação e armazenado no arquivo `app/etc/env.php` do Magento. Por segurança, recomenda-se utilizar um valor personalizado em vez do padrão `admin`.

---

## Documentação técnica

| Etapa | Documento |
|---|---|
| 01 | [Instalando o Debian](docs/pt_BR/01-instalando-o-debian.md) |
| 02 | [Preparando o Debian](docs/pt_BR/02-preparando-o-debian.md) |
| 03 | [Restrição de acesso SSH](docs/pt_BR/03-restricao-de-acesso-ssh.md) |
| 04 | [Firewall](docs/pt_BR/04-firewall.md) |
| 05 | [Instalando o Docker](docs/pt_BR/05-instalando-o-docker.md) |
| 06 | [Instalando o Composer](docs/pt_BR/06-instalando-o-composer.md) |
| 07 | [Obtendo as Magento Access Keys](docs/pt_BR/07-obtendo-as-magento-access-keys.md) |
| 08 | [Instalando o Magento 2](docs/pt_BR/08-instalando-o-magento-2.md) |

A documentação está disponível em português. A versão em inglês será incorporada ao e-book do projeto.

---

## Segurança

- **Firewall UFW** integrado ao Docker por meio do utilitário `ufw-docker`.
- **Fail2ban** configurado para monitoramento e bloqueio de tentativas de acesso não autorizado via SSH.
- **Política `no-new-privileges`** aplicada a todos os serviços do Docker Compose.
- **Cabeçalhos HTTP de segurança** no Nginx.
- **Mitigações específicas** para vulnerabilidades conhecidas do Magento 2.
- **Bloqueio de arquivos sensíveis** no Nginx.

As mitigações adotadas **não substituem** os patches oficiais da Adobe.

---

## E-book

O processo de construção deste ambiente está documentado no e-book **"Lionn: Como Transformei o Magento 2 numa Wiki Multi-idioma"**.

O material cobre:

- A jornada completa de construção
- Decisões de arquitetura e suas justificativas
- Erros cometidos e as soluções aplicadas
- Modelo de negócio e estratégia de publicação
- Estratégia de publicação: como disponibilizar um projeto Magento 2 que depende de módulos pagos sem violar licenças e sem frustrar quem clona

O e-book está disponível na plataforma da Hotmart. *(link a ser inserido em breve)*

---

## Contribuição

Contribuições são bem-vindas. Consulte [`CONTRIBUTING.md`](CONTRIBUTING.md) para diretrizes.

---

## Licença

Este projeto está licenciado sob a **Licença MIT**. Consulte [`LICENSE.md`](LICENSE.md).

---

**© Lionn**
**https://www.lionn.net**
