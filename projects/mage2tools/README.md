# Mage2Tools

O **Mage2Tools** é um ambiente de e-commerce e desenvolvimento baseado em **Magento 2 (Adobe Commerce)** com **Docker**, voltado para o segmento B2B/B2C de **ferramentas, autopeças, componentes industriais e hidráulica**.

O projeto atua como ambiente de testes para arquitetura em containers, integração de dados de catálogo (PIM), estruturação de produtos simples e configuráveis, além do gerenciamento de templates de e-mails transacionais.

---

## 🎯 Objetivo

Prover uma estrutura ágil e em containers Docker para o gerenciamento de catálogos técnicos de alta complexidade em Magento 2, incluindo:
- **Gestão de Catálogo (PIM):** Ingestão e padronização de produtos simples e configuráveis (info.txt, product.yml e README.md por produto).
- **E-mails Transacionais:** Organização e internacionalização dos e-mails nativos em pt_BR.
- **Infraestrutura e CI/CD:** Ambientes isolados via Docker e automação de imagens via GitHub Actions.

---

## 🛠️ Tecnologias Utilizadas

- **Magento 2 Community Edition**
- **Docker** & **Docker Compose**
- **Nginx** & **PHP-FPM**
- **GitHub Actions** (CI/CD)
- **YAML / Bash / Python** (Scripts de dados)

---

## 📂 Estrutura do Repositório

```
/ (Raiz do Repositório)
├── .github/
│   └── workflows/
│       └── docker-image.yml     # Pipeline de build/deploy
├── projects/
│   └── mage2tools/              # Núcleo do projeto Mage2Tools
│       ├── data/
│       │   ├── db/              # Banco de dados (MariaDB)
│       │   ├── emails/pt_BR/    # E-mails transacionais organizados por módulo
│       │   │   ├── clientes/
│       │   │   ├── componentes/
│       │   │   ├── sistema/
│       │   │   └── vendas/
│       │   ├── opensearch/      # Índices e configurações do mecanismo de busca (Open Search)
│       │   ├── products/        # Base de dados e catálogo de produtos organizados fora do Magento 2
│       │   └── html/            # Templates e componentes visuais (Diretório Principal Magento 2)
│       ├── nginx/               # Configurações do servidor Nginx
│       └── scripts/             # Scripts de automação e gestão
├── .env.example                 # Exemplo de variáveis de ambiente
├── Dockerfile                   # Imagem Docker principal da aplicação
├── docker-compose.yml           # Orquestração local dos serviços
└── README.md                    # Documentação do projeto (este arquivo)
```

---

## 🚀 Como Executar o Ambiente

### Pré-requisitos
- Docker e Docker Compose instalados.

### Passo a Passo

1. Clone o repositório:
   git clone https://github.com/seu-usuario/mage2tools.git
   cd mage2tools

2. Crie o arquivo de ambiente:
   cp .env.example .env

3. Suba os containers:
   docker-compose up -d

---

## 📌 Status do Projeto

🟡 Em Desenvolvimento
- [x] Estruturação da pasta de produtos (projects/mage2tools/data/products/)
- [x] Organização da árvore de e-mails transacionais em pt_BR
- [ ] Implementação das rotinas de importação automática via API REST
- [ ] Ajustes finos nos fluxos de checkout e pagamentos

---


⚠️ Aviso de Isenção de Responsabilidade (Disclaimer):

As descrições, especificações técnicas, imagens e dados contidos neste repositório são fornecidos exclusivamente para fins de estruturação, testes de catálogo e visualização deste projeto de integração. As informações foram coletadas a partir de conteúdos públicos e processadas/conferidas com auxílio de Inteligência Artificial para análise rápida, podendo conter erros, omissões ou divergências de digitação. Não nos responsabilizamos pela exatidão, atualização ou veracidade das informações dos produtos exibidos neste projeto. Para obter especificações oficiais, manuais técnicos atualizados e suporte, consulte sempre o site e a documentação oficial dos respectivos fabricantes.


---


## 📄 Licença

Este projeto está sob a licença [MIT](LICENSE.md).
