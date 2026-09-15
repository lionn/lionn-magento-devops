# Lionn_AdminLogo

**Módulo Magento 2 que substitui o logo padrão do Painel de Admin por um logo personalizado, além de controlar os estilos do backend do painel de administrçaão.**

---

## Sobre

O `Lionn_AdminLogo` substitui o logo padrão do Magento 2 no painel administrativo, tanto na tela de login quanto no menu principal do admin. O módulo também controla as cores, posição de elementos do backend e estilos gerais do painel de administração.

---

## Instalação

1. Copie o módulo para `app/code/Lionn/AdminLogo/`:

   cp -r Lionn/AdminLogo app/code/Lionn/

2. Habilite o módulo:

   php bin/magento module:enable Lionn_AdminLogo
   php bin/magento setup:upgrade
   php bin/magento cache:flush
   php bin/magento cache:clean

3. Coloque o seu logo em:

   app/code/Lionn/AdminLogo/view/adminhtml/web/images/logo.png

---

## Licença

MIT.

---

**© Lionn - [ https://www.lionn.net ]**
