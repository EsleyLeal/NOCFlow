<<<<<<< HEAD
# README.md

<p align="center">
  <img src="https://raw.githubusercontent.com/EsleyLeal/NOCFlow/main/public/NOCn2.png"
       width="420" alt="NOCFlow Logo">
</p>

=======
>>>>>>> 320bf5e618383ff255bfbd8d1f1d08e3e70b61e0
<p align="center">
<a href="https://github.com/laravel/framework/actions">
  <img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status">
</a>
<a href="https://packagist.org/packages/laravel/framework">
  <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
</a>
<a href="https://packagist.org/packages/laravel/framework">
  <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
</a>
<a href="https://packagist.org/packages/laravel/framework">
  <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
</a>
</p>

# 📡 NOCFlow — Network Operations Manager

Painel profissional para equipes NOC, criado para otimizar operações de rede, agilizar diagnóstico técnico e centralizar informações em um único ambiente moderno e eficiente.

Construído com **Laravel 11**, focado em **velocidade, organização e produtividade**.

---

## 🚀 Funcionalidades

- Registro completo de Troubleshooting  
- Edição avançada em abas organizadas  
- Pesquisa inteligente com múltiplos critérios  
- Controle de edição por usuário  
- Interface otimizada para operação em tempo real  
- Campos técnicos essenciais:
  - CPE (IP)
  - VLANs
  - PE Relacionado
  - Porta / Circuito
  - ONU
  - Designador
  - PRTG (Link)
  - Endereço completo
- Histórico de alterações automáticas  
- Suporte a JSON via campo `DETAILS`

---

## 🧱 Tecnologias Utilizadas

- PHP 8+
- Laravel 11
- Blade Templates
- MySQL/MariaDB
- Bootstrap 5
- SortableJS
- FontAwesome Icons

---

## 🛠️ Instalação

Clone o repositório:

git clone https://github.com/EsleyLeal/NOCFlow.git
cd NOCFlow

Instale as dependências do backend:

composer install

Instale dependências do frontend:

npm install
npm run build

Copie o arquivo de configuração:

cp .env.example .env

Gere a chave da aplicação:

php artisan key:generate

Configure o banco de dados no arquivo .env e rode as migrations:

php artisan migrate

Inicie o servidor local:

php artisan serve

app/
 └── Http/
       └── Controllers/
             └── TroubleshootingController.php

resources/
 └── views/
       └── reuse/
             └── viewEditTroubleshooting.blade.php

public/
 ├── pix/
 │    └── qrcode.jpeg
 ├── NOCn2.png
 └── index.php

<p align="center">
  <img src="https://raw.githubusercontent.com/EsleyLeal/NOCFlow/main/public/pix/qrcode.jpeg"
       width="260" alt="QR Code PIX">
</p>

<p align="center"><strong>Chave PIX:</strong> lealsantanati@gmail.com</p>

<<<<<<< HEAD
Contribuições são bem-vindas!

Abra uma issue antes de enviar grandes alterações para alinharmos ideias.

Se encontrar vulnerabilidades, envie uma mensagem privada ao mantenedor.

Este projeto é distribuído sob a licença MIT.
=======
---
=======
# NOCFlow
Sistema avançado de troubleshooting e gestão de incidentes em redes, projetado para equipes NOC que precisam de agilidade, organização e precisão no diagnóstico.

>>>>>>> 320bf5e618383ff255bfbd8d1f1d08e3e70b61e0
