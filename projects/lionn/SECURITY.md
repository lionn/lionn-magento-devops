# Política de Segurança

## Versões suportadas

| Versão | Suporte |
|--------|---------|
|   1.x  |  Sim    |
| < 1.0  |  Não    |

## Reportando uma vulnerabilidade

Não divulgue publicamente antes de nos contatar.

Envie e-mail para **seguranca@lionn.net** com:

- Descrição da vulnerabilidade.
- Passos para reproduzir.
- Impacto potencial.
- Sugestão de correção, se aplicável.

Resposta em até **72 horas**. Após a confirmação e correção, daremos o devido crédito, caso deseje.

## Escopo

Esta política cobre:

- Configuração do Docker Compose.
- Configuração do Nginx.
- Scripts de setup, instalação e deploy.
- Documentação técnica.

Esta política não cobre:

- Vulnerabilidades do Magento 2. Reporte à Adobe.
- Vulnerabilidades de dependências de terceiros. Reporte ao mantenedor.
- Vulnerabilidades da infraestrutura do servidor. Reporte ao provedor.

## Boas práticas adotadas

- Usuário não-root nos containers.
- Política `no-new-privileges` em todos os serviços.
- UFW integrado ao Docker por meio do utilitário `ufw-docker`.
- Fail2ban configurado para proteção do SSH.
- Cabeçalhos HTTP de segurança no Nginx.
- Mitigações para vulnerabilidades conhecidas do Magento 2.
- Bloqueio de arquivos sensíveis no servidor web.

---

**© Lionn - [ https://www.lionn.net ]**
